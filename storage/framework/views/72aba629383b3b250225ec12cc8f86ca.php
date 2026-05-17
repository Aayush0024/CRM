
<?php $__env->startSection('title', __('app.auth.login')); ?>
<?php $__env->startSection('content'); ?>
<h2 class="text-xl font-bold text-gray-900 mb-6 text-center"><?php echo e(__('app.auth.login')); ?></h2>
<form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4">
    <?php echo csrf_field(); ?>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.auth.email')); ?></label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-envelope text-sm"></i></span>
            <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                placeholder="you@example.com">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.auth.password')); ?></label>
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-lock text-sm"></i></span>
            <input type="password" name="password" required
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="••••••••">
        </div>
    </div>
    <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600">
            <?php echo e(__('app.auth.remember_me')); ?>

        </label>
    </div>
    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">
        <?php echo e(__('app.auth.login')); ?>

    </button>
</form>
<p class="text-center text-sm text-gray-500 mt-4">
    <?php echo e(__('app.auth.no_account')); ?>

    <a href="<?php echo e(route('register')); ?>" class="text-indigo-600 font-medium hover:underline"><?php echo e(__('app.buttons.register')); ?></a>
</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/auth/login.blade.php ENDPATH**/ ?>