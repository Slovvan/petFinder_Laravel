<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AnimalService;

class ArchivedOldAnimals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'animals:archive';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'archive automatically anounces older than 30 days';
    /**
     * Execute the console command.
     */
    public function handle(AnimalService $service)
    {
        $count = $service->archiveExpiredPosts();
        $this->info("{$count} Archived.");
    }
}
