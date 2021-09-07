<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Home API Focus</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{--    <link type="text/css" href="{{ asset('assets/css/argon.css') . "?v=1.1.0" }}" rel="stylesheet">--}}
    <link type="text/css" href="http://int.reparatucoche.com/assets/css/argon.css?v=1.1.0" rel="stylesheet">
</head>
<body style="background-color:#fff;">
<div style="height:100vh">
    <table width="100%;color:#000">
        <tr>
            <td width="60%"><p style="font-size:2rem">ALD Automotive</p></td>
            <td width="40%">
                <p>EXPEDIDOR</p>
                <p>TODOCHOFER</p>
                <p style='margin:0'>Carretera Leganés a Carabanchel, M425, KM. 10, 200</p>
                <p style='margin:0'>Esquina a Avenida de la Reina Sofia</p>
                <p style='margin:0'>28914 - Leganés - Madrid</p>
            </td>
        </tr>
    </table>
    <table width="100%;margin:15px;color:#000">
        <tr>
            <td width="50%" style="border:2px solid #000">
                <p>
                    <span><strong>Cliente: </strong></span>
                    <span>{{ $customer }}</span>
                </p>
                <p>
                    <span><strong>Cuenta: </strong></span>
                    <span>{{ $check }}</span>
                </p>
            </td>
            <td width="50%" style="border:2px solid #000">
                <p>
                    <span><strong>Albarán: </strong></span>
                    <span>{{ $delivery_no }}</span>
                </p>
                <p>
                    <span><strong>Fecha Salida: </strong></span>
                    <span>{{ $date_exit }}</span>
                </p>
                <p>
                    <span><strong>Fecha Emisión: </strong></span>
                    <span>{{ $created }}</span>
                </p>
            </td>
        </tr>
    </table>

    <table width="100%;margin:15px;color:#000">
        <tr>
            <td style="border:2px solid #000"><strong>Transportista</strong></td>
            <td style="border:2px solid #000"><strong>Destino</strong></td>
        </tr>
        <tr>
            <td width="50%" style="border:2px solid #000">
                <p>
                    <span><strong>Empresa: </strong></span>
                    <span>{{ $company }}</span>
                </p>
                <p>
                    <span><strong>Dirección: </strong></span>
                    <span>{{ $address }}</span>
                </p>
                <p>
                    <span><strong>Referencia: </strong></span>
                    <span>{{ $reference }}</span>
                </p>
                <p>
                    <span><strong>Camión: </strong></span>
                    <span>{{ $truck }}</span>
                </p>
                <p>
                    <span><strong>Remolque: </strong></span>
                    <span>{{ $trailer }}</span>
                </p>
                <p>
                    <span><strong>Conductor: </strong></span>
                    <span>{{ $driver }}</span>
                </p>
                <p>
                    <span><strong>DNI: </strong></span>
                    <span>{{ $dni }}</span>
                </p>
            </td>
            <td width="50%" style="border:2px solid #000">
                <p>
                    <span><strong>Consesión: </strong></span>
                    <span>DESCONOCIDO</span>
                </p>
                <p>
                    <span><strong>2da consesión: </strong></span>
                    <span>01-09-2021</span>
                </p>
            </td>
        </tr>
    </table>
    <table width="100%;margin:15px;color:#000">
        <tr>
            <td style="border:2px solid #000"><strong>Chasis</strong></td>
            <td style="border:2px solid #000"><strong>Matrícula</strong></td>
            <td style="border:2px solid #000"><strong>Modelo</strong></td>
            <td style="border:2px solid #000"><strong>Ubicación</strong></td>
        </tr>
        @foreach($vehicles as $vehicle)
            <tr>
                <td>{{ $vehicle->vin }}</td>
                <td>{{ $vehicle->plate }}</td>
                <td>{{ $vehicle->vehicleModel->name }}</td>
                <td>{{ $vehicle->ubication }}</td>
            </tr>
        @endforeach
    </table>

    <p style="margin:15px;color:#000">Número total de vehículos: {{ $total }}</p>

    <table width="100%" style="margin:15px;color:#000">
        <tr>
            <td><strong>Conforme transportista</strong></td>
            <td><strong>Conforme entregador</strong></td>
        </tr>
        <tr>
            <td><strong>Fecha:</strong></td>
            <td><strong>Fecha:</strong></td>
        </tr>
    </table>
</div>
</body>
</html>
