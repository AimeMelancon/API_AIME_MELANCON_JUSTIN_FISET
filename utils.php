<?php

function isValid(...$values) {
    foreach($values as $value) {
        if(isset($value)) {
            if(is_string($value) && empty($value)) {
                return false;
            }
        }
    }
    return true;
}

?>