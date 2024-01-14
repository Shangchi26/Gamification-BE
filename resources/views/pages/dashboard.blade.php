@extends('layout')
@section('content')
    <section class="bg-gray-200 min-h-screen w-full pl-6 sm:pl-[88px] pr-6 overflow-hidden font-inter">
        <div class="h-4 flex items-center gap-1 my-2">
            <a href="/admin/dashboard" class="text-pink-400">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </a>
            <p class="text-gray-400">/ Dashboard</p>
        </div>
        <h1 class="font-bold text-2xl leading-7 my-6">Statistic Gamification </h1>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:flex">
            <div class="w-full bg-white px-4 py-5 rounded-lg shadows xl:w-96">
                <div class="flex gap-5">
                    <div class="p-3 bg-blue-50 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm leading-5 font-semibold text-gray-500">Lượt mua</h3>
                        <p class="text-2xl leading-8 font-semibold text-gray-900">{{ $data[0]['orderCount'] }}</p>
                    </div>
                </div>
            </div>
            <div class="w-full bg-white px-4 py-5 rounded-lg shadows xl:w-96">
                <div class="flex gap-5">
                    <div class="p-3 bg-blue-50 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6 w-6 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm leading-5 font-semibold text-gray-500">Doanh số</h3>
                        <p class="text-2xl leading-8 font-semibold text-gray-900">{{ $data[0]['totalPrice'] }} VNĐ</p>
                    </div>
                </div>
            </div>
            <div class="w-full bg-white px-4 py-5 rounded-lg shadows xl:w-96">
                <div class="flex gap-5">
                    <div class="p-3 bg-blue-50 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm leading-5 font-semibold text-gray-500">Lượt đăng ký mới</h3>
                        <p class="text-2xl leading-8 font-semibold text-gray-900">{{ $data[0]['userCount'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 h-[600px] p-4 pb-8 bg-white rounded-lg shadow">
            <h2 class="text-xl leading-7 font-bold">Chart</h2>
            <canvas id="myChart" class=""></canvas>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('myChart');

            const currentDate = new Date();
            const labels = [];
            labels.push(currentDate.toLocaleDateString());
            for (let i = 0; i <= 8; i++) {
                const day = new Date(currentDate);
                const lastSunday = day.getDate() - day.getDay(); // Lấy ngày Chủ Nhật của tuần trước
                day.setDate(lastSunday - i * 7); // Lấy Chủ Nhật của các tuần trước
                labels.push(day.toLocaleDateString());
            }

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels.reverse(),
                    datasets: [{
                        label: '# of Orders count',
                        data: [{{ $data[9]['orderCount'] }}, {{ $data[8]['orderCount'] }},
                            {{ $data[7]['orderCount'] }},
                            {{ $data[6]['orderCount'] }}, {{ $data[5]['orderCount'] }},
                            {{ $data[4]['orderCount'] }}, {{ $data[3]['orderCount'] }},
                            {{ $data[2]['orderCount'] }}, {{ $data[1]['orderCount'] }},
                            {{ $data[0]['orderCount'] }}
                        ],
                        borderWidth: 2,
                        borderColor: '#22D3EE'
                    }, {
                        label: '# of Users count',
                        data: [{{ $data[9]['userCount'] }}, {{ $data[8]['userCount'] }},
                            {{ $data[7]['userCount'] }},
                            {{ $data[6]['userCount'] }}, {{ $data[5]['userCount'] }},
                            {{ $data[4]['userCount'] }}, {{ $data[3]['userCount'] }},
                            {{ $data[2]['userCount'] }}, {{ $data[1]['userCount'] }},
                            {{ $data[0]['userCount'] }}
                        ],
                        borderWidth: 2,
                        borderColor: '#EC4A6D'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    maintainAspectRatio: false,
                }
            });
        });
    </script>
@endsection
