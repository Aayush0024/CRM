
<?php $__env->startSection('title', $lead->title); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('leads.index')); ?>" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h2 class="text-xl font-bold text-gray-900"><?php echo e($lead->title); ?></h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs px-2 py-0.5 rounded-full badge-<?php echo e($lead->status_color); ?>"><?php echo e(__('app.status.'.$lead->status)); ?></span>
                    <span class="text-xs px-2 py-0.5 rounded-full badge-<?php echo e($lead->priority_color); ?>"><?php echo e(__('app.priority.'.$lead->priority)); ?></span>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <?php if($lead->status !== 'converted'): ?>
            <form action="<?php echo e(route('leads.convert', $lead)); ?>" method="POST" onsubmit="return confirm('Convert this lead to a deal?')">
                <?php echo csrf_field(); ?>
                <button class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
                    <i class="fas fa-exchange-alt"></i> <?php echo e(__('app.leads.convert')); ?>

                </button>
            </form>
            <?php endif; ?>
            <a href="<?php echo e(route('leads.edit', $lead)); ?>" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl transition">
                <i class="fas fa-edit"></i> <?php echo e(__('app.buttons.edit')); ?>

            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="space-y-4">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4">Lead Details</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Contact</span><span class="font-medium"><?php echo e($lead->name); ?></span></div>
                    <?php if($lead->email): ?><div class="flex justify-between"><span class="text-gray-500">Email</span><span><?php echo e($lead->email); ?></span></div><?php endif; ?>
                    <?php if($lead->phone): ?><div class="flex justify-between"><span class="text-gray-500">Phone</span><span><?php echo e($lead->phone); ?></span></div><?php endif; ?>
                    <?php if($lead->company): ?><div class="flex justify-between"><span class="text-gray-500">Company</span><span><?php echo e($lead->company); ?></span></div><?php endif; ?>
                    <?php if($lead->estimated_value): ?><div class="flex justify-between"><span class="text-gray-500">Value</span><span class="font-semibold text-green-600">₹<?php echo e(number_format($lead->estimated_value)); ?></span></div><?php endif; ?>
                    <?php if($lead->source): ?><div class="flex justify-between"><span class="text-gray-500">Source</span><span><?php echo e(ucwords(str_replace('_',' ',$lead->source))); ?></span></div><?php endif; ?>
                    <?php if($lead->expected_close_date): ?><div class="flex justify-between"><span class="text-gray-500">Close Date</span><span><?php echo e($lead->expected_close_date->format('d M Y')); ?></span></div><?php endif; ?>
                    <?php if($lead->assignedTo): ?><div class="flex justify-between"><span class="text-gray-500">Assigned To</span><span><?php echo e($lead->assignedTo->name); ?></span></div><?php endif; ?>
                </div>
            </div>
        </div>
        <div class="lg:col-span-2 space-y-4">
            <?php if($lead->description): ?>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-3">Description</h3>
                <p class="text-sm text-gray-600"><?php echo e($lead->description); ?></p>
            </div>
            <?php endif; ?>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4"><?php echo e(__('app.general.notes')); ?></h3>
                <form action="<?php echo e(route('notes.store')); ?>" method="POST" class="mb-4">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="notable_type" value="App\Models\Lead">
                    <input type="hidden" name="notable_id" value="<?php echo e($lead->id); ?>">
                    <div class="flex gap-2">
                        <input type="text" name="content" placeholder="<?php echo e(__('app.general.add_note')); ?>..." required class="flex-1 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition"><?php echo e(__('app.buttons.add')); ?></button>
                    </div>
                </form>
                <?php $__empty_1 = true; $__currentLoopData = $lead->notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 mb-2">
                    <div class="flex-1"><p class="text-sm text-gray-700"><?php echo e($note->content); ?></p><p class="text-xs text-gray-400 mt-1"><?php echo e($note->created_at->diffForHumans()); ?></p></div>
                    <form action="<?php echo e(route('notes.destroy', $note)); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-gray-400 hover:text-red-500 text-xs"><i class="fas fa-times"></i></button></form>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="text-sm text-gray-400 text-center py-3">No notes yet</p><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\lp\regional-crm\resources\views/leads/show.blade.php ENDPATH**/ ?>