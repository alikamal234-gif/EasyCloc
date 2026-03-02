@extends('adminlte::page')

@section('title', 'Settlement')

@section('content_header')
    <h1>Settlement - {{ $flatshare->name }}</h1>
@stop


@section('content')

    <div class="row mb-4">

        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-primary">
                    <i class="fas fa-coins"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Expenses</span>
                    <span class="info-box-number">
                        {{ number_format($total,2) }} DH
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-purple">
                    <i class="fas fa-user-friends"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Share Per Member</span>
                    <span class="info-box-number">
                        {{ number_format($share,2) }} DH
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-secondary">
                    <i class="fas fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Members</span>
                    <span class="info-box-number">
                        {{ $flatshare->users->count() }}
                    </span>
                </div>
            </div>
        </div>

    </div>


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Payment Overview</h3>
        </div>

        <div class="card-body p-0">

            @if(count($settlements) === 0)

                <div class="p-4 text-center text-success font-weight-bold">
                    Everyone is settled 
                </div>

            @else

                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>To</th>
                            <th class="text-right">Amount</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($settlements as $settlement)

                            <tr>

                                <td>
                                    <strong>{{ $settlement['from']->name }}</strong>
                                </td>

                                <td>
                                    <strong>{{ $settlement['to']->name }}</strong>
                                </td>

                                <td class="text-right text-danger font-weight-bold">
                                    {{ number_format($settlement['amount'],2) }} DH
                                </td>

                                <td class="text-center">

                                    @if ($settlement['to']->id == Auth()->id())

                                        <form action="{{ route('payment.market') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="amount"
                                                   value="{{ $settlement['amount'] }}">

                                            <input type="hidden" name="debtor_id"
                                                   value="{{ Auth()->id() }}">

                                            <input type="hidden" name="creditor_id"
                                                   value="{{ $settlement['from']->id }}">

                                            <input type="hidden" name="flatshare_id"
                                                   value="{{ $flatshare->id }}">

                                            <button type="submit"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Mark as Paid
                                            </button>
                                        </form>

                                    @else
                                        <span class="badge badge-warning">
                                            Pending
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>
                </table>

            @endif

        </div>
    </div>

@stop