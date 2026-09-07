<?php

declare(strict_types=1);

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Database;

class LoanChecklistController extends Controller
{
    public function index(): void
    {
        $selectedSlug = $this->request->query('type');

        $loans = Database::query(
            "SELECT * FROM loan_products 
             WHERE status = 'active' AND deleted_at IS NULL 
             ORDER BY sort_order ASC, id ASC"
        );

        $currentLoan = null;
        if (!empty($selectedSlug)) {
            foreach ($loans as $l) {
                if ($l['slug'] === $selectedSlug || (string)$l['id'] === $selectedSlug) {
                    $currentLoan = $l;
                    break;
                }
            }
        }

        if (!$currentLoan && !empty($loans)) {
            $currentLoan = $loans[0];
        }

        $this->render('public.loan_checklist', [
            'title' => 'เช็กความพร้อมก่อนยื่นกู้เงิน — สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด',
            'loans' => $loans,
            'currentLoan' => $currentLoan,
        ]);
    }
}
