<?php

namespace Utils;

class Validator
{
    private $errors = [];
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function required($field, $message = null)
    {
        if (!isset($this->data[$field]) || empty($this->data[$field])) {
            $this->errors[$field] = $message ?: "The {$field} field is required";
        }
        return $this;
    }

    public function email($field, $message = null)
    {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message ?: "The {$field} must be a valid email address";
        }
        return $this;
    }

    public function min($field, $length, $message = null)
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field] = $message ?: "The {$field} must be at least {$length} characters";
        }
        return $this;
    }

    public function max($field, $length, $message = null)
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->errors[$field] = $message ?: "The {$field} may not be greater than {$length} characters";
        }
        return $this;
    }

    public function numeric($field, $message = null)
    {
        if (isset($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field] = $message ?: "The {$field} must be a number";
        }
        return $this;
    }

    public function alpha($field, $message = null)
    {
        if (isset($this->data[$field]) && !ctype_alpha($this->data[$field])) {
            $this->errors[$field] = $message ?: "The {$field} must only contain letters";
        }
        return $this;
    }

    public function alphaNumeric($field, $message = null)
    {
        if (isset($this->data[$field]) && !ctype_alnum($this->data[$field])) {
            $this->errors[$field] = $message ?: "The {$field} must only contain letters and numbers";
        }
        return $this;
    }

    public function matches($field, $matchField, $message = null)
    {
        if (isset($this->data[$field]) && isset($this->data[$matchField]) && $this->data[$field] !== $this->data[$matchField]) {
            $this->errors[$field] = $message ?: "The {$field} and {$matchField} must match";
        }
        return $this;
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
