@extends('layouts.app')
@section('title', __('app.reports.title'))
@section('content')
<div class="py-2">
    <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('app.reports.title') }}</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mb-3"><i class="fas fa-rupee-sign text-green-600"></i></div>
            <div class="text-2xl font-bold text-gray-900">₹{{ number_format($totalRevenue) }}</div>
            <div class="text-sm text-gray-500 mt-0.5">{{ __('app.reports.total_revenue') }}</div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mb-3"><i class="fas fa-percentage text-blue-600"></i></div>
            <div class="text-2xl font-bold text-gray-900">{{ $winRate }}%</div>
            <div class="text-sm text-gray-500 mt-0.5">{{ __('app.reports.win_rate') }}</div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mb-3"><i class="fas fa-chart-line text-purple-600"></i></div>
            <div class="text-2xl font-bold text-gray-900">₹{{ number_format($avgDealValue) }}</div>
            <div class="text-sm text-gray-500 mt-0.5">{{ __('app.reports.avg_deal_value') }}</div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mb-3"><i class="fas fa-exchange-alt text-yellow-600"></i></div>
            <div class="text-2xl font-bold text-gray-900">{{ $conversionRate }}%</div>
            <div class="text-sm text-gray-500 mt-0.5">{{ __('app.reports.conversion_rate') }}</div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4">{{ __('app.reports.monthly_sales') }}</h3>
            <canvas id="monthlySalesChart" height="200"></canvas>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4">{{ __('app.reports.leads_by_source') }}</h3>
            <canvas id="leadsBySourceChart" height="200"></canvas>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4">{{ __('app.reports.top_deals') }}</h3>
            <div class="space-y-3">
                @foreach($topDeals as $deal)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div>
                        <a href="{{ route('deals.show', $deal) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $deal->title }}</a>
                        <p class="text-xs text-gray-400">{{ __('app.stages.'.$deal->stage) }}</p>
                    </div>
                    <span class="text-sm font-bold text-green-600">₹{{ number_format($deal->value) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4">{{ __('app.reports.leads_by_status') }}</h3>
            <div class="space-y-3">
                @foreach($leadsByStatus as $item)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ __('app.status.'.$item->status) }}</span>
                    <div class="flex items-center gap-3">
                        <div class="w-32 bg-gray-100 rounded-full h-2">
                            <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ $totalLeads > 0 ? ($item->count / $totalLeads * 100) : 0 }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-700 w-8 text-right">{{ $item->count }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
new Chart(document.getElementById('monthlySalesChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlySales->pluck('month')->toArray()) !!},
        datasets: [{ label: 'Revenue (₹)', data: {!! json_encode($monthlySales->pluck('total')->toArray()) !!}, borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,0.1)', fill: true, tension: 0.4, pointBackgroundColor: '#6366f1' }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
});
new Chart(document.getElementById('leadsBySourceChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($leadsBySource->pluck('source')->map(fn($s) => ucwords(str_replace('_',' ',$s ?? 'Unknown')))->toArray()) !!},
        datasets: [{ data: {!! json_encode($leadsBySource->pluck('count')->toArray()) !!}, backgroundColor: ['#6366f1','#f59e0b','#22c55e','#ef4444','#8b5cf6','#06b6d4','#f97316'], borderWidth: 0 }]
    },
    options: { responsive: true, cutout: '60%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, padding: 10, font: { size: 11 } } } } }
});
</script>
@endpush
@endsection
