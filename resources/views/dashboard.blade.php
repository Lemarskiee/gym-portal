@extends('layouts.app')

@section('content')

<style>
    .dashboard-bg {
        background: url('/images/gym-bg.jpg') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
        position: relative;
        padding: 30px 0;
    }

    /* DARK OVERLAY */
    .dashboard-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
        z-index: 0;
    }

    /* CONTENT ON TOP */
    .dashboard-content {
        position: relative;
        z-index: 1;
    }

    /* GLASS EFFECT CARDS */
    .glass-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        transition: 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-4px);
        background: rgba(255, 255, 255, 0.12);
    }
</style>

<div class="dashboard-bg">

    <div class="dashboard-overlay"></div>

    <div class="container dashboard-content">

        <h1 class="mb-4 fw-bold text-uppercase text-white" style="letter-spacing: 1px;">
            WEBFit
        </h1>

        {{-- STATS --}}
        <div class="row g-4">

            <div class="col-md-3">
                <div class="glass-card text-white shadow-sm">
                    <div class="p-3">
                        <h6 class="opacity-75">Total Members</h6>
                        <h2 class="fw-bold">{{ $totalMembers ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="glass-card text-white shadow-sm">
                    <div class="p-3">
                        <h6 class="opacity-75">Total Trainers</h6>
                        <h2 class="fw-bold">{{ $totalTrainers ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="glass-card text-white shadow-sm">
                    <div class="p-3">
                        <h6 class="opacity-75">Paid Bills</h6>
                        <h2 class="fw-bold">{{ $paidBills ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="glass-card text-white shadow-sm">
                    <div class="p-3">
                        <h6 class="opacity-75">Unpaid Bills</h6>
                        <h2 class="fw-bold">{{ $unpaidBills ?? 0 }}</h2>
                    </div>
                </div>
            </div>

        </div>

        {{-- REVENUE --}}
        <div class="row mt-4">

            <div class="col-md-12">
                <div class="glass-card text-center text-white p-5">

                    <h5 class="text-uppercase opacity-75">Total Revenue</h5>

                    <h1 class="fw-bold text-success">
                        ₱{{ number_format($revenue ?? 0, 2) }}
                    </h1>

                    <p class="opacity-50 mb-0">
                        Push harder. Earn stronger results.
                    </p>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection