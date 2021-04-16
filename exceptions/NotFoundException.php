<?php


namespace atpro\phpmvc\exceptions;


class NotFoundException extends \Exception
{
    protected $message = "Page not found";
    protected $code = 404;
}