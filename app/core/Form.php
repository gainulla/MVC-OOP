<?php

namespace App\Core;

use App\Core\SessionManager;

class Form
{
    private $data = [];
    private $errors = [];
    private $formLabelsList = [];

    public function __construct(array $formLabelsList=[])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->data = $_POST;

        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->data = $_GET;
        }

        $this->formLabelsList = $formLabelsList;
    }

    public function intoSession($sessionName, SessionManager $session)
    {
        $session->set($sessionName, serialize([
            'inputs' => $this->inputAll(),
            'errors' => $this->getErrors()
        ]));
    }

    public function fromSession($sessionName, SessionManager $session)
    {
        if ($session->has($sessionName)) {
            $data = unserialize($session->get($sessionName, true));
            foreach ($data['inputs'] as $name => $value) {
                $this->data[$name] = $value;
            }
            foreach ($data['errors'] as $name => $error) {
                $this->errors[$name] = $error;
            }
        }
    }

    public function input($name="")
    {
        return $this->data[$name] ?? NULL;
    }

    public function inputAll()
    {
        return $this->data;
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
        return (isset($this->formLabelsList[$inputName])
                ? $this->formLabelsList[$inputName]
                : FALSE
        );
    }

    public function validate($repository, $validationRules)
    {
        foreach ($this->data as $name => $value) {
            $field = $this->getFieldLabel($name);

            if (!$field) {
                continue;
            }

            $dataType = FALSE;

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
                $this->data[$name] = $value;
            }
        }

        return (count($this->errors) == 0);
    }
}
