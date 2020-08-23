<?php
return [
          '/' => [
              'description' => 'Default Route > Index',
              'medthod' => 'GET',
              'controller' => 'Exrals\\Bugebo\\Controller\\HomeController',
              'action'  => 'index'
          ]
];

interface iFoo {
    public function foobar($todo);
}

class Foo implements iFoo {
    public function foobar(MyTypeHint $todo)
    {
        
    }
}