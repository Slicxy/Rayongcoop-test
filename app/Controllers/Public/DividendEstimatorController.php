<?php

declare(strict_types=1);

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Database;

class DividendEstimatorController extends Controller
{
    public function index(): void
    {
        $latestStats = Database::first("SELECT * FROM financial_statistics ORDER BY year DESC, month DESC LIMIT 1");
        $defaultDividendRate = $latestStats ? (float)$latestStats['dividend_rate'] : 5.10;
        $defaultRefundRate = 12.50;

        $this->render('public.dividend_estimator', [
            'title' => 'โปรแกรมคำนวณและประมาณการเงินปันผล-เฉลี่ยคืน',
            'defaultDividendRate' => $defaultDividendRate,
            'defaultRefundRate' => $defaultRefundRate,
            'latestStats' => $latestStats,
        ]);
    }
}
