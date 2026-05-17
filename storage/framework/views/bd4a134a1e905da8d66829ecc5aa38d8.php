
<?php $__env->startSection('title', $contact->first_name.' '.$contact->last_name); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2 max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?php echo e(route('contacts.index')); ?>" class="text-gray-400 hover:text-gray-600"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-bold text-gray-900"><?php echo e($contact->first_name); ?> <?php echo e($contact->last_name); ?></h2>
        <a href="<?php echo e(route('contacts.edit', $contact)); ?>" class="ml-auto inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-edit"></i> Edit</a>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-2xl"><?php echo e(strtoupper(substr($contact->first_name, 0, 1) . substr((string) ($contact->last_name ?? ''), 0, 1))); ?></div>
            <div>
                <h3 class="text-lg font-bold text-gray-900"><?php echo e($contact->first_name); ?> <?php echo e($contact->last_name); ?></h3>
                <?php if($contact->job_title): ?><p class="text-sm text-gray-500"><?php echo e($contact->job_title); ?></p><?php endif; ?>
                <?php if($contact->customer): ?><p class="text-sm text-indigo-600"><a href="<?php echo e(route('customers.show', $contact->customer)); ?>"><?php echo e($contact->customer->name); ?></a></p><?php endif; ?>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <?php if($contact->email): ?><div class="flex items-center gap-3 text-gray-600"><i class="fas fa-envelope w-4 text-gray-400"></i><a href="mailto:<?php echo e($contact->email); ?>" class="hover:text-indigo-600"><?php echo e($contact->email); ?></a></div><?php endif; ?>
            <?php if($contact->phone): ?><div class="flex items-center gap-3 text-gray-600"><i class="fas fa-phone w-4 text-gray-400"></i><?php echo e($contact->phone); ?></div><?php endif; ?>
            <?php if($contact->preferred_language): ?><div class="flex items-center gap-3 text-gray-600"><i class="fas fa-language w-4 text-gray-400"></i><?php echo e(config('languages.supported.'.$contact->preferred_language.'.flag','')); ?> <?php echo e(config('languages.supported.'.$contact->preferred_language.'.native', $contact->preferred_language)); ?></div><?php endif; ?>
        </div>
        <?php if($contact->notes): ?><div class="mt-4 pt-4 border-t border-gray-100"><p class="text-sm text-gray-600"><?php echo e($contact->notes); ?></p></div><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/contacts/show.blade.php ENDPATH**/ ?>