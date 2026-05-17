
<?php $__env->startSection('title', __('app.nav.notifications')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2 max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.nav.notifications')); ?></h2>
        <?php if($notifications->where('read_at', null)->count()): ?>
        <form action="<?php echo e(route('notifications.read-all')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button class="text-sm text-indigo-600 hover:underline">Mark all as read</button>
        </form>
        <?php endif; ?>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-50">
        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex items-start gap-4 p-4 <?php echo e(is_null($notif->read_at) ? 'bg-indigo-50/30' : ''); ?> hover:bg-gray-50 transition">
            <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-bell text-indigo-500 text-sm"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm text-gray-800"><?php echo e($notif->message); ?></p>
                <p class="text-xs text-gray-400 mt-1"><?php echo e($notif->created_at->format('d M Y, H:i')); ?> · <?php echo e($notif->created_at->diffForHumans()); ?></p>
            </div>
            <div class="flex items-center gap-2">
                <?php if(is_null($notif->read_at)): ?>
                <form action="<?php echo e(route('notifications.read', $notif)); ?>" method="POST"><?php echo csrf_field(); ?><button class="text-xs text-indigo-600 hover:underline">Read</button></form>
                <?php endif; ?>
                <form action="<?php echo e(route('notifications.destroy', $notif)); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-gray-400 hover:text-red-500 text-xs"><i class="fas fa-times"></i></button></form>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="p-10 text-center text-gray-400">No notifications</div>
        <?php endif; ?>
    </div>
    <?php if($notifications->hasPages()): ?>
    <div class="mt-4"><?php echo e($notifications->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/notifications/index.blade.php ENDPATH**/ ?>