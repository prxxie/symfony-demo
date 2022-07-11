<?php

namespace App\MessageHandler;

use App\Message\MailNotification;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class MailNotificationHandler
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(MailNotification $message)
    {
        try {
            $email = (new TemplatedEmail())
                ->from('hello@example.com')
                ->to('you@example.com')
                ->subject('You have new post!')
                // ->text($message->getContent())
                ->htmlTemplate('emails/new-article.html.twig')
                ->context(['article' => $message->getContent()]);

            $this->mailer->send($email);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
