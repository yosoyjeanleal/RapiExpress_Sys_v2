<!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>RapiExpress - Couriers</title>
    <link rel="icon" href="assets/img/logo-rapi.ico" type="image/x-icon">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
    
    <!-- JS -->
    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>
</head>
<body>
    <?php include 'src/views/layout/barras.php'; ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="title">
                        <h4>Paquetes</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.php?c=dashboard&a=index">RapiExpress</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Entrada
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

       <div class="card-box mb-30">
    <div class="pd-30">
        <h4 class="text-blue h4">Lista de Paquetes</h4>
        <?php if (isset($_SESSION['mensaje']) && isset($_SESSION['tipo_mensaje'])): ?>
        <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['mensaje']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); endif; ?>

        <div class="pull-right">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#paqueteModal">
                <i class="fa fa-plus"></i> Agregar Paquete
            </button>
        </div>
    </div>

    <div class="pb-30">
        <table class="data-table table stripe hover nowrap" id="paquetesTable">
           <thead>
    <tr>
        <th>Tracking Tienda</th>
        <th>Nuevo Tracking</th>
        <th>Tienda</th>
        <th>Courier</th>
        <th>Peso (Kg)</th>
        <th>Peso (Lb)</th>
        <th>Piezas</th>
        <th>Cliente</th>
        <th>Receptor</th>
        <th>Descripción</th>
        <th>Categoría</th>
        <th>Estado</th>
        <th class="datatable-nosort">Acciones</th>
    </tr>
</thead>

            <tbody>
<?php foreach ($paquetes as $paquete): ?>
<tr>
    <td><?= htmlspecialchars($paquete['tracking_tienda']) ?></td>
    <td><?= htmlspecialchars($paquete['nuevo_tracking']) ?></td>
    <td><?= htmlspecialchars($paquete['nombre_tienda']) ?></td> <!-- Asume join en el controlador -->
    <td><?= htmlspecialchars($paquete['nombre_courier']) ?></td> <!-- Asume join en el controlador -->
    <td><?= htmlspecialchars($paquete['peso_kilogramo']) ?> kg</td>
    <td><?= htmlspecialchars($paquete['peso_libra']) ?> lb</td>
    <td><?= htmlspecialchars($paquete['cantidad_piezas']) ?></td>
    <td><?= htmlspecialchars($paquete['nombre_cliente']) ?></td> <!-- Asume join en el controlador -->
    <td><?= htmlspecialchars($paquete['nombre_receptor'] . ' ' . $paquete['apellido_receptor']) ?></td>
    <td><?= htmlspecialchars($paquete['descripcion']) ?></td>
    <td><?= htmlspecialchars($paquete['categoria']) ?></td>
    <td>
        <span class="badge badge-<?= $paquete['estado'] === 'entregado' ? 'success' : 'warning' ?>">
            <?= ucfirst($paquete['estado']) ?>
        </span>
    </td>
    <td>
        <!-- Acciones dropdown (ya está bien hecho) -->
        ...
    </td>
</tr>
<?php endforeach; ?>
</tbody>

        </table>
    </div>
</div>

<!-- Modal: Registrar Paquete -->
<div class="modal fade" id="paqueteModal" tabindex="-1" role="dialog" aria-labelledby="paqueteModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="index.php?c=paquete&a=registrar">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Nuevo Paquete</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
    <label>Tracking Tienda</label>
    <input type="text" name="tracking_tienda" class="form-control" required>
</div>
<div class="form-group">
    <label>Nuevo Tracking</label>
    <input type="text" name="nuevo_tracking" class="form-control" required>
</div>
<div class="form-group">
    <label>Tienda</label>
    <select name="id_tienda" class="form-control">
        <?php foreach ($tiendas as $tienda): ?>
            <option value="<?= $tienda['id_tienda'] ?>"><?= $tienda['nombre'] ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="form-group">
    <label>Courier</label>
    <select name="id_courier" class="form-control">
        <?php foreach ($couriers as $courier): ?>
            <option value="<?= $courier['id_courier'] ?>"><?= $courier['nombre'] ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="form-group">
    <label>Categoría</label>
    <select name="categoria" class="form-control">
        <option value="4x4">4x4</option>
        <option value="C-Costo">C-Costo</option>
    </select>
</div>
<div class="form-group">
    <label>Peso (Lb)</label>
    <input type="number" step="0.01" name="peso_libra" class="form-control" required>
</div>
<div class="form-group">
    <label>Cantidad de Piezas</label>
    <input type="number" name="cantidad_piezas" class="form-control" required>
</div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Registrar Paquete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modales por cada Paquete -->
<?php foreach ($paquetes as $paquete): ?>
<!-- Ver Paquete -->
<div class="modal fade" id="view-paquete-modal-<?= $paquete['id_paquete'] ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Paquete</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <label>Código:</label>
                <input class="form-control" readonly value="<?= htmlspecialchars($paquete['codigo']) ?>">
                <label>Descripción:</label>
                <textarea class="form-control" readonly><?= htmlspecialchars($paquete['descripcion']) ?></textarea>
                <label>Peso:</label>
                <input class="form-control" readonly value="<?= htmlspecialchars($paquete['peso']) ?>">
                <label>Estado:</label>
                <input class="form-control" readonly value="<?= ucfirst(htmlspecialchars($paquete['estado'])) ?>">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Editar Paquete -->
<div class="modal fade" id="edit-paquete-modal-<?= $paquete['id_paquete'] ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="index.php?c=paquete&a=editar">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Paquete</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_paquete" value="<?= $paquete['id_paquete'] ?>">
                    <label>Código:</label>
                    <input class="form-control" name="codigo" value="<?= htmlspecialchars($paquete['codigo']) ?>" required>
                    <label>Descripción:</label>
                    <textarea class="form-control" name="descripcion" required><?= htmlspecialchars($paquete['descripcion']) ?></textarea>
                    <label>Peso:</label>
                    <input class="form-control" type="number" step="0.01" name="peso" value="<?= htmlspecialchars($paquete['peso']) ?>" required>
                    <label>Estado:</label>
                    <select class="form-control" name="estado">
                        <option value="pendiente" <?= $paquete['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                        <option value="en tránsito" <?= $paquete['estado'] == 'en tránsito' ? 'selected' : '' ?>>En tránsito</option>
                        <option value="entregado" <?= $paquete['estado'] == 'entregado' ? 'selected' : '' ?>>Entregado</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal: Eliminar Paquete -->
<div class="modal fade" id="delete-paquete-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="modal-body">
                <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                <h4 class="mb-3 text-danger">¿Eliminar Paquete?</h4>
                <p class="text-muted">Esta acción no se puede deshacer.</p>
                <form method="POST" action="index.php?c=paquete&a=eliminar">
                    <input type="hidden" name="id" id="delete_paquete_id">
                    <div class="row justify-content-center gap-2">
                        <div class="col-6 px-1">
                            <button type="button" class="btn btn-secondary btn-lg btn-block" data-dismiss="modal">
                                <i class="fa fa-times"></i> No
                            </button>
                        </div>
                        <div class="col-6 px-1">
                            <button type="submit" class="btn btn-danger btn-lg btn-block">
                                <i class="fa fa-check"></i> Sí
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


        <div class="footer-wrap pd-20 mb-20 card-box">
            RapiExpress © 2025 - Sistema de Gestión de Paquetes                
        </div>
    </div>
</div>
</body>
</html>