@extends('adminlte::page')

@section('title', 'My Flatshares')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>My Flatshares</h1>

        @if($is_can)
            <a href="{{ route('flatshare.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Flatshare
            </a>
        @else
            <button class="btn btn-secondary" disabled>
                <i class="fas fa-plus"></i> Create Flatshare
            </button>
        @endif
    </div>
@stop

@section('content')
    <div class="row">
        @if ($flatshares->count() > 0)
            @foreach ($flatshares as $flatshare)
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card card-outline 
                        {{ $flatshare->status === 'active' 
                            ? 'card-success' 
                            : 'card-secondary' }} 
                        h-100 shadow-sm 
                        {{ $flatshare->status === 'cancelled' ? 'opacity-75' : '' }}">

                        {{-- Header --}}
                        <div class="card-header 
                            {{ $flatshare->status === 'cancelled' ? 'bg-secondary text-white' : '' }}">
                            <h3 class="card-title">
                                <i class="fas fa-home mr-2"></i>
                                {{ $flatshare->name }}
                            </h3>
                            <div class="card-tools">
                                <span class="badge 
                                    {{ $flatshare->status === 'active' 
                                        ? 'badge-success' 
                                        : 'badge-secondary' }}">
                                    <i class="fas 
                                        {{ $flatshare->status === 'active' 
                                            ? 'fa-check-circle' 
                                            : 'fa-ban' }} mr-1">
                                    </i>
                                    {{ ucfirst($flatshare->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            @if($flatshare->description)
                                <p class="text-muted mb-0">
                                    {{ Str::limit($flatshare->description, 100) }}
                                </p>
                            @else
                                <p class="text-muted fst-italic mb-0">
                                    No description provided
                                </p>
                            @endif

                            <div class="mt-3 small text-muted">
                                <i class="fas fa-users mr-1"></i>
                                {{ $flatshare->users->count() }} 
                                {{ $flatshare->users->count() == 1 ? 'member' : 'members' }}
                            </div>

                            @if($flatshare->status === 'cancelled' && $flatshare->updated_at)
                                <div class="mt-2 small text-danger">
                                    <i class="fas fa-clock mr-1"></i>
                                    Cancelled: {{ $flatshare->updated_at->format('d M Y') }}
                                </div>
                            @endif
                        </div>

                        <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="{{ route('flatshare.show', $flatshare->id) }}"
                                   class="btn btn-sm 
                                       {{ $flatshare->status === 'active' 
                                           ? 'btn-info' 
                                           : 'btn-secondary' }}"
                                   data-toggle="tooltip" 
                                   title="View details">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($flatshare->status === 'active' && $flatshare->pivot->internal_role == 'owner')
                                    <a href="{{ route('flatshare.edit', $flatshare->id) }}"
                                       class="btn btn-sm btn-warning"
                                       data-toggle="tooltip" 
                                       title="Edit flatshare">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="{{ route('flatshare.invite', $flatshare->id) }}"
                                       class="btn btn-sm btn-secondary"
                                       data-toggle="tooltip" 
                                       title="Invite members">
                                        <i class="fas fa-user-plus"></i>
                                    </a>
                                @endif
                            </div>

                            @if($flatshare->status === 'active' && $flatshare->pivot->internal_role == 'owner')
                                <form action="{{ route('flatshare.cancel', $flatshare->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to cancel this flatshare?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger"
                                            data-toggle="tooltip" 
                                            title="Cancel flatshare">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @elseif($flatshare->status === 'cancelled')
                                <span class="badge badge-secondary p-2">
                                    <i class="fas fa-ban mr-1"></i> Cancelled
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info text-center py-4">
                    <i class="fas fa-home fa-3x mb-3"></i>
                    <h4>No flatshare available</h4>
                    <p class="mb-0">Create your first flatshare to get started!</p>
                </div>
            </div>
        @endif
    </div>
@stop

@section('css')
    <style>
        .opacity-75 {
            opacity: 0.85;
        }
        .card-secondary .card-header {
            background-color: #6c757d;
            color: white;
        }
        .card-secondary .card-header .card-title {
            color: white;
        }
        .card-secondary .card-header .badge {
            background-color: #fff;
            color: #6c757d;
        }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop