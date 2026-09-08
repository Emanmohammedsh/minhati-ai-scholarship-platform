<?php

namespace App\Console\Commands;

use App\Models\Scholarship;
use App\Models\ScholarshipCriterion;
use App\Services\ScholarshipApiClient;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Throwable;

class SyncScholarships extends Command
{
    protected $signature = 'scholarships:sync
        {--query=* : Search terms to pull (default: a broad spread of fields)}
        {--limit=50 : Max results per query}
        {--dry-run : Print the raw API response instead of writing to the database}';

    protected $description = 'Sync scholarships from ScholarshipAPI (api.scholarshipapi.com) into the local database.';

    protected array $defaultQueries = [
        'engineering', 'computer science', 'business', 'medicine',
        'law', 'arts', 'science', 'education',
    ];

    public function handle(ScholarshipApiClient $client): int
    {
        $queries = $this->option('query') ?: $this->defaultQueries;
        $limit = (int) $this->option('limit');
        $dryRun = (bool) $this->option('dry-run');

        $totalCreated = 0;
        $totalUpdated = 0;

        foreach ($queries as $query) {
            $this->info("Fetching: \"{$query}\"...");

            try {
                $result = $client->search($query, $limit);
            } catch (Throwable $e) {
                $this->error("  Failed: {$e->getMessage()}");
                continue;
            }

            $hits = $result['hits'] ?? [];

            if ($dryRun) {
                $this->line(json_encode(array_slice($hits, 0, 3), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $this->info('Dry run: showing up to 3 raw hits above. No database changes made.');
                continue;
            }

            foreach ($hits as $hit) {
                [$created, $updated] = $this->upsertScholarship($hit);
                $totalCreated += $created ? 1 : 0;
                $totalUpdated += $updated ? 1 : 0;
            }
        }

        if (! $dryRun) {
            $this->info("Done. Created: {$totalCreated}, Updated: {$totalUpdated}.");
        }

        return self::SUCCESS;
    }

    protected function upsertScholarship(array $hit): array
    {
        $title = $hit['name'] ?? null;
        $universityCode = $hit['university'] ?? null;

        if (! $title) {
            return [false, false];
        }

        $country = $this->countryFromUniversityCode($universityCode);
        $providerName = $this->providerNameFromUniversityCode($universityCode);

        $scholarship = Scholarship::updateOrCreate(
            [
                'title' => $title,
                'provider_name' => $providerName,
            ],
            [
                'description' => $hit['summary'] ?? $hit['eligibilitySummary'] ?? null,
                'country' => $country,
                'field_of_study' => $hit['primaryCategory'] ?? null,
                'degree_level' => $this->mapDegreeLevel($hit),
                'application_deadline' => $this->parseCloseDate($hit['closeDate'] ?? null),
                'external_link' => $hit['url'] ?? $hit['link'] ?? null,
                'is_active' => ($hit['status'] ?? 'open') === 'open',
            ]
        );

        $wasCreated = $scholarship->wasRecentlyCreated;
        $this->syncCriteria($scholarship, $country, $hit);

        return [$wasCreated, ! $wasCreated];
    }

    protected function syncCriteria(Scholarship $scholarship, ?string $country, array $hit): void
    {
        if ($country) {
            ScholarshipCriterion::updateOrCreate(
                ['scholarship_id' => $scholarship->scholarship_id, 'criterion_type' => 'country'],
                ['criterion_value' => $country, 'weight' => 100, 'is_mandatory' => true]
            );
        }

        foreach ($hit['targetGroups'] ?? [] as $group) {
            ScholarshipCriterion::updateOrCreate(
                ['scholarship_id' => $scholarship->scholarship_id, 'criterion_type' => 'target_group', 'criterion_value' => $group],
                ['weight' => 25, 'is_mandatory' => false]
            );
        }
    }

    protected function countryFromUniversityCode(?string $code): ?string
    {
        if (! $code) {
            return null;
        }

        return match (strtolower(explode('/', $code)[0] ?? '')) {
            'au' => 'Australia',
            'nz' => 'New Zealand',
            default => null,
        };
    }

    protected function providerNameFromUniversityCode(?string $code): ?string
    {
        if (! $code) {
            return null;
        }

        $parts = explode('/', $code);
        return ucwords(str_replace('-', ' ', end($parts)));
    }

    protected function mapDegreeLevel(array $hit): ?string
    {
        $levels = $hit['academicLevels'] ?? null;
        return is_array($levels) ? ($levels[0] ?? null) : $levels;
    }

    protected function parseCloseDate(?int $closeDateMs): ?string
    {
        return $closeDateMs ? Carbon::createFromTimestampMs($closeDateMs)->toDateString() : null;
    }
}