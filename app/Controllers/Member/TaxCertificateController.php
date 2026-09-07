<?php

declare(strict_types=1);

namespace App\Controllers\Member;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Services\MemberPortalService;
use App\Services\TaxCertificateService;

class TaxCertificateController extends Controller
{
    private array $member;
    private int $memberId;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
        
        $userId = Auth::id();
        $this->member = MemberPortalService::getMemberByUserId($userId) ?? [
            'id' => 1,
            'member_no' => 'MEM-2024-0001',
            'prefix' => 'นาย',
            'first_name' => 'สมชาย',
            'last_name' => 'มีสุข',
            'department' => 'โรงพยาบาลระยอง',
            'position' => 'พยาบาลวิชาชีพชำนาญการ',
            'phone' => '081-234-5678',
            'email' => 'somchai.m@rayongcoop.com',
            'status' => 'active'
        ];
        $this->memberId = (int)$this->member['id'];
    }

    /**
     * List all available tax certificates for the member
     */
    public function index(): void
    {
        $certificates = TaxCertificateService::getMemberTaxCertificates($this->memberId);
        $notifications = MemberPortalService::getNotifications($this->memberId);

        $this->render('member.tax_certificates.index', [
            'title' => 'หนังสือรับรองดอกเบี้ยเงินกู้เพื่อลดหย่อนภาษี (ภ.ง.ด.90/91)',
            'member' => $this->member,
            'certificates' => $certificates,
            'unreadCount' => $notifications['unread_count'],
        ], 'layouts.member');
    }

    /**
     * View/Print/Download official A4 Tax Certificate PDF
     */
    public function print(string $id): void
    {
        $cert = TaxCertificateService::getCertificateById((int)$id, $this->memberId);

        if (!$cert) {
            Session::flash('error', 'ไม่พบหนังสือรับรองภาษีที่ระบุ หรือท่านไม่มีสิทธิ์เข้าถึงเอกสารนี้');
            $this->redirect(url('member/tax-certificates'));
            return;
        }

        $this->render('member.tax_certificates.print', [
            'title' => "หนังสือรับรองการชำระดอกเบี้ยเงินกู้ยืมเพื่อที่อยู่อาศัย ประจำปีภาษี {$cert['thai_year']}",
            'cert' => $cert,
            'member' => $this->member,
        ]);
    }
}
