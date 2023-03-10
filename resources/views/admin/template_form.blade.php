@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <form id="template_form">
        @if (!empty($template_id))
        <input type="hidden" name="template_id" value="{{$template_id}}">
        @endif
        <div class="card mb-5">
            <div class="card-body">
                <div class="card-title display-5 text-center">Template Form</div>
                <div class="row gap-4 justify-content-center">
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="template_name" name="name" required>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" id="template_title" name="title" required>
                    </div>                    
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Content</label>
                        <textarea class="form-control" name="content" placeholder="Enter Content" id="template_content" required></textarea>
                    </div>
                    
                    <div class="col-md-4 col-sm-12">                        
                        <div class="mt-3">
                            <label class="form-label">Template Picture</label>
                            <input class="form-control" type="file" name="template_picture" id="template_picture" accept="image/png, image/jpeg">
                            <div id="uploaded_template_picture" class="row mt-2"></div>
                        </div>                        
                    </div>                    
                </div>
            </div>
        </div>
        <div class="fixed-bottom row bg-white p-3 justify-content-end">
            <div class="col-sm-3">
                <button type="submit" id="save_btn" class="btn btn-danger text-white">Save</button>
                <button type="reset" class="btn btn-outline-danger">Reset</button>
            </div>
        </div>
    </form>
</div>
 
<script>

$(document).ready(function() { 
    
@if(!empty($template_id))
    let template_id = "{{$template_id}}";
    $("#save_btn").prop('disabled', true);
    $.ajax({
            url: "{{ route('fetch_template_details') }}",
            type: "GET",
            data: {
                    template_id
            },
            success: function(res_data) {
                let template_data = res_data;
                $("#template_name").val(template_data.name);
                $("#template_title").val(template_data.title);
                $("#template_content").val(template_data.content);                               

                $("#save_btn").prop('disabled', false);
            },
            error: function(res_data) {
                $("#save_btn").prop('disabled', false);
            }
    });
@endif  

    $('#template_form').submit(function(e) {
            e.preventDefault();
            $("#save_btn").prop('disabled', true);

            let form_data = new FormData(document.getElementById("template_form"));

            $.ajax({
                url: "{{ route('add_update_template') }}",
                type: "POST",
                data: form_data,
                processData: false,
                contentType: false,
                success: function(res_data) {
                    $("#save_btn").prop('disabled', false);
                },
                error: function(res_data) {
                    $("#save_btn").prop('disabled', false);
                }
            });

        });
    });

</script>

@endsection