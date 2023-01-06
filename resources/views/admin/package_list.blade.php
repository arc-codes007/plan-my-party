@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header display-6 bg-primary text-white">Package List<a href="{{route('package_form')}}" class="btn btn-default"><i class="fa-solid text-white fa-2xl fa-plus"></i></a></div>
        <div class="card-body">
            <table id="package_list" class="display w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Package Name</th>
                        <th>Venue_Name</th>                        
                        <th>Package Type</th>
                        <th>Venue Type</th>                        
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>

$('#package_list').DataTable( {
    ajax: "{{route('fetch_package_list')}}",
    columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'venue_id' },
            { data: 'type' },
            { data: 'venue_type' },
            { data: 'actions' },
        ],
});

</script>

@endsection