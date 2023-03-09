<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PartyController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function party_form()
    {
        
        return view("party.party_form");
    }

    public function fetch_party_recommedations(Request $request)
    {
        $request_params = $request->all();

        $packages = DB::table('packages');
        
        $packages->select('packages.*', 'venues.name as venue_name','venues.address', 'venues.gmap_location', 'venues.parking_capacity');

        $packages->leftJoin('venues', 'packages.venue_id', '=', 'venues.id');

        if(isset($request_params['type']))
        {
            $packages->where('packages.type',$request_params['type']);
        }

        if(isset($request_params['person_count']))
        {
            $packages->where('packages.min_persons', '<=',$request_params['person_count']);
            $packages->where('packages.max_persons', '>=',$request_params['person_count']);
        }

        if(isset($request_params['price_range']))
        {
            if($request_params['price_range'] == '10000+')
            {
                $packages->where('packages.cost','>=',10000);
            }
            else
            {
                $range = explode('-',$request_params['price_range']);

                $packages->where('packages.cost','>=',$range[0]);
                $packages->where('packages.cost','<=',$range[1]);
            }
        }

        if(isset($request_params['venue_type']))
        {
            $packages->where('packages.venue_type',$request_params['venue_type']);
        }

        if(isset($request_params['parking_compulsory']) && $request_params['parking_compulsory'])
        {
            $packages->where('venues.parking_capacity', '>',0);
        }

        switch($request_params['sorting'])
        {
            case 'price_high_to_low':
                    $packages->orderBy('packages.cost', 'desc');
                break;

            case 'price_low_to_high':
                    $packages->orderBy('packages.cost', 'asc');
                break;

            default:
                $packages->orderBy('packages.rating', 'desc');
        }

        $package_result = $packages->limit(10)->get()->all();

        $packages_html = array();
        foreach($package_result as $package)
        {
            $primary_picture = Image::where(['entity_id' => $package->id, 'belongs_to' => 'package', 'type' => 'primary'])->first();

            $package_data = array(
                'id' => $package->id,
                'primary_image_src' => asset($primary_picture->image_path),
                'name' => $package->name,
                'venue_name' => $package->venue_name,
                'address' => $package->address,
                'gmap_location' => $package->gmap_location,
                'parking_available' => ($package->parking_capacity > 0)? TRUE: FALSE,
                'additional_details' => empty($package->additional_details) ? null : json_decode($package->additional_details, TRUE),
            );


            
            $packages_html[] = view("components.package_card", $package_data)->render();
        }

        $venues = DB::table('venues');

        if(isset($request_params['person_count']))
        {
            $venues->where('venues.total_capacity', '>=',$request_params['person_count']);
        }

        if(isset($request_params['parking_compulsory']) && $request_params['parking_compulsory'])
        {
            $venues->where('venues.parking_capacity', '>',0);
        }

        $venues->orderBy('venues.venue_rating', 'desc');

        $venue_result = $venues->limit(10)->get()->all();

        $venues_html = array();

        foreach($venue_result as $venue)
        {
            $primary_picture = Image::where(['entity_id' => $venue->id, 'belongs_to' => 'venue', 'type' => 'primary'])->first();

            $venue_data = array(
                'id' => $venue->id,
                'primary_image_src' => asset($primary_picture->image_path),
                'name' => $venue->name,
                'address' => $venue->address,
                'gmap_location' => $venue->gmap_location,
                'parking_available' => ($venue->parking_capacity > 0)? TRUE: FALSE,
                'additional_features' => empty($venue->additional_features) ? null : json_decode($venue->additional_features, TRUE),
            );

            $venues_html[] = view("components.venue_card", $venue_data)->render();
        
        }

        $response_data = array(
            'packages' => $packages_html,
            'venues' => $venues_html,
        );
        
        return new Response($response_data, 200);
    }
}
