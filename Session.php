<?php


namespace atpro\phpmvc;


class Session
{
   protected const FLASH_KEY = 'flash_messages';

    /**
     * Session constructor.
     */
    public function __construct()
    {
        session_start();
        $flashMessage = $_SESSION[self::FLASH_KEY] ?? [];
        foreach($flashMessage as $key => &$message){
                $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY]= $flashMessage;
    }

    /**
     * Permet de recuper le contenu d'un variable en session
     * @param $key  *la  cle de la variable en session
     * @return false|string
     */
    public function get($key)
    {
        return $_SESSION[$key]?? false;
    }

    /**
     * Permet de sauvegarder une variable en session
     * @param $key *la  cle de la variable en session
     * @param $value *la  cle de la valeur en session
     */
    public function set($key, $value): void
    {
        $_SESSION[$key]= $value;
    }

    /**
     * Permet de supprimer une variable en session
     * @param $key *la  cle de la variable en session
     */
    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Permet de mettre des messages flash
     * @param $key *la  cle de la variable
     * @param $message *le message
     */
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove'=> false,
            'value' => $message
        ];
    }

    /**
     * Permet de recuperer un message flash
     * @param $key *la  cle du message flash
     * @return false|mixed
     */
    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    /**
     * Permet de supprimer un message flash dans le tableau des messages
     */
    public function __destruct()
    {
        $flashMessage = $_SESSION[self::FLASH_KEY] ?? [];
        foreach($flashMessage as $key => &$message){
            if($flashMessage['remove'] ){
                unset($flashMessage[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY]= $flashMessage;
    }
}