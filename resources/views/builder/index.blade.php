<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">

    <style>
        body {
            margin: 0;
        }

        #gjs {
            height: 100vh;
        }
    </style>
</head>

<body>

    <div id="gjs"></div>

    <script src="https://unpkg.com/grapesjs"></script>

    <script>
        const editor = grapesjs.init({
            container: '#gjs',
            height: '100vh',

            storageManager: false,

            canvas: {
                styles: [
                    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
                    'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Montserrat:wght@200;300;400;500;600&display=swap'
                ],

                scripts: [
                    'https://cdn.tailwindcss.com'
                ]
            }
        });

        @if (!empty($builder->project_data))

            editor.loadProjectData(
                @json($builder->project_data)
            );
        @else

            editor.setComponents(
                @json($html ?? '')
            );
        @endif
    </script>

</body>

</html>
