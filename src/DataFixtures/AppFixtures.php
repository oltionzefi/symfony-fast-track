<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Comment;
use App\Entity\Conference;
use App\Entity\Admin;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager)
    {
        $rome = new Conference();
        $rome->setCity('Rome');
        $rome->setYear('2020');
        $rome->setIsInternational(true);
        $manager->persist($rome);

        $munich = new Conference();
        $munich->setCity('Munich');
        $munich->setYear('2020');
        $munich->setIsInternational(true);
        $manager->persist($munich);

        $barcelona = new Conference();
        $barcelona->setCity('Barcelona');
        $barcelona->setYear('2020');
        $barcelona->setIsInternational(false);
        $manager->persist($barcelona);

        $comment1 = new Comment();
        $comment1->setConference($barcelona);
        $comment1->setAuthor('Sandro');
        $comment1->setEmail('sandro.noon@gmail.com');
        $comment1->setText('Greetings!!!');
        $comment1->setState('published');
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setConference($barcelona);
        $comment2->setAuthor('Alex');
        $comment2->setEmail('salex.noon@gmail.com');
        $comment2->setText('Greetings!!!');
        $comment2->setState('published');
        $manager->persist($comment2);

        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword(
            $this->encoderFactory->getEncoder(Admin::class)->encodePassword('admin', null)
        );
        $manager->persist($admin);

        $manager->flush();
    }
}
