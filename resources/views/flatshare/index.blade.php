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

                <div class="col-md-6">

                    <div class="card card-outline
                        {{ $flatshare->status === 'active' ? 'card-success' : 'card-danger' }}">

                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $flatshare->name }}
                            </h3>

                            <div class="card-tools">
                                <span class="badge
                                    {{ $flatshare->status === 'active'
                                        ? 'badge-success'
                                        : 'badge-danger' }}">
                                    {{ ucfirst($flatshare->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <p class="text-muted">
                                {{ $flatshare->description }}
                            </p>
                        </div>

                        <div class="card-footer d-flex justify-content-between">

                            <div>
                                <a href="{{ route('flatshare.show', $flatshare->id) }}"
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                              
                                @if ($flatshare->pivot->internal_role == 'owner')
                                    
                                
                                <a href="{{ route('flatshare.edit', $flatshare->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <a href="{{ route('flatshare.invite', $flatshare->id) }}"
                                   class="btn btn-sm btn-secondary">
                                    <i class="fas fa-user-plus"></i> Invite
                                </a>
                            </div>

                            <form action="{{ route('flatshare.cancel', $flatshare->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </form>
                            @endif
                        </div>

                    </div>

                </div>

            @endforeach

        @else

            <div class="col-12">
                <div class="alert alert-info text-center">
                    No flatshare available.
                </div>
            </div>

        @endif

    </div>

@stop