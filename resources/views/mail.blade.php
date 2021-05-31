
<?php
/**
 * Documentation:
 *
 * Change CSS link when uploading to production
 * Parameters:
 */

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>¡Hola mundo!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Styles -->
    <!-- Favicon -->
</head>
<body>
<div class="bg-white">
    <div class="container bg-white" >
        <div class="row justify-content-md-center" style="justify-content: center !important;">
            <div class="col-md-8">
                <br><br><br>
                <div class="text-left">

                </div>
                <h1 class="text-left" style="margin-top: 0; margin-bottom: .5rem; font-family: 'Open Sans'; font-weight: 600; line-height: 1.5; ">Mensaje recibido de Focus</h1>
                <p class="lead" style="font-size: 1.25rem; font-weight: 300; line-height: 1.7; margin-top: 1.5rem;">Hola: {{ $name }}</p>
                <p class="lead" style="font-size: 1.25rem; font-weight: 300; line-height: 1.7; margin-top: 1.5rem;">
                    Tu código para restablecer tu contraseña es: {{ $code }}
                </p>
                <br>

                <br><br>
            </div>
        </div>
        <hr style="width: 100px; height: 1px;">
    </div>
</div>
</body>
</html>
