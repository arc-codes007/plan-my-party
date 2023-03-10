@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-header display-6 bg-primary text-white">Template List<a href="{{route('template_form')}}" class="btn btn-default"><i class="fa-solid text-white fa-2xl fa-plus"></i></a></div>
        <div class="card-body">
            <table id="template_list" class="display w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Content</th>                        
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>

$('#template_list').DataTable( {
    ajax: "{{route('fetch_template_list')}}",
    columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'title' },
            { data: 'content' },            
            { data: 'actions' },
        ],
} );

</script>

@endsection