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

    public function fetch_user_list()
    {
        $response_list = array();

        foreach(User::all() as $user)
        {           
            $data = array(
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' =>$user->is_admin,
                'phone' => $user->phone,                
            );           
                
            $actions = '';
            //yash page add here 
            $actions .= '<a href="'.route('package_form',$user->id).'" class="btn btn-sm btn-info mx-2"><i class="fa-solid text-white fa-pen-to-square"></i></a>';
            $actions .= '<a href="#" class="btn btn-sm btn-warning mx-2"><i class="fa-solid fa-trash-can"></i></a>';


            $data['actions'] = $actions;
            $response_list[] = $data;
        }

        return new Response(['data' => $response_list], 200);
    }

}
