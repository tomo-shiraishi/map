<?php
namespace App\Validator;

class CustomValidator extends \Illuminate\Validation\Validator
{

    public function validateZipcode($attribute, $value, $parameters)
    {
        return preg_match('/^\d{3}-\d{4}$/', $value);
    }

    public function validatePasswordCheck($attribute, $value, $parameters)
    {
        return preg_match('/^[A-Za-z\d]{8,16}$/', $value);
    }

    // 指定したフォームの値の大小比較
    public function validateCheckMax($attribute, $value, $parameters)
    {
        $specified_val = $this->getValue($parameters[0]);
        return $value >= $specified_val;
    }
}
