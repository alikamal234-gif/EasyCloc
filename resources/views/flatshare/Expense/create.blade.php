@extends('adminlte::page')

@section('title', 'Add Expense')

@section('content_header')
    <h1>Add Expense - {{ $flatshare->name }}</h1>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">New Expense</h3>
                </div>

                <form action="{{ route('expense.store', $flatshare->id) }}" method="POST">
                    @csrf

                    <div class="card-body">

                        {{-- Title --}}
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title') }}"
                                   class="form-control"
                                   required>

                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Amount --}}
                        <div class="form-group">
                            <label>Amount (DH)</label>
                            <input type="number"
                                   step="0.01"
                                   name="amount"
                                   value="{{ old('amount') }}"
                                   class="form-control"
                                   required>

                            @error('amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Date --}}
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date"
                                   name="date"
                                   value="{{ old('date', date('Y-m-d')) }}"
                                   class="form-control"
                                   required>

                            @error('date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id"
                                    class="form-control"
                                    required>
                                <option value="">Select Category</option>

                                @foreach($flatshare->categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Hidden Fields --}}
                        <input type="hidden" name="flatshare_id" value="{{ $flatshare->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    </div>

                    <div class="card-footer d-flex justify-content-between">

                        <a href="{{ route('flatshare.show', $flatshare->id) }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-success">
                            <i class="fas fa-save"></i> Save Expense
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

@stop