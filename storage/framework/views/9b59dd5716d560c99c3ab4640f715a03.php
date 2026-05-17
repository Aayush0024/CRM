
<?php $__env->startSection('title', __('app.tasks.title')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.tasks.title')); ?></h2>
        <a href="<?php echo e(route('tasks.create')); ?>" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            <i class="fas fa-plus"></i> <?php echo e(__('app.tasks.add')); ?>

        </a>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-48 relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-search text-sm"></i></span>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('app.general.search_placeholder')); ?>" class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Status</option>
                <?php $__currentLoopData = ['pending','in_progress','completed','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>><?php echo e(__('app.status.'.$s)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="priority" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Priority</option>
                <?php $__currentLoopData = ['low','medium','high','urgent']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p); ?>" <?php echo e(request('priority') === $p ? 'selected' : ''); ?>><?php echo e(__('app.priority.'.$p)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition"><?php echo e(__('app.buttons.filter')); ?></button>
            <a href="<?php echo e(route('tasks.index')); ?>" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm rounded-xl hover:bg-gray-200 transition"><?php echo e(__('app.buttons.reset')); ?></a>
        </form>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-5 py-3 font-medium w-8"></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.tasks.title_field')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.tasks.type')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.tasks.status')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.tasks.priority')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.tasks.due_date')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.tasks.assigned_to')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.general.actions')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition <?php echo e($task->isOverdue() ? 'bg-red-50/30' : ''); ?>">
                        <td class="px-5 py-3.5">
                            <form action="<?php echo e(route('tasks.complete', $task)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-5 h-5 rounded-full border-2 <?php echo e($task->status === 'completed' ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-indigo-500'); ?> flex items-center justify-center transition">
                                    <?php if($task->status === 'completed'): ?><i class="fas fa-check text-white text-xs"></i><?php endif; ?>
                                </button>
                            </form>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="font-medium text-gray-900 <?php echo e($task->status === 'completed' ? 'line-through text-gray-400' : ''); ?>"><?php echo e($task->title); ?></span>
                            <?php if($task->isOverdue()): ?><span class="ml-2 text-xs text-red-500"><i class="fas fa-exclamation-circle"></i> <?php echo e(__('app.general.overdue')); ?></span><?php endif; ?>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e(__('app.task_types.'.$task->type)); ?></td>
                        <td class="px-5 py-3.5"><span class="text-xs px-2.5 py-1 rounded-full font-medium badge-<?php echo e($task->status_color); ?>"><?php echo e(__('app.status.'.$task->status)); ?></span></td>
                        <td class="px-5 py-3.5"><span class="text-xs px-2.5 py-1 rounded-full font-medium badge-<?php echo e($task->priority_color); ?>"><?php echo e(__('app.priority.'.$task->priority)); ?></span></td>
                        <td class="px-5 py-3.5 text-gray-500 <?php echo e($task->isOverdue() ? 'text-red-500 font-medium' : ''); ?>"><?php echo e($task->due_date?->format('d M Y, H:i') ?? '—'); ?></td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($task->assignedTo->name ?? '—'); ?></td>
                        <td class="px-5 py-3.5">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('tasks.edit', $task)); ?>" class="text-gray-400 hover:text-yellow-500"><i class="fas fa-edit"></i></a>
                                <form action="<?php echo e(route('tasks.destroy', $task)); ?>" method="POST" onsubmit="return confirm('<?php echo e(__('app.general.confirm_delete')); ?>')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button></form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="8" class="px-5 py-10 text-center text-gray-400"><?php echo e(__('app.general.no_data')); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($tasks->hasPages()): ?>
        <div class="px-5 py-4 border-t border-gray-100"><?php echo e($tasks->withQueryString()->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/tasks/index.blade.php ENDPATH**/ ?>