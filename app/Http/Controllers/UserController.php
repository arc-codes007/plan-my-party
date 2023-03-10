<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function user_list()
    {
        return view('admin.user_list');
    }

    public function admin_delete_user($user_id)
    {
        // print_r("helo from delete");
        $user = User::find($user_id);
        if ($user->delete()) {
            return redirect(route('user_list'));
        } else {
            return new Response(['errors' => ['Something went wrong']], 400);
        }
    }

    public function fetch_user_list()
    {
        $response_list = array();

        foreach (User::all() as $user) {
            $data = array(
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
                'phone' => $user->phone,
            );

            $actions = '';
            $actions .= '<a href="' . route('admin_delete_user', $data['id']) . '" class="btn btn-sm btn-warning mx-2"><i class="fa-solid fa-trash-can"></i></a>';


            $data['actions'] = $actions;
            $response_list[] = $data;
        }

        return new Response(['data' => $response_list], 200);
    }
}
