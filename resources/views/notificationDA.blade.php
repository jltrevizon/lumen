<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Hola!</h1>
    <h3>El siguiente vehículo no tiene el distintivo ambiental:</h3>
    <p><strong>Matrícula: </strong> {{$vehicle->plate}}</p>
    <p><strong>Marca: </strong> {{$vehicle->vehicleModel?->brand?->name}}</p>
    <p><strong>Modelo: </strong> {{$vehicle->vehicleModel?->name}}</p>
    <p><strong>Bastidor: </strong>{{$vehicle->vin}}</p>
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
</body>
</html>