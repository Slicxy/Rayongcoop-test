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

    /**
     * Public View/Print e-Receipt by receipt_no or verification token
     */
    public function viewReceipt(string $no): void
    {
        $receipt = ReceiptService::getReceiptDetails($no);
        if (!$receipt) {
            // Try lookup by token if token was passed
            $receipt = ReceiptService::verifyByToken($no);
        }

        if (!$receipt) {
            $this->response->setStatusCode(404);
            $this->render('public.404', ['title' => '404 - ไม่พบใบเสร็จรับเงิน'], 'layouts.public');
            return;
        }

        $this->render('member.receipt_print', [
            'receipt' => $receipt,
            'title' => "ใบเสร็จรับเงิน {$receipt['receipt_no']}"
        ]);
    }
}
