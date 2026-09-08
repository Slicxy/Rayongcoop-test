<?php

declare(strict_types=1);

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;

class SurveyController extends Controller
{
    /**
     * Show public survey by slug
     */
    public function show(string $slug): void
    {
        $survey = Database::first(
            "SELECT * FROM surveys WHERE (id = ? OR slug = ?) AND status = 'active' AND deleted_at IS NULL",
            [is_numeric($slug) ? (int)$slug : 0, $slug]
        );

        if (!$survey) {
            $this->response->setStatusCode(404);
            $this->render('public.404', ['title' => '404 - ไม่พบแบบสำรวจ'], 'layouts.public');
            return;
        }

        $questions = Database::query(
            "SELECT * FROM survey_questions WHERE survey_id = ? ORDER BY sort_order ASC",
            [$survey['id']]
        );

        foreach ($questions as &$q) {
            if (!empty($q['options_json']) && is_string($q['options_json'])) {
                $q['options'] = json_decode($q['options_json'], true) ?? [];
            } else {
                $q['options'] = [];
            }
        }

        $this->render('public.surveys.show', [
            'title' => $survey['title'],
            'survey' => $survey,
            'questions' => $questions,
        ]);
    }

    /**
     * Submit public survey response
     */
    public function submit(string $slug): void
    {
        $survey = Database::first("SELECT * FROM surveys WHERE slug = ? AND status = 'active' AND deleted_at IS NULL", [$slug]);
        if (!$survey) {
            $this->redirect(url('/'));
            return;
        }

        $surveyId = (int)$survey['id'];
        $questions = Database::query("SELECT * FROM survey_questions WHERE survey_id = ?", [$surveyId]);
        $answers = $this->request->input('answers') ?? [];

        // Validate required questions
        foreach ($questions as $q) {
            if (!empty($q['is_required'])) {
                $val = $answers[$q['id']] ?? null;
                if ($val === null || (is_string($val) && trim($val) === '')) {
                    Session::flash('error', 'กรุณาตอบคำถามที่จำเป็นให้ครบทุกข้อ (*)');
                    $this->redirect(url('surveys/' . $slug));
                    return;
                }
            }
        }

        $token = bin2hex(random_bytes(16));
        $ip = (string)$this->request->ip();
        $ua = substr((string)$this->request->userAgent(), 0, 250);

        $responseId = Database::insert(
            "INSERT INTO survey_responses (survey_id, member_id, session_token, ip_address, user_agent, submitted_at)
             VALUES (?, NULL, ?, ?, ?, NOW())",
            [$surveyId, $token, $ip, $ua]
        );

        foreach ($questions as $q) {
            $qid = (int)$q['id'];
            $ans = $answers[$qid] ?? null;

            $ratingVal = null;
            $ansText = null;
            $selectedJson = null;

            if ($q['question_type'] === 'rating_1_5') {
                $ratingVal = is_numeric($ans) ? (int)$ans : 5;
            } elseif ($q['question_type'] === 'multiple_choice' && is_array($ans)) {
                $selectedJson = json_encode($ans, JSON_UNESCAPED_UNICODE);
            } else {
                $ansText = is_string($ans) ? trim($ans) : (string)$ans;
            }

            Database::execute(
                "INSERT INTO survey_answers (response_id, question_id, rating_value, answer_text, selected_options_json)
                 VALUES (?, ?, ?, ?, ?)",
                [$responseId, $qid, $ratingVal, $ansText, $selectedJson]
            );
        }

        Session::flash('success', $survey['thank_you_message'] ?: 'บันทึกคำตอบของท่านเรียบร้อยแล้ว ขอขอบพระคุณเป็นอย่างยิ่ง');
        $this->redirect(url('/'));
    }
}
