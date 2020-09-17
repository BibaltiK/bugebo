<?php

declare(strict_types=1);

namespace Exdrals\Excidia\Component\Http;


class Session 
{    
    protected array $sessionData;
    

    public function __construct() 
    {
        $this->init();
        $this->sessionData = $_SESSION;        
    }
    
    public function __destruct() 
    {
        $_SESSION = $this->sessionData;
        session_write_close();
    }

    public function set(string $key, $value) 
    {
        $this->sessionData[$key] = $value;
    }
    
    public function get(string $key)
    {        
        return $this->sessionData[$key] ?? null;
    }
    
    public function unsetSession(string $key)
    {
        if ($this->get($key))
        {
            $this->set($key, null);
            unset ($this->sessionData[$key]);
        }
    }
    
    public function cleanSession()
    {
        $this->sessionData = [];
    }
    
    protected function init()
    {
        if (!isset($_SESSION))
        {
            session_start();
        }
    }        
}
