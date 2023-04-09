<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>DISTRIMUSIC</title>
        
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        
        <!-- Icons -->
        <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
        
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        
        @livewireStyles
    </head>
    
    <body>
        <div id="app">
            @include('layouts.nav')
        
            <main class="py-4">
                @yield('content')
            </main>
        </div>

        @stack('modals')
        
        @livewireScripts
        
        @stack('scripts')
        
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        
        @if (session()->has('success')) 
        <script>
            var notyf = new Notyf({dismissible: true})
            notyf.success('{{ session('success') }}')
        </script> 
        @endif
        
        <script>
            /* Simple Alpine Image Viewer */
            document.addEventListener('alpine:init', () => {
                Alpine.data('imageViewer', (src = '') => {
                    return {
                        imageUrl: src,
        
                        refreshUrl() {
                            this.imageUrl = this.$el.getAttribute("image-url")
                        },
        
                        fileChosen(event) {
                            this.fileToDataUrl(event, src => this.imageUrl = src)
                        },
        
                        fileToDataUrl(event, callback) {
                            if (! event.target.files.length) return
        
                            let file = event.target.files[0],
                                reader = new FileReader()
        
                            reader.readAsDataURL(file)
                            reader.onload = e => callback(e.target.result)
                        },
                    }
                })
            })
        </script>
    </body>
</html>