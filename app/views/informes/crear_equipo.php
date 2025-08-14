<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <label for="selectequipo" class="form-label">Equipo</label>
                <form action="/softgenn/public/index.php?action=listarequipo" method="POST">
                    <div class="row">
                        <div class="col">
                            <label for="equi_tipo_equipo" class="form-label">Tipo equipo</label>
                            <input type="text" class="form-control" id="equi_tipo_equipo" name="tipo_equipo" required >
                        </div>
                        <div class="col">
                             <label for="equi_marca" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="equi_marca" name="marca" required >
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit">Crear</button>
                        <a href="/softGenn/public/index.php?action=listarequipo" class="btn btn-secondary">cancelar</a>
                    </div>
                    
                </form>



            </div>
        </div>


    </div>
</body>
</html>