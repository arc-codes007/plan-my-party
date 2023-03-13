<div class="row h5">
    <div class="col-6">
        <form id="party_invitation_form">
            @if (!empty($invitation_data))
                <input type="hidden" id="party_invitation_id" value="{{$invitation_data['id']}}">
            @endif    
            <div class="mx-2 my-3 text-danger fw-bold h3">
                Templates : -
            </div>
            <div class="border border-dark border-2 row m-0 p-0" style="height: 40vh; overflow-y:scroll;" id="party_invite_templates_container">
                @foreach ($invite_templates as $template)
                    @php
                        $selected_template_id = array();
                        if(!empty($invitation_data))
                        {
                            $selected_template_id[] = $invitation_data['invite_template_id'];
                        }
                    @endphp
                    <div class="col-4">
                        <img class="img-thumbnail mx-2 p-2 invite_template_image {{(in_array($template['id'], $selected_template_id)) ? 'bg-selected' : ''}}" style="height: 20rem; width: 15rem; cursor: pointer;" onclick="fetch_invite_data({{$template['id']}}, {{$party_data['id']}}, event)" src="{{asset($template['image_path'])}}" alt="">
                        <div class="text-center">{{ $template['name'] }}</div>    
                    </div>
                @endforeach
            </div>

            <div class="my-3">
                <label for="invitation_title" class="mb-2 form-label">Title:</label>
                <input type="text" class="form-control" name="invitation_title" id="invitation_title" value="{{!empty($invitation_data) ? $invitation_data['title'] : '' }}">
            </div>

            <div class="my-3">
                <label for="invitation_content" class="mb-2 form-label">Content:</label>
                <textarea class="form-control tiny" rows="8" name="invitation_content" placeholder="Enter Content" id="invitation_content">
                    {{!empty($invitation_data) ? $invitation_data['content'] : '' }}
                </textarea>
            </div>
            <div class="mx-2 my-3">
                <button type="submit" id="party_invitation_save_btn" class="btn btn-success text-white">Save</button>
            </div>
        </form>
    </div>
    <div class="col-6 d-flex p-5 justify-content-center align-items-center">
        <div class="border border-dark border-2 row justify-content-center align-items-center template_background" id="party_invitation" style="height : 70vh; width:70%; {{!empty($invitation_data) ? 'background-image : url('.asset($invite_templates[$invitation_data['invite_template_id']]['image_path']).')' : ''}}">
            <div class="text-center h3 mx-2 fw-bold" id="party_invitation_title" style="overflow:hidden">
                {!! !empty($invitation_data) ? $invitation_data['title'] : '' !!}
            </div>
            <div class="text-center h4 mx-2 fw-bold" id="party_invitation_content" style="overflow:hidden">
                {!! !empty($invitation_data) ? $invitation_data['content'] : '' !!}
            </div>
        </div>
    </div>
</div>


<script>
    @if (empty($invitation_data))
        let selected_template_id = null;
    @else
        let selected_template_id = {{$invitation_data['invite_template_id']}}
    @endif
    $(document).ready(function(){

        tinyMCE.init({
            selector: 'textarea.tiny', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
            branding: false,
            promotion: false,
            force_br_newlines : true,
            setup:function(ed) {
                ed.on('keyup', function(e) {
                   $("#party_invitation_content").html(ed.getContent());
                });
            }
        });

        $("#invitation_title").on('keyup', function(){
            $("#party_invitation_title").html($("#invitation_title").val());
        });

        $("#party_invitation_form").submit(function(e){
            e.preventDefault();

            if(selected_template_id == null)
            {
                alertify.alert('Error',"Please select a template!");
            }

            let data = {
                'template_id' : selected_template_id,
                'party_id' : {{$party_data['id']}},
                'title' : $("#invitation_title").val(),
                'content' : tinyMCE.get('invitation_content').getContent(),
            };

            if($("#party_invitation_id").val())
            {
                data['invitation_id'] = $("#party_invitation_id").val();
            }

            $.ajax({
                url: "{{ route('create_update_invitation') }}",
                type: "POST",
                data: data,
                success: function(res_data) {
                    alertify.alert('Notification', res_data.message);
                    $("#party_save_btn").prop('disabled', false);
                },
                error: function(res_data) {
                    $("#party_save_btn").prop('disabled', false);
                }
            });
        });
    });

    function fetch_invite_data(template_id, party_id, e)
    {
        if( ! $(e.target).hasClass('bg-selected'))
        {
            $.ajax({
                url: "{{ route('fetch_template_details') }}",
                type: "GET",
                data: {template_id, party_id},
                success: function(res_data) {
                    $("#invitation_title").val(res_data.title);
                    tinyMCE.get('invitation_content').setContent(res_data.content);

                    $("#party_invitation_title").html(res_data.title);
                    $("#party_invitation_content").html(res_data.content);

                    $(".invite_template_image").removeClass('bg-selected');
                    $(".invite_template_image").removeClass('bg-selected');
                    $("#party_invitation").css('background-image', "url("+$(e.target).attr('src')+")");        
                    $(e.target).addClass('bg-selected');

                    selected_template_id = template_id;

                },
                error: function(res_data) {

                }
            });
        }
    }
</script>