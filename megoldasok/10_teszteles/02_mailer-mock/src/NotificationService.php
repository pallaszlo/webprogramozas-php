<?php

class NotificationService
{
    /**
     * A Mailer függőséget konstruktoron keresztül kapja meg (Dependency Injection).
     * Ez teszi lehetővé a mock-alapú tesztelést.
     */
    public function __construct(private Mailer $mailer) {}

    public function notify(string $recipient, string $text): void
    {
        $this->mailer->send($recipient, $text);
    }
}
