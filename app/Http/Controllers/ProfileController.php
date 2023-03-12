<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Image;
use App\Models\User;
use Error;
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

    public function profile_view()
    {
        return view('profile');
    }

    public function reset_pass(Request $request)
    {
        $id = $request['user_id'];
        // print_r($id);
        return view('auth.passwords.reset');
    }

    // public function edit_user_profile()
    // {
    //     return view('edit_user_profile');
    // }

    public function update_password(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'current_pass' => 'required',
            'password' => 'required | min:8 | string',
            'password_confirm' => 'required | min:8 | string',
        ]);
        $pass_data = array(
            'user_id' => $request['user_id'],
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
            // return  redirect()->route('profile_view');
            return new Response(['redirect' => route('profile_view')], 200);
        } else {
            return new Response(['redirect' => route('profile_view')], 402);
        }
    }

    public function delete_user(Request $request)
    {
        $request->validate([
            'del_user_id' => 'required',
            'delete_pass_confirm' => 'required | min:8 | string',
        ]);
        $pass_data = array(
            'user_id' => $request['del_user_id'],
            'pass_confirm' => $request['delete_pass_confirm'],
        );
        $user = User::find($pass_data['user_id']);
        if (Hash::check($pass_data['pass_confirm'], $user['password'])) {
            // $user->delete();
            if ($user->delete()) {
                Auth::logout();
                return redirect(route('landing'));
            }
        } else {
            return new Response(['errors' => ['Something went wrong']],400);
        }
    }

    public function fetch_user_detail(Request $request)
    {
        $user_id = $request["user_id"];
        $user_data = User::find($user_id);
        $user_data = $user_data->getAttributes();
        $user_details = array(
            'email' => $user_data['email'],
            'phone' => $user_data['phone'],
        );
        return new Response($user_details, 200);
    }

    public function update_user(Request $request)
    {

        $request->validate([
            'email' => 'required | email | unique:users',
            'phone' => 'required | digits:10',
        ]);

        $update_data = array(
            'id' => $request['id'],
            'email' => $request['email'],
            'phone' => $request['phone'],
        );
        // print_r($update_data);


        $user = User::find($update_data['id'])->get()->all();
        if (!empty($user)) {
            $users = User::where('id', $update_data['id'])->first();
            $users->update($update_data);
            // print_r("success");
            return new Response(['redirect' => route('profile_view')], 200);
        } else {
            return new Response(['redirect' => route('profile_view')], 402);
        }
    }
}
