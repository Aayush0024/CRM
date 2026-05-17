
<?php $__env->startSection('title', $customer->name); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('customers.index')); ?>" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h2 class="text-xl font-bold text-gray-900"><?php echo e($customer->name); ?></h2>
                <p class="text-sm text-gray-500"><?php echo e($customer->company); ?></p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('customers.edit', $customer)); ?>" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl transition">
                <i class="fas fa-edit"></i> <?php echo e(__('app.buttons.edit')); ?>

            </a>
            <form action="<?php echo e(route('customers.destroy', $customer)); ?>" method="POST" onsubmit="return confirm('<?php echo e(__('app.general.confirm_delete')); ?>')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="inline-flex items-center gap-2 bg-red-50 border border-red-200 hover:bg-red-100 text-red-600 text-sm font-medium px-4 py-2 rounded-xl transition">
                    <i class="fas fa-trash"></i> <?php echo e(__('app.buttons.delete')); ?>

                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl">
                        <?php echo e(strtoupper(substr($customer->name, 0, 2))); ?>

                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900"><?php echo e($customer->name); ?></h3>
                        <span class="text-xs px-2 py-0.5 rounded-full badge-<?php echo e($customer->status_color); ?>"><?php echo e(__('app.status.'.$customer->status)); ?></span>
                    </div>
                </div>
                <div class="space-y-3 text-sm">
                    <?php if($customer->email): ?>
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-envelope w-4 text-gray-400"></i> <a href="mailto:<?php echo e($customer->email); ?>" class="hover:text-indigo-600"><?php echo e($customer->email); ?></a></div>
                    <?php endif; ?>
                    <?php if($customer->phone): ?>
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-phone w-4 text-gray-400"></i> <?php echo e($customer->phone); ?></div>
                    <?php endif; ?>
                    <?php if($customer->mobile): ?>
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-mobile-alt w-4 text-gray-400"></i> <?php echo e($customer->mobile); ?></div>
                    <?php endif; ?>
                    <?php if($customer->website): ?>
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-globe w-4 text-gray-400"></i> <a href="<?php echo e($customer->website); ?>" target="_blank" class="hover:text-indigo-600 truncate"><?php echo e($customer->website); ?></a></div>
                    <?php endif; ?>
                    <?php if($customer->city || $customer->state): ?>
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-map-marker-alt w-4 text-gray-400"></i> <?php echo e(implode(', ', array_filter([$customer->city, $customer->state, $customer->country]))); ?></div>
                    <?php endif; ?>
                    <?php if($customer->industry): ?>
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-industry w-4 text-gray-400"></i> <?php echo e($customer->industry); ?></div>
                    <?php endif; ?>
                    <?php if($customer->preferred_language): ?>
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-language w-4 text-gray-400"></i>
                        <?php echo e(config('languages.supported.'.$customer->preferred_language.'.flag','')); ?>

                        <?php echo e(config('languages.supported.'.$customer->preferred_language.'.native', $customer->preferred_language)); ?>

                    </div>
                    <?php endif; ?>
                    <?php if($customer->assignedTo): ?>
                    <div class="flex items-center gap-3 text-gray-600"><i class="fas fa-user w-4 text-gray-400"></i> <?php echo e($customer->assignedTo->name); ?></div>
                    <?php endif; ?>
                </div>
                <?php if($customer->tags->count()): ?>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex flex-wrap gap-1.5">
                        <?php $__currentLoopData = $customer->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="text-xs bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-full"><?php echo e($tag->name); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="grid grid-cols-2 gap-3">
                    <div class="text-center p-3 bg-blue-50 rounded-xl">
                        <div class="text-xl font-bold text-blue-600"><?php echo e($customer->contacts->count()); ?></div>
                        <div class="text-xs text-gray-500 mt-0.5"><?php echo e(__('app.customers.contacts')); ?></div>
                    </div>
                    <div class="text-center p-3 bg-yellow-50 rounded-xl">
                        <div class="text-xl font-bold text-yellow-600"><?php echo e($customer->leads->count()); ?></div>
                        <div class="text-xs text-gray-500 mt-0.5"><?php echo e(__('app.customers.leads')); ?></div>
                    </div>
                    <div class="text-center p-3 bg-indigo-50 rounded-xl">
                        <div class="text-xl font-bold text-indigo-600"><?php echo e($customer->deals->count()); ?></div>
                        <div class="text-xs text-gray-500 mt-0.5"><?php echo e(__('app.customers.deals')); ?></div>
                    </div>
                    <div class="text-center p-3 bg-orange-50 rounded-xl">
                        <div class="text-xl font-bold text-orange-600"><?php echo e($customer->tasks->count()); ?></div>
                        <div class="text-xs text-gray-500 mt-0.5"><?php echo e(__('app.customers.tasks')); ?></div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="lg:col-span-2 space-y-4">
            
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4"><?php echo e(__('app.general.notes')); ?></h3>
                <form action="<?php echo e(route('notes.store')); ?>" method="POST" class="mb-4">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="notable_type" value="App\Models\Customer">
                    <input type="hidden" name="notable_id" value="<?php echo e($customer->id); ?>">
                    <div class="flex gap-2">
                        <input type="text" name="content" placeholder="<?php echo e(__('app.general.add_note')); ?>..." required
                            class="flex-1 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition"><?php echo e(__('app.buttons.add')); ?></button>
                    </div>
                </form>
                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $customer->noteRecords->sortByDesc('is_pinned'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start gap-3 p-3 rounded-xl <?php echo e($note->is_pinned ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50'); ?>">
                        <?php if($note->is_pinned): ?><i class="fas fa-thumbtack text-yellow-500 mt-0.5 text-xs"></i><?php endif; ?>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-700"><?php echo e($note->content); ?></p>
                            <p class="text-xs text-gray-400 mt-1"><?php echo e($note->createdBy->name ?? ''); ?> · <?php echo e($note->created_at->diffForHumans()); ?></p>
                        </div>
                        <div class="flex gap-2">
                            <form action="<?php echo e(route('notes.pin', $note)); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button class="text-gray-400 hover:text-yellow-500 text-xs"><i class="fas fa-thumbtack"></i></button>
                            </form>
                            <form action="<?php echo e(route('notes.destroy', $note)); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="text-gray-400 hover:text-red-500 text-xs"><i class="fas fa-times"></i></button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-400 text-center py-3">No notes yet</p>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4"><?php echo e(__('app.general.activities')); ?></h3>
                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $customer->activities->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-circle text-indigo-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-700"><?php echo e($activity->description); ?></p>
                            <p class="text-xs text-gray-400"><?php echo e($activity->causer->name ?? 'System'); ?> · <?php echo e($activity->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-400 text-center py-3">No activities yet</p>
                    <?php endif; ?>
                </div>
            </div>

            
            <?php if($customer->deals->count()): ?>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4"><?php echo e(__('app.customers.deals')); ?></h3>
                <div class="space-y-2">
                    <?php $__currentLoopData = $customer->deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div>
                            <a href="<?php echo e(route('deals.show', $deal)); ?>" class="text-sm font-medium text-gray-800 hover:text-indigo-600"><?php echo e($deal->title); ?></a>
                            <p class="text-xs text-gray-400"><?php echo e(__('app.stages.'.$deal->stage)); ?></p>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">₹<?php echo e(number_format($deal->value)); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/customers/show.blade.php ENDPATH**/ ?>