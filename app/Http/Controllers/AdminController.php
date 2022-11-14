<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function venue_form($form_id = false)
    {
        return view('admin.venue_form', ['form_id' => $form_id]);
    }
}
