<?php
return [
    
        'index' => [
                    'path' => '/{id}',
                    'methods' => ['GET', 'POST', 'PUT', 'DELETE'],
                    'Controller' => 'Exdrals\Bugebo\Controller\HomeController',
                    'Action' => 'index'
        ]
];