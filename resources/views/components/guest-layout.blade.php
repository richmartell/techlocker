<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GarageIQ') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Use Tailwind CSS CDN instead of Vite for now -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Styles -->
    <style>
        [x-cloak] { display: none !important; }
        html, body, .font-sans, [data-flux-field], [data-flux-label], [data-flux-control] {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif !important;
        }
    </style>
    @livewireStyles
    @fluxStyles
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">
    {{ $slot }}
    
    @livewireScripts
    @fluxScripts
</body>
</html> 