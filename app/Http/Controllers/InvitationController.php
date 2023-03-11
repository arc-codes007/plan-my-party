<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class InvitationController extends Controller
{
    public function create_update_invitation(Request $request)
    {
        $request->validate([
            'template_id' => 'required',
            'party_id' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);


        $invitation_data = array(
            'invite_template_id' => $request->template_id,
            'title' => $request->title,
            'content' => $request->content,
        );

        DB::beginTransaction();

        
        if(!empty($request->invitation_id))
        {
            $invitation = Invitation::find($request->invitation_id);
            $invitation->update($invitation_data);
            $party = TRUE;
        }
        else
        {
            $invitation = Invitation::create($invitation_data);
            $party = Party::find($request->party_id)->update(['invitation_id' => $invitation->id]);
        }

        if($invitation && $party)
        {
            DB::commit();
            return new Response(['message' => "Invitation Saved Successfully!"], 200);
        }
        else
        {
            DB::rollBack();
            return new Response(['errors' => ['Something went wrong']], 400);
        }
    }
}
