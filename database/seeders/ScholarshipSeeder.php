<?php

namespace Database\Seeders;

use App\Models\Scholarship;
use Illuminate\Database\Seeder;

class ScholarshipSeeder extends Seeder
{
    public function run(): void
    {
        $scholarships = [
            [
                'title' => 'Scholarships for Palestine',
                'provider_name' => 'University of Sussex',
                'country' => 'United Kingdom',
                'field_of_study' => null,
                'degree_level' => 'master',
                'application_deadline' => null,
                'description' => 'Full funding plus £17,460 living stipend, for residents of Gaza and the West Bank.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'country', 'criterion_value' => 'Palestine, State of', 'weight' => 60, 'is_mandatory' => true],
                    ['criterion_type' => 'degree_level', 'criterion_value' => 'master', 'weight' => 40, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'HESPAL',
                'provider_name' => 'British Council',
                'country' => 'United Kingdom',
                'field_of_study' => null,
                'degree_level' => 'master',
                'application_deadline' => null,
                'description' => 'Full funding at UK universities for staff of Gaza universities.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'country', 'criterion_value' => 'Palestine, State of', 'weight' => 60, 'is_mandatory' => true],
                    ['criterion_type' => 'degree_level', 'criterion_value' => 'master', 'weight' => 40, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'Dima Alhaj Scholarship',
                'provider_name' => 'University of Glasgow',
                'country' => 'United Kingdom',
                'field_of_study' => null,
                'degree_level' => null,
                'application_deadline' => null,
                'description' => 'For displaced Palestinian students.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'country', 'criterion_value' => 'Palestine, State of', 'weight' => 100, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'Scholarship for Displaced Students',
                'provider_name' => 'University of Oxford',
                'country' => 'United Kingdom',
                'field_of_study' => null,
                'degree_level' => 'phd',
                'application_deadline' => null,
                'description' => 'Postgraduate scholarship for displaced students from Gaza and the West Bank.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'country', 'criterion_value' => 'Palestine, State of', 'weight' => 60, 'is_mandatory' => true],
                    ['criterion_type' => 'degree_level', 'criterion_value' => 'phd', 'weight' => 40, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'Palestinian Citizens Scholarship',
                'provider_name' => 'University of Alberta',
                'country' => 'Canada',
                'field_of_study' => null,
                'degree_level' => null,
                'application_deadline' => null,
                'description' => "For bachelor's and master's students holding Palestinian citizenship.",
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'country', 'criterion_value' => 'Palestine, State of', 'weight' => 100, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'Gaza-displaced Scholarship',
                'provider_name' => 'University of Leeds',
                'country' => 'United Kingdom',
                'field_of_study' => null,
                'degree_level' => null,
                'application_deadline' => null,
                'description' => 'For students displaced from Gaza after October 2023.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'country', 'criterion_value' => 'Palestine, State of', 'weight' => 100, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'Halema Salama Gaber Scholarship',
                'provider_name' => 'Palestinian American Community Center',
                'country' => 'United States',
                'field_of_study' => null,
                'degree_level' => null,
                'application_deadline' => '2026-04-17',
                'description' => '$500-$1000 award.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'country', 'criterion_value' => 'Palestine, State of', 'weight' => 100, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'Tanya Baker-Asad Scholarship',
                'provider_name' => 'PARC (Palestinian American Research Center)',
                'country' => 'United States',
                'field_of_study' => null,
                'degree_level' => 'phd',
                'application_deadline' => '2026-01-12',
                'description' => '$5,000-$25,000, for women pursuing a PhD.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'degree_level', 'criterion_value' => 'phd', 'weight' => 100, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'DAFI Scholarship',
                'provider_name' => 'UNHCR',
                'country' => null,
                'field_of_study' => null,
                'degree_level' => 'bachelor',
                'application_deadline' => null,
                'description' => 'For registered refugees, includes the Palestinian territories.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'degree_level', 'criterion_value' => 'bachelor', 'weight' => 100, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'ISNAD',
                'provider_name' => 'Taawon (Welfare Association)',
                'country' => 'Palestine',
                'field_of_study' => null,
                'degree_level' => null,
                'application_deadline' => null,
                'description' => 'For students at Gaza universities. 2026 target: 30,000 scholarships.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'country', 'criterion_value' => 'Palestine, State of', 'weight' => 100, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'The Copty Scholarship',
                'provider_name' => "Queen's University Belfast",
                'country' => 'United Kingdom',
                'field_of_study' => null,
                'degree_level' => 'master',
                'application_deadline' => null,
                'description' => 'For residents of Gaza, the West Bank, or East Jerusalem.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'country', 'criterion_value' => 'Palestine, State of', 'weight' => 60, 'is_mandatory' => true],
                    ['criterion_type' => 'degree_level', 'criterion_value' => 'master', 'weight' => 40, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'Palestinian Scholarship',
                'provider_name' => 'Goldsmiths, University of London',
                'country' => 'United Kingdom',
                'field_of_study' => null,
                'degree_level' => null,
                'application_deadline' => null,
                'description' => 'Full funding plus £20,500/year living stipend.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'country', 'criterion_value' => 'Palestine, State of', 'weight' => 100, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'UQ Graduate Research Scholarships',
                'provider_name' => 'University of Queensland',
                'country' => 'Australia',
                'field_of_study' => null,
                'degree_level' => null,
                'application_deadline' => null,
                'description' => 'AU$39,220 annual stipend, full tuition, and health insurance for research master\'s (MPhil) or PhD students.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'degree_level', 'criterion_value' => 'master', 'weight' => 50, 'is_mandatory' => false],
                    ['criterion_type' => 'degree_level', 'criterion_value' => 'phd', 'weight' => 50, 'is_mandatory' => false],
                ],
            ],
            [
                'title' => 'Dalarna University Master\'s Scholarships',
                'provider_name' => 'Dalarna University',
                'country' => 'Sweden',
                'field_of_study' => null,
                'degree_level' => 'master',
                'application_deadline' => null,
                'description' => 'Tuition discount (5,000 SEK) via the Choose Dalarna First scholarship, plus a possible merit scholarship of up to 90,000 SEK for master\'s students.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'degree_level', 'criterion_value' => 'master', 'weight' => 100, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'Qarshi University Scholarship',
                'provider_name' => 'Qarshi University',
                'country' => 'Pakistan',
                'field_of_study' => null,
                'degree_level' => null,
                'application_deadline' => null,
                'description' => 'Tuition coverage for non-medical fields, with an MBA track also available, for Palestinian students via the Palestine-Egypt education support initiative.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'country', 'criterion_value' => 'Palestine, State of', 'weight' => 100, 'is_mandatory' => true],
                ],
            ],
            [
                'title' => 'Czech Government Scholarship',
                'provider_name' => 'Government of the Czech Republic',
                'country' => 'Czech Republic',
                'field_of_study' => null,
                'degree_level' => null,
                'application_deadline' => '2026-09-30',
                'description' => '16,000 CZK/month for master\'s students, 17,000 CZK/month for PhD students, plus healthcare coverage, at Czech public universities.',
                'external_link' => null,
                'criteria' => [
                    ['criterion_type' => 'degree_level', 'criterion_value' => 'master', 'weight' => 50, 'is_mandatory' => false],
                    ['criterion_type' => 'degree_level', 'criterion_value' => 'phd', 'weight' => 50, 'is_mandatory' => false],
                ],
            ],
        ];

        foreach ($scholarships as $data) {
            $criteria = $data['criteria'];
            unset($data['criteria']);

            $scholarship = Scholarship::create($data);
            foreach ($criteria as $criterion) {
                $scholarship->criteria()->create($criterion);
            }
        }
    }
}