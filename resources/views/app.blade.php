<!DOCTYPE html>
<html @class(['dark' => ($appearance ?? 'system') == 'dark']) lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1" name="viewport">

  {{-- Inline script to detect system dark mode preference and apply it immediately --}}
  <script>
    (function () {
      const appearance = '{{ $appearance ?? 'system' }}';

      if (appearance === 'system') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (prefersDark) {
          document.documentElement.classList.add('dark');
        }
      }
    })();
  </script>

  {{-- Inline style to set the HTML background color based on our theme in app.css --}}
  <style>
    html {
      background-color: oklch(1 0 0);
    }

    html.dark {
      background-color: oklch(0.145 0 0);
    }
  </style>

  <title inertia>{{ config('app.name', 'TwitterClone') }}</title>

  <link href="/favicon.ico" rel="icon" sizes="any">
  <link href="/favicon.svg" rel="icon" type="image/svg+xml">
  <link href="/apple-touch-icon.png" rel="apple-touch-icon">

  @routes
  @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
  @inertiaHead
</head>

<body class="font-sans antialiased">
  @inertia
</body>

</html>
