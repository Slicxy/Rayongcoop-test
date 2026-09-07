<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Logger;
use Throwable;

class MailService
{
    /**
     * Send email notification (Fail-safe)
     */
    public static function send(string $to, string $subject, string $body, array $headers = []): bool
    {
        $fromEmail = config('app.coop.email', 'noreply@rayongcoop.com');
        $fromName = config('app.coop.name', 'สหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด');

        $defaultHeaders = [
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=UTF-8',
            'From' => sprintf('=?UTF-8?B?%s?= <%s>', base64_encode($fromName), $fromEmail),
            'Reply-To' => $fromEmail,
            'X-Mailer' => 'PHP/' . phpversion(),
        ];

        $mergedHeaders = array_merge($defaultHeaders, $headers);
        $headerString = '';
        foreach ($mergedHeaders as $k => $v) {
            $headerString .= "{$k}: {$v}\r\n";
        }

        try {
            // If in local/test without configured sendmail, log only
            if (config('app.env') === 'local' && !ini_get('sendmail_path')) {
                Logger::info("Local Mail Simulation to {$to}: {$subject}");
                return true;
            }

            $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $success = @mail($to, $encodedSubject, $body, $headerString);
            if (!$success) {
                Logger::warning("Mail delivery failed to: {$to}");
            }
            return $success;
        } catch (Throwable $e) {
            Logger::error("Mail sending error: " . $e->getMessage());
            return false;
        }
    }
}
