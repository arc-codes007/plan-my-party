<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Image;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{    
    public function package_form($package_id = false){
        return view('admin.package_form', ['package_id' => $package_id] );
    }

    function add_update_package_form(Request $request){

        $validations = array(
            'venue_id' => 'required',
            'name' => 'required',
            'type' => 'required',
            'billing_config' => 'required',
            'cost_per_amount' => 'required|numeric',
            'cost' => 'required|numeric' ,
            'min_persons' => 'required|numeric' ,
            'max_persons' => 'required|numeric' ,
            'venue_type' => 'required',
            'primary_picture' => 'required|image',
        );  

        $primary_pic_already_exists = FALSE;
        if(isset($request->package_id))
        {
            $primary_picture = Image::where(['entity_id' => $request->package_id, 'belongs_to' => 'package', 'type' => 'primary'])->first();
            if(!empty($primary_picture))
            {
                $primary_pic_already_exists = TRUE;
                unset($validations['primary_picture']);
            }
        }

        $request->validate($validations);
    
        $post_data = $request->all(); 

        $package_data = array(
            'venue_id' => $post_data['venue_id'],
            'name' => $post_data['name'],
            'type' => $post_data['type'],
            'cost' => floatval($post_data['cost']),
            'min_persons' => $post_data['min_persons'],
            'max_persons' => $post_data['max_persons'],
            'venue_type' => $post_data['venue_type'],
        );

        $billing_config = array(
            'type' => $post_data['billing_config'],
            'amount' => $post_data['cost_per_amount'],
        );

        $package_data['billing_config'] = json_encode($billing_config);

        $package_data['active'] = (isset($post_data['active']) && $post_data['active']=="on")? 1 : 0;

        if(!empty($post_data['menu']))
        {        
            $package_data['menu'] = json_encode($post_data['menu']);
        }
        if(!empty($post_data['additional_details']))
        {
            $package_data['additional_details'] = json_encode($post_data['additional_details']);
        }
        if(!empty($post_data['contact_email']))
        {        
            $package_data['contact_email'] = $post_data['contact_email'];
        }
        if(!empty($post_data['contact_phone']))
        {        
            $package_data['contact_phone'] = $post_data['contact_phone'];
        }
        if(!empty($post_data['timmings']))
        {
            $package_data['timmings'] = json_encode($post_data['timmings']);
        }

        DB::beginTransaction();
        
        if(!empty($post_data['package_id']))
        {
            $package = Package::where('id', $post_data['package_id'])->first();
            $package->update($package_data);
        }
        else
        {
            $package = Package::create($package_data);
        }

        if($package)
        {
            if(! $primary_pic_already_exists)
            {
                $primary_image = $request->file('primary_picture');
                $original_name = $primary_image->getClientOriginalName();
                $path = $primary_image->store('images/package');

                $primary_pic_data = array(
                    'entity_id' => $package->id,
                    'belongs_to' => 'package',
                    'type' => 'primary',
                    'original_name' => $original_name,
                    'image_path' => $path,
                );

                $primary_pic = Image::create($primary_pic_data);
            }
            else
            {
                $primary_pic = TRUE;
            }

            if($primary_pic)
            {
                DB::commit();
            }
            else
            {
                DB::rollBack();
                return new Response(['errors' => ['Something went wrong']], 400);
            }

            return new Response(['redirect' => route('package_list')], 402);

        }
    }


    public function package_list()
    {
        return view('admin.package_list');
    }
    
    public function fetch_package_list()
    {
        $response_list = array();

        foreach(Package::all() as $package)
        {           
            $data = array(
                'id' => $package->id,
                'name' => $package->name,
                'venue_id' => $package->venue->name,
                'type' =>$package->type,
                'venue_type' => $package->venue_type,                
            );           
                
            $actions = '';
            $actions .= '<a href="'.route('package_form',$package->id).'" class="btn btn-sm btn-info mx-2"><i class="fa-solid text-white fa-pen-to-square"></i></a>';
            $data['actions'] = $actions;
            $response_list[] = $data;
        }

        return new Response(['data' => $response_list], 200);
    }

    function fetch_package_details(Request $request)
    {
        if( ! $request->package_id)
            return new Response(['redirect' => route('package_list')], 402);

        $package_id = $request->package_id;

        $package_rawdata = Package::find($package_id);
        if(empty($package_rawdata))
        {
            return new Response(['redirect' => route('package_list')], 402);
        }
        $package_rawdata = $package_rawdata->getAttributes();

        $primary_picture = Image::where(['entity_id' => $package_id, 'belongs_to' => 'package', 'type' => 'primary'])->first();

        $package_details = array(
            'venue_id' => $package_rawdata['venue_id'],
            'name' => $package_rawdata['name'],
            'type' => $package_rawdata['type'],
            'billing_config' => json_decode($package_rawdata['billing_config'],TRUE),
            'cost' => $package_rawdata['cost'],
            'min_persons' => $package_rawdata['min_persons'],
            'max_persons' => $package_rawdata['max_persons'],
            'venue_type' => $package_rawdata['venue_type'],
            'timmings' => json_decode($package_rawdata['timmings'],TRUE),
            'menu'     => json_decode($package_rawdata['menu'],TRUE),
            'additional_details' => json_decode($package_rawdata['additional_details'],TRUE),
            'contact_email' => $package_rawdata['contact_email'],
            'contact_phone' => $package_rawdata['contact_phone'],
        );

        if(!empty($primary_picture))
        {
            $package_details['primary_picture'] = array(
                'id' => $primary_picture->id,
                'original_name' => $primary_picture->original_name,
            );
        }

        $package_details['active'] = ($package_rawdata['active']== 1) ? 'on' : 'off';

        return new Response($package_details, 200);

    }

    public function fetch_all_packages()
    {
        $packages = Package::where('active',1)->orderBy('rating', 'desc')->limit(10)->get();
        if(empty($packages))
        {
            return new Response(['errors' => 'No Package Found!'], 400);
        }
        {
            $final_packages_data = array();

            foreach($packages as $package)
            {
                $primary_picture = Image::where(['entity_id' => $package->id, 'belongs_to' => 'package', 'type' => 'primary'])->first();

                $package_data = array(
                    'package_id' => $package->id,
                    'name' => $package->name,
                    'image_src' => asset($primary_picture->image_path),
                    'venue_name' => $package->venue->name,
                    'address' => $package->venue->address,
                    'gmap_link' => $package->venue->gmap_location,
                    'rating' => $package->rating,
                    'additional_features' => (empty($package->additional_details)) ? array() : json_decode($package->additional_details, TRUE),
                    'parking_available' => ($package->venue->parking_capacity > 0) ? TRUE : FALSE
                );

                $final_packages_data[] = $package_data;
            }

            $response_data = array(
                'packages' => $final_packages_data
            );

            return new Response($response_data, 200);
        }
    }

    public function get_package_details(Request $request)
    {
        $request->validate([
            'package_id' => 'required'
        ]);

        $package_id = $request->package_id;

        $package = Package::find($package_id);
        $primary_picture = Image::where(['entity_id' => $package_id, 'belongs_to' => 'package', 'type' => 'primary'])->first();

        $pricing = json_decode($package->billing_config, TRUE);
        $pricing['cost'] = $package->cost;

        $package_details  = array(
            'name' => $package->name,
            'package_type' => $package->type,
            'image_src' => asset($primary_picture->image_path),
            'menu' => (empty($package->menu)) ? array() : json_decode($package->menu, TRUE),
            'pricing' => $pricing,
            'min_person' => $package->min_persons,
            'max_person' => $package->max_persons,
            'sitting_type' => $package->venue_type,
            'contact_email' => (empty($package->contact_email)) ? $package->venue->contact_email : $package->contact_email,
            'contact_phone' => (empty($package->contact_phone)) ? $package->venue->contact_phone : $package->contact_phone,
            'additional_details' => (empty($package->additional_details)) ? array() : json_decode($package->additional_details, TRUE),
            'timmings' => (empty($package->timmings)) ? json_decode($package->venue->timmings, TRUE) : json_decode($package->timmings, TRUE),
            'sitting_type' => $package->venue_type,
            'package_rating' => empty($package->rating) ? FALSE :  $package->rating,
            'venue_name' => $package->venue->name,
            'address' => $package->venue->address,
            'gmap_link' => $package->venue->gmap_location,
            'parking_available' => ($package->venue->parking_capacity > 0) ? TRUE : FALSE,
            'venue_rating' => $package->venue->venue_rating,
        );

        $response_data = array(
            'package_data' => $package_details
        );

        return new Response($response_data, 200);
    }

    // public function get_package_details(Request $request)
    // {
    //     $request->validate([
    //         'package_id' => 'required'
    //     ]);

    //     $package_id = $request->package_id;


    public function fetch_venue_package_page(Request $request)
    {        
                $request->validate([
                    'venue_id' => 'required'
                ]);
                $venue_id = $request->venue_id;
        $packages = Package::where('venue_id',$venue_id)->where('active',1)->orderBy('rating', 'desc')->limit(10)->get();
        if(empty($packages))
        {
            return new Response(['errors' => 'No Package Found!'], 400);
        }
        {
            $final_packages_data = array();

            foreach($packages as $package)
            {
                $primary_picture = Image::where(['entity_id' => $package->id, 'belongs_to' => 'package', 'type' => 'primary'])->first();

                $package_data = array(
                    'package_id' => $package->id,
                    'name' => $package->name,
                    'image_src' => asset($primary_picture->image_path),
                    'venue_name' => $package->venue->name,
                    'address' => $package->venue->address,
                    'gmap_link' => $package->venue->gmap_location,
                    'rating' => $package->rating,
                    'additional_features' => (empty($package->additional_details)) ? array() : json_decode($package->additional_details, TRUE),
                    'parking_available' => ($package->venue->parking_capacity > 0) ? TRUE : FALSE
                );

                $final_packages_data[] = $package_data;
            }

            $response_data = array(
                'packages' => $final_packages_data
            );

            return new Response($response_data, 200);
        }
    }

}