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

    public function get($key)
    {
        return $_SESSION[$key]?? false;
    }
    public function set($key, $value): void
    {
        $_SESSION[$key]= $value;
    }

    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove'=> false,
            'value' => $message
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

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