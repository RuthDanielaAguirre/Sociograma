<?php
function oldField(string $key, array $old_data = []):string{
    if(isset($old_data[$key])){
        return htmlspecialchars($old_data[$key], ENT_QUOTES, 'UTF-8');
    }
    return '';
}


function oldCheckbox(string $key, string $value, array $old_data = []):string{
    if(isset($old_data[$key])){
        if(in_array($value, (array)$old_data[$key])){
            return 'checked';
        }
    }
    return '';
}

function oldRadio(string $key, string $value, array $old_data = []): string {
    if (isset($old_data[$key])) {
        if ($old_data[$key] == $value) {
            return 'checked';
        }
        return '';
    }
    return '';
}