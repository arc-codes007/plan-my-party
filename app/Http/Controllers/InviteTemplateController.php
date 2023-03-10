<?php

namespace App\Http\Controllers;

use App\Models\invite_template;
use App\Models\Image;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class InviteTemplateController extends Controller
{
    public function template_form($template_id = false)
    {
        return view('admin.template_form', ['template_id' => $template_id]);
    }

    public function add_update_template_form(Request $request)
    {


        $validations = array(
            'name' => 'required',
            'title' => 'required',
            'template_content' => 'required',
            'template_picture' => 'required|image',            
        );

        if(isset($request->template_id))
        {
            $invite_template = invite_template::find($request->template_id);

            if(!empty($invite_template['image_path']))
            {
                unset($validations['template_picture']);
            }
        }

        $request->validate($validations);

        $post_data = $request->all(); 

        $template_data = array(            
            'name' => $post_data['name'],
            'title' => $post_data['title'],
            'content' => $post_data['template_content'],             
        );        


        if($request->hasFile('template_picture'))
        {
            $template_image = $request->file('template_picture');                
            $template_data['image_path'] = $template_image->store('images/system/template');
        }                        


        if(!empty($post_data['template_id']))
        {
            $template = invite_template::find($post_data['template_id']);
            $template->update($template_data);
        }
        else
        {
            $template = invite_template::create($template_data);
        }
        
        if($template)
        {                
             return new Response(['redirect' => route('template_list')], 402);
        }

    }


    public function template_list()
    {
        return view('admin.template_list');
    }

    public function fetch_template_list()
    {
        $response_list = array();
        foreach(invite_template::all() as $template)
        {
            $data = array(
                'id' => $template->id,
                'name' => $template->name,
                'title' => $template->title,
                'content' => $template->content,                
            );            

            $actions = '';            
            $actions .= '<a href="'.route('template_form',$template->id).'" class="btn btn-sm btn-info mx-2"><i class="fa-solid text-white fa-pen-to-square"></i></a>';
            $data['actions'] = $actions;
            $response_list[] = $data;
        }

        return new Response(['data' => $response_list], 200);
    }


    function fetch_template_details(Request $request)
    {
        $request->validate([
            'template_id' => 'required'
        ]);

        $template_id = $request->template_id;

        $template_rawdata = invite_template::find($template_id);
        
        $template_details = array(
            'id' => $template_rawdata->id,
            'name' => $template_rawdata->name,
            'title' => $template_rawdata->title,
            'content' => $template_rawdata->content,
        );

        if(!empty($request->party_id))
        {
            $title = $template_rawdata->title;
            $content = $template_rawdata->content;

            $party = Party::find($request->party_id);

            $title = str_replace('{party_name}', $party->name, $title);
            $title = str_replace('{user_name}', Auth::user()->name, $title);
            $title = str_replace('{venue_name}', $party->venue->name, $title);
            $title = str_replace('{party_date}', date("d M Y", strtotime($party->date)), $title);

            if(!empty($party->timming))
            {
                $title = str_replace('{party_start_time}', json_decode($party->timming)->from, $title);
                $title = str_replace('{party_end_time}', json_decode($party->timming)->to, $title);
            }

            $content = str_replace('{party_name}', $party->name, $content);
            $content = str_replace('{user_name}', Auth::user()->name, $content);
            $content = str_replace('{venue_name}', $party->venue->name, $content);
            $content = str_replace('{party_date}', date("d M Y", strtotime($party->date)), $content);

            if(!empty($party->timming))
            {
                $content = str_replace('{party_start_time}', json_decode($party->timming)->from, $content);
                $content = str_replace('{party_end_time}', json_decode($party->timming)->to, $content);
            }

            $template_details['title'] = $title;
            $template_details['content'] = $content;
        }

        return new Response($template_details, 200);

    }



}
