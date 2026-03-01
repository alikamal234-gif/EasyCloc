@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Platform Statistics</h1>
@stop

@section('content')


    <div class="row">

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $activeFlatshares }}</h3>
                    <p>Active Flatshares</p>
                </div>
                <div class="icon">
                    <i class="fas fa-home"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($totalAmount,2) }} DH</h3>
                    <p>Total amount Expenses</p>
                </div>
                <div class="icon">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($totalPaid,2) }} DH</h3>
                    <p>Total Paid</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

    </div>



    <div class="row">

        <div class="col-md-4">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Users Overview</h3>
                </div>
                <div class="card-body">
                    <p><strong>Active:</strong> {{ $activeUsers }}</p>
                    <p><strong>Banned:</strong> {{ $bannedUsers }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Flatshares Overview</h3>
                </div>
                <div class="card-body">
                    <p><strong>Total:</strong> {{ $totalFlatshares }}</p>
                    <p><strong>Cancelled:</strong> {{ $cancelledFlatshares }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                </div>
                <div class="card-body">
                    <p><strong>Total Categories:</strong> {{ $totalCategories }}</p>
                </div>
            </div>
        </div>

    </div>


    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Top 5 Spenders</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Total Spent</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topSpenders as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>
                                {{ number_format($user->total_spent ?? 0,2) }} DH
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Most Active Flatshares</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Flatshare</th>
                        <th>Expenses Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topFlatshares as $flatshare)
                        <tr>
                            <td>{{ $flatshare->name }}</td>
                            <td>{{ $flatshare->expenses_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop