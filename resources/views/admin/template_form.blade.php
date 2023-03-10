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
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>                    
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Content</label>
                        <textarea class="form-control" name="content" placeholder="Enter Content" id="content" required></textarea>
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
                let template_data=res_data;
                $("#name").html(template_data.name);
                $("#title").html(template_data.title);
                $("#content").html(template_data.content);                               
            },
            error: function(res_data) {}
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



{{-- 
    <script>

 $(document).ready(function() {

        @if(!empty($venue_id))

        let venue_id = "{{$venue_id}}";
        $("#save_btn").prop('disabled', true);
        $.ajax({
            url: "{{ route('fetch_venue_details') }}",
            type: "GET",
            data: {
                venue_id
            },
            success: function(res_data) {
                for (let key in res_data) {
                    if (key == 'timmings') {
                        for (let day in res_data.timmings) {
                            $('#' + day).prop("checked", true);
                            $('.' + day + 'time').prop("disabled", false);
                            $('#' + day + '_from').val(res_data.timmings[day]['from']).trigger('change');
                            $('#' + day + '_to').val(res_data.timmings[day]['to']).trigger('change');
                        }
                    } else if (['cuisines', 'additional_features'].includes(key)) {
                        if (res_data[key]) {
                            $('#' + key + ' option').each(function() {
                                let val = $(this).val();
                                if (res_data[key].includes(val)) {
                                    $(this).prop('selected', true);
                                    delete res_data[key][val];
                                }
                            });
                        }

                        for (let remaining_val in res_data[key]) {
                            $('#' + key).append(`<option selected value="${res_data[key][remaining_val]}">${res_data[key][remaining_val]}</option>`);
                        }
                        $('#' + key).trigger('change')
                    } else if (key == 'primary_picture') {
                        let append_html = `<div id="append_primary" class="col-10">${res_data.primary_picture.original_name}</div><div class="col-2 text-end"><button role="button" onclick="delete_file(event,${res_data.primary_picture.id})" class="btn btn-sm btn-warning"><i class="fa-solid fa-trash-can"></i></div>`;
                        console.log("id"+res_data.primary_picture.id);

                        $('#uploaded_primary_picture').html(append_html);
                    } else if (key == 'secondary_pictures') {
                        if (res_data.secondary_pictures)

                            var append_html = '';
                        for (let sec_file of res_data.secondary_pictures) {
                            append_html += `<div class="mt-1 col-10">${sec_file.original_name}</div><div class="mt-1 col-2 text-end"><button role="button" onclick="delete_file(event,${sec_file.id})" class="btn btn-sm btn-warning"><i class="fa-solid fa-trash-can"></i></div>`;
                        }

                        $('#uploaded_secondary_pictures').html(append_html);

                    } else {
                        $('#' + key).val(res_data[key]);
                    }
                }
                $("#save_btn").prop('disabled', false);
            },
            error: function(res_data) {}
        });
        @endif


        $('#venue_form').submit(function(e) {
            e.preventDefault();
            $("#save_btn").prop('disabled', true);

            let form_data = new FormData(document.getElementById("venue_form"));

            $.ajax({
                url: "{{ route('add_update_venue') }}",
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

    function enable_disable_time(day) {
        if ($('#' + day).is(":checked")) {
            $('.' + day + 'time').prop('disabled', false);
        } else {
            $('.' + day + 'time').prop('disabled', true);
        }
    }

    function delete_file(e,image_id){
        e.preventDefault();
        $.ajax({
            url: "{{route('delete_image')}}",
            type: "POST",
            data: {image_id},
            success: function(res_data) 
            {
                $(e.target).parent().parent().remove();
                alertify.alert('Success', res_data.responseJSON.message);
            },
            error: function(res_data) {
                alertify.alert('Error', res_data.responseJSON.error);
            }
        });
    }
</script>
 --}}
@endsection