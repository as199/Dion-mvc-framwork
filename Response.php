<?php


namespace App\core;

/**
 * @Author Assane Dione
 * Class Response
 * @package App\core
 */
class Response
{
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    /**
     * Permet de rediriger vers un url donne
     * @param string $path
     */
    public function redirect(string $path)
    {
        header("Location: ".$path );
    }
}