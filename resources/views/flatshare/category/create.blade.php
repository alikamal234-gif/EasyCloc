@extends('adminlte::page')

@section('title', 'Create Category')

@section('content_header')
    <h1>Create New Category</h1>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card card-info">

                <div class="card-header">
                    <h3 class="card-title">Add Category</h3>
                </div>

                <form action="{{ route('category.store', $flatshareId) }}" method="POST">
                    @csrf

                    <div class="card-body">

                        {{-- Category Name --}}
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="e.g. Groceries"
                                   class="form-control"
                                   required>

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            @if(session('success'))
                                <small class="text-success">
                                    {{ session('success') }}
                                </small>
                            @endif
                        </div>

                        {{-- Hidden flatshare --}}
                        <input type="hidden" name="flatshare_id" value="{{ $flatshareId }}">

                    </div>

                    <div class="card-footer d-flex justify-content-between">

                        <a href="{{ url()->previous() }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-info">
                            <i class="fas fa-save"></i> Save Category
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

@stop