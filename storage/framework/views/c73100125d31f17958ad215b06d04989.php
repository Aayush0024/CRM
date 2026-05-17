
<?php $__env->startSection('title', __('app.auth.register')); ?>
<?php $__env->startSection('content'); ?>
<h2 class="text-xl font-bold text-gray-900 mb-6 text-center"><?php echo e(__('app.auth.register')); ?></h2>
<form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4">
    <?php echo csrf_field(); ?>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.auth.name')); ?></label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-user text-sm"></i></span>
            <input type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="Your full name">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.auth.email')); ?></label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-envelope text-sm"></i></span>
            <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="you@example.com">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.auth.password')); ?></label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-lock text-sm"></i></span>
            <input type="password" name="password" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="Min 8 characters">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.auth.confirm_password')); ?></label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-lock text-sm"></i></span>
            <input type="password" name="password_confirmation" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="Repeat password">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.settings.user_language')); ?></label>
        <select name="language_preference" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <?php $__currentLoopData = config('languages.supported'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($code); ?>" <?php echo e(old('language_preference','en') === $code ? 'selected' : ''); ?>>
                <?php echo e($lang['flag']); ?> <?php echo e($lang['native']); ?> (<?php echo e($lang['name']); ?>)
            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">
        <?php echo e(__('app.auth.register')); ?>

    </button>
</form>
<p class="text-center text-sm text-gray-500 mt-4">
    <?php echo e(__('app.auth.have_account')); ?>

    <a href="<?php echo e(route('login')); ?>" class="text-indigo-600 font-medium hover:underline"><?php echo e(__('app.auth.login')); ?></a>
</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\lp\regional-crm\resources\views/auth/register.blade.php ENDPATH**/ ?>