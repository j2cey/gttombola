<?php


namespace App\Traits\Request;


trait RequestTraits
{
    public function getCheckValue($field) {
        $formInput = $this->all();
        if (array_key_exists($field, $formInput)) {
            if (is_null($formInput[$field])) {
                return 0;
            } else {
                return ($formInput[$field] === "true" || $formInput[$field] === "1" || $formInput[$field] === true) ? 1 : 0;
            }
        } else {
            return 0;
        }
    }
}
