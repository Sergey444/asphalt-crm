<?php

namespace app\components;

use yii\i18n\Formatter;

class FormatterHelper extends Formatter {

    public function asPhone($value) {
        return preg_replace("/^(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})$/", "+$1 ($2) $3-$4-$5", $value);
    }

}