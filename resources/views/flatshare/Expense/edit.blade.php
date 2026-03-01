@extends('adminlte::page')

@section('title', 'Edit Expense')

@section('content_header')
    <h1>Edit Expense - {{ $expense->flatshare->name }}</h1>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card card-warning">

                <div class="card-header">
                    <h3 class="card-title">Update Expense</h3>
                </div>

                <form action="{{ route('expense.update', $expense->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        {{-- Title --}}
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $expense->title) }}"
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
                                   value="{{ old('amount', $expense->amount) }}"
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
                                   value="{{ old('date', \Carbon\Carbon::parse($expense->date)->format('Y-m-d')) }}"
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

                                @foreach ($expense->flatshare->categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $expense->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-between">

                        <a href="{{ route('flatshare.show', $expense->flatshare_id) }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Expense
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

@stop