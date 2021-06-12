<?php


namespace atpro\phpmvc\form;


use atpro\phpmvc\Model;

/**
 * @Author Assane Dione
 * Class Form
 * @package atpro\phpmvc\form
 */
class Form
{
    /**
     * Permet d'indiquer le debut du formulaire
     * @param $action * l'action du formulaire
     * @param $method * la methode
     * @return Form
     */
    public static function begin($action, $method): Form
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    /**
     * Permet d'indiquer la fin du formulaire
     */
    public static function end()
    {
        echo '</form>';
    }

    /**
     * @param Model $model * le Model
     * @param $attribute * les attributs
     * @return InputField
     */
    public function field(Model $model, $attribute): InputField
    {
        return new InputField($model, $attribute);
    }
}