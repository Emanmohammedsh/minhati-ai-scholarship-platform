<?php

namespace App\Console\Commands;

use App\Services\ScholarshipDiscoveryService;
use Illuminate\Console\Command;

class DiscoverScholarships extends Command
{
    protected $signature = 'scholarships:discover {--limit=10}';

    protected $description = 'Use Gemini + Google Search to find new real scholarships and add them (pending review) to the database.';

    public function handle(ScholarshipDiscoveryService $service): int
    {
        $limit = (int) $this->option('limit');

        $this->info("Searching for up to {$limit} new scholarships...");

        $result = $service->discoverAndStore($limit);

        $this->info("Added: {$result['added']}");
        $this->info("Skipped (duplicates/invalid): {$result['skipped']}");

        foreach ($result['errors'] as $error) {
            $this->warn("- {$error}");
        }

        if ($result['added'] > 0) {
            $this->comment('New scholarships added with is_active = false. Review and activate manually.');
        }

        return self::SUCCESS;
    }
}