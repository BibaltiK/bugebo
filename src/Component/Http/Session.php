<?php

declare(strict_types=1);

namespace Exdrals\Excidia\Component\Http;


class Session 
{
    
    public function __construct() 
    {
        $this->sessionData = [];
        $this->init();
    }
    
    public function __destruct() 
    {
        session_write_close();
    }

    public function set(string $key, $value) 
    {
        $_SESSION[$key] = $value;
    }
    
    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }
    
    public function unsetSession(string $key)
    {
        if ($this->get($key))
        {
            $this->set($key, null);
            unset ($_SESSION[$key]);
        }
    }

    protected function init()
    {
        if (!isset($_SESSION))
        {
            session_start();
        }
    }        
}
