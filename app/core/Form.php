<?php

namespace App\Core;

use App\Core\SessionManager;
use App\Libs\UploadException;

class Form
{
    private $data = [];
    private $errors = [];
    private $formFieldsList = [];

    public function __construct(array $formFieldsList=[])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->data = $_POST;

        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->data = $_GET;
        }

        $this->formFieldsList = $formFieldsList;
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
        return (isset($this->formFieldsList[$inputName])
                ? $this->formFieldsList[$inputName]
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

    public function uploadFile($uploadsPath='', array $extensions=[], string $name='userfile')
    {
        pr($_FILES);

        if (isset($_FILES[$name])) {

            $ext_error = false;
            $file_ext = explode('.', $_FILES[$name]['name']);
            $file_ext = end($file_ext);

            if (!in_array($file_ext, $extensions)) {
                $ext_error = true;
            }

            try {
                if ($_FILES[$name]['error']) {
                    throw new UploadException($_FILES[$name]['error']);
                } else if ($ext_error) {
                    throw new Exception('Invalid file extension!');
                } else {
                    if (!move_uploaded_file(
                        $_FILES[$name]['tmp_name'],
                        rtrim($uploadsPath, '/') . '/' . $_FILES[$name]['name']
                    )) {
                        throw new Exception('Fail to move uploaded file!');
                    }
                }
            } catch (Exception $e) {
                $this->errors[$name] = $e->getMessage();
            }
        } else {
            echo 'File name not isset!';
        }
    }
}
