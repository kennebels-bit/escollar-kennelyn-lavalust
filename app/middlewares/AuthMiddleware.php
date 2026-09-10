<?php

class AuthMiddleware
{
    public function handle(Closure $next)
    {
        if (!isset($_SESSION['user'])) {
            redirect('login');
        }

        return $next();
    }
}