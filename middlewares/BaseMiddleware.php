<?php


namespace atpro\phpmvc\middlewares;


abstract class BaseMiddleware
{
    abstract public function execute();
}