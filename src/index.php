<?php
$page_title = "Formulario Sociograma";
//require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/header.php';

//variables para rehidratacion del formulario (vacias por defecto)
$old_data = $old_data ?? [];
$errors = $errors ?? [];
?>

<form method="POST" action="process.php" class="space-y-8" novalidate>


<?php require __DIR__ . '/includes/footer.php'; ?>