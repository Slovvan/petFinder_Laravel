<?php

use Illuminate\Support\Facades\Schedule;

// Schedule to archive animals older than 30 days
Schedule::command('animals:archive')->daily();
