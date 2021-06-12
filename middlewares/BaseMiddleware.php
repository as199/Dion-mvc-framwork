<?php


namespace atpro\phpmvc\middlewares;

/**
 * @Author Assane Dione
 * Class BaseMiddleware
 * @package atpro\phpmvc\middlewares
 */
abstract class BaseMiddleware
{
    abstract public function execute();
}