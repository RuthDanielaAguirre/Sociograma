<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Sociograma RDALL' ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="min-h-screen">
    
        <div class="max-w-5xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold tracking-tight">Sociograma RDALL</h1>
                    <p class=" mt-2 text-lg">Análisis de dinámicas de grupo</p>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="index.php" class="transition-colors font-medium hover:text-yellow-500">
                        Formulario
                    </a>
                    <a href="api.php" class="transition-colors font-medium hover:text-yellow-500">
                        API
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-6 py-12 fade-in">