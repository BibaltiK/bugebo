<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Component\Feature;

use Exdrals\Bugebo\Component\Http\Session;

class FlashMessage 
{
    public function __construct(protected Session $session)
    {}
    
    public function add(string $Message, string $level): void
    {           
        $flash = $this->session->get('flash');        
        $flash[$level][] = $Message;
        $this->session->set('flash', $flash);
    }
    
    public function hasFlashMessage(): bool
    {
        return (bool)count($this->session->get('flash') ?? []);
    }
    
    public function get(): ?array
    {
        $flashMsg = $this->session->get('flash');
        $this->clean();
        return $flashMsg;
    }
    
    public function clean(): void
    {
        $this->session->unsetSession('flash');
    }
}
