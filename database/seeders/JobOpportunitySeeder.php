<?php

namespace Database\Seeders;

use App\Models\JobOpportunity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobOpportunitySeeder extends Seeder
{
    public function run(): void
    {
        /*
         * Demo opportunities for Jisr AI.
         * These are sample jobs, not live vacancies.
         *
         * Only title and description are translated.
         * Matching requirements remain
         *  unchanged.
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

                'translations' => [
                    'en' => [
                        'title' => 'Junior Cyber Security Analyst',
                        'description' => 'Entry-level cyber security role focused on monitoring, identifying security risks, and supporting incident response activities.',
                    ],
                    'ar' => [
                        'title' => 'محلل أمن سيبراني مبتدئ',
                        'description' => 'وظيفة للمبتدئين في مجال الأمن السيبراني، تركز على المراقبة واكتشاف المخاطر الأمنية والمساعدة في الاستجابة للحوادث الأمنية.',
                    ],
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

                'translations' => [
                    'en' => [
                        'title' => 'Network Security Assistant',
                        'description' => 'Junior role supporting network monitoring, security configuration, troubleshooting, and infrastructure protection.',
                    ],
                    'ar' => [
                        'title' => 'مساعد أمن شبكات',
                        'description' => 'وظيفة للمبتدئين للمساعدة في مراقبة الشبكات وإعدادات الأمان واستكشاف المشكلات التقنية وحلها وحماية البنية التحتية.',
                    ],
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

                'translations' => [
                    'en' => [
                        'title' => 'Junior Backend Developer',
                        'description' => 'Entry-level backend development role working with APIs, databases, server-side applications, and software development practices.',
                    ],
                    'ar' => [
                        'title' => 'مطور Backend مبتدئ',
                        'description' => 'وظيفة للمبتدئين في تطوير الأنظمة الخلفية، تشمل العمل على واجهات API وقواعد البيانات وتطبيقات الخوادم وممارسات تطوير البرمجيات.',
                    ],
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

                'translations' => [
                    'en' => [
                        'title' => 'IT Support Assistant',
                        'description' => 'Entry-level IT support role involving user support, network troubleshooting, system configuration, and technical issue resolution.',
                    ],
                    'ar' => [
                        'title' => 'مساعد دعم فني لتكنولوجيا المعلومات',
                        'description' => 'وظيفة للمبتدئين في الدعم الفني، تشمل مساعدة المستخدمين وحل مشكلات الشبكات وإعداد الأنظمة ومعالجة الأعطال التقنية.',
                    ],
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

                'translations' => [
                    'en' => [
                        'title' => 'SOC Analyst Intern',
                        'description' => 'Cyber security internship focused on security monitoring, network analysis, vulnerability awareness, and incident investigation.',
                    ],
                    'ar' => [
                        'title' => 'متدرب محلل مركز العمليات الأمنية SOC',
                        'description' => 'تدريب في الأمن السيبراني يركز على المراقبة الأمنية وتحليل الشبكات وفهم الثغرات الأمنية والتحقيق في الحوادث.',
                    ],
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

        DB::transaction(function () use ($jobs) {
            foreach ($jobs as $data) {
                /*
                 * Identify existing demo jobs by their
                 * canonical title and company name.
                 *
                 * Do not overwrite existing job data
                 * or change existing job IDs.
                 */
                $job = JobOpportunity::firstOrCreate(
                    [
                        'title' => $data['job']['title'],
                        'company_name' => $data['job']['company_name'],
                    ],
                    $data['job']
                );

                /*
                 * Insert or update translations.
                 * One translation per job and locale.
                 */
                foreach ($data['translations'] as $locale => $translation) {
                    $job->translations()->updateOrCreate(
                        [
                            'locale' => $locale,
                        ],
                        $translation
                    );
                }

                /*
                 * Preserve existing matching requirements.
                 * Do not duplicate requirements when
                 * the seeder runs again.
                 */
                foreach ($data['requirements'] as $requirement) {
                    $job->requirements()->firstOrCreate(
                        [
                            'requirement_type' => $requirement['requirement_type'],
                            'required_value' => $requirement['required_value'],
                        ],
                        [
                            'is_mandatory' => $requirement['is_mandatory'],
                            'weight' => $requirement['weight'],
                        ]
                    );
                }
            }
        });
    }
}
