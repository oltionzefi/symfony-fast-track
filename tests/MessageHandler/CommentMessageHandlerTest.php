<?php

namespace App\Tests\MessageHandler;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentMessageHandlerTest extends WebTestCase
{
    public function testMailerAssertion()
    {
        $client = static::createClient();
        $client->request('GET', '/en');

        $this->assertEmailCount(0);
        $event = $this->getMailerEvent(0);
        $this->assertEmailIsQueued($event);

        $email = $this->getMailerMessage(0);
        $this->assertEmailHeaderSame($email, 'To', 'admin@example.com');
        $this->assertEmailTextBodyContains($email, 'Bar');
        $this->assertEmailAttachmentCount($email, 1);
    }
}