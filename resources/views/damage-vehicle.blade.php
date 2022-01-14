<?php
/**
 * Documentation:
 *
 * Change CSS link when uploading to production
 * Parameters:
 */

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Incidencia de Vehículo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Styles -->
    <!-- Favicon -->
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!--  CSS -->
    {{--    <link type="text/css" href="{{ asset('assets/css/argon.css') . "?v=1.1.0" }}" rel="stylesheet">--}}
    <link type="text/css" href="http://int.reparatucoche.com/assets/css/argon.css?v=1.1.0" rel="stylesheet">
</head>
<body>
<div class="bg-white">
    <div class="container bg-white" >
        <div class="row justify-content-md-center" style="justify-content: center !important;">
            <div class="col-md-8">
                <br><br><br>
                <div class="text-left">
                    <img src="https://dev.api.focus.grupomobius.com/images/focus.jpg" alt="" width="175px" height="auto">
                </div>
                <h1 class="text-left" style="margin-top: 0; margin-bottom: .5rem; font-family: 'Open Sans'; font-weight: 600; line-height: 1.5; ">Mensaje recibido de Focus</h1>
                <p class="lead" style="font-size: 1.25rem; font-weight: 300; line-height: 1.7; margin-top: 1.5rem;">
                    Ha recibido una incidencia del vehículo con matrícula [{{$vehicle->plate}}] con una severidad [{{$severity->description}}]
                </p>

                <p class="lead" style="font-size: 1.25rem; font-weight: 300; line-height: 1.7; margin-top: 1.5rem;">
                    Observación:
                    <br>
                    {{$description}}
                </p>

                <p class="lead" style="font-size: 1.25rem; font-weight: 300; line-height: 1.7; margin-top: 1.5rem;">
                    Para más información del vehículo, acceda al siguiente link:
                    <br>
                    <a href="{{env('APP_URL')}}/#/incidences/{{$vehicle->id}}">Ver vehículo</a>
                </p>

                <p class="lead" style="font-size: 1.25rem; font-weight: 300; line-height: 1.7; margin-top: 1.5rem;">
					Muchas Gracias.
                </p>

            </div>
        </div>
        <hr style="width: 100px; height: 1px;">
        <div class="row justify-content-md-center" style="justify-content: center !important;">
            <div class="col-md-8">
                <p style="color: #8898aa !important; text-align: center !important;">
                    Enviado por Grupo Mobius<br>
                    Calle Anabel Segura, 7, 28108 Alcobendas, Madrid<br>
                    <a href="#" class="btn btn-link" style="font-weight: 400; text-decoration: none; color: #5e72e4;">Blog</a> •
                    <a href="#" class="btn btn-link" style="font-weight: 400; text-decoration: none; color: #5e72e4;">Políticas</a>
                </p>
                <br><br><br>
            </div>
        </div>
    </div>
</div>
</body>
</html>
