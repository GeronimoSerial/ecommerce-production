<!DOCTYPE html>
<html>

<head>
    <title>Crear Usuario</title>
</head>

<body>
    <h1>Crear Usuario</h1>

    <form action="/back/usuario/guardar" method="post">
        <label>DNI:</label><br>
        <input type="text" name="dni" required><br>

        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br>

        <label>Apellido:</label><br>
        <input type="text" name="apellido" required><br>

        <label>Teléfono:</label><br>
        <input type="text" name="telefono"><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br>

        <label>Rol (id):</label><br>
        <input type="number" name="id_rol" required><br>

        <button type="submit">Guardar</button>
    </form>
</body>

</html>