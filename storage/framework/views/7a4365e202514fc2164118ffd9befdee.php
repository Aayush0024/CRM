
<?php $__env->startSection('title', __('app.users.title')); ?>
<?php $__env->startSection('content'); ?>
<div class="py-2">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900"><?php echo e(__('app.users.title')); ?></h2>
        <a href="<?php echo e(route('users.create')); ?>" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            <i class="fas fa-plus"></i> <?php echo e(__('app.users.add')); ?>

        </a>
    </div>

    
    <div class="flex flex-wrap gap-2 mb-4">
        <span class="text-xs text-gray-500 font-medium self-center">Roles:</span>
        <span class="text-xs px-2.5 py-1 rounded-full badge-red font-medium">Admin — Full access</span>
        <span class="text-xs px-2.5 py-1 rounded-full badge-blue font-medium">Sales Manager — Team leads, assign deals, team reports</span>
        <span class="text-xs px-2.5 py-1 rounded-full badge-indigo font-medium">Sales Executive — Own leads, own deals, own tasks</span>
        <span class="text-xs px-2.5 py-1 rounded-full badge-purple font-medium">Support Agent — Customer issues, notes &amp; tasks</span>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                    <th class="px-5 py-3 font-medium"><?php echo e(__('app.users.name')); ?></th>
                    <th class="px-5 py-3 font-medium"><?php echo e(__('app.users.email')); ?></th>
                    <th class="px-5 py-3 font-medium"><?php echo e(__('app.users.role')); ?></th>
                    <th class="px-5 py-3 font-medium"><?php echo e(__('app.users.language')); ?></th>
                    <th class="px-5 py-3 font-medium"><?php echo e(__('app.users.status')); ?></th>
                    <th class="px-5 py-3 font-medium"><?php echo e(__('app.general.actions')); ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 <?php echo e(!$user->is_active ? 'opacity-60' : ''); ?>">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="<?php echo e($user->avatar_url); ?>" class="w-8 h-8 rounded-full object-cover" alt="">
                            <div>
                                <span class="font-medium text-gray-900"><?php echo e($user->name); ?></span>
                                <?php if($user->id === auth()->id()): ?>
                                    <span class="ml-1 text-xs text-indigo-500">(you)</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600"><?php echo e($user->email); ?></td>
                    <td class="px-5 py-3.5">
                        <?php
                            $roleColors = [
                                'admin'           => 'badge-red',
                                'sales_manager'   => 'badge-blue',
                                'manager'         => 'badge-blue',
                                'sales_executive' => 'badge-indigo',
                                'agent'           => 'badge-indigo',
                                'support_agent'   => 'badge-purple',
                            ];
                            $roleName = $user->role->name ?? '';
                            $roleColor = $roleColors[$roleName] ?? 'badge-gray';
                        ?>
                        <span class="text-xs px-2.5 py-1 rounded-full <?php echo e($roleColor); ?>">
                            <?php echo e($user->role->display_name ?? '—'); ?>

                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">
                        <?php echo e(config('languages.supported.'.$user->language_preference.'.flag','')); ?>

                        <?php echo e(config('languages.supported.'.$user->language_preference.'.native', $user->language_preference ?? 'en')); ?>

                    </td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs px-2.5 py-1 rounded-full <?php echo e($user->is_active ? 'badge-green' : 'badge-gray'); ?>">
                            <?php echo e($user->is_active ? __('app.users.active') : __('app.users.inactive')); ?>

                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            
                            <a href="<?php echo e(route('users.edit', $user)); ?>"
                               class="text-gray-400 hover:text-yellow-500" title="Edit user">
                                <i class="fas fa-edit"></i>
                            </a>

                            
                            <a href="<?php echo e(route('users.reset-password', $user)); ?>"
                               class="text-gray-400 hover:text-indigo-500" title="Reset password">
                                <i class="fas fa-key"></i>
                            </a>

                            <?php if($user->id !== auth()->id()): ?>
                                
                                <form action="<?php echo e(route('users.toggle-active', $user)); ?>" method="POST"
                                      onsubmit="return confirm('<?php echo e($user->is_active ? 'Disable this account?' : 'Enable this account?'); ?>')">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                            class="text-gray-400 <?php echo e($user->is_active ? 'hover:text-orange-500' : 'hover:text-green-500'); ?>"
                                            title="<?php echo e($user->is_active ? 'Disable account' : 'Enable account'); ?>">
                                        <i class="fas <?php echo e($user->is_active ? 'fa-ban' : 'fa-check-circle'); ?>"></i>
                                    </button>
                                </form>

                                
                                <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST"
                                      onsubmit="return confirm('<?php echo e(__('app.general.confirm_delete')); ?>')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-gray-400 hover:text-red-500" title="Delete user">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-gray-400"><?php echo e(__('app.general.no_data')); ?></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\LPU\lp\regional-crm\resources\views/users/index.blade.php ENDPATH**/ ?>