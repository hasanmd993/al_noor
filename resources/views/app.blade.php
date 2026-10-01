<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Al-Noor Properties BD | Luxury Real Estate & Living Spaces in Dhaka</title>
    <meta name="description" content="Al-Noor Properties BD crafts architectural landmarks, luxury apartments, and visionary living spaces in Gulshan, Banani, Dhanmondi, and Dhaka's finest neighborhoods.">
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="/images/logo.jpeg">
    <link rel="shortcut icon" href="/favicon.ico">

    <!-- Fonts: Cormorant Garamond, Plus Jakarta Sans, Public Sans (for Sneat) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Cinzel:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Boxicons (for Sneat Admin) -->
    <link rel="stylesheet" href="/admin-assets/vendor/fonts/boxicons.css" />

    <!-- Leaflet Map CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0f19] text-slate-100 font-sans antialiased selection:bg-[#c6923b] selection:text-white overflow-x-hidden min-h-screen">
    <div id="app"></div>
</body>
</html>
