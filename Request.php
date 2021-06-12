<?php


namespace atpro\phpmvc;

/**
 * @Author Assane Dione
 * Class Request
 * @package atpro\phpmvc
 */
class Request
{
    /**
     * Permet de retour les parametres passé dans l'url
     * @return false|string
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if($position === false){
            return $path;
        }
       return substr($path, 0, $position);
    }

    /**
     * Permet de recuperer la method
     * Exemple: post, get, etc...
     */
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Permet de verifier si la requete est de type "GET"
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->method() === 'get';
    }

    /**
     * Permet de verifier si la requete est de type "POST"
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->method() === 'post';
    }

    /**
     * Permet recuper le contenu du formulaire envoyer en GET ou POST
     * @return array
     */
    public function getBody(): array
    {
        $body = [];
        if($this->method() === 'get'){
            foreach($_GET as $key => $value){
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);;
            }
        }

        if($this->method() === 'post'){
            foreach($_POST as $key => $value){
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);;
            }
        }
        return $body;
    }
}