<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada</title>
    <link rel="stylesheet" href="<?php echo ROOT_URL; ?>/libs/css/styles.css" />
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-position: center;
        }

        #footer_404 {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.7);
            padding: 20px;
            border-radius: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media only screen and (min-width: 1920px) {
            body {
                background-image: url('uploads/404-large.jpg');
            }
        }

        @media only screen and (max-width: 1919px) {
            body {
                background-image: url('uploads/404-medium.jpg');
            }
        }

        @media only screen and (max-width: 768px) {
            body {
                background-image: url('uploads/404-small.jpg');
            }
        }
    </style>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</head>

<body>
    <div id="footer_404">
        <a href="javascript:void(0);" onclick="goBack()">
            Volver
        </a>
    </div>
</body>

</html>