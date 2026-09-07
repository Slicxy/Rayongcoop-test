<?php

declare(strict_types=1);

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Database;

class HomeController extends Controller
{
    public function index(): void
    {
        // 1. Hero Slides
        $heroSlides = Database::query("SELECT * FROM hero_slides WHERE status = 'active' AND (start_at IS NULL OR start_at <= NOW()) AND (end_at IS NULL OR end_at >= NOW()) ORDER BY priority DESC, sort_order ASC");

        // 2. Deposit Rates & Loan Rates
        $depositRates = Database::query("SELECT * FROM interest_rates WHERE product_type = 'deposit' AND status = 'active' ORDER BY sort_order ASC LIMIT 4");
        $loanRates = Database::query("SELECT * FROM interest_rates WHERE product_type = 'loan' AND status = 'active' ORDER BY sort_order ASC LIMIT 4");

        // 3. Featured News & Announcements
        $latestNews = Database::query("SELECT n.*, c.name as category_name FROM news n JOIN news_categories c ON n.category_id = c.id WHERE n.workflow_status = 'published' AND (n.publish_at IS NULL OR n.publish_at <= NOW()) ORDER BY n.is_pinned DESC, n.publish_at DESC LIMIT 6");

        // 4. Featured Deposit & Loan Products
        $featuredDeposits = Database::query("SELECT * FROM deposit_products WHERE is_featured = 1 AND status = 'active' ORDER BY sort_order ASC LIMIT 3");
        $featuredLoans = Database::query("SELECT * FROM loan_products WHERE is_featured = 1 AND status = 'active' ORDER BY sort_order ASC LIMIT 3");

        // 5. Executive Statistics (Latest)
        $latestStats = Database::first("SELECT * FROM financial_statistics ORDER BY year DESC, month DESC LIMIT 1");

        // 6. E-Service Quick Links
        $eservices = Database::query("SELECT * FROM eservice_links WHERE status = 'active' ORDER BY sort_order ASC LIMIT 6");

        // 7. Important Announcements (Latest Published & Active)
        $importantAnnouncements = [];
        try {
            $importantAnnouncements = Database::query("SELECT * FROM important_announcements WHERE status = 'published' AND publication_date <= CURDATE() AND (expiry_date IS NULL OR expiry_date >= CURDATE()) ORDER BY is_pinned DESC, priority DESC, publication_date DESC LIMIT 3");
        } catch (\Throwable $e) {
            // ignore if table doesn't exist
        }

        // 8. Upcoming Events
        $upcomingEvents = [];
        try {
            $upcomingEvents = Database::query("SELECT * FROM events WHERE status = 'upcoming' AND deleted_at IS NULL AND start_date >= CURDATE() ORDER BY start_date ASC, start_time ASC LIMIT 4");
        } catch (\Throwable $e) {
            // ignore
        }

        $this->render('public.home', [
            'title' => 'หน้าแรก',
            'heroSlides' => $heroSlides,
            'depositRates' => $depositRates,
            'loanRates' => $loanRates,
            'latestNews' => $latestNews,
            'featuredDeposits' => $featuredDeposits,
            'featuredLoans' => $featuredLoans,
            'latestStats' => $latestStats,
            'eservices' => $eservices,
            'importantAnnouncements' => $importantAnnouncements,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}

