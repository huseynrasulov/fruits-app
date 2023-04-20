<?php 

namespace App\Mailer;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class FruitsSavedEmail
{
    private $mailer;
    private $adminEmail;

    public function __construct(MailerInterface $mailer, string $adminEmail)
    {
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
    }

    public function send()
    {
        $email = (new Email())
            ->from('noreply@example.com')
            ->to($this->adminEmail)
            ->subject('All fruits have been saved')
            ->text('All fruits have been saved to the database.');

        $this->mailer->send($email);
    }
}