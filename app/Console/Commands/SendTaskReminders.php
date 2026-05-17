<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Task;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendTaskReminders extends Command
{
    protected $signature   = 'notifications:task-reminders';
    protected $description = 'Send due-soon and overdue task reminder notifications';

    public function handle(): void
    {
        $now      = now();
        $tomorrow = now()->addDay();

        // ── Due tomorrow (24-hour warning) ────────────────────────────────
        $dueSoon = Task::whereIn('status', ['pending', 'in_progress'])
            ->whereNotNull('due_date')
            ->whereDate('due_date', $tomorrow->toDateString())
            ->whereNotNull('assigned_to')
            ->get();

        foreach ($dueSoon as $task) {
            // Skip if we already sent a "due soon" reminder today for this task
            $alreadySent = Notification::where('user_id', $task->assigned_to)
                ->where('title', 'Task Due Soon')
                ->where('link', route('tasks.edit', $task->id))
                ->whereDate('created_at', $now->toDateString())
                ->exists();

            if (!$alreadySent) {
                NotificationService::taskDueSoon(
                    $task->assigned_to,
                    $task->title,
                    $task->id,
                    $task->due_date->format('d M Y')
                );
            }
        }

        // ── Overdue (past due date, not completed) ────────────────────────
        $overdue = Task::whereIn('status', ['pending', 'in_progress'])
            ->whereNotNull('due_date')
            ->where('due_date', '<', $now->startOfDay())
            ->whereNotNull('assigned_to')
            ->get();

        foreach ($overdue as $task) {
            // Only send one overdue notification per task per day
            $alreadySent = Notification::where('user_id', $task->assigned_to)
                ->where('title', 'Task Overdue')
                ->where('link', route('tasks.edit', $task->id))
                ->whereDate('created_at', $now->toDateString())
                ->exists();

            if (!$alreadySent) {
                NotificationService::taskOverdue(
                    $task->assigned_to,
                    $task->title,
                    $task->id,
                    $task->due_date->format('d M Y')
                );
            }
        }

        $this->info("Reminders sent — due soon: {$dueSoon->count()}, overdue: {$overdue->count()}");
    }
}
