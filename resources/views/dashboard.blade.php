@extends('layouts.app')

@section('content')

<h1 class="mb-4">Dashboard</h1>

<div class="row">

    <div class="col-md-3">
        <div class="card-stat bg-primary text-white">
            <h5>Total Members</h5>
            <h2>{{ $totalMembers }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-stat bg-success text-white">
            <h5>Total Trainers</h5>
            <h2>{{ $totalTrainers }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-stat bg-warning text-dark">
            <h5>Paid Bills</h5>
            <h2>{{ $paidBills }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-stat bg-danger text-white">
            <h5>Unpaid Bills</h5>
            <h2>{{ $unpaidBills }}</h2>
        </div>
    </div>

</div>

<div class="row mt-4">

    <div class="col-md-12">
        <div class="card-stat bg-dark text-white">
            <h4>Total Revenue</h4>
            <h1>₱{{ number_format($revenue, 2) }}</h1>
        </div>
    </div>

</div>

@endsection