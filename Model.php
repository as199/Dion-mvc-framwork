<?php


namespace atpro\phpmvc;

/**
 * @Author Assane Dione
 * Class Model
 * @package atpro\phpmvc
 */
abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public array $errors = [];

    /**
     * Permet de verifier si une propriété appartient à la classe
     * @param $data
     */
    public function loadData($data): void
    {
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function labels(): array
    {
        return [];
    }

    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute ;
    }

    /**
     * Permet de valider les differents champs d'un formulaire
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules){
            $value = $this->{$attribute};
            foreach ($rules as $rule){
                $ruleName = $rule;
                if(!is_string($ruleName)){
                    $ruleName = $rule[0];
                }
                if($ruleName  === self::RULE_REQUIRED && !$value){
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if($ruleName  === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule['class'];
                   $uniqueAttribute= $attribute = $rule['attribute'] ?? $attribute;
                   $tableName = $className::tableName();
                  $statement= Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttribute =:attribute");
                   $statement->bindValue(":attribute", $value);
                   $statement->execute();
                   $record = $statement->fetchObject();
                   if($record){
                       $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field'=> $this->getLabel($attribute)]);
                   }
                }
            }
        }
        return (empty($this->errors));
    }

    /**
     * Permet d'ajouter les messsages d'erreur
     * @param $attribute
     * @param $rule
     * @param array $params
     */
    private function addErrorForRule($attribute, $rule, $params= [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach($params as $key => $value){
            $message = str_replace("{{$key}}",$value ,$message);
        }
        $this->errors[$attribute][] = $message;
    }

    /**
     * Permet d'ajouter les messsages d'erreur
     * @param $attribute
     * @param $message
     */
    public function addError($attribute, $message)
    {
        $this->errors[$attribute][] = $message;
    }

    /**
     * Retour les differents erreurs suivants les cas possible
     * @return string[]
     */
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists'
        ];
    }

    /**
     * Permet de voir si le champs est valide ou pas
     * @param $attribute
     * @return false|mixed
     */
    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    /**
     * Permet de recuper le message d'eurreur
     * @param $attribute
     * @return false|mixed
     */
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}