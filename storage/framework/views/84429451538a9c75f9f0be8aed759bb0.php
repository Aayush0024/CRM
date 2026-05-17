
<?php $__env->startSection('title', __('app.leads.edit')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2 max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?php echo e(route('leads.show', $lead)); ?>" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.leads.edit')); ?>: <?php echo e($lead->title); ?></h2>
    </div>
    <form action="<?php echo e(route('leads.update', $lead)); ?>" method="POST" class="space-y-5">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.leads.title_field')); ?> <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="<?php echo e(old('title', $lead->title)); ?>" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.leads.name')); ?></label><input type="text" name="name" value="<?php echo e(old('name', $lead->name)); ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.leads.email')); ?></label><input type="email" name="email" value="<?php echo e(old('email', $lead->email)); ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.leads.phone')); ?></label><input type="text" name="phone" value="<?php echo e(old('phone', $lead->phone)); ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.leads.company')); ?></label><input type="text" name="company" value="<?php echo e(old('company', $lead->company)); ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.leads.status')); ?></label>
                    <select name="status" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <?php $__currentLoopData = ['new','contacted','qualified','unqualified','converted','lost']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(old('status', $lead->status) === $s ? 'selected' : ''); ?>><?php echo e(__('app.status.'.$s)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.leads.priority')); ?></label>
                    <select name="priority" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <?php $__currentLoopData = ['low','medium','high']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p); ?>" <?php echo e(old('priority', $lead->priority) === $p ? 'selected' : ''); ?>><?php echo e(__('app.priority.'.$p)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.leads.value')); ?></label><input type="number" name="estimated_value" value="<?php echo e(old('estimated_value', $lead->estimated_value)); ?>" step="0.01" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.leads.close_date')); ?></label><input type="date" name="expected_close_date" value="<?php echo e(old('expected_close_date', $lead->expected_close_date?->format('Y-m-d'))); ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.leads.assigned_to')); ?></label>
                    <select name="assigned_to" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value=""><?php echo e(__('app.general.select')); ?></option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php echo e(old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : ''); ?>><?php echo e($user->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.leads.description')); ?></label><textarea name="description" rows="3" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"><?php echo e(old('description', $lead->description)); ?></textarea></div>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition"><?php echo e(__('app.buttons.update')); ?></button>
            <a href="<?php echo e(route('leads.show', $lead)); ?>" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition"><?php echo e(__('app.buttons.cancel')); ?></a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\lp\regional-crm\resources\views/leads/edit.blade.php ENDPATH**/ ?>