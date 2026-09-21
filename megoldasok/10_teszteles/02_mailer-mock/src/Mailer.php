<?php

class Mailer
{
    /**
     * E-mail küldése a megadott címre.
     * Valódi alkalmazásban itt történne a tényleges küldés (pl. SMTP).
     */
    public function send(string $to, string $message): void
    {
        mail($to, 'Értesítés', $message);
    }
}
