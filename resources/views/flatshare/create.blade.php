@extends('adminlte::page')

@section('title', 'Create Flatshare')

@section('content_header')
    <h1>Create Flatshare</h1>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">New Flatshare</h3>
                </div>

                <form action="{{ route('flatshare.store') }}" method="POST">
                    @csrf

                    <div class="card-body">

                        {{-- Name --}}
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control"
                                   required>

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description"
                                      rows="3"
                                      class="form-control">{{ old('description') }}</textarea>

                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Hidden Status --}}
                        <input type="hidden" name="status" value="active">

                    </div>

                    <div class="card-footer d-flex justify-content-between">

                        <a href="{{ route('flatshare.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-primary">
                            <i class="fas fa-save"></i> Save
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

@stop