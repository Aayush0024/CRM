
<?php $__env->startSection('title', __('app.nav.contacts')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.nav.contacts')); ?></h2>
        <a href="<?php echo e(route('contacts.create')); ?>" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            <i class="fas fa-plus"></i> <?php echo e(__('app.contacts.add')); ?>

        </a>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-48 relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-search text-sm"></i></span>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('app.general.search_placeholder')); ?>" class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition"><?php echo e(__('app.buttons.filter')); ?></button>
            <a href="<?php echo e(route('contacts.index')); ?>" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm rounded-xl hover:bg-gray-200 transition"><?php echo e(__('app.buttons.reset')); ?></a>
        </form>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.general.name')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.customers.email')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.customers.phone')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.general.customer')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.contacts.position')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.customers.language')); ?></th>
                        <th class="px-5 py-3 font-medium"><?php echo e(__('app.general.actions')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-semibold text-xs"><?php echo e(strtoupper(substr($contact->first_name,0,1).substr($contact->last_name,0,1))); ?></div>
                                <a href="<?php echo e(route('contacts.show', $contact)); ?>" class="font-medium text-gray-900 hover:text-indigo-600"><?php echo e($contact->first_name); ?> <?php echo e($contact->last_name); ?></a>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($contact->email ?? '—'); ?></td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($contact->phone ?? '—'); ?></td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($contact->customer->name ?? '—'); ?></td>
                        <td class="px-5 py-3.5 text-gray-600"><?php echo e($contact->job_title ?? '—'); ?></td>
                        <td class="px-5 py-3.5 text-gray-600">
                            <?php if($contact->preferred_language): ?>
                            <?php echo e(config('languages.supported.'.$contact->preferred_language.'.flag','')); ?>

                            <?php echo e(config('languages.supported.'.$contact->preferred_language.'.native', $contact->preferred_language)); ?>

                            <?php else: ?> —
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('contacts.show', $contact)); ?>" class="text-gray-400 hover:text-indigo-600"><i class="fas fa-eye"></i></a>
                                <a href="<?php echo e(route('contacts.edit', $contact)); ?>" class="text-gray-400 hover:text-yellow-500"><i class="fas fa-edit"></i></a>
                                <form action="<?php echo e(route('contacts.destroy', $contact)); ?>" method="POST" onsubmit="return confirm('<?php echo e(__('app.general.confirm_delete')); ?>')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-gray-400 hover:text-red-500"><i class="fas fa-trash"></i></button></form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400"><?php echo e(__('app.general.no_data')); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($contacts->hasPages()): ?>
        <div class="px-5 py-4 border-t border-gray-100"><?php echo e($contacts->withQueryString()->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/contacts/index.blade.php ENDPATH**/ ?>