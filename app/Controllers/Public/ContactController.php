<?php

declare(strict_types=1);

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Services\MailService;

class ContactController extends Controller
{
    public function index(): void
    {
        $this->render('public.contact', [
            'title' => 'ติดต่อสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด',
        ]);
    }

    public function submit(): void
    {
        $data = $this->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $ip = $this->request->ip();
        $userAgent = mb_substr($this->request->header('User-Agent') ?? '', 0, 255);

        $sql = "INSERT INTO contact_messages (name, phone, email, subject, message, status, ip_address, user_agent, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, 'new', ?, ?, NOW(), NOW())";

        $messageId = Database::insert($sql, [
            $data['name'],
            $data['phone'],
            $data['email'],
            $data['subject'],
            $data['message'],
            $ip,
            $userAgent
        ]);

        // Send fail-safe notification email to staff
        $staffEmail = config('app.coop.email', 'contact@rayongcoop.com');
        $emailBody = "<h3>มีการส่งข้อความติดต่อใหม่ผ่านเว็บไซต์</h3>"
            . "<p><b>ผู้ติดต่อ:</b> " . htmlspecialchars($data['name']) . "</p>"
            . "<p><b>เบอร์โทรศัพท์:</b> " . htmlspecialchars($data['phone']) . "</p>"
            . "<p><b>อีเมล:</b> " . htmlspecialchars($data['email']) . "</p>"
            . "<p><b>หัวข้อ:</b> " . htmlspecialchars($data['subject']) . "</p>"
            . "<p><b>ข้อความ:</b><br>" . nl2br(htmlspecialchars($data['message'])) . "</p>"
            . "<hr><p><small>ระบบบริหารจัดการเว็บไซต์ สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด</small></p>";

        MailService::send($staffEmail, "ข้อความติดต่อใหม่: {$data['subject']}", $emailBody);

        if ($this->request->isAjax()) {
            $this->json([
                'success' => true,
                'message' => 'ส่งข้อความติดต่อเรียบร้อยแล้ว เจ้าหน้าที่จะดำเนินการและติดต่อกลับโดยเร็วที่สุด ขอบคุณครับ',
            ]);
        } else {
            Session::flash('success', 'ส่งข้อความติดต่อเรียบร้อยแล้ว เจ้าหน้าที่จะดำเนินการและติดต่อกลับโดยเร็วที่สุด ขอบคุณครับ');
            $this->redirect(url('contact'));
        }
    }

    public function faqs(): void
    {
        $faqs = Database::query("SELECT * FROM faqs WHERE status = 'active' ORDER BY sort_order ASC");

        $this->render('public.faqs', [
            'title' => 'คำถามที่พบบ่อย (Frequently Asked Questions)',
            'faqs' => $faqs,
        ]);
    }
}
