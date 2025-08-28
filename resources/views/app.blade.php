<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>Two Medics - Prepárate para ENARM, ENAM y ESSALUD</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('twomedics/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('twomedics/favicon.ico') }}" type="image/x-icon">

    <!-- SEO Básico -->

    <!-- Description -->
    <meta name="description"
        content="Accede a recursos médicos descargables y contenidos clínicos por especialidad para reforzar tu preparación médica.">

    <!-- Keywords -->
    <meta name="keywords"
        content="Two Medics, ENAM, ENARM, ESSALUD, flash cards médicas, cursos médicos Perú, preparación médica, recursos médicos, medicina descargables">

    <!-- Author -->
    <meta name="author" content="Araccelli Zevallos (UX/UI designer) y Frank Jacobo (full stack developer)">

    <!-- Copyright -->
    <meta name="copyright"
        content="© 2025 Two Medics. Desarrollado por Araccelli Zevallos y Frank Jacobo. Todos los derechos reservados.">

    <!-- Idioma -->
    <meta http-equiv="content-language" content="es-PE">

    <!-- Robots -->
    <meta name="robots" content="index,follow">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://api.twomedicsoficial.com/">

    <!-- Open Graph -->
    <meta property="og:title" content="Prepárate para ENARM, ENAM y ESSALUD con Two Medics">
    <meta property="og:description"
        content="Flash Cards y contenidos clínicos descargables para reforzar tu preparación médica. Especializado en exámenes nacionales.">
    <meta property="og:image" content="https://pub-951249b1f6194dd28b5a32d1bc4c9581.r2.dev/og_image.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="https://api.twomedicsoficial.com/">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Two Medics" />
    <meta property="og:locale" content="es_PE" />

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Prepárate para ENARM, ENAM y ESSALUD con Two Medics" />
    <meta name="twitter:description"
        content="Contenidos médicos descargables por especialidad. Flash Cards y PDFs listos para estudiar." />
    <meta name="twitter:image" content="https://pub-951249b1f6194dd28b5a32d1bc4c9581.r2.dev/og_image.png" />
    <meta name="twitter:image:alt" content="Ilustración médica con recursos de estudio de Two Medics" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>