<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Package;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user(); 
        if($user->is_admin)
            return redirect(route('admin_dashboard'));

        $parties = User::find($user->id)->party()->get()->all();

        $data = array();
        foreach($parties as $party)
        {
            $party_prepped_data = array(
                'id' => $party->id,
                'name' => $party->name,
                'date' => date("d M Y", strtotime($party->date)),
                'status' => $party->status,
                'person_count' => empty($party->person_count) ? 'N/A' : $party->person_count,
                'venue_name' => Venue::find($party->venue_id)->name,  
                'venue_id' => $party->venue_id
            );

            if($party->type == 'standard')
            {
                $primary_picture = Image::where(['entity_id' => $party->package_id, 'belongs_to' => 'package', 'type' => 'primary'])->first();
                $party_prepped_data['image_src'] = asset($primary_picture->image_path);
                $party_prepped_data['package_name'] = Package::find($party->package_id)->name;
                $party_prepped_data['package_id'] = $party->package_id;
            }
            else
            {
                $primary_picture = Image::where(['entity_id' => $party->venue_id, 'belongs_to' => 'venue', 'type' => 'primary'])->first();
                $party_prepped_data['image_src'] = asset($primary_picture->image_path);
            }

            $data['user_parties'][] = $party_prepped_data;
        }
        
        return view('home', $data);
    }
}
