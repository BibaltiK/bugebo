<?php
return [
         'index' => [
             'path' => '/',
             'controller' => 'Exdrals\Bugebo\Controller\Index',
             'action' => 'index',
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