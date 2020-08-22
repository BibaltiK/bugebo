<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index(Request $request): Response
    {
        $response = new Response();

        $response->setContent("<p>Hallo Welt!</p>");
        return $response;
    }
}