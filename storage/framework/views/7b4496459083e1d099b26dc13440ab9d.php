
<?php $__env->startSection('title', __('app.customers.title')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.customers.title')); ?></h2>
        <a href="<?php echo e(route('customers.create')); ?>" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            <i class="fas fa-plus"></i> <?php echo e(__('app.customers.add')); ?>

        </a>
    </div>

    
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-48 relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-search text-sm"></i></span>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('app.general.search_placeholder')); ?>"
                    class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value=""><?php echo e(__('app.general.all')); ?> <?php echo e(__('app.customers.status')); ?></option>
                <?php $__currentLoopData = ['active','inactive','prospect','churned']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>><?php echo e(__('app.status.'.$s)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="assigned_to" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value=""><?php echo e(__('app.general.all')); ?> <?php echo e(__('app.customers.assigned_to')); ?></option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($user->id); ?>" <?php echo e(request('assigned_to') == $user->id ? 'selected' : ''); ?>><?php echo e($user->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition"><?php echo e(__('app.buttons.filter')); ?></button>
            <a href="<?php echo e(route('customers.index')); ?>" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm rounded-xl hover:bg-gray-200 transition"><?php echo e(__('app.buttons.reset')); ?></a>
        </form>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.customers.name')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.customers.company')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.customers.email')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.customers.phone')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.customers.status')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.customers.language')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.customers.assigned_to')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.general.actions')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-xs flex-shrink-0">
                                    <?php echo e(strtoupper(substr($customer->name, 0, 2))); ?>

                                </div>
                                <div>
                                    <a href="<?php echo e(route('customers.show', $customer)); ?>" class="font-medium text-gray-900 hover:text-indigo-600"><?php echo e($customer->name); ?></a>
                                    <?php if($customer->tags->count()): ?>
                                    <div class="flex gap-1 mt-0.5">
                                        <?php $__currentLoopData = $customer->tags->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="text-xs bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded"><?php echo e($tag->name); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($customer->company ?? '—'); ?></td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($customer->email ?? '—'); ?></td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($customer->phone ?? '—'); ?></td>
                        <td class="px-5 py-3.5">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium badge-<?php echo e($customer->status_color); ?>"><?php echo e(__('app.status.'.$customer->status)); ?></span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600">
                            <?php if($customer->preferred_language): ?>
                            <?php echo e(config('languages.supported.'.$customer->preferred_language.'.flag','')); ?>

                            <?php echo e(config('languages.supported.'.$customer->preferred_language.'.native', $customer->preferred_language)); ?>

                            <?php else: ?> —
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($customer->assignedTo->name ?? '—'); ?></td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('customers.show', $customer)); ?>" class="text-gray-400 hover:text-indigo-600 transition" title="<?php echo e(__('app.buttons.view')); ?>"><i class="fas fa-eye"></i></a>
                                <a href="<?php echo e(route('customers.edit', $customer)); ?>" class="text-gray-400 hover:text-yellow-500 transition" title="<?php echo e(__('app.buttons.edit')); ?>"><i class="fas fa-edit"></i></a>
                                <form action="<?php echo e(route('customers.destroy', $customer)); ?>" method="POST" onsubmit="return confirm('<?php echo e(__('app.general.confirm_delete')); ?>')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="<?php echo e(__('app.buttons.delete')); ?>"><i class="fas fa-trash"></i></button>
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
        <?php if($customers->hasPages()): ?>
        <div class="px-5 py-4 border-t border-gray-100"><?php echo e($customers->withQueryString()->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/customers/index.blade.php ENDPATH**/ ?>