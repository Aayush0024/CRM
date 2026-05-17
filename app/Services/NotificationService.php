<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Send a notification to a single user.
     */
    public static function send(
        int    $userId,
        string $type,
        string $title,
        string $message,
        string $link = null,
        array  $data = []
    ): void {
        // Don't notify if user doesn't exist or is inactive
        $user = User::find($userId);
        if (!$user || !$user->is_active) {
            return;
        }

        Notification::create([
            'user_id' => $userId,
            'type'    => $type,   // info | success | warning | danger
            'title'   => $title,
            'message' => $message,
            'link'    => $link,
            'data'    => $data ?: null,
        ]);
    }

    /**
     * Send the same notification to multiple users.
     */
    public static function sendToMany(
        array  $userIds,
        string $type,
        string $title,
        string $message,
        string $link = null,
        array  $data = []
    ): void {
        foreach (array_unique($userIds) as $userId) {
            self::send($userId, $type, $title, $message, $link, $data);
        }
    }

    // ── Lead notifications ────────────────────────────────────────────────

    public static function leadAssigned(int $assignedTo, string $leadTitle, int $leadId, int $assignedBy): void
    {
        if ($assignedTo === $assignedBy) return; // Don't notify if assigning to yourself

        self::send(
            $assignedTo,
            'info',
            'Lead Assigned to You',
            "You have been assigned the lead: \"{$leadTitle}\".",
            route('leads.show', $leadId)
        );
    }

    public static function leadConverted(int $createdBy, int $assignedTo, string $leadTitle, int $dealId): void
    {
        $recipients = array_unique(array_filter([$createdBy, $assignedTo]));
        foreach ($recipients as $userId) {
            self::send(
                $userId,
                'success',
                'Lead Converted to Deal',
                "Lead \"{$leadTitle}\" has been successfully converted to a deal.",
                route('deals.show', $dealId)
            );
        }
    }

    public static function leadStatusChanged(int $assignedTo, int $updatedBy, string $leadTitle, string $newStatus, int $leadId): void
    {
        if ($assignedTo === $updatedBy) return;

        self::send(
            $assignedTo,
            'info',
            'Lead Status Updated',
            "Lead \"{$leadTitle}\" status changed to " . ucfirst(str_replace('_', ' ', $newStatus)) . ".",
            route('leads.show', $leadId)
        );
    }

    // ── Deal notifications ────────────────────────────────────────────────

    public static function dealAssigned(int $assignedTo, string $dealTitle, int $dealId, int $assignedBy): void
    {
        if ($assignedTo === $assignedBy) return;

        self::send(
            $assignedTo,
            'info',
            'Deal Assigned to You',
            "You have been assigned the deal: \"{$dealTitle}\".",
            route('deals.show', $dealId)
        );
    }

    public static function dealStageChanged(int $assignedTo, int $updatedBy, string $dealTitle, string $newStage, int $dealId): void
    {
        if ($assignedTo === $updatedBy) return;

        $stageLabel = ucfirst(str_replace('_', ' ', $newStage));
        self::send(
            $assignedTo,
            'info',
            'Deal Stage Updated',
            "Deal \"{$dealTitle}\" moved to stage: {$stageLabel}.",
            route('deals.show', $dealId)
        );
    }

    public static function dealWon(int $assignedTo, int $createdBy, string $dealTitle, int $dealId): void
    {
        $recipients = array_unique(array_filter([$assignedTo, $createdBy]));
        foreach ($recipients as $userId) {
            self::send(
                $userId,
                'success',
                'Deal Won! 🎉',
                "Congratulations! Deal \"{$dealTitle}\" has been marked as Won.",
                route('deals.show', $dealId)
            );
        }
    }

    public static function dealLost(int $assignedTo, int $updatedBy, string $dealTitle, int $dealId): void
    {
        if ($assignedTo === $updatedBy) return;

        self::send(
            $assignedTo,
            'warning',
            'Deal Marked as Lost',
            "Deal \"{$dealTitle}\" has been marked as Lost.",
            route('deals.show', $dealId)
        );
    }

    // ── Task notifications ────────────────────────────────────────────────

    public static function taskAssigned(int $assignedTo, string $taskTitle, int $taskId, int $assignedBy, string $dueDate = null): void
    {
        if ($assignedTo === $assignedBy) return;

        $duePart = $dueDate ? " Due: {$dueDate}." : '';
        self::send(
            $assignedTo,
            'info',
            'Task Assigned to You',
            "You have a new task: \"{$taskTitle}\".{$duePart}",
            route('tasks.edit', $taskId)
        );
    }

    public static function taskDueSoon(int $assignedTo, string $taskTitle, int $taskId, string $dueDate): void
    {
        self::send(
            $assignedTo,
            'warning',
            'Task Due Soon',
            "Reminder: Task \"{$taskTitle}\" is due on {$dueDate}.",
            route('tasks.edit', $taskId)
        );
    }

    public static function taskOverdue(int $assignedTo, string $taskTitle, int $taskId, string $dueDate): void
    {
        self::send(
            $assignedTo,
            'danger',
            'Task Overdue',
            "Task \"{$taskTitle}\" was due on {$dueDate} and is now overdue.",
            route('tasks.edit', $taskId)
        );
    }

    public static function taskCompleted(int $createdBy, int $completedBy, string $taskTitle, int $taskId): void
    {
        if ($createdBy === $completedBy) return;

        self::send(
            $createdBy,
            'success',
            'Task Completed',
            "\"{$taskTitle}\" has been marked as completed.",
            route('tasks.edit', $taskId)
        );
    }

    // ── Customer notifications ────────────────────────────────────────────

    public static function customerAssigned(int $assignedTo, string $customerName, int $customerId, int $assignedBy): void
    {
        if ($assignedTo === $assignedBy) return;

        self::send(
            $assignedTo,
            'info',
            'Customer Assigned to You',
            "Customer \"{$customerName}\" has been assigned to you.",
            route('customers.show', $customerId)
        );
    }
}
