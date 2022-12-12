<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    
    public function package_form($package_id = false){
        return view('admin.package_form', ['package_id' => $package_id] );
    }

    function add_update_package_form(Request $request){

            $request->validate([
            'venue_id' => 'required',
            'name' => 'required',
            'type' => 'required',
            'billing_config' => 'required',
            'cost_per_amount' => 'required|numeric',
            'cost' => 'required|numeric' ,
            'min_persons' => 'required|numeric' ,
            'max_persons' => 'required|numeric' ,
            'venue_type' => 'required' ,
        ]);  

    
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
            'cost_per_amount' => $post_data['cost_per_amount'],
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

        if(!empty($post_data['package_id']))
        {
            $package = Package::where('id', $post_data['package_id'])->update($package_data);
        }
        else
        {
            $package = Package::create($package_data);
        }
        if($package)
        {
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
            $actions .= '<a href="#" class="btn btn-sm btn-success mx-2"><i class="fa-solid text-white fa-plus"></i></a>';
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

             if($package_rawdata['active']== 1)
        {        
            $package_details['active'] = "on";
        }
        elseif($package_rawdata['active']==0)
        {
            $package_details['active'] = "off";
        }          
        return new Response($package_details, 200);

    }
}
