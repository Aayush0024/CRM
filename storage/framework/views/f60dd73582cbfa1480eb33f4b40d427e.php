
<?php $__env->startSection('title', __('app.deals.edit')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2 max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?php echo e(route('deals.show', $deal)); ?>" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.deals.edit')); ?>: <?php echo e($deal->title); ?></h2>
    </div>
    <form action="<?php echo e(route('deals.update', $deal)); ?>" method="POST" class="space-y-5">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.deals.title_field')); ?> <span class="text-red-500">*</span></label><input type="text" name="title" value="<?php echo e(old('title', $deal->title)); ?>" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.deals.value')); ?></label><input type="number" name="value" value="<?php echo e(old('value', $deal->value)); ?>" step="0.01" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.deals.stage')); ?></label>
                    <select name="stage" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <?php $__currentLoopData = ['prospecting','qualification','proposal','negotiation','closed_won','closed_lost']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(old('stage', $deal->stage) === $s ? 'selected' : ''); ?>><?php echo e(__('app.stages.'.$s)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.deals.probability')); ?></label><input type="number" name="probability" value="<?php echo e(old('probability', $deal->probability)); ?>" min="0" max="100" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.deals.close_date')); ?></label><input type="date" name="expected_close_date" value="<?php echo e(old('expected_close_date', $deal->expected_close_date?->format('Y-m-d'))); ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.general.customer')); ?></label>
                    <select name="customer_id" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value=""><?php echo e(__('app.general.select')); ?></option>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->id); ?>" <?php echo e(old('customer_id', $deal->customer_id) == $customer->id ? 'selected' : ''); ?>><?php echo e($customer->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.deals.assigned_to')); ?></label>
                    <select name="assigned_to" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value=""><?php echo e(__('app.general.select')); ?></option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php echo e(old('assigned_to', $deal->assigned_to) == $user->id ? 'selected' : ''); ?>><?php echo e($user->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.deals.description')); ?></label><textarea name="description" rows="3" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"><?php echo e(old('description', $deal->description)); ?></textarea></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.deals.lost_reason')); ?></label><input type="text" name="lost_reason" value="<?php echo e(old('lost_reason', $deal->lost_reason)); ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition"><?php echo e(__('app.buttons.update')); ?></button>
            <a href="<?php echo e(route('deals.show', $deal)); ?>" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition"><?php echo e(__('app.buttons.cancel')); ?></a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/deals/edit.blade.php ENDPATH**/ ?>