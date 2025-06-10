<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>RapiExpress</title>
		<link rel="icon" href="assets\img\logo-rapi.ico" type="image/x-icon">



		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

			<?php include 'src\views\layout\barras.php'; ?>

		
		 
	</head>
	<body>
		 

		
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			
				
					<div class="page-header">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="title">
									<h4>Empleados</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="index.php?c=dashboard&a=index">RapiExpress</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Empleados
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
							
		
	
<div class="card-box mb-30">
    <div class="pd-30">
        <h4 class="text-blue h4">Gestión de Usuarios</h4>
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
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#usuarioModal">
                <i class="fa fa-user-plus"></i> Agregar Usuario
            </button>
        </div>
    </div>
    <div class="pb-30">
    <table class="data-table table stripe hover nowrap" id="usuariosTable">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Usuario</th>
                <th>Nombre Completo</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Sucursal</th>
                <th>Cargo</th>
                <th class="datatable-nosort">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['documento']) ?></td>
                <td><?= isset($usuario['username']) ? htmlspecialchars($usuario['username']) : ''; ?></td>
                <td><?= htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']) ?></td>
                <td><?= htmlspecialchars($usuario['email']) ?></td>
                <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                <td><?= htmlspecialchars($usuario['sucursal']) ?></td>
                <td><?= htmlspecialchars($usuario['cargo']) ?></td>
                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-usuario-modal-<?= $usuario['id'] ?>">
                                <i class="dw dw-eye"></i> Ver Detalles
                            </a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-usuario-modal-<?= $usuario['id'] ?>">
                                <i class="dw dw-edit2"></i> Editar
                            </a>
                            <?php if ($usuario['username'] !== $_SESSION['usuario']): ?>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-usuario-modal" 
                               onclick="document.getElementById('delete_usuario_id').value = <?= $usuario['id'] ?>">
                                <i class="dw dw-delete-3"></i> Eliminar
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para agregar usuario -->
<div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="usuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="usuarioModalLabel">Registrar Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="index.php?c=usuario&a=registrar">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Documento</label>
                                <input type="text" pattern="\d{6,10}" class="form-control" name="documento" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombres</label>
                                <input type="text" class="form-control" name="nombres" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correo Electrónico</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" class="form-control" name="telefono" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sucursal</label>
                                <select class="form-control" name="sucursal" required>
                                    <option value="" disabled selected>Seleccionar Sucursal</option>
                                    <option value="sucursal_usa">USA</option>
                                    <option value="sucursal_ec">Ecuador</option>
                                    <option value="sucursal_ven">Venezuela</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cargo</label>
                                <select class="form-control" name="cargo" required>
                                    <option value="" disabled selected>Seleccionar Cargo</option>
                                    <option value="encargado_bodega">Encargado Bodega</option>
                                    <option value="jefe_logistica">Jefe Logística</option>
                                    <option value="jefe_operaciones">Jefe Operaciones</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
  <!-- Contraseña -->
  <div class="col-md-6">
    <div class="form-group">
      <label>Contraseña</label>
       <div class="input-group custom mb-4">
    <input name="password" type="password" class="form-control form-control-lg password-input" placeholder="Contraseña" required>
    <div class="input-group-append custom toggle-password" style="cursor: pointer;">
      <span class="input-group-text"><i class="fa fa-eye"></i></span>
    </div>
  </div>
    </div>
  </div>
  
 
</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Modal para Eliminar Usuario -->
<div class="modal fade" id="delete-usuario-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center p-4">
            <div class="modal-body">
                <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                <h4 class="mb-20 font-weight-bold text-danger">¿Eliminar Usuario?</h4>
                <p class="mb-30 text-muted">Esta acción no se puede deshacer. <br>¿Está seguro que desea eliminar este usuario?</p>

                <form method="POST" action="index.php?c=usuario&a=eliminar">
                    <input type="hidden" name="id" id="delete_usuario_id">
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
<!-- Modal para Ver Detalles del Usuario (Solo lectura) -->
<?php foreach ($usuarios as $usuario): ?>
<div class="modal fade bs-example-modal-lg" id="view-usuario-modal-<?= $usuario['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalles del Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Documento</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['documento']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['username']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['nombres']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['apellidos']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Correo Electrónico</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['telefono']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sucursal</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['sucursal']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cargo</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['cargo']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Registro</label>
                            <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?>" readonly>
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

<!-- Modal para Editar Usuario -->
<?php foreach ($usuarios as $usuario): ?>
<div class="modal fade" id="edit-usuario-modal-<?= $usuario['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form method="POST" action="index.php?c=usuario&a=editar">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Documento</label>
                            <input type="text" class="form-control" name="documento" value="<?= htmlspecialchars($usuario['documento']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($usuario['username']) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nombres</label>
                            <input type="text" class="form-control" name="nombres" value="<?= htmlspecialchars($usuario['nombres']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" value="<?= htmlspecialchars($usuario['apellidos']) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Correo Electrónico</label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Sucursal</label>
                            <select class="form-control" name="sucursal" required>
                                <option value="sucursal_usa" <?= $usuario['sucursal'] == 'sucursal_usa' ? 'selected' : '' ?>>USA</option>
                                <option value="sucursal_ec" <?= $usuario['sucursal'] == 'sucursal_ec' ? 'selected' : '' ?>>Ecuador</option>
                                <option value="sucursal_ven" <?= $usuario['sucursal'] == 'sucursal_ven' ? 'selected' : '' ?>>Venezuela</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Cargo</label>
                            <select class="form-control" name="cargo" required>
                                <option value="encargado_bodega" <?= $usuario['cargo'] == 'encargado_bodega' ? 'selected' : '' ?>>Encargado Bodega</option>
                                <option value="jefe_logistica" <?= $usuario['cargo'] == 'jefe_logistica' ? 'selected' : '' ?>>Jefe Logística</option>
                                <option value="jefe_operaciones" <?= $usuario['cargo'] == 'jefe_operaciones' ? 'selected' : '' ?>>Jefe Operaciones</option>
                            </select>
                        </div>
                    </div>
                    
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
				
				<div class="footer-wrap pd-20 mb-20 card-box">
					RapiExpress © 2025 - Sistema de Gestión de Paquetes				
				</div>
			</div>
		</div>
  

		 
	</body>
</html>
