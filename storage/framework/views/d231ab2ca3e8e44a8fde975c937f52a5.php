
<?php $__env->startSection('title', __('app.dashboard.title')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900"><?php echo e(__('app.dashboard.welcome')); ?>, <?php echo e(auth()->user()->name); ?> 👋</h2>
        <p class="text-gray-500 text-sm mt-1"><?php echo e(now()->format('l, d F Y')); ?></p>
    </div>

    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
                <span class="text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded-full font-medium">+12%</span>
            </div>
            <div class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['total_customers'])); ?></div>
            <div class="text-sm text-gray-500 mt-0.5"><?php echo e(__('app.dashboard.total_customers')); ?></div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-funnel-dollar text-yellow-600"></i>
                </div>
                <span class="text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded-full font-medium">+8%</span>
            </div>
            <div class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['total_leads'])); ?></div>
            <div class="text-sm text-gray-500 mt-0.5"><?php echo e(__('app.dashboard.total_leads')); ?></div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-briefcase text-indigo-600"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['open_deals'])); ?></div>
            <div class="text-sm text-gray-500 mt-0.5"><?php echo e(__('app.dashboard.open_deals')); ?></div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-rupee-sign text-green-600"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">₹<?php echo e(number_format($stats['total_deal_value'], 0)); ?></div>
            <div class="text-sm text-gray-500 mt-0.5"><?php echo e(__('app.dashboard.deal_value')); ?></div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-trophy text-purple-600"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['won_deals'])); ?></div>
            <div class="text-sm text-gray-500 mt-0.5"><?php echo e(__('app.dashboard.won_deals')); ?></div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-tasks text-orange-600"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['pending_tasks'])); ?></div>
            <div class="text-sm text-gray-500 mt-0.5"><?php echo e(__('app.dashboard.pending_tasks')); ?></div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-circle text-red-600"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['overdue_tasks'])); ?></div>
            <div class="text-sm text-gray-500 mt-0.5"><?php echo e(__('app.dashboard.overdue_tasks')); ?></div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-star text-teal-600"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['new_leads_this_month'])); ?></div>
            <div class="text-sm text-gray-500 mt-0.5"><?php echo e(__('app.dashboard.new_leads')); ?></div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
        
        <div class="lg:col-span-2 bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4"><?php echo e(__('app.dashboard.deals_by_stage')); ?></h3>
            <canvas id="dealsChart" height="120"></canvas>
        </div>
        
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4"><?php echo e(__('app.dashboard.leads_by_status')); ?></h3>
            <canvas id="leadsChart" height="180"></canvas>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800"><?php echo e(__('app.dashboard.recent_activities')); ?></h3>
                <a href="<?php echo e(route('activities.index')); ?>" class="text-xs text-indigo-600 hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-<?php echo e($activity->type === 'created' ? 'plus' : ($activity->type === 'updated' ? 'edit' : 'trash')); ?> text-indigo-500 text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-700 leading-snug"><?php echo e($activity->description); ?></p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            <?php echo e($activity->causer->name ?? 'System'); ?> · <?php echo e($activity->created_at->diffForHumans()); ?>

                        </p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-gray-400 text-center py-4"><?php echo e(__('app.general.no_data')); ?></p>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800"><?php echo e(__('app.dashboard.my_tasks')); ?></h3>
                <a href="<?php echo e(route('tasks.index')); ?>" class="text-xs text-indigo-600 hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $myTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-indigo-50 transition">
                    <form action="<?php echo e(route('tasks.complete', $task)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-5 h-5 rounded-full border-2 <?php echo e($task->status === 'completed' ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-indigo-500'); ?> flex items-center justify-center transition">
                            <?php if($task->status === 'completed'): ?><i class="fas fa-check text-white text-xs"></i><?php endif; ?>
                        </button>
                    </form>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate"><?php echo e($task->title); ?></p>
                        <p class="text-xs text-gray-400">
                            <?php if($task->due_date): ?>
                                <span class="<?php echo e($task->isOverdue() ? 'text-red-500' : ''); ?>">
                                    <i class="fas fa-clock mr-1"></i><?php echo e($task->due_date->format('d M Y')); ?>

                                </span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full badge-<?php echo e($task->priority_color); ?>"><?php echo e(__('app.priority.'.$task->priority)); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-gray-400 text-center py-4"><?php echo e(__('app.general.no_data')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-800"><?php echo e(__('app.dashboard.recent_customers')); ?></h3>
            <a href="<?php echo e(route('customers.index')); ?>" class="text-xs text-indigo-600 hover:underline">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-400 uppercase tracking-wider border-b border-gray-100">
                        <th class="pb-3 font-medium"><?php echo e(__('app.customers.name')); ?></th>
                        <th class="pb-3 font-medium"><?php echo e(__('app.customers.company')); ?></th>
                        <th class="pb-3 font-medium"><?php echo e(__('app.customers.status')); ?></th>
                        <th class="pb-3 font-medium"><?php echo e(__('app.customers.assigned_to')); ?></th>
                        <th class="pb-3 font-medium"><?php echo e(__('app.general.created_at')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $recentCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="py-3">
                            <a href="<?php echo e(route('customers.show', $customer)); ?>" class="font-medium text-gray-900 hover:text-indigo-600"><?php echo e($customer->name); ?></a>
                        </td>
                        <td class="py-3 text-gray-500"><?php echo e($customer->company ?? '—'); ?></td>
                        <td class="py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full badge-<?php echo e($customer->status_color); ?>"><?php echo e(__('app.status.'.$customer->status)); ?></span>
                        </td>
                        <td class="py-3 text-gray-500"><?php echo e($customer->assignedTo->name ?? '—'); ?></td>
                        <td class="py-3 text-gray-400"><?php echo e($customer->created_at->format('d M Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="py-6 text-center text-gray-400"><?php echo e(__('app.general.no_data')); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Deals by Stage Bar Chart
const dealsCtx = document.getElementById('dealsChart').getContext('2d');
new Chart(dealsCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($dealsByStage->pluck('stage')->map(fn($s) => __('app.stages.'.$s))->toArray()); ?>,
        datasets: [{
            label: 'Deals',
            data: <?php echo json_encode($dealsByStage->pluck('count')->toArray()); ?>,
            backgroundColor: ['#6366f1','#8b5cf6','#f59e0b','#f97316','#22c55e','#ef4444'],
            borderRadius: 8,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
});

// Leads by Status Doughnut
const leadsCtx = document.getElementById('leadsChart').getContext('2d');
new Chart(leadsCtx, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($leadsByStatus->pluck('status')->map(fn($s) => __('app.status.'.$s))->toArray()); ?>,
        datasets: [{
            data: <?php echo json_encode($leadsByStatus->pluck('count')->toArray()); ?>,
            backgroundColor: ['#6366f1','#f59e0b','#22c55e','#ef4444','#8b5cf6','#94a3b8'],
            borderWidth: 0,
        }]
    },
    options: { responsive: true, cutout: '65%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, padding: 10, font: { size: 11 } } } } }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/dashboard/index.blade.php ENDPATH**/ ?>