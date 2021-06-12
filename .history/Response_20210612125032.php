<?php


namespace atpro\phpmvc;

/**
 * @Author Assane Dione
 * Class Response
 * Permet de gerer la reponse
 * @package atpro\phpmvc
 */
class Response
{
    /**
     * Permet de modifier le status de la response
     * @Param $code
     */
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