<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return new Response(<<<EOF
<html>
    <body>
        $greet
        <img src="/images/under-construction.gif" />
    </body>
<html>
EOF
        );
    }

    /**
     * @Route("/hello/{name}", name="hello")
     */
    public function hello(string $name = '')
    {
        $greet = '';
        if ($name) {
            $greet = sprintf('<h1>Hello %s!</h1>', htmlspecialchars($name));
        }

        return new Response(<<<EOF
<html>
    <body>
        $greet
        <img src="/images/under-construction.gif" />
    </body>
<html>
EOF
        ); 
    }
}
