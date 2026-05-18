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
    .dashboard-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
        z-index: 0;
    }
    .dashboard-content {
        position: relative;
        z-index: 1;
    }
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
    .search-box input, .search-box select {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        border-radius: 8px;
    }
    .search-box input::placeholder { color: rgba(255,255,255,0.5); }
    .search-box input:focus, .search-box select:focus {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.4);
        color: white;
        box-shadow: none;
    }
    .search-box select option { background: #1a1a1a; color: white; }
    .table-dark-glass {
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        overflow: hidden;
    }
    .table-dark-glass table { margin: 0; }
    .table-dark-glass thead th {
        background: rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.8);
        border: none;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .table-dark-glass tbody tr {
        background: transparent !important;
    }
    .table-dark-glass tbody td {
        color: rgba(255,255,255,0.85);
        border-color: rgba(255,255,255,0.05);
        font-size: 0.9rem;
        background: transparent !important;
    }
    .table-dark-glass tbody tr:hover td {
        background: rgba(255,255,255,0.05) !important;
    }
    .autocomplete-wrapper {
        position: relative;
    }
    .autocomplete-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        z-index: 999;
        max-height: 200px;
        overflow-y: auto;
        display: none;
    }
    .autocomplete-list.show { display: block; }
    .autocomplete-item {
        padding: 10px 14px;
        color: rgba(255,255,255,0.85);
        cursor: pointer;
        font-size: 0.9rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        transition: 0.2s;
    }
    .autocomplete-item:hover {
        background: rgba(220,53,69,0.3);
        color: white;
    }
    .autocomplete-item span {
        color: rgba(255,255,255,0.4);
        font-size: 0.8rem;
        margin-left: 8px;
    }
</style>

<div class="dashboard-bg">
    <div class="dashboard-overlay"></div>
    <div class="container dashboard-content">

        <h1 class="mb-4 fw-bold text-uppercase text-white" style="letter-spacing: 1px;">WEBFit</h1>

        {{-- STATS --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="glass-card text-white shadow-sm p-3">
                    <h6 class="opacity-75">Total Members</h6>
                    <h2 class="fw-bold">{{ $totalMembers ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card text-white shadow-sm p-3">
                    <h6 class="opacity-75">Total Trainers</h6>
                    <h2 class="fw-bold">{{ $totalTrainers ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card text-white shadow-sm p-3">
                    <h6 class="opacity-75">Paid Bills</h6>
                    <h2 class="fw-bold text-success">{{ $paidBills ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card text-white shadow-sm p-3">
                    <h6 class="opacity-75">Unpaid Bills</h6>
                    <h2 class="fw-bold text-danger">{{ $unpaidBills ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- REVENUE --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="glass-card text-center text-white p-5">
                    <h5 class="text-uppercase opacity-75">Total Revenue</h5>
                    <h1 class="fw-bold text-success">₱{{ number_format($revenue ?? 0, 2) }}</h1>
                    <p class="opacity-50 mb-0">Push harder. Earn stronger results.</p>
                </div>
            </div>
        </div>

        {{-- CHARTS ROW --}}
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="glass-card p-4">
                    <h6 class="text-white opacity-75 mb-3">Monthly Revenue</h6>
                    <canvas id="revenueChart" height="120"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card p-4">
                    <h6 class="text-white opacity-75 mb-3">Members by Plan</h6>
                    <canvas id="planChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- BILLING STATUS BAR --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="glass-card p-4">
                    <h6 class="text-white opacity-75 mb-3">Billing Status</h6>
                    <canvas id="billingChart" height="80"></canvas>
                </div>
            </div>
        </div>

        {{-- SEARCH & FILTER --}}
        <div class="glass-card p-4 mb-4">
            <h6 class="text-white opacity-75 mb-3">Smart Search — Recent Members</h6>
            <form method="GET" action="/dashboard" class="search-box" id="searchForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="autocomplete-wrapper">
                            <input
                                type="text"
                                name="search"
                                id="searchInput"
                                class="form-control"
                                placeholder="Search by name or email..."
                                value="{{ $search ?? '' }}"
                                autocomplete="off"
                            >
                            <div class="autocomplete-list" id="autocompleteList"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="plan_id" class="form-select">
                            <option value="">All Plans</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $planFilter == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-danger w-100">Search</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- MEMBERS TABLE --}}
        <div class="table-dark-glass mb-5">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Start Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentMembers as $member)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->membershipPlan->name ?? 'N/A' }}</td>
                        <td>{{ $member->start_date }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center opacity-50">No members found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const revenueData = @json($billingByMonth);

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: revenueData.map(d => monthNames[d.month - 1]),
            datasets: [{
                label: 'Revenue (₱)',
                data: revenueData.map(d => d.total),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40,167,69,0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#28a745',
            }]
        },
        options: {
            plugins: { legend: { labels: { color: 'white' } } },
            scales: {
                x: { ticks: { color: 'rgba(255,255,255,0.6)' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                y: { ticks: { color: 'rgba(255,255,255,0.6)' }, grid: { color: 'rgba(255,255,255,0.05)' } }
            }
        }
    });

    const planData = @json($membersByPlan);

    new Chart(document.getElementById('planChart'), {
        type: 'doughnut',
        data: {
            labels: planData.map(p => p.name),
            datasets: [{
                data: planData.map(p => p.members_count),
                backgroundColor: ['#dc3545', '#28a745', '#ffc107', '#17a2b8'],
                borderWidth: 0,
            }]
        },
        options: {
            plugins: { legend: { labels: { color: 'white', font: { size: 11 } } } }
        }
    });

    new Chart(document.getElementById('billingChart'), {
        type: 'bar',
        data: {
            labels: ['Paid', 'Unpaid'],
            datasets: [{
                label: 'Bills',
                data: [{{ $paidBills }}, {{ $unpaidBills }}],
                backgroundColor: ['rgba(40,167,69,0.7)', 'rgba(220,53,69,0.7)'],
                borderRadius: 8,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { color: 'rgba(255,255,255,0.6)' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                y: { ticks: { color: 'rgba(255,255,255,0.6)' }, grid: { color: 'rgba(255,255,255,0.05)' } }
            }
        }
    });

    // Autocomplete - live search from database
    const searchInput = document.getElementById('searchInput');
    const autocompleteList = document.getElementById('autocompleteList');

    let debounceTimer;

    searchInput.addEventListener('input', function() {
        const val = this.value.trim();
        autocompleteList.innerHTML = '';

        if (val.length < 1) {
            autocompleteList.classList.remove('show');
            return;
        }

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetch(`/dashboard/search?q=${encodeURIComponent(val)}`)
                .then(res => res.json())
                .then(members => {
                    autocompleteList.innerHTML = '';

                    if (members.length === 0) {
                        autocompleteList.classList.remove('show');
                        return;
                    }

                    members.forEach(m => {
                        const item = document.createElement('div');
                        item.classList.add('autocomplete-item');
                        item.innerHTML = `${m.name} <span>${m.email} — ${m.plan}</span>`;
                        item.addEventListener('click', () => {
                            searchInput.value = m.name;
                            autocompleteList.classList.remove('show');
                            document.getElementById('searchForm').submit();
                        });
                        autocompleteList.appendChild(item);
                    });

                    autocompleteList.classList.add('show');
                });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target)) {
            autocompleteList.classList.remove('show');
        }
    });
</script>

@endsection