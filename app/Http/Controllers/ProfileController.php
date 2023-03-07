<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile_admin_view($id)
    {
        if (Auth::user()->is_admin == 1) {
            $data['user_type'] = 'admin';
            $user = User::where('id', $id)->first();
            $data['user'] = $user;
            return view('profile_admin_view', $data);
        } else {
            abort(401);
        }
    }

    public function profile_view()
    {
        return view('profile');
    }

    public function reset_pass(Request $request)
    {
        $id = $request['user_id'];
        print_r($id);
        return view('auth.passwords.reset');
    }

    public function edit_user_profile()
    {
        return view('edit_user_profile');
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'current_pass' => 'required',
            'password' => 'required | min:8 | string',
            'password_confirm' => 'required | min:8 | string',
        ]);
        $pass_data = array(
            'user_id' => $request['id'],
            'old_pass' => $request['current_pass'],
            'new_pass' => $request['password'],
            'confirm_pass' => $request['password_confirm'],
        );
        $user = User::find($pass_data['user_id']);
        if (Hash::check($pass_data['old_pass'], $user['password'])) {
            // The passwords match...
            if ($pass_data['old_pass'] == $pass_data['new_pass']) {
                print_r("new password cant be same as old one");
            } else if ($pass_data['new_pass'] == $pass_data['confirm_pass']) {
                $user->password = Hash::make($pass_data['new_pass']);
            }
        }
        $data['user'] = $user;
        if ($user->save()) {
            return  redirect()->route('profile_view');
        } else {
            return  redirect()->route('edit_user_profile');
        }
    }

    public function update_user(Request $request)
    {

        $request->validate([
            'email' => 'required | email',
            'phone' => 'required | digits:10',
        ]);

        $update_data = array(
            'id' => $request['id'],
            'email' => $request['email'],
            'phone' => $request['phone'],
        );
        print_r($update_data);


        $user = User::find($update_data['id'])->get()->all();
        if (!empty($user)) {
            $users = User::where('id', $update_data['id'])->first();
            $users->update($update_data);
            print_r("success");
            return new Response(['redirect' => route('profile_view')], 200);
        } else {
            return new Response(['redirect' => route('edit_user_profile')], 402);
        }
    }
}
