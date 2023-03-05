@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header display-6 bg-primary text-white">User List </div>
        <div class="card-body">
            <table id="user_list" class="display w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>User Email</th>                        
                        <th>Is Admin</th>
                        <th>User Phone</th>                        
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>

$('#user_list').DataTable( {
    ajax: "{{route('fetch_user_list')}}",
    columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'is_admin' },
            { data: 'phone' },
            { data: 'actions' },
        ],
});

</script>

@endsection