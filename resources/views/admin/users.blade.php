@extends('adminlte::page')

@section('title', 'Users Management')

@section('content_header')
<h1>Users Management</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">

    <div class="card-header">
        <h3 class="card-title">All Users</h3>
    </div>

    <div class="card-body table-responsive p-0">

        <table class="table table-hover text-nowrap">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Reputation</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($users as $user)

                    <tr>

                        <td>{{ $user->id }}</td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td>

                            <span class="
                        @if($user->reputation_score > 0)
                            text-success
                        @elseif($user->reputation_score < 0)
                            text-danger
                        @endif
                        ">

                                {{ $user->reputation_score }}

                            </span>

                        </td>

                        <td>

                            @if($user->is_banned)

                                <span class="badge badge-danger">
                                    Banned
                                </span>

                            @else

                                <span class="badge badge-success">
                                    Active
                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                @if(!$user->is_banned)

                                    <form action="{{ route('admin.users.ban', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <button class="btn btn-warning btn-sm">
                                            Ban
                                        </button>

                                    </form>

                                @else

                                    <form action="{{ route('admin.users.unban', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <button class="btn btn-success btn-sm">
                                            Unban
                                        </button>

                                    </form>

                                @endif

                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="card-footer">

        {{ $users->links() }}

    </div>

</div>

@stop