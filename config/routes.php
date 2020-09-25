<?php
use Exdrals\Bugebo\Controller\{
                                Index,
                                User,
                                Transaction
};

return [
        'index' => [
                    'path' => '/',
                    'controller' => Index::class,
                    'action' => 'index',
                    'method' => 'GET'
                ],
        'show_login' => [
                    'path' => '/login',
                    'controller' => User::class,
                    'action' => 'showLogin',
                    'method' => 'GET'
                ],
        'check_login' => [
                    'path' => '/login',
                    'controller' => User::class,
                    'action' => 'checkLogin',
                    'method' => 'POST'
                ],
        'logout' => [
                    'path' => '/logout',
                    'controller' => User::class,
                    'action' => 'logout',
                    'method' => 'GET'
                ],
        'account' => [
                    'path' => '/account',
                    'controller' => User::class,
                    'action' => 'show',
                    'method' => 'GET'
                ],
        'transaction_payments' => [
                    'path' => '/transaction/payment/(\S+)?',
                    'controller' => Transaction::class,
                    'action' => 'newIncomingPayment',
                    'method' => 'GET',
                    'params' => []
                ]
];
