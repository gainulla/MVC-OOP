<?php

namespace App\Core;

class Form
{
    public $inputs = [];
    private $errors = [];
    private $formLabelsList = [];

    public function __construct(array $formLabelsList = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->inputs = $_POST;
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->inputs = $_GET;
        }

        $this->formLabelsList = $formLabelsList;
    }

    public function getInputs($name='')
    {
        if ($name) {
            return $this->inputs[$name] ?? "";
        } else {
            return $this->inputs;
        }
    }

    public function validationPassed()
    {
        return (count($this->errors) == 0);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getFieldLabel($inputName) {
        return $this->formLabelsList[$inputName];
    }

    public function validate($repository, $validationRules)
    {
        foreach ($this->inputs as $name => $value) {
            $field = $this->getFieldLabel($name);
            $dataType = false;

            $value = trim($value);

            if (empty($value) && in_array('required', $validationRules[$name])) {
                $this->errors[$name] = "Поле '{$field}' является обязательным.";
                continue;

            } else if (!empty($value)) {

                foreach ($validationRules[$name] as $rules) {
                    if (is_array($rules)) {
                        if (key($rules) === 'dataType') {
                            $dataType = new $rules['dataType']($value);
                            if ($dataType->hasErrors()) {
                                $this->errors[$name] = implode(' ', $dataType->getErrors());
                            }
                        }
                    } else {
                        switch ($rules) {
                            case 'unique':
                                    if (!$repository->isUnique($name, $value)) {
                                        $this->errors[$name] = "Значение поля '{$field}' не доступно.";
                                    }
                                    break;
                        }
                    }
                }
            }

            if (empty($this->error[$name])) {
                $this->inputs[$name] = $value;
            }
        }

        return (count($this->errors) == 0);
    }
}
