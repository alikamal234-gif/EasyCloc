@extends('adminlte::page')

@section('title', $flatshare->name)

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>{{ $flatshare->name }}</h1>
        <small class="text-muted">
            {{ $flatshare->description }}
        </small>
    </div>

    @php
        $pivot = $flatshare->users
            ->where('id', auth()->id())
            ->first()
            ->pivot ?? null;
    @endphp

    @if($pivot && $pivot->internal_role === 'owner')
        <form action="{{ route('flatshare.cancel', $flatshare->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button class="btn btn-danger btn-sm">
                <i class="fas fa-times"></i> Cancel
            </button>
        </form>
    @else
        <form action="{{ route('flatshare.exit', $flatshare->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button class="btn btn-danger btn-sm">
                <i class="fas fa-sign-out-alt"></i> Exit
            </button>
        </form>
    @endif
</div>
@stop


@section('content')

{{-- STATUS BADGE --}}
<div class="mb-4">
    <span class="badge {{ $flatshare->status === 'active' ? 'badge-success' : 'badge-danger' }}">
        {{ ucfirst($flatshare->status) }}
    </span>
</div>

{{-- MEMBERS --}}
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">Members</h3>
    </div>

    <div class="card-body">
        <div class="row">

            @foreach($flatshare->users as $user)
                @if($user->pivot->left_at == null)

                    <div class="col-md-4 mb-3">

                        <div class="border rounded p-3">

                            <strong>
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="badge badge-primary">You</span>
                                @endif
                            </strong>

                            <div class="text-muted small">
                                {{ ucfirst($user->pivot->internal_role) }}
                            </div>

                            <div class="mt-2
                                            @if($user->reputation_score < 0)
                                                text-danger
                                            @elseif($user->reputation_score > 0)
                                                text-success
                                            @endif">
                                Score: {{ $user->reputation_score }}
                            </div>

                        </div>

                    </div>

                @endif
            @endforeach

        </div>
    </div>
</div>


{{-- EXPENSES --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Expenses</h3>

        <div>
            <a href="{{ route('expense.create', $flatshare->id) }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Expense
            </a>

            <a href="{{ route('expense.credit', $flatshare->id) }}" class="btn btn-info btn-sm">
                <i class="fas fa-balance-scale"></i> Settlement
            </a>
        </div>
    </div>

    <div class="card-body p-0">

        @php
            $total = $flatshare->expenses->sum('amount');
        @endphp

        <div class="p-3 border-bottom">
            <strong>Total:</strong>
            <span class="text-primary font-weight-bold">
                {{ $total }} DH
            </span>
        </div>

        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Paid By</th>
                    <th>Date</th>
                    <th class="text-right">Amount</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>

                @forelse($flatshare->expenses as $expense)
                    <tr>
                        <td>{{ $expense->title }}</td>
                        <td>
                            {{ $expense->user->name }}
                            @if($expense->user->id === auth()->id())
                                <span class="badge badge-success">You</span>
                            @endif
                        </td>
                        <td>{{ $expense->date }}</td>
                        <td class="text-right font-weight-bold">
                            {{ $expense->amount }} DH
                        </td>
                        <td>
                            {{ $expense->category->name ?? '—' }}
                        </td>
                        <td>
                            @if ($expense->user->id == Auth()->id())
                                <a href="{{ route('expense.edit', $expense->id) }}">edit</a>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No expenses yet.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>
</div>

@stop