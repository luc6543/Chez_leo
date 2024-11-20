<?php


use Illuminate\Support\Facades\Schedule;

Schedule::command('app:remove-inactive-reservations')->everyMinute();
Schedule::command('app:send-review-mails')->everyMinute();
