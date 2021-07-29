<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nuestra primera View</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <header class="p-4 bg-dark text-white">
        Encabezado
    </header>
    <main class="container">
        <h1>Listado de regiones</h1>

        <ul>
        @foreach( $regiones as $region )
            <li>{{ $region->regNombre }}</li>
        @endforeach
        </ul>

    </main>

</body>
</html>
