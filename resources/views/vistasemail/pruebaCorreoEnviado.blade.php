<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <title>Correo enviado</title>

    <style>
        body {
            background-color: rgb(2, 0, 36);
            background-color: linear-gradient(0deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 20%, rgba(40, 40, 152, 1) 42%, rgba(78, 78, 173, 1) 71%);
        }
        #txt {
            color: gainsboro;
        }
    </style>
</head>

<body>
    <div>
        <div id="txt" style="position: absolute; top: 43%; left: 50%; transform: translate(-50%, -50%);">
            <h1>El correo se ha enviado con éxito</h1>
        </div>
        <div id="txt" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <h3>Revisa tu bandeja para poder acceder</h3>
        </div>
        <div style="position: absolute; top: 60%; left: 50%; transform: translate(-50%, -50%);">
            <img src="/resources/views/img/correo.png" alt="">
        </div>
        <div style="position: absolute; top: 95%; left: 50%; transform: translate(-50%, -50%); color:#a5a5ff;">
            <h5>Ya puedes cerrar esta pestaña</h5>
        </div>

        <img src="/resources/views/img/correo.png" alt="">
    </div>
</body>

</html>