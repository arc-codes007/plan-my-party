<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Venue;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FormController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }


    public function reco_form()
    {
        return view('reco_form');
    }

    public function fetch_venues()
    {
        $response_list = array();
        foreach (Venue::all() as $venue) {
            $data = array(
                'id' => $venue->id,
                'name' => $venue->name,
                'type' => $venue->type,
                'email' => $venue->contact_email,
                'phone' => $venue->contact_phone,
            );
            $response_list[] = $data;
        }

        return new Response(['data' => $response_list], 200);
    }

    public function party_pref(Request $request)
    {
        $party_data = array(
            'type' => $request['type'],
            'venue_type' => $request['venue_type'],
            'must_have' => $request['must_have'],
            'members' => $request['members'],
        );
        // print_r($party_data);
        // exit;
        $venue = Venue::where('type', '=', $party_data['venue_type'])
            ->orWhere('total_capacity', '>=', $party_data['members'])
            ->orWhere('parking_capacity', '>', 0)->get()->all();
        // print_r($venue);
        // exit;
        // $package = Package::where('type', '=', $party_data['type'])
        //     ->orWhere('min_persons', '<=', $party_data['members'])
        //     ->orWhere('max_persons', '>=', $party_data['members'])
        //     ->get()->all();
        $package = Package::where('type', '=', $party_data['type'])
            ->where('min_persons', '<=', $party_data['members'])
            ->where('max_persons', '>=', $party_data['members'])
            ->get()->all();
        // print_r($package);
        // exit;
        foreach ($venue as $venues) {
            $venues = $venues->getAttributes();
            $venue_data[] = array(
                'id' => $venues['id'],
                'name' => $venues['name'],
                'type' => $venues['type'],
            );
        }
        print_r($venue_data);
        // exit;

        foreach ($package as $packages) {
            $packages = $packages->getAttributes();
            $package_data = array(
                'id' => $packages['id'],
                'name' => $packages['name'],
                'type' => $package['type'],
            );
        }
        print_r($package_data);



        // $venue = DB::table('Venues')->where('type','=',$party_data['venue_type'])->get()->all();
        // $venue_rawdata = $venue->getAttributes();
        // if(empty($venue))
        // {
        //     return new Response(['redirect' => route('venue_form')], 402);
        // }
        // $venue = $venue->getAttributes();
        // $venue = Venue::where('type', $party_data['venue_type'])->get()->all();
        // $venue = Venue::where('type','=','cafe')->get()->all();
        // $venue = DB::table('Venues')->where('parking_capacity','>',2)->get()->all();
        // $venue = DB::table('Venues')->select()->get()->toArray();
        return new Response(['venue_data' => $venue_data], 200);
        // return new Response(['venue_data' => $venue_data,'package_data'=>$packages], 200);
    }
}
