<?php

use PHPUnit\Framework\TestCase;

class NotificationServiceTest extends TestCase
{
    public function testNotifySendsEmailToRecipientOnce(): void
    {
        // Arrange – mock Mailer létrehozása, nincs valódi e-mail küldés
        $mailerMock = $this->createMock(Mailer::class);

        // A send() metódus pontosan egyszer kell, hogy meghívódjon
        // a várt paraméterekkel
        $mailerMock->expects($this->once())
                   ->method('send')
                   ->with(
                       $this->equalTo('felhasznalo@example.com'),
                       $this->equalTo('Köszöntjük!')
                   );

        $service = new NotificationService($mailerMock);

        // Act
        $service->notify('felhasznalo@example.com', 'Köszöntjük!');

        // Assert – a mock objektum automatikusan ellenőrzi a hívások számát
        // és paramétereit; ha nem stimmel, a teszt elbukik
    }

    public function testNotifyCallsSendWithCorrectArguments(): void
    {
        // Arrange
        $to      = 'admin@example.com';
        $message = 'Rendszerriasztás!';

        $mailerMock = $this->createMock(Mailer::class);
        $mailerMock->expects($this->once())
                   ->method('send')
                   ->with($to, $message);

        $service = new NotificationService($mailerMock);

        // Act
        $service->notify($to, $message);
    }

    public function testNotifyDoesNotCallSendWithoutBeingInvoked(): void
    {
        // Arrange – a send() nem hívódhat meg, ha notify() sem fut
        $mailerMock = $this->createMock(Mailer::class);
        $mailerMock->expects($this->never())
                   ->method('send');

        // Assert – pusztán azzal, hogy notify()-t nem hívjuk, a teszt teljesül
        $this->assertInstanceOf(NotificationService::class,
            new NotificationService($mailerMock)
        );
    }
}
