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
<body class="bg-gray-50 min-h-screen">
    
    <header class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg">
        <div class="max-w-5xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold tracking-tight">Sociograma RDALL</h1>
                    <p class="text-indigo-100 mt-2 text-lg">Análisis de dinámicas de grupo</p>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="index.php" class="text-white hover:text-indigo-200 transition-colors font-medium">
                        Formulario
                    </a>
                    <a href="api.php" class="text-white hover:text-indigo-200 transition-colors font-medium">
                        API
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-6 py-12 fade-in">