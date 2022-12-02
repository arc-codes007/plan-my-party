@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header display-6 bg-primary text-white">Venue List<a href="{{route('venue_form')}}" class="btn btn-default"><i class="fa-solid text-white fa-2xl fa-plus"></i></a></div>
        <div class="card-body">
            <table id="venue_list" class="display w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Venue Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>

$('#venue_list').DataTable( {
    ajax: "{{route('fetch_venue_list')}}",
    columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'type' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'venue_rating' },
            { data: 'actions' },
        ],
} );

</script>

@endsection