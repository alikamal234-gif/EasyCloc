@extends('adminlte::page')

@section('title', 'Edit Flatshare')

@section('content_header')
    <h1>Edit Flatshare</h1>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Update Flatshare Information</h3>
                </div>

                <form action="{{ route('flatshare.update', $flatshare->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        {{-- Name --}}
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $flatshare->name) }}"
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
                                      class="form-control">{{ old('description', $flatshare->description) }}</textarea>

                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-between">

                        <a href="{{ route('flatshare.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

@stop