<?php


namespace atpro\phpmvc\form;

/**
 * @Author Assane Dione
 * Class TextareaField
 * @package atpro\phpmvc\form
 */
class TextareaField extends BaseField
{
    /**
     * Permet de rendre un textarea
     * @return string
     */
    public function renderInput(): string
    {
        return sprintf('<textarea name="%s"  class="form-control%s" cols="30" rows="5">%s</textarea>',
        $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' :'',
            $this->model->{$this->attribute}
        );
    }
}