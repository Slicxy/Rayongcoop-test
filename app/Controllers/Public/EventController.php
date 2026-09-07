<?php

declare(strict_types=1);

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Database;

class EventController extends Controller
{
    public function index(): void
    {
        $category = $this->request->query('cat');
        $month = $this->request->query('month');
        $year = $this->request->query('year');

        $where = ["status != 'cancelled'", "deleted_at IS NULL"];
        $params = [];

        if (!empty($category) && in_array($category, ['meeting', 'loan_window', 'dividend', 'holiday', 'activity', 'other'], true)) {
            $where[] = "category = ?";
            $params[] = $category;
        }

        if (!empty($month)) {
            $where[] = "MONTH(start_date) = ?";
            $params[] = (int)$month;
        }

        if (!empty($year)) {
            // Support Thai Buddhist year (e.g. 2569 -> 2026)
            $adYear = ((int)$year > 2400) ? ((int)$year - 543) : (int)$year;
            $where[] = "YEAR(start_date) = ?";
            $params[] = $adYear;
        }

        $whereSql = implode(" AND ", $where);
        $sql = "SELECT * FROM events 
                WHERE {$whereSql} 
                ORDER BY start_date ASC, start_time ASC";

        $events = Database::query($sql, $params);

        // Upcoming featured events
        $upcoming = Database::query(
            "SELECT * FROM events 
             WHERE status = 'upcoming' AND deleted_at IS NULL AND start_date >= CURDATE() 
             ORDER BY start_date ASC LIMIT 5"
        );

        $this->render('public.events.index', [
            'title' => 'ปฏิทินกิจกรรมและกำหนดการสหกรณ์',
            'events' => $events,
            'upcoming' => $upcoming,
            'selectedCategory' => $category,
            'selectedMonth' => $month,
            'selectedYear' => $year,
        ]);
    }
}
