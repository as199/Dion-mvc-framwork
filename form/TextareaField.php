<?php


namespace atpro\phpmvc\form;


class TextareaField extends BaseField
{

    public function renderInput(): string
    {
        return sprintf('<textarea name="%s"  class="form-control%s" cols="30" rows="5">%s</textarea>',
        $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' :'',
            $this->model->{$this->attribute}
        );
    }
}