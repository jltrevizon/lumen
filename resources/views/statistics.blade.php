
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
</head>
<body>
    <h2>Vehículos recepcionados en la última semana</h2>
    <img src="https://quickchart.io/chart?c={{$reception_by_days}}" width="600px" alt="">
    <h2>Vehículos recepcionados en los últimos meses</h2>
    <img src="https://quickchart.io/chart?c={{$reception_by_months}}" width="600px" alt="">
    <h2>Tareas inciadas en la última semana</h2>
    <img src="https://quickchart.io/chart?c={{$pending_tasks_by_days}}" width="600px" alt="">
    <h2>Tareas inciadas en los últimos meses</h2>
    <img src="https://quickchart.io/chart?c={{$pending_tasks_by_months}}" width="600px" alt="">
    <h2>Tareas finalizadas en la última semana</h2>
    <img src="https://quickchart.io/chart?c={{$pending_tasks_end_by_days}}" width="600px" alt="">
    <h2>Tareas finalizadas en los últimos meses</h2>
    <img src="https://quickchart.io/chart?c={{$pending_tasks_end_by_months}}" width="600px" alt="">
</body>
</html>
