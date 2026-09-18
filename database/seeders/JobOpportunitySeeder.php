<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobOpportunity;

class JobOpportunitySeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Demo Job Opportunities
        |--------------------------------------------------------------------------
        |
        | These opportunities are sample data for demonstrating the Jisr AI
        | Career Matching Engine. They are not presented as live vacancies.
        |
        */

        $jobs = [
            [
                'job' => [
                    'title' => 'Junior Cyber Security Analyst',
                    'company_name' => 'Jisr Demo Tech',
                    'description' => 'Entry-level cyber security role focused on monitoring, identifying security risks, and supporting incident response activities.',
                    'country' => 'Palestine, State of',
                    'city' => 'Gaza',
                    'employment_type' => 'Full Time',
                    'work_mode' => 'Hybrid',
                    'minimum_experience_years' => 0,
                    'application_url' => null,
                    'application_deadline' => '2026-10-15',
                    'is_active' => true,
                ],
                'requirements' => [
                    [
                        'requirement_type' => 'field_of_study',
                        'required_value' => 'Cyber Security',
                        'is_mandatory' => false,
                        'weight' => 30,
                    ],
                    [
                        'requirement_type' => 'degree_level',
                        'required_value' => 'bachelor',
                        'is_mandatory' => false,
                        'weight' => 20,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'Network Security',
                        'is_mandatory' => false,
                        'weight' => 30,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'Python',
                        'is_mandatory' => false,
                        'weight' => 20,
                    ],
                ],
            ],

            [
                'job' => [
                    'title' => 'Network Security Assistant',
                    'company_name' => 'Jisr Demo Networks',
                    'description' => 'Junior role supporting network monitoring, security configuration, troubleshooting, and infrastructure protection.',
                    'country' => 'Palestine, State of',
                    'city' => 'Gaza',
                    'employment_type' => 'Full Time',
                    'work_mode' => 'On-site',
                    'minimum_experience_years' => 0,
                    'application_url' => null,
                    'application_deadline' => '2026-10-20',
                    'is_active' => true,
                ],
                'requirements' => [
                    [
                        'requirement_type' => 'field_of_study',
                        'required_value' => 'Cyber Security',
                        'is_mandatory' => false,
                        'weight' => 25,
                    ],
                    [
                        'requirement_type' => 'degree_level',
                        'required_value' => 'bachelor',
                        'is_mandatory' => false,
                        'weight' => 15,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'Network Security',
                        'is_mandatory' => false,
                        'weight' => 35,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'Linux',
                        'is_mandatory' => false,
                        'weight' => 25,
                    ],
                ],
            ],

            [
                'job' => [
                    'title' => 'Junior Backend Developer',
                    'company_name' => 'Jisr Demo Software',
                    'description' => 'Entry-level backend development role working with APIs, databases, server-side applications, and software development practices.',
                    'country' => 'Palestine, State of',
                    'city' => 'Remote',
                    'employment_type' => 'Full Time',
                    'work_mode' => 'Remote',
                    'minimum_experience_years' => 0,
                    'application_url' => null,
                    'application_deadline' => '2026-10-25',
                    'is_active' => true,
                ],
                'requirements' => [
                    [
                        'requirement_type' => 'degree_level',
                        'required_value' => 'bachelor',
                        'is_mandatory' => false,
                        'weight' => 20,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'Python',
                        'is_mandatory' => false,
                        'weight' => 30,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'PHP',
                        'is_mandatory' => false,
                        'weight' => 25,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'MySQL',
                        'is_mandatory' => false,
                        'weight' => 25,
                    ],
                ],
            ],

            [
                'job' => [
                    'title' => 'IT Support Assistant',
                    'company_name' => 'Jisr Demo Services',
                    'description' => 'Entry-level IT support role involving user support, network troubleshooting, system configuration, and technical issue resolution.',
                    'country' => 'Palestine, State of',
                    'city' => 'Gaza',
                    'employment_type' => 'Full Time',
                    'work_mode' => 'On-site',
                    'minimum_experience_years' => 0,
                    'application_url' => null,
                    'application_deadline' => '2026-11-01',
                    'is_active' => true,
                ],
                'requirements' => [
                    [
                        'requirement_type' => 'degree_level',
                        'required_value' => 'bachelor',
                        'is_mandatory' => false,
                        'weight' => 20,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'Network Security',
                        'is_mandatory' => false,
                        'weight' => 25,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'Troubleshooting',
                        'is_mandatory' => false,
                        'weight' => 30,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'Windows',
                        'is_mandatory' => false,
                        'weight' => 25,
                    ],
                ],
            ],

            [
                'job' => [
                    'title' => 'SOC Analyst Intern',
                    'company_name' => 'Jisr Demo Security Lab',
                    'description' => 'Cyber security internship focused on security monitoring, network analysis, vulnerability awareness, and incident investigation.',
                    'country' => 'Palestine, State of',
                    'city' => 'Remote',
                    'employment_type' => 'Internship',
                    'work_mode' => 'Remote',
                    'minimum_experience_years' => 0,
                    'application_url' => null,
                    'application_deadline' => '2026-11-10',
                    'is_active' => true,
                ],
                'requirements' => [
                    [
                        'requirement_type' => 'field_of_study',
                        'required_value' => 'Cyber Security',
                        'is_mandatory' => false,
                        'weight' => 30,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'Network Security',
                        'is_mandatory' => false,
                        'weight' => 30,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'Linux',
                        'is_mandatory' => false,
                        'weight' => 20,
                    ],
                    [
                        'requirement_type' => 'skill',
                        'required_value' => 'SIEM',
                        'is_mandatory' => false,
                        'weight' => 20,
                    ],
                ],
            ],
        ];

        foreach ($jobs as $data) {
            $job = JobOpportunity::create($data['job']);

            foreach ($data['requirements'] as $requirement) {
                $job->requirements()->create($requirement);
            }
        }
    }
}
