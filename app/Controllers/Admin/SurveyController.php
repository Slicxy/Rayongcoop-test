<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Services\AuditService;

class SurveyController extends Controller
{
    /**
     * List all surveys with response counts and status
     */
    public function index(): void
    {
        $surveys = Database::query(
            "SELECT s.*, 
                    (SELECT COUNT(*) FROM survey_responses r WHERE r.survey_id = s.id) as response_count,
                    (SELECT COUNT(*) FROM survey_questions q WHERE q.survey_id = s.id) as question_count
             FROM surveys s
             WHERE s.deleted_at IS NULL
             ORDER BY s.created_at DESC"
        );

        $this->render('admin.surveys.index', [
            'title' => 'ระบบสำรวจความพึงพอใจและโพลล์สมาชิก (Surveys & Polls)',
            'surveys' => $surveys,
        ], 'layouts.admin');
    }

    /**
     * Show create survey form
     */
    public function create(): void
    {
        $this->render('admin.surveys.create', [
            'title' => 'สร้างแบบสำรวจใหม่',
        ], 'layouts.admin');
    }

    /**
     * Store new survey and questions
     */
    public function store(): void
    {
        $title = trim((string)$this->request->input('title'));
        $description = trim((string)$this->request->input('description'));
        $category = trim((string)$this->request->input('category')) ?: 'satisfaction';
        $targetAudience = $this->request->input('target_audience') ?: 'all';
        $startDate = $this->request->input('start_date') ?: date('Y-m-d');
        $endDate = $this->request->input('end_date') ?: null;
        $isAnonymous = $this->request->input('is_anonymous') ? 1 : 0;
        $status = $this->request->input('status') ?: 'active';
        $thankYouMessage = trim((string)$this->request->input('thank_you_message')) ?: 'ขอขอบพระคุณท่านสมาชิกที่ร่วมแสดงความคิดเห็น';

        if (empty($title)) {
            Session::flash('error', 'กรุณาระบุชื่อหัวข้อแบบสำรวจ');
            $this->redirect(url('admin/surveys/create'));
            return;
        }

        $slug = 'survey-' . date('Ymd') . '-' . rand(100, 999);

        $surveyId = Database::insert(
            "INSERT INTO surveys (
                title, slug, description, category, target_audience,
                status, start_date, end_date, is_anonymous, thank_you_message,
                created_by, created_at
             ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())",
            [
                $title, $slug, $description, $category, $targetAudience,
                $status, $startDate, $endDate, $isAnonymous, $thankYouMessage,
                Auth::id()
            ]
        );

        // Process questions
        $questions = $this->request->input('questions') ?? [];
        if (is_array($questions)) {
            $order = 1;
            foreach ($questions as $q) {
                $qText = trim((string)($q['text'] ?? ''));
                if (!empty($qText)) {
                    $qType = $q['type'] ?? 'rating_1_5';
                    $qOptions = !empty($q['options']) ? json_encode(array_map('trim', explode("\n", (string)$q['options'])), JSON_UNESCAPED_UNICODE) : null;
                    $qRequired = !empty($q['is_required']) ? 1 : 0;

                    Database::execute(
                        "INSERT INTO survey_questions (survey_id, question_text, question_type, options_json, is_required, sort_order, created_at)
                         VALUES (?, ?, ?, ?, ?, ?, NOW())",
                        [$surveyId, $qText, $qType, $qOptions, $qRequired, $order++]
                    );
                }
            }
        }

        AuditService::log('survey', 'create', (string)$surveyId, null, ['title' => $title]);
        Session::flash('success', 'สร้างแบบสำรวจเรียบร้อยแล้ว');
        $this->redirect(url('admin/surveys'));
    }

    /**
     * Real-time Analytics & Results Dashboard for a Survey
     */
    public function results(string $id): void
    {
        $survey = Database::first("SELECT * FROM surveys WHERE id = ? AND deleted_at IS NULL", [(int)$id]);
        if (!$survey) {
            Session::flash('error', 'ไม่พบแบบสำรวจที่ระบุ');
            $this->redirect(url('admin/surveys'));
            return;
        }

        $questions = Database::query(
            "SELECT * FROM survey_questions WHERE survey_id = ? ORDER BY sort_order ASC",
            [(int)$id]
        );

        $totalResponses = (int)(Database::first(
            "SELECT COUNT(*) as cnt FROM survey_responses WHERE survey_id = ?",
            [(int)$id]
        )['cnt'] ?? 0);

        // Calculate statistics for each question
        $questionStats = [];
        $overallScoreSum = 0.0;
        $overallRatingCount = 0;

        foreach ($questions as $q) {
            $qid = (int)$q['id'];
            $stat = [
                'question' => $q,
                'avg_score' => 0.0,
                'distribution' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
                'text_answers' => [],
                'option_counts' => []
            ];

            if ($q['question_type'] === 'rating_1_5') {
                $ratings = Database::query(
                    "SELECT rating_value, COUNT(*) as cnt FROM survey_answers WHERE question_id = ? AND rating_value IS NOT NULL GROUP BY rating_value",
                    [$qid]
                );
                $sum = 0;
                $count = 0;
                foreach ($ratings as $r) {
                    $val = (int)$r['rating_value'];
                    $c = (int)$r['cnt'];
                    $stat['distribution'][$val] = $c;
                    $sum += ($val * $c);
                    $count += $c;
                }
                if ($count > 0) {
                    $stat['avg_score'] = round($sum / $count, 2);
                    $overallScoreSum += $stat['avg_score'];
                    $overallRatingCount++;
                }
            } elseif ($q['question_type'] === 'text') {
                $stat['text_answers'] = Database::query(
                    "SELECT a.answer_text, r.submitted_at 
                     FROM survey_answers a 
                     JOIN survey_responses r ON a.response_id = r.id 
                     WHERE a.question_id = ? AND a.answer_text IS NOT NULL AND a.answer_text != ''
                     ORDER BY r.submitted_at DESC LIMIT 50",
                    [$qid]
                );
            } else {
                // Choice questions
                $choiceAnswers = Database::query(
                    "SELECT answer_text, selected_options_json, COUNT(*) as cnt FROM survey_answers WHERE question_id = ? GROUP BY answer_text, selected_options_json",
                    [$qid]
                );
                foreach ($choiceAnswers as $ca) {
                    $text = $ca['answer_text'] ?: ($ca['selected_options_json'] ?? 'อื่น ๆ');
                    $stat['option_counts'][$text] = (int)$ca['cnt'];
                }
            }

            $questionStats[] = $stat;
        }

        $csatScore = $overallRatingCount > 0 ? round(($overallScoreSum / $overallRatingCount) * 20, 1) : 0.0; // CSAT percentage
        $averageRating = $overallRatingCount > 0 ? round($overallScoreSum / $overallRatingCount, 2) : 0.0;

        $this->render('admin.surveys.results', [
            'title' => "ผลการสำรวจ: {$survey['title']}",
            'survey' => $survey,
            'totalResponses' => $totalResponses,
            'csatScore' => $csatScore,
            'averageRating' => $averageRating,
            'questionStats' => $questionStats,
        ], 'layouts.admin');
    }

    /**
     * Delete survey (Soft delete)
     */
    public function destroy(string $id): void
    {
        Database::execute("UPDATE surveys SET deleted_at = NOW() WHERE id = ?", [(int)$id]);
        AuditService::log('survey', 'delete', $id);
        Session::flash('success', 'ลบแบบสำรวจเรียบร้อยแล้ว');
        $this->redirect(url('admin/surveys'));
    }
}
