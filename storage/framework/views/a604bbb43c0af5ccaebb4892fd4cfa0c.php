<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'Regional CRM')); ?> - <?php echo $__env->yieldContent('title'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Devanagari:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>body { font-family: 'Inter', 'Noto Sans Devanagari', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-indigo-600 rounded-2xl shadow-lg mb-4">
                <i class="fas fa-handshake text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900"><?php echo e(config('app.name', 'Regional CRM')); ?></h1>
            <p class="text-gray-500 text-sm mt-1"><?php echo e(__('app.general.crm_tagline')); ?></p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <?php if(session('success')): ?>
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4 text-sm">
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-4 text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        
        <div class="flex flex-wrap justify-center gap-2 mt-6">
            <?php $__currentLoopData = config('languages.supported'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('lang.switch', $code)); ?>" class="text-xs px-2 py-1 rounded-full <?php echo e(app()->getLocale() === $code ? 'bg-indigo-600 text-white' : 'bg-white text-gray-500 hover:bg-indigo-50 border border-gray-200'); ?> transition">
                <?php echo e($lang['flag']); ?> <?php echo e($lang['native']); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH E:\LPU\lp\regional-crm\resources\views/layouts/auth.blade.php ENDPATH**/ ?>