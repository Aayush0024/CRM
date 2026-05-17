
<?php $__env->startSection('title', __('app.users.add')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2 max-w-xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?php echo e(route('users.index')); ?>" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.users.add')); ?></h2>
    </div>
    <form action="<?php echo e(route('users.store')); ?>" method="POST" class="space-y-5">
        <?php echo csrf_field(); ?>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.users.name')); ?> <span class="text-red-500">*</span></label><input type="text" name="name" value="<?php echo e(old('name')); ?>" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.users.email')); ?> <span class="text-red-500">*</span></label><input type="email" name="email" value="<?php echo e(old('email')); ?>" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.users.phone')); ?></label><input type="text" name="phone" value="<?php echo e(old('phone')); ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.users.role')); ?></label>
                    <select name="role_id" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($role->id); ?>" <?php echo e(old('role_id') == $role->id ? 'selected' : ''); ?>><?php echo e(ucfirst($role->name)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.users.language')); ?></label>
                    <select name="language_preference" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <?php $__currentLoopData = config('languages.supported'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($code); ?>" <?php echo e(old('language_preference','en') === $code ? 'selected' : ''); ?>><?php echo e($lang['flag']); ?> <?php echo e($lang['native']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.users.password')); ?> <span class="text-red-500">*</span></label><input type="password" name="password" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.users.confirm_password')); ?> <span class="text-red-500">*</span></label><input type="password" name="password_confirmation" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div class="sm:col-span-2 flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" id="is_active" <?php echo e(old('is_active', true) ? 'checked' : ''); ?> class="rounded border-gray-300 text-indigo-600">
                    <label for="is_active" class="text-sm text-gray-700"><?php echo e(__('app.users.active')); ?></label>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition"><?php echo e(__('app.buttons.save')); ?></button>
            <a href="<?php echo e(route('users.index')); ?>" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition"><?php echo e(__('app.buttons.cancel')); ?></a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/users/create.blade.php ENDPATH**/ ?>