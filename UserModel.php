<?php


namespace atpro\phpmvc;


use atpro\phpmvc\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}