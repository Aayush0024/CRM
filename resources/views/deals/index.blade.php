@extends('layouts.app')
@section('title', __('app.deals.title'))
@section('content')
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-bold text-gray-900">{{ __('app.deals.title') }}</h2>
        <div class="flex gap-2">
            <button onclick="toggleView('kanban')" id="btnKanban" class="px-3 py-2 text-sm rounded-xl border border-gray-200 bg-indigo-600 text-white transition"><i class="fas fa-columns mr-1"></i> {{ __('app.deals.kanban') }}</button>
            <button onclick="toggleView('list')" id="btnList" class="px-3 py-2 text-sm rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition"><i class="fas fa-list mr-1"></i> {{ __('app.deals.list') }}</button>
            <a href="{{ route('deals.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
                <i class="fas fa-plus"></i> {{ __('app.deals.add') }}
            </a>
        </div>
    </div>

    {{-- Kanban View --}}
    <div id="kanbanView" class="overflow-x-auto pb-4">
        <div class="flex gap-4 min-w-max">
            @foreach(['prospecting','qualification','proposal','negotiation','closed_won','closed_lost'] as $stage)
            @php $stageDeals = $deals->where('stage', $stage); @endphp
            <div class="w-72 flex-shrink-0">
                <div class="flex items-center justify-between mb-3 px-1">
                    <h3 class="font-semibold text-sm text-gray-700">{{ __('app.stages.'.$stage) }}</h3>
                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ $stageDeals->count() }}</span>
                </div>
                <div class="kanban-col bg-gray-100 rounded-2xl p-3 space-y-3" data-stage="{{ $stage }}">
                    @forelse($stageDeals as $deal)
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 cursor-pointer hover:shadow-md transition" draggable="true" data-deal-id="{{ $deal->id }}">
                        <div class="flex items-start justify-between mb-2">
                            <a href="{{ route('deals.show', $deal) }}" class="font-medium text-sm text-gray-900 hover:text-indigo-600 leading-snug">{{ $deal->title }}</a>
                            <a href="{{ route('deals.edit', $deal) }}" class="text-gray-300 hover:text-gray-500 ml-2 flex-shrink-0"><i class="fas fa-edit text-xs"></i></a>
                        </div>
                        @if($deal->customer)
                        <p class="text-xs text-gray-500 mb-2"><i class="fas fa-building mr-1"></i>{{ $deal->customer->name }}</p>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-green-600">₹{{ number_format($deal->value) }}</span>
                            <span class="text-xs text-gray-400">{{ $deal->probability }}%</span>
                        </div>
                        @if($deal->expected_close_date)
                        <p class="text-xs text-gray-400 mt-2"><i class="fas fa-calendar mr-1"></i>{{ $deal->expected_close_date->format('d M Y') }}</p>
                        @endif
                        @if($deal->assignedTo)
                        <div class="flex items-center gap-1.5 mt-2">
                            <div class="w-5 h-5 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xs font-bold">{{ strtoupper(substr($deal->assignedTo->name,0,1)) }}</div>
                            <span class="text-xs text-gray-500">{{ $deal->assignedTo->name }}</span>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-6 text-xs text-gray-400">No deals</div>
                    @endforelse
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- List View --}}
    <div id="listView" class="hidden">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                            <th class="px-5 py-3 font-medium">{{ __('app.deals.title_field') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('app.general.customer') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('app.deals.stage') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('app.deals.value') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('app.deals.probability') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('app.deals.close_date') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('app.general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($deals as $deal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3.5"><a href="{{ route('deals.show', $deal) }}" class="font-medium text-gray-900 hover:text-indigo-600">{{ $deal->title }}</a></td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $deal->customer->name ?? '—' }}</td>
                            <td class="px-5 py-3.5"><span class="text-xs px-2.5 py-1 rounded-full font-medium badge-{{ $deal->stage_color }}">{{ __('app.stages.'.$deal->stage) }}</span></td>
                            <td class="px-5 py-3.5 font-semibold text-green-600">₹{{ number_format($deal->value) }}</td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $deal->probability }}%</td>
                            <td class="px-5 py-3.5 text-gray-500">{{ $deal->expected_close_date?->format('d M Y') ?? '—' }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex gap-2">
                                    <a href="{{ route('deals.show', $deal) }}" class="text-gray-400 hover:text-indigo-600"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('deals.edit', $deal) }}" class="text-gray-400 hover:text-yellow-500"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('deals.destroy', $deal) }}" method="POST" onsubmit="return confirm('{{ __('app.general.confirm_delete') }}')">@csrf @method('DELETE')<button class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button></form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400">{{ __('app.general.no_data') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function toggleView(view) {
    document.getElementById('kanbanView').classList.toggle('hidden', view !== 'kanban');
    document.getElementById('listView').classList.toggle('hidden', view !== 'list');
    document.getElementById('btnKanban').className = view === 'kanban' ? 'px-3 py-2 text-sm rounded-xl border border-gray-200 bg-indigo-600 text-white transition' : 'px-3 py-2 text-sm rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition';
    document.getElementById('btnList').className = view === 'list' ? 'px-3 py-2 text-sm rounded-xl border border-gray-200 bg-indigo-600 text-white transition' : 'px-3 py-2 text-sm rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition';
}
// Drag and drop for kanban
document.querySelectorAll('[draggable]').forEach(card => {
    card.addEventListener('dragstart', e => { e.dataTransfer.setData('dealId', card.dataset.dealId); card.classList.add('opacity-50'); });
    card.addEventListener('dragend', e => { card.classList.remove('opacity-50'); });
});
document.querySelectorAll('.kanban-col').forEach(col => {
    col.addEventListener('dragover', e => { e.preventDefault(); col.classList.add('drag-over'); });
    col.addEventListener('dragleave', () => col.classList.remove('drag-over'));
    col.addEventListener('drop', e => {
        e.preventDefault(); col.classList.remove('drag-over');
        const dealId = e.dataTransfer.getData('dealId');
        const stage = col.dataset.stage;
        fetch(`/deals/${dealId}/stage`, { method: 'PATCH', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }, body: JSON.stringify({ stage }) })
            .then(r => r.json()).then(() => location.reload());
    });
});
</script>
@endpush
@endsection
