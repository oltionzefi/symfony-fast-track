<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Panther\PantherTestCase;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;

class ConferenceControllerTest extends PantherTestCase
{
    public function testHomepage()
    {
        $client = static::createClient();
        $client->request('GET', '/en');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Give your feedback');
    }

    public function testConferencePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en');

        $this->assertCount(3, $crawler->filter('h4'));

        $client->click($crawler->filter('h4 + p a')->link());
        $this->assertPageTitleContains('Barcelona');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Barcelona 2020');
        $this->assertSelectorExists('div:contains("There are 2 comments")');
    }

    public function testCommentSubmission()
    {
        $client = static::createClient();
        $client->request('GET', '/en/conference/barcelona-2020');
        $client->submitForm('Submit', [
            'comment_form[author]' => 'Yehran',
            'comment_form[text]' => 'Some feedback from an automated functional test',
            'comment_form[email]' => $email = 'sandro@gmail.com',
            'comment_form[photo]' => dirname(__DIR__, 2).'/public/images/underconstruction.gif',
        ]);

        $this->assertResponseRedirects();
        $comment = self::$container->get(CommentRepository::class)->findOneByEmail($email);
        $comment->setState('published');
        self::$container->get(EntityManagerInterface::class)->flush();

        $client->followRedirect();
        $this->assertSelectorExists('div:contains("There are 3 comments")');
    }
}
