<?php


namespace atpro\phpmvc\form;


use atpro\phpmvc\Model;

/**
 * @Author Assane Dione
 * Class BaseField
 * @package atpro\phpmvc\form
 */
abstract class BaseField
{
    public Model $model;
    public string $attribute;
    abstract public function renderInput(): string;

    /**
     * Field constructor.
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {

        $this->model = $model;
        $this->attribute = $attribute;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('
               <div class="form-group">
                    <label class="form-label">%s</label>
                    %s
                    <div class="invalid-feedback">
                        %s
                    </div>
            </div>', $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)

        );
    }
}