<?php
return [
         '/' => [
             'controller' => 'Exdrals\Bugebo\Controller\Index',
             'action' => 'index',
             'method' => 'GET'
         ],
    
        '/foo' => [
             'controller' => 'Exdrals\Bugebo\Controller\Foo',
             'action' => 'bar',
             'method' => 'GET|POST'
         ],
    
        '/foo/(\d+)?' => [
             'controller' => 'Exdrals\Bugebo\Controller\Foo',
             'action' => 'bar',
             'method' => 'GET|POST',
             'params' => []
         ]
];