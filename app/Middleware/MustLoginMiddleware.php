<?php

namespace Test\OSHS\PHP\MVC\Middleware;

use Test\OSHS\PHP\MVC\App\View;
use Test\OSHS\PHP\MVC\Config\Database;
use Test\OSHS\PHP\MVC\Repository\SessionRepository;
use Test\OSHS\PHP\MVC\Repository\UserRepository;
use Test\OSHS\PHP\MVC\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            View::redirect('/users/login');
        }
    }
}
