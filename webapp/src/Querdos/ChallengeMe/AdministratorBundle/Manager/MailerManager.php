<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 4/6/17
 * Time: 11:44 AM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Symfony\Component\DependencyInjection\Container;

class MailerManager
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * Send a mail to a newly registered player
     *
     * @param string $to
     * @param string $body
     * @param string $subject
     */
    public function sendMail($to, $body, $subject)
    {
        // creating the message
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom("hamza.essayegh@gmail.com")
            ->setTo($to)
            ->setBody($body, 'text/html')
        ;

        // sending the mail
        $this->mailer->send($message);
    }

    /**
     * @param \Swift_Mailer $mailer
     *
     * @return MailerManager
     */
    public function setMailer($mailer)
    {
        $this->mailer = $mailer;
        return $this;
    }

    /**
     * @param \Twig_Environment $twig
     *
     * @return MailerManager
     */
    public function setTwig($twig)
    {
        $this->twig = $twig;
        return $this;
    }
}