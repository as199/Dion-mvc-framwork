<?php


namespace atpro\phpmvc\exceptions;


class ForbiddenException extends \Exception
{
    protected $message = "You don't have permission to access this page";
    protected $code = 403;
}