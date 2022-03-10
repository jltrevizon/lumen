<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Hola!</h2>
    <h3>Se ha creado una nueva incidencia para tu grupo.</h3>
    <p><strong>{{date('d-m-Y H:i:s', strtotime($damage->created_at))}}</strong></p>
    <p><strong>Creador: </strong></p>
    <p>{{$damage?->user?->name}} {{$damage?->user?->surname}}</p>
    <p><strong>Datos del vehículo:</strong></p>
    <p><strong>Matrícula:</strong> {{$damage->vehicle->plate}} <strong>Marca:</strong> {{$damage?->vehicle?->vehicleModel?->brand?->name}} <strong>Modelo:</strong> {{$damage?->vehicle?->vehicleModel?->name}}</p>
    <p><strong>Tipo de incidencia</strong></p>
    <p>{{$damage?->damageType?->description}}</p>
    <p><strong>Notificado a:</strong></p>
    <ol>
        @foreach($damage->roles as $role)
        <li>{{$role->description}}</li>
        @endforeach
    </ol>
    <p><strong>Tareas:</strong></p>
    <ol>
        @foreach($damage->tasks as $task)
        <li>{{$task->name}}</li>
        @endforeach
    </ol>
    <p><strong>Nota: Las tareas solicitadas se crearán automáticamente.</strong></p>
    <a style="background-color: #03989e; padding: 10px; border-radius: 4px; color: #fff; font-weight: bold; text-decoration: none" href={{ env('APP_FRONT') . '/#/incidences/' . $damage?->id }}>Ir a la aplicación</a>
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
