<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

class AuthMiddleware
{
    public function handle(Request $request, Response $response): bool
    {
        if (!Auth::check()) {
            if (Auth::checkPending2FA()) {
                $response->redirect(url('admin/2fa'));
                return false;
            }

            if ($request->isAjax()) {
                $response->json([
                    'success' => false,
                    'code' => 'UNAUTHORIZED',
                    'message' => 'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่'
                ], 401);
                return false;
            }

            Session::flash('error', 'กรุณาเข้าสู่ระบบก่อนเข้าใช้งาน');
            $response->redirect(url('login'));
            return false;
        }

        return true;
    }
}
