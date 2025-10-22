<?php
function load_json(string $path): array{
    if(!file_exists($path)){
        throw new Exception("Archivo no encontrado: $path\n");
    }

    $json_string = file_get_contents($path);
    if ($json_string === false) {
        throw new Exception("No se pudo leer el archivo: $path");
    }

    $data = json_decode($json_string, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("JSON inválido: " . json_last_error_msg());
    }

    return $data;
}


function save_json(string $path, array $data): bool {
$dir = dirname($path);
if(!is_dir($dir)){
    mkdir($dir, 0755, true);
}
$json_string = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
if ($json_string === false) {
    throw new Exception("No se pudo codificar JSON: " . json_last_error_msg());
}

$result = file_put_contents($path, $json_string);

if($result === false){

throw new Exception("No se pudo guardar el archivo: $path");

}

return true;

}

