
<?php $__env->startSection('title', __('app.leads.title')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.leads.title')); ?></h2>
        <a href="<?php echo e(route('leads.create')); ?>" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            <i class="fas fa-plus"></i> <?php echo e(__('app.leads.add')); ?>

        </a>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-48 relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-search text-sm"></i></span>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('app.general.search_placeholder')); ?>" class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value=""><?php echo e(__('app.general.all')); ?> Status</option>
                <?php $__currentLoopData = ['new','contacted','qualified','unqualified','converted','lost']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>><?php echo e(__('app.status.'.$s)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="priority" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value=""><?php echo e(__('app.general.all')); ?> Priority</option>
                <?php $__currentLoopData = ['low','medium','high']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p); ?>" <?php echo e(request('priority') === $p ? 'selected' : ''); ?>><?php echo e(__('app.priority.'.$p)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition"><?php echo e(__('app.buttons.filter')); ?></button>
            <a href="<?php echo e(route('leads.index')); ?>" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm rounded-xl hover:bg-gray-200 transition"><?php echo e(__('app.buttons.reset')); ?></a>
        </form>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.leads.title_field')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.leads.name')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.leads.company')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.leads.status')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.leads.priority')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.leads.value')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.leads.assigned_to')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.general.actions')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3.5">
                            <a href="<?php echo e(route('leads.show', $lead)); ?>" class="font-medium text-gray-900 hover:text-indigo-600"><?php echo e($lead->title); ?></a>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($lead->name); ?></td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($lead->company ?? '—'); ?></td>
                        <td class="px-5 py-3.5"><span class="text-xs px-2.5 py-1 rounded-full font-medium badge-<?php echo e($lead->status_color); ?>"><?php echo e(__('app.status.'.$lead->status)); ?></span></td>
                        <td class="px-5 py-3.5"><span class="text-xs px-2.5 py-1 rounded-full font-medium badge-<?php echo e($lead->priority_color); ?>"><?php echo e(__('app.priority.'.$lead->priority)); ?></span></td>
                        <td class="px-5 py-3.5 text-gray-700 font-medium"><?php echo e($lead->estimated_value ? '₹'.number_format($lead->estimated_value) : '—'); ?></td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($lead->assignedTo->name ?? '—'); ?></td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('leads.show', $lead)); ?>" class="text-gray-400 hover:text-indigo-600"><i class="fas fa-eye"></i></a>
                                <a href="<?php echo e(route('leads.edit', $lead)); ?>" class="text-gray-400 hover:text-yellow-500"><i class="fas fa-edit"></i></a>
                                <?php if($lead->status !== 'converted'): ?>
                                <form action="<?php echo e(route('leads.convert', $lead)); ?>" method="POST" onsubmit="return confirm('Convert this lead to a deal?')">
                                    <?php echo csrf_field(); ?>
                                    <button class="text-gray-400 hover:text-green-500" title="Convert to Deal"><i class="fas fa-exchange-alt"></i></button>
                                </form>
                                <?php endif; ?>
                                <form action="<?php echo e(route('leads.destroy', $lead)); ?>" method="POST" onsubmit="return confirm('<?php echo e(__('app.general.confirm_delete')); ?>')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="8" class="px-5 py-10 text-center text-gray-400"><?php echo e(__('app.general.no_data')); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($leads->hasPages()): ?>
        <div class="px-5 py-4 border-t border-gray-100"><?php echo e($leads->withQueryString()->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\lp\regional-crm\resources\views/leads/index.blade.php ENDPATH**/ ?>