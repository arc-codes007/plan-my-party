<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Package;
use App\Models\Party;
use App\Models\Review;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function save_review(Request $request)
    {


        $request->validate([
            'user_type' => 'required',
            'user_id' => 'required',
            'rating' => 'required',
            'review' => 'required',
        ]);

        $review_data = array(
            'user_type' => $request->user_type,
            'rating' => $request->rating,
            'review' => $request->review,
        );

        if($request->user_type == 'user')
        {
            $request->validate([
                'party_id' => 'required'
            ]);

            $party = Party::find($request->party_id);

            $review_data['party_id'] = $request->party_id;
            $review_data['venue_id'] = $party->venue_id;
            $review_data['package_id'] = $party->package_id;
            $review_data['user_id'] = $request->user_id;
        }
        else
        {
            $guest = Guest::find($request->user_id);

            $review_data['party_id'] = $guest->party->id;
            $review_data['venue_id'] = $guest->party->venue_id;
            $review_data['package_id'] = $guest->party->package_id;
            $review_data['user_id'] = $request->user_id;
        }

        DB::beginTransaction();

        $review = Review::create($review_data);

        $venue_average_rating = DB::table('reviews')->select(DB::raw('avg(rating) as average_rating'))->where('venue_id',$review_data['venue_id'])->get()->first();
        $venue_average_rating = round($venue_average_rating->average_rating);

        $venue = Venue::find($review_data['venue_id']);
        $venue->update(['venue_rating' => $venue_average_rating]);

        if(!empty($review_data['package_id']))
        {
            $package_average_rating = DB::table('reviews')->select(DB::raw('avg(rating) as average_rating'))->where('package_id', $review_data['package_id'])->get()->first();
            $package_average_rating = round($package_average_rating->average_rating);

            $package = Package::find($review_data['package_id']);
            $venue->update(['rating' => $package_average_rating]);
        }
        else
        {
            $package = TRUE;
        }

        if($review && $venue && $package)
        {
            DB::commit();
            return new Response(['message' => "Thank You!"], 200);
        }
        else
        {
            DB::rollBack();
            return new Response(['errors' => ['Something went wrong']], 400);
        }


    }
}
