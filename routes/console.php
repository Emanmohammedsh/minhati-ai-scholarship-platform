<?php

use App\Models\Notification;
use App\Models\SavedApplication;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('notifications:send-deadline-reminders', function () {

    $today = now()->startOfDay();
    $windowEnd = now()->addDays(7)->endOfDay();

    $applications = SavedApplication::with(['user', 'scholarship'])
        ->whereHas('scholarship', function ($query) use ($today, $windowEnd) {
            $query->whereNotNull('application_deadline')
                ->whereBetween('application_deadline', [
                    $today->toDateString(),
                    $windowEnd->toDateString(),
                ]);
        })
        ->get();

    $sent = 0;
    $failed = 0;

    foreach ($applications as $application) {

        $scholarship = $application->scholarship;
        $user = $application->user;

        if (! $scholarship || ! $user) {
            continue;
        }

        $alreadyProcessed = Notification::where(
            'saved_application_id',
            $application->saved_application_id
        )
            ->where('notification_type', 'deadline_reminder')
            ->where('reminder_window_days', 7)
            ->exists();

        if ($alreadyProcessed) {
            continue;
        }

        $notification = Notification::create([
            'user_id' => $user->user_id,
            'saved_application_id' => $application->saved_application_id,
            'notification_type' => 'deadline_reminder',
            'reminder_window_days' => 7,
            'channel' => 'email',
            'status' => 'pending',
            'scheduled_for' => now(),
            'created_at' => now(),
        ]);

        try {

            Mail::raw(
                "Hello {$user->full_name},\n\n" .
                "This is a reminder that the scholarship \"" .
                "{$scholarship->title}\" has an application deadline on " .
                "{$scholarship->application_deadline->format('Y-m-d')}.\n\n" .
                "Please make sure to complete your application before the deadline.\n\n" .
                "Manhati Team",
                function ($message) use ($user, $scholarship) {
                    $message->to($user->email)
                        ->subject(
                            'Scholarship Deadline Reminder: ' .
                            $scholarship->title
                        );
                }
            );

            $notification->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            $sent++;

        } catch (\Throwable $e) {

            $notification->update([
                'status' => 'failed',
                'failure_reason' => $e->getMessage(),
            ]);

            Log::error('Deadline notification failed', [
                'notification_id' => $notification->notification_id,
                'user_id' => $user->user_id,
                'scholarship_id' => $scholarship->scholarship_id,
                'error' => $e->getMessage(),
            ]);

            $failed++;
        }
    }

    $this->info("Deadline reminders completed. Sent: {$sent}, Failed: {$failed}");

})->purpose('Send scholarship deadline reminder emails');

Schedule::command('notifications:send-deadline-reminders')
    ->dailyAt('09:00');