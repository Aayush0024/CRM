
<?php $__env->startSection('title', __('app.settings.title')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2 max-w-2xl">
    <h2 class="text-xl font-bold text-gray-900 mb-6"><?php echo e(__('app.settings.title')); ?></h2>
    <form action="<?php echo e(route('settings.update')); ?>" method="POST" class="space-y-5">
        <?php echo csrf_field(); ?>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100"><?php echo e(__('app.settings.company')); ?></h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.settings.company_name')); ?></label>
                    <input type="text" name="company_name" value="<?php echo e($settings['company_name'] ?? config('app.name')); ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.settings.company_email')); ?></label>
                    <input type="email" name="company_email" value="<?php echo e($settings['company_email'] ?? ''); ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.settings.company_phone')); ?></label>
                    <input type="text" name="company_phone" value="<?php echo e($settings['company_phone'] ?? ''); ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.settings.company_address')); ?></label>
                    <textarea name="company_address" rows="2" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"><?php echo e($settings['company_address'] ?? ''); ?></textarea>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100"><?php echo e(__('app.settings.language')); ?></h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.settings.default_language')); ?></label>
                    <select name="default_language" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <?php $__currentLoopData = config('languages.supported'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($code); ?>" <?php echo e(($settings['default_language'] ?? 'en') === $code ? 'selected' : ''); ?>><?php echo e($lang['flag']); ?> <?php echo e($lang['native']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo e(__('app.settings.currency')); ?></label>
                    <select name="default_currency" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="INR" <?php echo e(($settings['default_currency'] ?? 'INR') === 'INR' ? 'selected' : ''); ?>>INR (₹)</option>
                        <option value="USD" <?php echo e(($settings['default_currency'] ?? '') === 'USD' ? 'selected' : ''); ?>>USD ($)</option>
                        <option value="EUR" <?php echo e(($settings['default_currency'] ?? '') === 'EUR' ? 'selected' : ''); ?>>EUR (€)</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100"><?php echo e(__('app.settings.user_language')); ?></h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <?php $__currentLoopData = config('languages.supported'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('lang.switch', $code)); ?>" class="flex items-center gap-2 p-3 rounded-xl border-2 <?php echo e(app()->getLocale() === $code ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 hover:border-indigo-300'); ?> transition">
                    <span class="text-xl"><?php echo e($lang['flag']); ?></span>
                    <div>
                        <div class="text-sm font-medium text-gray-800"><?php echo e($lang['native']); ?></div>
                        <div class="text-xs text-gray-400"><?php echo e($lang['name']); ?></div>
                    </div>
                    <?php if(app()->getLocale() === $code): ?><i class="fas fa-check-circle text-indigo-500 ml-auto"></i><?php endif; ?>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition"><?php echo e(__('app.buttons.save')); ?></button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/settings/index.blade.php ENDPATH**/ ?>