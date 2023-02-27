<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    


    public function index()
    {
        return view('admin.admin_panel');
    }

    public function fetch_admindash_stats()
    {
        $statistics = array(
            'users' => User::count(),
            'venues' => Venue::count(),
            'packages' => Package::count(),
        );

        return new Response(['data' => $statistics], 200);
    }
}
