<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScholarshipCriterionController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\RecommendationCriteriaMatchController;
use App\Http\Controllers\CoverLetterController;
use App\Http\Controllers\SavedApplicationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminActionLogController;

/*
|--------------------------------------------------------------------------
| Public routes (no auth required)
|--------------------------------------------------------------------------
*/
Route::get('/scholarships', [ScholarshipController::class, 'index']);
Route::get('/scholarships/{scholarship}', [ScholarshipController::class, 'show']);
Route::get('/scholarships/{scholarship}/criteria', [ScholarshipCriterionController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Authenticated routes (any logged-in user — student or admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Student Profile
    Route::get('/student-profile', [StudentProfileController::class, 'show']);
    Route::post('/student-profile', [StudentProfileController::class, 'store']);
    Route::put('/student-profile', [StudentProfileController::class, 'update']);
    Route::delete('/student-profile', [StudentProfileController::class, 'destroy']);
    Route::get('/profile', [StudentProfileController::class, 'show']);
    Route::post('/profile', [StudentProfileController::class, 'store']);
    Route::put('/profile', [StudentProfileController::class, 'update']);
    Route::delete('/profile', [StudentProfileController::class, 'destroy']);
    // CVs
    Route::get('/cvs', [CvController::class, 'index']);
    Route::get('/cvs/{cv}', [CvController::class, 'show']);
    Route::post('/cvs', [CvController::class, 'store']);
    Route::get('/cvs/{cv}/download', [CvController::class, 'download']);
    Route::patch('/cvs/{cv}/set-active', [CvController::class, 'setActive']);
    Route::delete('/cvs/{cv}', [CvController::class, 'destroy']);
    Route::post('/cvs/{cv}/extract', [CvController::class, 'extract']);
    Route::put('/cvs/{cv}/confirm', [CvController::class, 'confirm']);
    // Recommendations
    Route::get('/recommendations', [RecommendationController::class, 'index']);
    Route::get('/recommendations/{recommendation}', [RecommendationController::class, 'show']);
    Route::post('/recommendations/generate', [RecommendationController::class, 'generate']);
    Route::delete('/recommendations/{recommendation}', [RecommendationController::class, 'destroy']);
    Route::get('/recommendations/{recommendation}/criteria-matches', [RecommendationCriteriaMatchController::class, 'index']);

    // Cover Letters
    Route::get('/cover-letters', [CoverLetterController::class, 'index']);
    Route::get('/cover-letters/{coverLetter}', [CoverLetterController::class, 'show']);
    Route::post('/cover-letters', [CoverLetterController::class, 'store']);
    Route::delete('/cover-letters/{coverLetter}', [CoverLetterController::class, 'destroy']);

    // Saved Applications
    Route::get('/saved-applications', [SavedApplicationController::class, 'index']);
    Route::post('/saved-applications', [SavedApplicationController::class, 'store']);
    Route::patch('/saved-applications/{savedApplication}/status', [SavedApplicationController::class, 'updateStatus']);
    Route::delete('/saved-applications/{savedApplication}', [SavedApplicationController::class, 'destroy']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/{notification}', [NotificationController::class, 'show']);
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Admin-only routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    // Scholarships (write actions)
    Route::post('/scholarships', [ScholarshipController::class, 'store']);
    Route::put('/scholarships/{scholarship}', [ScholarshipController::class, 'update']);
    Route::delete('/scholarships/{scholarship}', [ScholarshipController::class, 'destroy']);

    // Scholarship Criteria (write actions)
    Route::post('/scholarships/{scholarship}/criteria', [ScholarshipCriterionController::class, 'store']);
    Route::put('/scholarships/{scholarship}/criteria/{criterion}', [ScholarshipCriterionController::class, 'update']);
    Route::delete('/scholarships/{scholarship}/criteria/{criterion}', [ScholarshipCriterionController::class, 'destroy']);

    // Admin Action Logs (read-only, audit trail)
    Route::get('/admin/action-logs', [AdminActionLogController::class, 'index']);
    Route::get('/admin/action-logs/{adminActionLog}', [AdminActionLogController::class, 'show']);
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

