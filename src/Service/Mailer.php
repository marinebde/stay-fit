<?php 

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class Mailer {

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($email, $user, $token) 
    {

        $email = (new TemplatedEmail())
        ->from('mbcontactservice@gmail.com')
        ->to($email)
        ->subject('Votre compte StayFit')
        ->htmlTemplate('registration/mailcreationcompte.html.twig')
        ->context([
            'user' => $user,
            'token' => $token,
            ])
        ;

        $this->mailer->send($email);
    }

    public function sendPartenaire($email, $user) 
    {

        $email = (new TemplatedEmail())
        ->from('mbcontactservice@gmail.com')
        ->to($email)
        ->subject('Nouvelle structure')
        ->htmlTemplate('partenaire/mailnewstructure.html.twig')
        ->context([
            'user' => $user,
            ])
        ;

        $this->mailer->send($email);
    }




}

