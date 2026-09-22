<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'skill_tag' => 'ielts',
                'title'     => 'اكتبي هون اسم الكورس',
                'url'       => 'https://PASTE_VERIFIED_URL',
                'provider'  => 'British Council',
                'hours'     => 4,
            ],
            [
                'skill_tag' => 'python_basics',
                'title'     => 'اكتبي هون اسم الكورس',
                'url'       => 'https://PASTE_VERIFIED_URL',
                'provider'  => 'freeCodeCamp',
                'hours'     => 4,
            ],
        ];

        foreach ($items as $item) {
            Resource::updateOrCreate(
                ['skill_tag' => $item['skill_tag'], 'url' => $item['url']],
                $item + ['is_free' => true, 'language' => 'en']
            );
        }
    }
}