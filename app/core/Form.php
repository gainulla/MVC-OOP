<?php

namespace App\Core;

use App\Core\SessionManager;

class Form
{
    private $inputs = [];
    private $errors = [];
    private $formLabelsList = [];

    public function __construct(array $formLabelsList=[])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->inputs = $_POST;

        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->inputs = $_GET;
        }

        $this->formLabelsList = $formLabelsList;
    }

    public function intoSession($sessionName, SessionManager $session)
    {
        $session->set($sessionName, serialize([
            'inputs' => $this->getInputs(),
            'errors' => $this->getErrors()
        ]));
    }

    public function fromSession($sessionName, SessionManager $session)
    {
        if ($session->has($sessionName)) {
            $data = unserialize($session->get($sessionName, true));
            foreach ($data['inputs'] as $name => $value) {
                $this->inputs[$name] = $value;
            }
            foreach ($data['errors'] as $name => $error) {
                $this->errors[$name] = $error;
            }
        }
    }

    public function getInputs($name='')
    {
        if ($name) {
            return $this->inputs[$name] ?? "";
        } else {
            return $this->inputs;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function validationPassed()
    {
        return (count($this->errors) == 0);
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

            if (!isset($this->errors[$name])) {
                $this->inputs[$name] = $value;
            }
        }

        return (count($this->errors) == 0);
    }
}
