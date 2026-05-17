<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(config('languages.supported.'.app()->getLocale().'.direction', 'ltr')); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Regional CRM')); ?> - <?php echo $__env->yieldContent('title', __('app.nav.dashboard')); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Devanagari:wght@400;500;600;700&family=Noto+Sans+Tamil:wght@400;500;600;700&family=Noto+Sans+Telugu:wght@400;500;600;700&family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Sans+Gujarati:wght@400;500;600;700&family=Noto+Sans+Kannada:wght@400;500;600;700&family=Noto+Sans+Malayalam:wght@400;500;600;700&family=Noto+Sans+Gurmukhi:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', 'Noto Sans Devanagari', 'Noto Sans Tamil', 'Noto Sans Telugu', 'Noto Sans Bengali', sans-serif; }
        .sidebar-link.active { background: rgba(99,102,241,0.15); color: #6366f1; border-right: 3px solid #6366f1; }
        .sidebar-link:hover { background: rgba(99,102,241,0.08); }
        [dir="rtl"] .sidebar-link.active { border-right: none; border-left: 3px solid #6366f1; }
        .badge-green { background:#dcfce7;color:#166534; }
        .badge-red { background:#fee2e2;color:#991b1b; }
        .badge-blue { background:#dbeafe;color:#1e40af; }
        .badge-yellow { background:#fef9c3;color:#854d0e; }
        .badge-purple { background:#f3e8ff;color:#6b21a8; }
        .badge-gray { background:#f3f4f6;color:#374151; }
        .badge-orange { background:#ffedd5;color:#9a3412; }
        .badge-indigo { background:#e0e7ff;color:#3730a3; }
        .kanban-col { min-height: 400px; }
        .drag-over { background: #e0e7ff; border: 2px dashed #6366f1; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
        .fade-in { animation: fadeIn 0.2s ease; }
        .scrollbar-thin::-webkit-scrollbar { width: 4px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 2px; }
        /* Let the main column shrink inside h-screen flex so overflow-y-auto can scroll */
        .app-main-scroll { min-height: 0; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 text-gray-800 overflow-x-hidden">

<div class="flex h-screen min-h-0 overflow-hidden">
    
    <aside id="sidebar" class="w-64 bg-white shadow-lg flex flex-col fixed inset-y-0 left-0 z-30 transform -translate-x-full md:translate-x-0 transition-transform duration-200">
        
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
            <div class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-handshake text-white text-sm"></i>
            </div>
            <div>
                <div class="font-bold text-gray-900 text-sm leading-tight"><?php echo e(config('app.name','Regional CRM')); ?></div>
                <div class="text-xs text-gray-400"><?php echo e(config('languages.supported.'.app()->getLocale().'.native', 'English')); ?></div>
            </div>
        </div>

        
        <nav class="flex-1 overflow-y-auto scrollbar-thin py-4 px-3">
            <a href="<?php echo e(route('dashboard')); ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 mb-1 <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-th-large w-5 text-center"></i> <?php echo e(__('app.nav.dashboard')); ?>

            </a>

            
            <a href="<?php echo e(route('customers.index')); ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 mb-1 <?php echo e(request()->routeIs('customers.*') ? 'active' : ''); ?>">
                <i class="fas fa-users w-5 text-center"></i> <?php echo e(__('app.nav.customers')); ?>

            </a>

            
            <a href="<?php echo e(route('contacts.index')); ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 mb-1 <?php echo e(request()->routeIs('contacts.*') ? 'active' : ''); ?>">
                <i class="fas fa-address-book w-5 text-center"></i> <?php echo e(__('app.nav.contacts')); ?>

            </a>

            
            <?php if(auth()->user()->isAdmin() || auth()->user()->isManager() || auth()->user()->isSalesExecutive()): ?>
            <a href="<?php echo e(route('leads.index')); ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 mb-1 <?php echo e(request()->routeIs('leads.*') ? 'active' : ''); ?>">
                <i class="fas fa-funnel-dollar w-5 text-center"></i> <?php echo e(__('app.nav.leads')); ?>

            </a>
            <a href="<?php echo e(route('deals.index')); ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 mb-1 <?php echo e(request()->routeIs('deals.*') ? 'active' : ''); ?>">
                <i class="fas fa-briefcase w-5 text-center"></i> <?php echo e(__('app.nav.deals')); ?>

            </a>
            <?php endif; ?>

            
            <a href="<?php echo e(route('tasks.index')); ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 mb-1 <?php echo e(request()->routeIs('tasks.*') ? 'active' : ''); ?>">
                <i class="fas fa-tasks w-5 text-center"></i> <?php echo e(__('app.nav.tasks')); ?>

            </a>

            
            <a href="<?php echo e(route('activities.index')); ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 mb-1 <?php echo e(request()->routeIs('activities.*') ? 'active' : ''); ?>">
                <i class="fas fa-history w-5 text-center"></i> <?php echo e(__('app.nav.activities')); ?>

            </a>

            
            <?php if(auth()->user()->canViewReports()): ?>
            <a href="<?php echo e(route('reports.index')); ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 mb-1 <?php echo e(request()->routeIs('reports.*') ? 'active' : ''); ?>">
                <i class="fas fa-chart-bar w-5 text-center"></i> <?php echo e(__('app.nav.reports')); ?>

            </a>
            <?php endif; ?>

            
            <?php if(auth()->user()->isAdmin()): ?>
            <div class="mt-4 mb-2 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin</div>
            <a href="<?php echo e(route('users.index')); ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 mb-1 <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
                <i class="fas fa-user-cog w-5 text-center"></i> <?php echo e(__('app.nav.users')); ?>

            </a>
            <a href="<?php echo e(route('settings.index')); ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 mb-1 <?php echo e(request()->routeIs('settings.*') ? 'active' : ''); ?>">
                <i class="fas fa-cog w-5 text-center"></i> <?php echo e(__('app.nav.settings')); ?>

            </a>
            <?php endif; ?>
        </nav>

        
        <div class="border-t border-gray-100 p-4">
            <div class="flex items-center gap-3">
                <img src="<?php echo e(auth()->user()->avatar_url); ?>" class="w-8 h-8 rounded-full object-cover" alt="">
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-gray-900 truncate"><?php echo e(auth()->user()->name); ?></div>
                    <div class="text-xs text-gray-400 truncate"><?php echo e(auth()->user()->role->display_name ?? 'User'); ?></div>
                </div>
            </div>
        </div>
    </aside>

    
    <div class="flex-1 flex flex-col min-h-0 w-full min-w-0 md:ml-64">
        
        <header class="shrink-0 bg-white shadow-sm z-20 px-4 md:px-6 py-3 flex items-center justify-between border-b border-gray-100">
            <div class="flex items-center gap-3">
                <button id="sidebarToggle" class="md:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <h1 class="text-lg font-semibold text-gray-800"><?php echo $__env->yieldContent('title', __('app.nav.dashboard')); ?></h1>
            </div>
            <div class="flex items-center gap-3">
                
                <div class="relative" x-data="{ open: false }">
                    <button onclick="document.getElementById('langMenu').classList.toggle('hidden')" class="flex items-center gap-2 text-sm text-gray-600 hover:text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition">
                        <span><?php echo e(config('languages.supported.'.app()->getLocale().'.flag','🌐')); ?></span>
                        <span class="hidden sm:inline"><?php echo e(config('languages.supported.'.app()->getLocale().'.native','English')); ?></span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div id="langMenu" class="hidden absolute right-0 mt-1 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50 fade-in">
                        <?php $__currentLoopData = config('languages.supported'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('lang.switch', $code)); ?>" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo e(app()->getLocale() === $code ? 'bg-indigo-50 text-indigo-600 font-medium' : ''); ?>">
                            <span><?php echo e($lang['flag']); ?></span>
                            <span><?php echo e($lang['native']); ?></span>
                            <?php if(app()->getLocale() === $code): ?><i class="fas fa-check ml-auto text-xs"></i><?php endif; ?>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <div class="relative">
                    <button onclick="document.getElementById('notifMenu').classList.toggle('hidden')" class="relative text-gray-500 hover:text-indigo-600 p-2 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-bell text-lg"></i>
                        <?php $unread = auth()->user()->unreadNotifications()->count(); ?>
                        <?php if($unread > 0): ?>
                        <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center"><?php echo e($unread > 9 ? '9+' : $unread); ?></span>
                        <?php endif; ?>
                    </button>
                    <div id="notifMenu" class="hidden absolute right-0 mt-1 w-80 bg-white rounded-xl shadow-lg border border-gray-100 z-50 fade-in">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                            <span class="font-semibold text-gray-800 text-sm"><?php echo e(__('app.nav.notifications')); ?></span>
                            <?php if($unread > 0): ?>
                            <form action="<?php echo e(route('notifications.read-all')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button class="text-xs text-indigo-600 hover:underline">Mark all read</button>
                            </form>
                            <?php endif; ?>
                        </div>
                        <div class="max-h-72 overflow-y-auto scrollbar-thin">
                            <?php $__empty_1 = true; $__currentLoopData = auth()->user()->notifications()->latest()->take(8)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $iconMap = [
                                    'info'    => ['icon' => 'fa-info-circle',       'bg' => 'bg-blue-100',   'text' => 'text-blue-500'],
                                    'success' => ['icon' => 'fa-check-circle',      'bg' => 'bg-green-100',  'text' => 'text-green-500'],
                                    'warning' => ['icon' => 'fa-exclamation-circle','bg' => 'bg-yellow-100', 'text' => 'text-yellow-500'],
                                    'danger'  => ['icon' => 'fa-times-circle',      'bg' => 'bg-red-100',    'text' => 'text-red-500'],
                                ];
                                $style = $iconMap[$notif->type] ?? $iconMap['info'];
                            ?>
                            <div class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 <?php echo e(is_null($notif->read_at) ? 'bg-indigo-50/40' : ''); ?>">
                                <div class="w-8 h-8 rounded-full <?php echo e($style['bg']); ?> flex items-center justify-center flex-shrink-0">
                                    <i class="fas <?php echo e($style['icon']); ?> <?php echo e($style['text']); ?> text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <?php if($notif->link): ?>
                                        <a href="<?php echo e($notif->link); ?>" class="text-sm text-gray-700 leading-snug hover:text-indigo-600 block"><?php echo e($notif->message); ?></a>
                                    <?php else: ?>
                                        <p class="text-sm text-gray-700 leading-snug"><?php echo e($notif->message); ?></p>
                                    <?php endif; ?>
                                    <p class="text-xs text-gray-400 mt-0.5"><?php echo e($notif->created_at->diffForHumans()); ?></p>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="px-4 py-6 text-center text-sm text-gray-400">No notifications</div>
                            <?php endif; ?>
                        </div>
                        <div class="border-t border-gray-100 px-4 py-2">
                            <a href="<?php echo e(route('notifications.index')); ?>" class="text-xs text-indigo-600 hover:underline">View all</a>
                        </div>
                    </div>
                </div>

                
                <div class="relative">
                    <button onclick="document.getElementById('userMenu').classList.toggle('hidden')" class="flex items-center gap-2 hover:bg-gray-100 rounded-lg px-2 py-1.5 transition">
                        <img src="<?php echo e(auth()->user()->avatar_url); ?>" class="w-7 h-7 rounded-full object-cover" alt="">
                        <span class="hidden sm:inline text-sm font-medium text-gray-700"><?php echo e(auth()->user()->name); ?></span>
                        <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                    </button>
                    <div id="userMenu" class="hidden absolute right-0 mt-1 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50 fade-in">
                        <a href="<?php echo e(route('profile.change-password.form')); ?>"
                           class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                            <i class="fas fa-lock w-4 text-center"></i> Reset Password
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="w-full text-left flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt w-4 text-center"></i> <?php echo e(__('app.nav.logout')); ?>

                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        
        <div class="shrink-0 px-4 md:px-6 pt-4">
            <?php if(session('success')): ?>
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4 fade-in">
                <i class="fas fa-check-circle text-green-500"></i>
                <span class="text-sm"><?php echo e(session('success')); ?></span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600"><i class="fas fa-times"></i></button>
            </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-4 fade-in">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <span class="text-sm"><?php echo e(session('error')); ?></span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600"><i class="fas fa-times"></i></button>
            </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-4 fade-in">
                <div class="flex items-center gap-2 mb-1"><i class="fas fa-exclamation-triangle text-red-500"></i><span class="text-sm font-medium">Please fix the errors below:</span></div>
                <ul class="list-disc list-inside text-sm space-y-0.5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>

        
        <main class="app-main-scroll flex-1 overflow-y-auto overflow-x-hidden px-4 md:px-6 pb-8 scrollbar-thin">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>


<div id="sidebarOverlay" class="hidden fixed inset-0 bg-black/40 z-20 md:hidden" onclick="closeSidebar()"></div>

<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
        document.getElementById('sidebarOverlay').classList.toggle('hidden');
    });
    function closeSidebar() {
        document.getElementById('sidebar').classList.add('-translate-x-full');
        document.getElementById('sidebarOverlay').classList.add('hidden');
    }
    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        ['langMenu','notifMenu','userMenu'].forEach(id => {
            const el = document.getElementById(id);
            if (el && !el.previousElementSibling?.contains(e.target) && !el.contains(e.target)) {
                el.classList.add('hidden');
            }
        });
    });
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH E:\LPU\lp\regional-crm\resources\views/layouts/app.blade.php ENDPATH**/ ?>