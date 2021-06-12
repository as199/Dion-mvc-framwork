<?php


namespace atpro\phpmvc;


use atpro\phpmvc\db\DbModel;

/**
 * @Author Assane Dione
 * Class UserModel
 * @package atpro\phpmvc
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}