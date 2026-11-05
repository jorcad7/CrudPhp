
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'miCrud') ?> - miCrud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand bg-body-tertiary mb-4">
        <div class="container">
           <!-- <a class="navbar-brand" href="/products">miCrud</a>
                <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/products">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="/users">Usuarios</a></li>
            </ul> -->
        </div>
    </nav>
 
    <main class="container pb-5">
        <?= $content ?>
    </main>
</body>
</html>
 