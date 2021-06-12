<?php


namespace atpro\phpmvc\form;


use atpro\phpmvc\Model;

/**
 * @Author Assane Dione
 * Class InputField
 * @package atpro\phpmvc\form
 */
class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';

    public string $type;
    public Model $model;
    public string $attribute;

    /**
     * Field constructor.
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
       parent::__construct($model, $attribute);
    }

    /**
     * Permet de mettre les champs password le type password
     */
    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    /**
     * @return $this
     */
    public function numberField()
    {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }

    /**
     * Permet de rendre une input et sa validation
     * @return string
     */
    public function renderInput(): string
    {
        return sprintf('<input type="%s" name="%s" value="%s" class="form-control%s" >',
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? ' is-invalid' :''
        );
    }
}