@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">📈 Statistics Dashboard</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
                    <h5>Total Users</h5>
                    <h2 class="text-primary fw-bold">{{ $total_users }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
                    <h5>Total Posts : </h5>
                    <h2 class="text-success fw-bold">{{ $total_posts }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
                    <h5>Integrated Platforms</h5>
                    <h2 class="text-warning fw-bold">{{ $platforms }}</h2>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 mt-5 p-4">
            <h5 class="mb-3">Posts Growth Trend (2025)</h5>
            <canvas id="postTrendChart" height="120"></canvas>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const postTrendCtx = document.getElementById('postTrendChart').getContext('2d');
        const postTrendChart = new Chart(postTrendCtx, {
            type: 'line',
            data: {
                labels:  ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Posts',
                    data: {{    json_encode($monthlyPostsData)    }},
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22, 163, 74, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#16a34a',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        }
                    }
                }
            }
        });
    </script>
@endsection
