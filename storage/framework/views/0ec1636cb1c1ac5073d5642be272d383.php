
<?php $__env->startSection('title', __('app.nav.activities')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2">
    <h2 class="text-xl font-bold text-gray-900 mb-6"><?php echo e(__('app.nav.activities')); ?></h2>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-start gap-4 pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0
                    <?php echo e($activity->type === 'created' ? 'bg-green-100' : ($activity->type === 'updated' ? 'bg-blue-100' : ($activity->type === 'deleted' ? 'bg-red-100' : 'bg-gray-100'))); ?>">
                    <i class="fas fa-<?php echo e($activity->type === 'created' ? 'plus text-green-600' : ($activity->type === 'updated' ? 'edit text-blue-600' : ($activity->type === 'deleted' ? 'trash text-red-600' : 'circle text-gray-600'))); ?> text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-800"><?php echo e($activity->description); ?></p>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-xs text-gray-400"><?php echo e($activity->causer->name ?? 'System'); ?></span>
                        <span class="text-xs text-gray-300">·</span>
                        <span class="text-xs text-gray-400"><?php echo e($activity->created_at->format('d M Y, H:i')); ?></span>
                        <span class="text-xs text-gray-300">·</span>
                        <span class="text-xs text-gray-400"><?php echo e($activity->created_at->diffForHumans()); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center text-gray-400 py-8"><?php echo e(__('app.general.no_data')); ?></p>
            <?php endif; ?>
        </div>
        <?php if($activities->hasPages()): ?>
        <div class="mt-4 pt-4 border-t border-gray-100"><?php echo e($activities->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\lp\regional-crm\resources\views/activities/index.blade.php ENDPATH**/ ?>