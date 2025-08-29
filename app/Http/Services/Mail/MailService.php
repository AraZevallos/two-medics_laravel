<?php

namespace App\Http\Services\Mail;

use Illuminate\Mail\Mailable;
use Mailgun\Mailgun;

class MailService
{
    protected string $to;

    public static function to(string $email): self
    {
        $instance = new self;
        $instance->to = $email;

        return $instance;
    }

    public function send(Mailable $mailable): void
    {
        $mg = Mailgun::create(config('services.mailgun.secret'), config('services.mailgun.endpoint'));
        $mg->messages()->send(
            config('services.mailgun.domain'),
            [
                'from' => $mailable->envelope()->from,
                'to' => $this->to,
                'subject' => $mailable->envelope()->subject,
                'html' => $mailable->render(),
            ]
        );
    }
}
