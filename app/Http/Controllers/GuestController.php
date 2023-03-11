<?php

namespace App\Http\Controllers;

use App\Mail\PartyInvite;
use App\Models\Guest;
use App\Models\Party;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class GuestController extends Controller
{
    public function create_update_guest(Request $request)
    {
        $request->validate([
            'guest_name' => 'required',
            'guest_email' => 'required',
            'party_id' => 'required',
        ]);

        $guest_data = array(
            'party_id' => $request->party_id,
            'name' => $request->guest_name,
            'email' => $request->guest_email,
            'status' => 'No Response'
        );

        if(empty($request->guest_id))
        {
            $guest = Guest::create($guest_data);
        }
        else
        {
            $guest = Guest::find($request->guest_id);
            $guest->update($guest_data);
        }

        if($guest)
        {
            return new Response(['message' => "Guest Data Saved Successfully!", 'guest_id' => $guest->id], 200);
        }
        else
        {
            return new Response(['errors' => ['Something went wrong']], 400);
        }
    }

    public function delete_guest(Request $request)
    {
        $request->validate([
            'guest_id' => 'required',
        ]);

        $guest = Guest::find($request->guest_id);

        if(empty($guest))
        {
            return new Response(['errors' => ['Guest Not Found!']], 400);
        }

        if($guest->delete())
        {
            return new Response(['message' => "Guest Deleted Successfully!"], 200);
        }
        else
        {
            return new Response(['errors' => ['Something went wrong']], 400);
        }
    }

    public function send_invitation(Request $request)
    {
        $request->validate([
            'action_type' => 'required'
        ]);

        if($request->action_type == 'single')
        {
            $guest = Guest::find($request->guest_id);

            $invitation = $guest->party->invitation;

            if(empty($invitation))
            {
                return new Response(['errors' => ['Please create an Invitation to send!']], 400);
            }

            $data = array(
                'invitation_link' => route('guest_view_invitation', $guest->id),
                'host_name' => $guest->party->user->name,
            );

            Mail::to($guest->email)->send(new PartyInvite($data));
        }
        else
        {
            $party = Party::find($request->party_id);

            if(empty($party->invitation))
            {
                return new Response(['errors' => ['Please create an Invitation to send!']], 400);
            }

            $guests = $party->guest->where('status','No Response');
            
            foreach($guests as $guest)
            {
                $data = array(
                    'invitation_link' => route('guest_view_invitation', $guest->id),
                    'host_name' => $party->user->name,
                );

                Mail::to($guest->email)->send(new PartyInvite($data));
            }
        }

        return new Response(['message' => "Invite Sent!"], 200);
    }

    public function view_invitation($guest_id)
    {
        $guest = Guest::find($guest_id);

        $invitation = $guest->party->invitation;

        $data = array(
            'guest_id' => $guest_id,
            'invitation_title' => $invitation->title,
            'invitation_content' => $invitation->content,
            'invitation_image_path' => $invitation->invite_template->image_path,
            'guest_response_status' => $guest->status,
            'host_name' => $guest->party->user->name,
        );


        return view('party.invitation_view', $data);
    }

    public function save_response(Request $request)
    {
        $request->validate([
            'guest_id' => 'required',
            'response' => 'required'
        ]);

        try
        {
            $guest = Guest::find($request->guest_id);

            $guest->update(['status' => $request->response]);

            return new Response(['message' => "Response Recorded!"], 200);
        }
        catch(Exception $e)
        {
            return new Response(['errors' => ['Something went wrong! Please Try again later.']], 400);
        }

    }
}
