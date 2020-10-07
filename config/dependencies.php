<?php
use Symfony\Component\HttpFoundation\Request;
use Exdrals\Excidia\Component\Router\Router;
use Exdrals\Excidia\Component\Http\Session;
use Exdrals\Excidia\Component\Feature\FlashMessage;
use Exdrals\Excidia\Component\Template\Template;
use Exdrals\Excidia\Component\Repository\DatabasePDO;
use Exdrals\Bugebo\Repository\PDO\Account;
use Exdrals\Bugebo\Controller\{
                                Auth,
                                Index,
                                User,
                                Transaction
};

return [
        Request::class => [],
        Session::class => [],
        DatabasePDO::class => [],
        Router::class => [
            Request::class
        ],
        FlashMessage::class => [
            Session::class
        ],
        Template::class => [],
        Account::class => [
            DatabasePDO::class
        ],
        // Controller
        Auth::class => [
            Session::class,
            Account::class,
            FlashMessage::class
        ],
        Index::class => [
            Template::class,
            Request::class,
            Auth::class
        ],
        User::class => [
            Template::class,
            Request::class,
            Auth::class,
            Session::class,
            FlashMessage::class
        ],
        Transaction::class => [
            Template::class,
            Request::class,
            Auth::class,
            Session::class
        ]
];
