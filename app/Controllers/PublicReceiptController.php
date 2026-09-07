<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\ReceiptService;

class PublicReceiptController extends Controller
{
    /**
     * Public QR Code Verification endpoint
     */
    public function verify(string $token): void
    {
        $receipt = ReceiptService::verifyByToken($token);

        $this->render('public.verify_receipt', [
            'title' => 'ตรวจสอบความถูกต้องของใบเสร็จรับเงินอิเล็กทรอนิกส์ (e-Receipt Verification)',
            'receipt' => $receipt,
            'token' => $token,
            'isValid' => $receipt !== null,
        ]);
    }
}
