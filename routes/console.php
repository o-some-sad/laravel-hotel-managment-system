<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\LoginReminderMail;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $oneMonthAgo = Carbon::now()->subMonth();

    // Get users who haven't logged in for a month
    $users = User::where('last_login_at', '<', $oneMonthAgo)
        ->orWhereNull('last_login_at')
        ->get();

    // Queue an email for each user
    foreach ($users as $user) {
        Mail::to($user->email)->queue(new LoginReminderMail($user));
    }

    // Log success message in console
    \Illuminate\Support\Facades\Log::info('Login reminder emails queued successfully.');
})->daily()->description('Send login reminder to users who haven’t logged in for a month');
