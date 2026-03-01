@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>My Profile</h1>
@stop

@section('content')

    <div class="row">

        {{-- Reputation Card --}}
        <div class="col-md-4">
            <div class="card card-outline 
                @if(auth()->user()->reputation_score >= 0)
                    card-success
                @else
                    card-danger
                @endif">

                <div class="card-header">
                    <h3 class="card-title">Reputation Score</h3>
                </div>

                <div class="card-body text-center">

                    <h2 class="
                        @if(auth()->user()->reputation_score >= 0)
                            text-success
                        @else
                            text-danger
                        @endif
                        font-weight-bold">
                        {{ auth()->user()->reputation_score }}
                    </h2>

                    <small class="text-muted">
                        Based on flatshare activity
                    </small>

                </div>
            </div>
        </div>

        {{-- Update Profile --}}
        <div class="col-md-8">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Update Profile Information</h3>
                </div>

                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>

            </div>
        </div>

    </div>


    <div class="row mt-4">

        {{-- Update Password --}}
        <div class="col-md-6">
            <div class="card card-warning">

                <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                </div>

                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>

            </div>
        </div>

        {{-- Delete Account --}}
        <div class="col-md-6">
            <div class="card card-danger">

                <div class="card-header">
                    <h3 class="card-title">Delete Account</h3>
                </div>

                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>
        </div>

    </div>

@stop