<?php

namespace App\Http\Controllers;

use App\Mail\GuestRating;
use App\Models\Image;
use App\Models\Invitation;
use App\Models\invite_template;
use App\Models\Package;
use App\Models\Party;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PartyController extends Controller
{
    //

    public function party_form($party_id = FALSE)
    {
        $this->middleware('auth');

        $data = array(
            'is_planned' => FALSE
        );

        if($party_id)
        {
            $party_data = Party::find($party_id);
            if(empty($party_data))
            {
                return abort(404);
            }
            if($party_data->status == config('pmp.party_statuses.celebrated'))
            {
                return abort(404);
            }
            
            if(!empty($party_data->timming))
            {
                $party_data->timming = json_decode($party_data->timming, TRUE);
            }

            if($party_data->status == config('pmp.party_statuses.planned'))
            {
                $data['is_planned'] = TRUE;
            }

            $data['party_data'] = $party_data;
            $data['venue_data'] = Venue::find($party_data['venue_id']);

            if($party_data['type'] == 'standard')
            {
                $data['package_data'] = Package::find($party_data['package_id']);
                $primary_picture = Image::where(['entity_id' => $party_data['package_id'], 'belongs_to' => 'package', 'type' => 'primary'])->first();
                $data['party_image_src'] = asset($primary_picture->image_path);
            }
            else
            {
                $primary_picture = Image::where(['entity_id' => $party_data['venue_id'], 'belongs_to' => 'venue', 'type' => 'primary'])->first();
                $data['party_image_src'] = asset($primary_picture->image_path);
            }

            if(!empty($party_data->invitation_id))
            {
                $data['invitation_data'] = Invitation::find($party_data->invitation_id);
            }

            $data['party_guests'] = $party_data->guest;


        }

        if( ! $data['is_planned'])
        {
            $invite_templates = invite_template::get()->all();

            if(!empty($invite_templates))
            {
                $invite_templates_arr = array();
                foreach($invite_templates as $template)
                {
                    $invite_templates_arr[$template->id] = $template->getAttributes();
                }
                
                $data['invite_templates'] = $invite_templates_arr;
            }
        }


        return view("party.party_form", $data);
    }

    public function fetch_party_recommedations(Request $request)
    {
        $this->middleware('auth');

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
                'additional_details' => empty($package->additional_details) ? array() : json_decode($package->additional_details, TRUE),
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
                'additional_features' => empty($venue->additional_features) ? array() : json_decode($venue->additional_features, TRUE),
            );

            $venues_html[] = view("components.venue_card", $venue_data)->render();
        
        }

        $response_data = array(
            'packages' => $packages_html,
            'venues' => $venues_html,
        );
        
        return new Response($response_data, 200);
    }

    public function create_party(Request $request)
    {
        $this->middleware('auth');
        
        $request->validate([
            'entity_id' => 'required',
            'belongs_to' => 'required'
        ]);

        $request_data = $request->all();

        $user_name = Auth::user()->name;

        if($request_data['belongs_to'] == 'package')
        {
            $package = Package::find($request['entity_id']);
            $package_id = $request['entity_id'];
            $venue_id = $package->venue_id;
            $party_name = $user_name."'s ".$package->name;
            $type = 'standard';
        }
        else if($request_data['belongs_to'] == 'venue')
        {
            $package_id = null;
            $venue_id = $request['entity_id'];
            $party_name = $user_name."'s Party at ".Venue::find($venue_id)->name;
            $type = 'custom';
        }
        
        $party_data = array(
            'venue_id' => $venue_id,
            'package_id' => $package_id,
            'user_id' => Auth::user()->id,
            'type' => $type,
            'name' => $party_name,
            'status' => config('pmp.party_statuses.draft')
        );

        if(isset($request_data['person_count']))
        {
            $party_data['person_count'] = $request_data['person_count'];
        }

        $party_id = Party::create($party_data);

        if($party_id)
        {
            return new Response(['redirect' => route('party_planning', $party_id)], 402);
        }
        else
        {
            return new Response(['errors' => ['Something went wrong']], 400);
        }
    }

    public function save_party_data(Request $request)
    {
        $this->middleware('auth');

        $request->validate([
            'party_id' => 'required',
            'party_name' => 'required',
            'party_date' => 'required',
        ]);

        $request_data = $request->all();

        $party = Party::find($request_data['party_id']);

        $party_data = array(
            'name' => $request_data['party_name'],
            'date' => date('Y-m-d H:i:s' ,strtotime($request_data['party_date']))
        );

        if(!empty($request_data['party_person_count']))
        {
            $party_data['person_count'] = $request_data['party_person_count'];
        }

        if(!empty($request_data['party_timming']))
        {
            $party_data['timming'] = json_encode($request_data['party_timming']);
        }

        if($party->update($party_data))
        {
            return new Response(['message' => "Party Saved Successfully!"], 200);
        }
        else
        {
            return new Response(['errors' => ['Something went wrong']], 400);
        }
    } 

    public function set_party_to_planned(Request $request)
    {
        $this->middleware('auth');

        $request->validate([
            'party_id' => 'required'
        ]);

        $party = Party::find($request->party_id);

        $party->update(['status' => config('pmp.party_statuses.planned')]);

        return new Response(['redirect' => route('party_planning', $party->id)], 402);
    }

    public function check_for_celebration_date_pass()
    {
        $all_parties = Party::where('date', '<' ,now())->where('status', config('pmp.party_statuses.planned'))->get()->all();

        foreach($all_parties as $party)
        {
            $party_guests = $party->guest->where('status', 'Accepted');

            foreach($party_guests as $guest)
            {
                $data = array(
                    'invitation_link' => route('guest_view_invitation', $guest->id),
                    'host_name' => $party->user->name,
                );

                Mail::to($guest->email)->send(new GuestRating($data));
            }

            $party->update(['status' => config('pmp.party_statuses.celebrated')]);
        }
    }
}
