<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\CvVersion;
use App\Models\Scholarship;
use App\Services\CvTailorService;
use Illuminate\Http\Request;

class CvTailorController extends Controller
{
    public function tailor(Request $request, CvTailorService $service)
    {
        $data = $request->validate([
            'cv_id'          => 'required|integer|exists:cvs,cv_id',
            'scholarship_id' => 'required|integer|exists:scholarships,scholarship_id',
        ]);

        // الـ CV لازم يكون للمستخدم نفسه
        $cv = Cv::where('cv_id', $data['cv_id'])
            ->where('user_id', $request->user()->getKey())
            ->firstOrFail();

        $scholarship = Scholarship::where('scholarship_id', $data['scholarship_id'])->firstOrFail();

        return response()->json($service->tailor($cv, $scholarship));
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'cv_id'                     => 'required|integer|exists:cvs,cv_id',
            'scholarship_id'            => 'required|integer|exists:scholarships,scholarship_id',
            'accepted'                  => 'required|array|min:1',
            'accepted.skills'           => 'sometimes|array',
            'accepted.skills.*'         => 'string',
            'accepted.qualifications'   => 'sometimes|array',
            'accepted.qualifications.*' => 'string',
        ]);

        // الـ CV لازم يكون للمستخدم نفسه
        $cv = Cv::where('cv_id', $data['cv_id'])
            ->where('user_id', $request->user()->getKey())
            ->firstOrFail();

        $content = [
            'skills'         => $cv->extracted_skills ?? [],
            'qualifications' => $cv->extracted_qualifications ?? [],
            'education'      => $cv->extracted_education ?? [],
        ];
        $applied = [];

        foreach (['skills', 'qualifications'] as $section) {
            if (!isset($data['accepted'][$section])) {
                continue;
            }

            $value = array_values($data['accepted'][$section]);

            // المهارات: بس اللي موجود أصلاً بالـ CV
            if ($section === 'skills') {
                $orig = array_map('mb_strtolower', array_map('strval', $content['skills']));
                $value = array_values(array_filter(
                    $value,
                    fn ($x) => in_array(mb_strtolower($x), $orig, true)
                ));
            }

            if (empty($value)) {
                continue;
            }

            $content[$section] = $value;
            $applied[] = $section;
        }

        if (empty($applied)) {
            return response()->json(['message' => 'No valid sections to save'], 422);
        }

        // الـ CV الأصلي ما بينلمس أبداً
        $version = CvVersion::updateOrCreate(
            ['cv_id' => $cv->cv_id, 'scholarship_id' => $data['scholarship_id']],
            ['content' => $content, 'applied_sections' => $applied]
        );

        return response()->json($version, 201);
    }
    public function indexVersions(Request $request)
{
    $versions = CvVersion::query()
        ->whereHas('cv', function ($query) use ($request) {
            $query->where('user_id', $request->user()->getKey());
        })
        ->with([
            'cv:cv_id,original_filename',
            'scholarship:scholarship_id,title,provider_name',
        ])
        ->latest()
        ->get();

    return response()->json($versions);
}
}
