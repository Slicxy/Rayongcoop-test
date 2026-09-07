<?php

declare(strict_types=1);

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Services\TaxCertificateService;

class TaxCertificateController extends Controller
{
    /**
     * Public QR Code Verification endpoint for Tax Certificate (PDPA Protected)
     */
    public function verify(string $token): void
    {
        $cert = TaxCertificateService::verifyByToken($token);

        $this->render('public.verify_tax_cert', [
            'title' => 'ตรวจสอบความถูกต้องของหนังสือรับรองการชำระดอกเบี้ยเงินกู้เพื่อลดหย่อนภาษี',
            'cert' => $cert,
            'token' => $token,
            'isValid' => $cert !== null,
        ]);
    }
}
