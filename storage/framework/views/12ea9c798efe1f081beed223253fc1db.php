
<?php $__env->startSection('title', 'Reset Password — ' . $user->name); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2 max-w-lg">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?php echo e(route('users.index')); ?>" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-xl font-bold text-gray-900">Reset Password</h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-3 mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl">
            <i class="fas fa-key text-amber-500"></i>
            <div>
                <p class="text-sm font-medium text-amber-800">Resetting password for: <strong><?php echo e($user->name); ?></strong></p>
                <p class="text-xs text-amber-600"><?php echo e($user->email); ?> &bull; <?php echo e($user->role->display_name ?? 'No role'); ?></p>
            </div>
        </div>

        <form action="<?php echo e(route('users.reset-password.update', $user)); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" required minlength="8"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                    placeholder="Minimum 8 characters">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required minlength="8"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                    placeholder="Repeat the new password">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition">
                    <i class="fas fa-key mr-1"></i> Reset Password
                </button>
                <a href="<?php echo e(route('users.index')); ?>"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-5 py-2.5 rounded-xl transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/users/reset-password.blade.php ENDPATH**/ ?>