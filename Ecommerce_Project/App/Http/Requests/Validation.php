<?php
namespace App\Http\Requests;

use App\Database\Models\Model;

class Validation
{
    private $value;
    private string $valueName;
    private array $errors=[];
    private array $oldValues = [];

    public function required() : self
    {
        if(empty($this->value)){
            $this->errors[$this->valueName][__FUNCTION__]="{$this->valueName} required";
        }
        return $this;
    }


    public function between(int $min,int $max) : self
    {
        if(strlen($this->value)< $min || strlen($this->value)>$max){
            $this->errors[$this->valueName][__FUNCTION__]="{$this->valueName} length should be between {$min}:{$max}";
        }
        return $this;
    }

    public function betweenval(int $min, int $max): self
    {
        if ($this->value < $min || $this->value > $max) {
            $this->errors[$this->valueName][__FUNCTION__] = "{$this->valueName} should be between {$min}:{$max}";
        }
        return $this;
    }


    public function digits(int $len): self
    {
        if (strlen($this->value) != $len) {
            $this->errors[$this->valueName][__FUNCTION__] = "{$this->valueName} length should be {$len}";
        }
        return $this;
    }

    public function in(array $values) : self
    {
        if(!in_array($this->value,$values)){
            $this->errors[$this->valueName][__FUNCTION__]="{$this->valueName} should be one of this values" . implode(",",$values);
        }
        return $this;
    }

    public function isstring() : self
    {
        if (is_numeric($this->value) && is_int(0 + $this->value)) {
            $this->errors[$this->valueName][__FUNCTION__]="{$this->valueName} should be string";
        }
        return $this;
    }

    public function regex($pattern, $message = null): self
    {
        if(! preg_match($pattern,$this->value)){
            $this->errors[$this->valueName][__FUNCTION__] = $message ? $message : "{$this->valueName} Invalid";
        }
        return $this;
    }
    

    public function confirmed($confirmedValue) : self
    {
        if($this->value != $confirmedValue){
            $this->errors[$this->valueName][__FUNCTION__]="{$this->valueName} not confirmed";
        }
        return $this;
    }

    public function unique(string $table,string $column) : self
    {
        $model=new Model;
        $result=$model->search($table,$column,$this->value);
        if($result->num_rows > 0){
            $this->errors[$this->valueName][__FUNCTION__]="{$this->valueName} already exists";
        }
        return $this;
    }


    public function exists(string $table,string $column) : self
    {
        $model=new Model;
        $result=$model->search($table,$column,$this->value);
        if($result->num_rows ==0){
            $this->errors[$this->valueName][__FUNCTION__]="{$this->valueName} not exists";
        }
        return $this;
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of valueName
     */ 
    public function getValueName()
    {
        return $this->valueName;
    }

    /**
     * Set the value of valueName
     *
     * @return  self
     */ 
    public function setValueName($valueName)
    {
        $this->valueName = $valueName;

        return $this;
    }

    /**
     * Get the value of errors
     */ 
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the value of errors
     *
     * @return  self
     */ 
    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    public function getError($inputName) :?string
    {
        if(isset($this->errors[$inputName])){
            foreach ($this->errors[$inputName] as $error) {
                return $error;
            }

        }
        return null;
    }

    public function getMessage($inputName) :?string
    {
        $message=$this->getError($inputName);
        return $message?"<div class='alert alert-danger' role='alert'>".$message." </div>" :"";
    }



    /**
     * Get the value of oldValues
     */
    public function getOldValues()
    {
        return $this->oldValues;
    }

    /**
     * Set the value of oldValues
     *
     * @return  self
     */
    public function setOldValues($oldValues)
    {
        $this->oldValues = $oldValues;

        return $this;
    }

    public function getOldValue($inputName): ?string
    {
        if (isset($this->oldValues[$inputName])) {
            return $this->oldValues[$inputName];
        }
        return null;
    }
}