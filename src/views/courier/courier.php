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
                        <h4>Couriers</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.php?c=dashboard&a=index">RapiExpress</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Couriers
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            <div class="pd-30">
                <h4 class="text-blue h4">Lista de Couriers</h4>
                <?php if (isset($_SESSION['mensaje']) && isset($_SESSION['tipo_mensaje'])): ?>
                <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['mensaje']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php 
                    unset($_SESSION['mensaje']);
                    unset($_SESSION['tipo_mensaje']);
                ?>
                <?php endif; ?>

                <div class="pull-right">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#courierModal">
                        <i class="fa fa-plus"></i> Agregar Courier
                    </button>
                </div>
            </div>
            <div class="pb-30">
                <table class="data-table table stripe hover nowrap" id="couriersTable">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Tipo</th>                            
                            <th class="datatable-nosort">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($couriers as $courier): ?>
                        <tr>
                            <td><?= htmlspecialchars($courier['codigo']) ?></td>
                            <td><?= htmlspecialchars($courier['nombre']) ?></td>
                            <td><?= htmlspecialchars($courier['direccion']) ?></td>
                               <td>
    <?php 
    $badgeClass = 'secondary'; // Por defecto
    switch(strtolower($courier['tipo'])) {
        case 'propio': $badgeClass = 'success'; break;
        case 'asociado': $badgeClass = 'danger'; break;
    }
    ?>
    <span class="badge badge-<?= $badgeClass ?>">
        <?= ucfirst($courier['tipo']) ?>
    </span>
</td>
                            
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-courier-modal-<?= $courier['id_courier'] ?>">
                                            <i class="dw dw-eye"></i> Ver Detalles
                                        </a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-courier-modal-<?= $courier['id_courier'] ?>">
                                            <i class="dw dw-edit2"></i> Editar
                                        </a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-courier-modal" 
                                           onclick="document.getElementById('delete_courier_id').value = <?= $courier['id_courier'] ?>">
                                            <i class="dw dw-delete-3"></i> Eliminar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal para agregar courier -->
        <div class="modal fade" id="courierModal" tabindex="-1" role="dialog" aria-labelledby="courierModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="courierModalLabel">Registrar Nuevo Courier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
<form method="POST" action="index.php?c=courier&a=registrar">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Código</label>
                                        <input type="text" class="form-control" name="codigo" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select class="form-control" name="tipo" required>
                                            <option value="propio">Propio</option>
                                            <option value="asociado">Asociado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" class="form-control" name="nombre" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Dirección</label>
                                <textarea class="form-control" name="direccion" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
<button type="submit" class="btn btn-primary">Registrar Courier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para Ver Detalles del Courier (Solo lectura) -->
        <?php foreach ($couriers as $courier): ?>
        <div class="modal fade bs-example-modal-lg" id="view-courier-modal-<?= $courier['id_courier'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detalles del Courier</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Código</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($courier['codigo']) ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <input type="text" class="form-control" value="<?= ucfirst(htmlspecialchars($courier['tipo'])) ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($courier['nombre']) ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <textarea class="form-control" rows="3" readonly><?= htmlspecialchars($courier['direccion']) ?></textarea>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Modal para Editar Courier -->
        <?php foreach ($couriers as $courier): ?>
        <div class="modal fade" id="edit-courier-modal-<?= $courier['id_courier'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Courier</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
<form method="POST" action="index.php?c=courier&a=editar">
                        <div class="modal-body">
                            <input type="hidden" name="id_courier" value="<?= $courier['id_courier'] ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Código</label>
                                    <input type="text" class="form-control" name="codigo" value="<?= htmlspecialchars($courier['codigo']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Tipo</label>
                                    <select class="form-control" name="tipo" required>
                                        <option value="propio" <?= $courier['tipo'] == 'propio' ? 'selected' : '' ?>>Propio</option>
                                        <option value="asociado" <?= $courier['tipo'] == 'asociado' ? 'selected' : '' ?>>Asociado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($courier['nombre']) ?>" required>
                                </div>
                            </div>
                            <label>Dirección</label>
                            <textarea class="form-control" name="direccion" rows="3" required><?= htmlspecialchars($courier['direccion']) ?></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Modal para Eliminar Courier -->
        <div class="modal fade" id="delete-courier-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center p-4">
                    <div class="modal-body">
                        <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                        <h4 class="mb-20 font-weight-bold text-danger">¿Eliminar Courier?</h4>
                        <p class="mb-30 text-muted">Esta acción no se puede deshacer. <br>¿Está seguro que desea eliminar este courier?</p>

                        <form method="POST" action="index.php?c=courier&a=eliminar">
                            <input type="hidden" name="id" id="delete_courier_id">
                            <div class="row justify-content-center gap-2" style="max-width: 200px; margin: 0 auto;">
                                <div class="col-6 px-1">
                                    <button type="button" class="btn btn-secondary btn-lg btn-block border-radius-100" data-dismiss="modal">
                                        <i class="fa fa-times"></i> No
                                    </button>
                                </div>
                                <div class="col-6 px-1">
                                    <button type="submit" class="btn btn-danger btn-lg btn-block border-radius-100">
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