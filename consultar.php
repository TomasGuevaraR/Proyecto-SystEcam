<?php
// Creación de la conexión a MySQL
$conn = new mysqli("localhost", "root", "", "basesystecam");

// Verificación de la conexión
if ($conn->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    exit();
}

// Consulta para obtener las categorías, laboratorios y ubicaciones únicos para los filtros
$categoriasQuery = "SELECT DISTINCT categoria FROM productos";
$laboratoriosQuery = "SELECT DISTINCT laboratorio FROM productos";
$ubicacionesQuery = "SELECT DISTINCT ubicacion FROM productos"; // Nuevo filtro de ubicación

$categoriasResult = $conn->query($categoriasQuery);
$laboratoriosResult = $conn->query($laboratoriosQuery);
$ubicacionesResult = $conn->query($ubicacionesQuery); // Resultado del filtro de ubicación

// Variables para almacenar los filtros seleccionados
$categoriaFiltro = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$laboratorioFiltro = isset($_GET['laboratorio']) ? $_GET['laboratorio'] : '';
$ubicacionFiltro = isset($_GET['ubicacion']) ? $_GET['ubicacion'] : ''; // Filtro de ubicación
$fechaVencimientoFiltro = isset($_GET['fecha_vencimiento']) ? $_GET['fecha_vencimiento'] : '';
$pronto_vencer = isset($_GET['pronto_vencer']) ? $_GET['pronto_vencer'] : ''; // Filtro "Pronto a Vencer"

// Consulta base para obtener los productos
$query = "SELECT * FROM productos WHERE 1=1";

// Agregar filtros a la consulta SQL
if (!empty($categoriaFiltro)) {
    $query .= " AND categoria = '$categoriaFiltro'";
}
if (!empty($laboratorioFiltro)) {
    $query .= " AND laboratorio = '$laboratorioFiltro'";
}
if (!empty($ubicacionFiltro)) {
    $query .= " AND ubicacion = '$ubicacionFiltro'"; // Aplicar filtro de ubicación
}
if (!empty($fechaVencimientoFiltro)) {
    $query .= " AND fecha_vencimiento >= '$fechaVencimientoFiltro'";
}

// Aplicar filtro de "Pronto a Vencer"
if ($pronto_vencer == '1') {
    $query .= " AND fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)"; // Próximo a vencer (30 días)
} elseif ($pronto_vencer == '2') {
    $query .= " AND fecha_vencimiento < CURDATE()"; // Ya vencidos
}

$resultado = $conn->query($query);

// Verifica si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>SystEcam - Lista de Productos</title>
    <link rel="stylesheet" href="css/consultar.css">
</head>
<body>

    <!-- Encabezado -->
    <header>
        <div class="header-container">
            <img src="img/logo.png" alt="SystEcam" class="logo">
            <h1 class="nombre-software">
                <a href="modulos.php" style="text-decoration: none; color: inherit;">SystEcam</a>
            </h1>
            <div class="dropdown" style="position: absolute; right: 0;">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Menú
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item active" href="modulos.php">Inicio</a></li>
                    <li><a class="dropdown-item" href="#">Venta</a></li>
                    <li><a class="dropdown-item" href="modproducto.php">Producto</a></li>
                    <li><a class="dropdown-item" href="#">Reportes</a></li>
                    <li><a class="dropdown-item" href="#">Clientes</a></li>
                    <li><a class="dropdown-item" href="#">Proveedores</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Cerrar</a></li>
                </ul>
            </div>
        </div>
    </header>
    
    <div class="container">
        <h1 class="text-center">Lista de Productos</h1>

        <!-- Formulario de Filtros -->
        <form method="GET" class="row mb-4">
            <div class="col-md-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select name="categoria" id="categoria" class="form-select">
                    <option value="">Todas</option>
                    <?php while ($fila = $categoriasResult->fetch_assoc()): ?>
                        <option value="<?php echo $fila['categoria']; ?>" <?php if ($fila['categoria'] == $categoriaFiltro) echo 'selected'; ?>>
                            <?php echo $fila['categoria']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="laboratorio" class="form-label">Laboratorio</label>
                <select name="laboratorio" id="laboratorio" class="form-select">
                    <option value="">Todos</option>
                    <?php while ($fila = $laboratoriosResult->fetch_assoc()): ?>
                        <option value="<?php echo $fila['laboratorio']; ?>" <?php if ($fila['laboratorio'] == $laboratorioFiltro) echo 'selected'; ?>>
                            <?php echo $fila['laboratorio']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <select name="ubicacion" id="ubicacion" class="form-select">
                    <option value="">Todas</option>
                    <?php while ($fila = $ubicacionesResult->fetch_assoc()): ?>
                        <option value="<?php echo $fila['ubicacion']; ?>" <?php if ($fila['ubicacion'] == $ubicacionFiltro) echo 'selected'; ?>>
                            <?php echo $fila['ubicacion']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="pronto_vencer" class="form-label">Pronto a Vencer:</label>
                <select name="pronto_vencer" id="pronto_vencer" class="form-select">
                    <option value="">No Filtrar</option>
                    <option value="1" <?php echo $pronto_vencer == '1' ? 'selected' : ''; ?>>Próximo a Vencer (30 días)</option>
                    <option value="2" <?php echo $pronto_vencer == '2' ? 'selected' : ''; ?>>Ya Vencidos</option>
                </select>
            </div>
            <div class="col-12 mt-3 text-center">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>

        <!-- Tabla de productos -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Costo</th>
                    <th>Precio Venta</th>
                    <th>Laboratorio</th>
                    <th>Categoría</th>
                    <th>Ubicación</th>
                    <th>Código INVIMA</th>
                    <th>Fecha de Vencimiento</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado->num_rows > 0): ?>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['id_producto']; ?></td>
                        <td><?php echo $fila['nombre_producto']; ?></td>
                        <td><?php echo $fila['cantidad']; ?></td>
                        <td><?php echo $fila['precio_costo']; ?></td>
                        <td><?php echo $fila['precio_venta']; ?></td>
                        <td><?php echo $fila['laboratorio']; ?></td>
                        <td><?php echo $fila['categoria']; ?></td>
                        <td><?php echo $fila['ubicacion']; ?></td> <!-- Mostrar ubicación -->
                        <td><?php echo $fila['cod_invima']; ?></td>
                        <td><?php echo $fila['fecha_vencimiento']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">No se encontraron productos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-Oj7xyT77K5e5C3G+Be8FYD+X3BqzyoHjTcWbE3F2IbxWzvQxgL7D7Gp1Bq4/cH43" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-6xUukN9zId1woPCpRxz5TT4+yMuSXQOs7PYsmGFX8S8XekI62ZMYK0hH2i4uApXs" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
