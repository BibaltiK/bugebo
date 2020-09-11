<?php
return [
            'index' => [
                'path' => '/',
                'controller' => 'Exdrals\Bugebo\Controller\Index',
                'action' => 'index',
                'method' => 'GET'
            ],
    
            'show_login' => [
                'path' => '/login',
                'controller' => 'Exdrals\Bugebo\Controller\Account',
                'action' => 'showLogin',
                'method' => 'GET'
            ],
            'check_login' => [
                'path' => '/login',
                'controller' => 'Exdrals\Bugebo\Controller\Account',
                'action' => 'checkLogin',
                'method' => 'POST'
            ],
            'logout' => [
                'path' => '/logout',
                'controller' => 'Exdrals\Bugebo\Controller\Account',
                'action' => 'logout',
                'method' => 'GET'
            ],
    
           'account' => [
                 'path' => '/account',
                 'controller' => 'Exdrals\Bugebo\Controller\Account',
                 'action' => 'show',
                 'method' => 'GET'
             ],
    
        'foo_route' => [
             'path' => '/foo',
             'controller' => 'Exdrals\Bugebo\Controller\Foo',
             'action' => 'bar',
             'method' => 'GET|POST'
         ],
    
        'foo_bar_with_params' => [
             'path' => '/foo/(\d+)?',
             'controller' => 'Exdrals\Bugebo\Controller\Foo',
             'action' => 'bar',
             'method' => 'GET|POST',
             'params' => []
         ]
];