<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    public function venue_form($venue_id = false)
    {
        return view('admin.venue_form', ['venue_id' => $venue_id]);
    }


    public function add_update_venue_form(Request $request)
    {


        $validations = array(
            'name' => 'required',
            'type' => 'required',
            'contact_email' => 'required | email',
            'contact_phone' => 'required | digits:10',
            'address' => 'required',
            'total_capacity' => 'required',
            'timmings' => 'required',
            'primary_picture' => 'required|image',
            'secondary_pictures.*' => 'image',
        );

        $primary_pic_already_exists = FALSE;
        if(isset($request->venue_id))
        {
            $primary_picture = Image::where(['entity_id' => $request->venue_id, 'belongs_to' => 'venue', 'type' => 'primary'])->first();
            if(!empty($primary_picture))
            {
                $primary_pic_already_exists = TRUE;
                unset($validations['primary_picture']);
            }
        }

        $request->validate($validations);

        $post_data = $request->all(); 

        $venue_data = array(
            'name' => $post_data['name'],
            'type' => $post_data['type'],
            'address' => $post_data['address'],
            'contact_email' => $post_data['contact_email'],
            'contact_phone' => $post_data['contact_phone'],
            'total_capacity' => $post_data['total_capacity'],
            'timmings' => json_encode($post_data['timmings']),
        );

        if(!empty($post_data['gmap_location']))
        {
            $venue_data['gmap_location'] = $post_data['gmap_location'];
        }
        if(!empty($post_data['parking_capacity']))
        {
            $venue_data['parking_capacity'] = $post_data['parking_capacity'];
        }
        if(!empty($post_data['cuisines']))
        {
            $venue_data['cuisines'] = json_encode($post_data['cuisines']);
        }
        if(!empty($post_data['additional_features']))
        {
            $venue_data['additional_features'] = json_encode($post_data['additional_features']);
        }
        if(!empty($post_data['venue_rating']))
        {
            $venue_data['venue_rating'] = $post_data['venue_rating'];
        }

        DB::beginTransaction();

        if(!empty($post_data['venue_id']))
        {
            $venue = Venue::where('id', $post_data['venue_id'])->first();
            $venue->update($venue_data);
        }
        else
        {
            $venue = Venue::create($venue_data);
        }

        if($venue)
        {
            if(! $primary_pic_already_exists)
            {
                $primary_image = $request->file('primary_picture');
                $original_name = $primary_image->getClientOriginalName();
                $path = $primary_image->store('images/venue');

                $primary_pic_data = array(
                    'entity_id' => $venue->id,
                    'belongs_to' => 'venue',
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

            $saved_succesfully = TRUE;
            if($request->hasFile('secondary_pictures'))
            {
                foreach($request->file('secondary_pictures') as $key => $secondary_image)
                {
                    $original_name = $secondary_image->getClientOriginalName();
                    $path = $secondary_image->store('images/venue');
        
                    $secondary_pic_data = array(
                        'entity_id' => $venue->id,
                        'belongs_to' => 'venue',
                        'type' => 'secondary',
                        'original_name' => $original_name,
                        'image_path' => $path,
                    );

                    if( ! Image::create($secondary_pic_data))
                    {
                        $saved_succesfully = FALSE;
                    }
                }
            }

            if($primary_pic && $saved_succesfully)
            {
                DB::commit();
            }
            else
            {
                DB::rollBack();
                return new Response(['errors' => ['Something went wrong']], 400);
            }

            return new Response(['redirect' => route('venue_list')], 402);
        }

    }

    public function delete_image(Request $request)
    {

        $request->validate([
            'image_id' => 'required',
        ]);

        $image_id = $request->image_id;

        $image = Image::find($image_id);

        if(empty($image))
        {
            return new Response(['errors' => ['Something went wrong']], 400);
        }

        $image_path = $image->image_path;

        Storage::delete($image_path);
        
        if($image->delete())
        {
            return new Response(['message' => 'File deleted successfully'] ,200);    
        }
        else
        {
            return new Response(['errors' => ['Something went wrong']], 400);
        }
    }


    public function venue_list()
    {
        return view('admin.venue_list');
    }

    public function fetch_venue_list()
    {
        $response_list = array();
        foreach(Venue::all() as $venue)
        {
            $data = array(
                'id' => $venue->id,
                'name' => '<a href="'.route('venue_details',$venue->id).'">'.$venue->name.'</a>',
                'type' => $venue->type,
                'email' => $venue->contact_email,
                'phone' => $venue->contact_phone,
            );

            if($venue->venue_rating)
            {
                $data['venue_rating'] = $venue->venue_rating;
            }
            else
            {
                $data['venue_rating'] = "N/A";
            }

            $actions = '';
            $actions .= '<a href="'.route('venue_form',$venue->id).'" class="btn btn-sm btn-info mx-2"><i class="fa-solid text-white fa-pen-to-square"></i></a>';
            $data['actions'] = $actions;
            $response_list[] = $data;
        }

        return new Response(['data' => $response_list], 200);
    }

    function fetch_venue_details(Request $request)
    {
        if( ! $request->venue_id)
            return new Response(['redirect' => route('venue_list')], 402);

        $venue_id = $request->venue_id;

        $venue_rawdata = Venue::find($venue_id);
        if(empty($venue_rawdata))
        {
            return new Response(['redirect' => route('venue_list')], 402);
        }
        $venue_rawdata = $venue_rawdata->getAttributes();

        $primary_picture = Image::where(['entity_id' => $venue_id, 'belongs_to' => 'venue', 'type' => 'primary'])->first();

        $secondary_picture_coll = Image::where(['entity_id' => $venue_id, 'belongs_to' => 'venue', 'type' => 'secondary'])->get();
        $secondary_pictures = array();

        if(!empty($secondary_picture_coll))
        {
            foreach($secondary_picture_coll as $file)
            {
                $secondary_pictures[] = array(
                    'id' => $file->id,
                    'original_name' => $file->original_name,
                );
            }
        }
        
        $venue_details = array(
            'name' => $venue_rawdata['name'],
            'type' => $venue_rawdata['type'],
            'address' => $venue_rawdata['address'],
            'gmap_location' => $venue_rawdata['gmap_location'],
            'contact_email' => $venue_rawdata['contact_email'],
            'contact_phone' => $venue_rawdata['contact_phone'],
            'total_capacity' => $venue_rawdata['total_capacity'],
            'parking_capacity' => $venue_rawdata['parking_capacity'],
            'cuisines' => json_decode($venue_rawdata['cuisines'], TRUE),
            'additional_features' => json_decode($venue_rawdata['additional_features'], TRUE),
            'venue_rating' => $venue_rawdata['venue_rating'],
            'timmings' => json_decode($venue_rawdata['timmings'], TRUE),
            'primary_picture' => array(
                'id' => $primary_picture->id,
                'original_name' => $primary_picture->original_name,
            ),
            'secondary_pictures' => $secondary_pictures,
        );


        return new Response($venue_details, 200);

    }

    public function show_venue_details($venue_id = false)
    {
        return view('admin.venue_details', ['venue_id' => $venue_id]);
    }

    function fetch_venue_details_page(Request $request)
    {
        if( ! $request->venue_id)
            return new Response(['redirect' => route('venue_list')], 402);

        $venue_id = $request->venue_id;

        $venue_rawdata = Venue::find($venue_id);
        if(empty($venue_rawdata))
        {
            return new Response(['redirect' => route('venue_list')], 402);
        }
        $venue_rawdata = $venue_rawdata->getAttributes();

        $primary_picture = Image::where(['entity_id' => $venue_id, 'belongs_to' => 'venue', 'type' => 'primary'])->first();

        $secondary_picture_coll = Image::where(['entity_id' => $venue_id, 'belongs_to' => 'venue', 'type' => 'secondary'])->get();
        $secondary_pictures = array();

        if(!empty($secondary_picture_coll))
        {
            foreach($secondary_picture_coll as $file)
            {
                $secondary_pictures[] = array(
                    'id' => $file->id,
                    'original_name' => $file->original_name,
                    'path' => asset($file->image_path),
                );
            }
        }
        
        $venue_details = array(
            'name' => $venue_rawdata['name'],
            'type' => $venue_rawdata['type'],
            'address' => $venue_rawdata['address'],
            'gmap_location' => $venue_rawdata['gmap_location'],
            'contact_email' => $venue_rawdata['contact_email'],
            'contact_phone' => $venue_rawdata['contact_phone'],
            'total_capacity' => $venue_rawdata['total_capacity'],
            'parking_capacity' => $venue_rawdata['parking_capacity'],
            'cuisines' => json_decode($venue_rawdata['cuisines'], TRUE),
            'additional_features' => json_decode($venue_rawdata['additional_features'], TRUE),
            'venue_rating' => $venue_rawdata['venue_rating'],
            'timmings' => json_decode($venue_rawdata['timmings'], TRUE),
            'primary_picture' => array(
                'id' => $primary_picture->id,
                'original_name' => $primary_picture->original_name,
            ),
            'secondary_pictures' => $secondary_pictures,
            'image_src' => asset($primary_picture->image_path),
        );


        return new Response($venue_details, 200);

    }
}
