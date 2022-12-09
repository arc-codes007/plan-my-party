<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'contact_email' => 'required | email',
            'contact_phone' => 'required | digits:10',
            'address' => 'required',
            'total_capacity' => 'required',
            'timmings' => 'required'
        ]);

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

        if(!empty($post_data['venue_id']))
        {
            $venue = Venue::where('id', $post_data['venue_id'])->update($venue_data);
        }
        else
        {
            $venue = Venue::create($venue_data);
        }

        if($venue)
        {
            return new Response(['redirect' => route('venue_list')], 402);
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
                'name' => $venue->name,
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
            $actions .= '<a href="#" class="btn btn-sm btn-success mx-2"><i class="fa-solid text-white fa-plus"></i></a>';
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
        );


        return new Response($venue_details, 200);

    }
}
