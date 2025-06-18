<?php
// barras.php provides the full HTML structure
include 'src/views/layout/barras.php';
?>

<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="title">
                            <h4><?= t('branches_page_title') ?></h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php?c=dashboard&a=index&lang=<?= getCurrentLanguage() ?>"><?= t('breadcrumb_home') ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= t('branches_page_title') ?>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <?php /* <div class="title pb-20"><h2 class="h3 mb-0"><?= t('branches_page_title') ?></h2></div> */ ?>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4"><?= t('branches_list_title') ?></h4>
                    <?php if (isset($_SESSION['mensaje']) && isset($_SESSION['tipo_mensaje'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_SESSION['mensaje']); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="<?= t('button_close') ?>">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
                    <?php endif; ?>
                    <div class="pull-right">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sucursalModal">
                            <i class="fa fa-building"></i> <?= t('add_branch_button') ?>
                        </button>
                    </div>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap" id="sucursalesTable">
                        <thead>
                            <tr>
                                <th><?= t('table_header_id') ?></th>
                                <th><?= t('table_header_code') ?></th>
                                <th><?= t('table_header_name') ?></th>
                                <th><?= t('table_header_address') ?></th>
                                <th><?= t('table_header_phone') ?></th>
                                <th class="datatable-nosort"><?= t('table_header_actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sucursales as $sucursal): ?>
                            <tr>
                                <td><?= htmlspecialchars($sucursal['id_sucursal']) ?></td>
                                <td><?= htmlspecialchars($sucursal['codigo']) ?></td>
                                <td class="table-plus"><?= htmlspecialchars($sucursal['nombre_sucursal']) ?></td>
                                <td><?= htmlspecialchars($sucursal['direccion']) ?></td>
                                <td><?= htmlspecialchars($sucursal['telefono']) ?></td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-sucursal-modal-<?= $sucursal['id_sucursal'] ?>">
                                                <i class="dw dw-eye"></i> <?= t('action_view_details') ?>
                                            </a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-sucursal-modal-<?= $sucursal['id_sucursal'] ?>">
                                                <i class="dw dw-edit2"></i> <?= t('action_edit') ?>
                                            </a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-sucursal-modal"
                                               onclick="setDeleteId(<?= $sucursal['id_sucursal'] ?>)">
                                                <i class="dw dw-delete-3"></i> <?= t('action_delete') ?>
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

            <!-- Modal Agregar Sucursal -->
            <div class="modal fade" id="sucursalModal" tabindex="-1" role="dialog" aria-labelledby="sucursalModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="POST" action="index.php?c=sucursal&a=registrar">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sucursalModalLabel"><?= t('modal_register_branch_title') ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_name') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="nombre_sucursal" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_code') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="codigo" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_address') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="direccion" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_phone') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="telefono" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t('button_cancel') ?></button>
                                <button type="submit" class="btn btn-primary"><?= t('button_register_branch') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php foreach ($sucursales as $suc): ?>
            <!-- Modal Ver Detalles -->
            <div class="modal fade" id="view-sucursal-modal-<?= $suc['id_sucursal'] ?>" tabindex="-1" role="dialog" aria-labelledby="viewSucursalModalLabel-<?= $suc['id_sucursal'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="viewSucursalModalLabel-<?= $suc['id_sucursal'] ?>"><?= t('modal_view_branch_title') ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><?= t('table_header_id') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $suc['id_sucursal'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><?= t('table_header_code') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $suc['codigo'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><?= t('table_header_name') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $suc['nombre_sucursal'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><?= t('table_header_address') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $suc['direccion'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><?= t('table_header_phone') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $suc['telefono'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t('button_close') ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Editar -->
            <div class="modal fade" id="edit-sucursal-modal-<?= $suc['id_sucursal'] ?>" tabindex="-1" role="dialog" aria-labelledby="editSucursalModalLabel-<?= $suc['id_sucursal'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" action="index.php?c=sucursal&a=editar">
                            <div class="modal-header">
                                <h4 class="modal-title" id="editSucursalModalLabel-<?= $suc['id_sucursal'] ?>"><?= t('modal_edit_branch_title') ?></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id_sucursal" value="<?= $suc['id_sucursal'] ?>">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_name') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="nombre_sucursal" value="<?= $suc['nombre_sucursal'] ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_code') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="codigo" value="<?= $suc['codigo'] ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_address') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="direccion" value="<?= $suc['direccion'] ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_phone') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="telefono" value="<?= $suc['telefono'] ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t('button_cancel') ?></button>
                                <button type="submit" class="btn btn-primary"><?= t('button_save_changes') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Modal Eliminar -->
            <div class="modal fade" id="delete-sucursal-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" action="index.php?c=sucursal&a=eliminar" id="delete-sucursal-form">
                            <div class="modal-body text-center font-18">
                                <h4 class="padding-top-30 mb-30 weight-500"><?= t('modal_delete_branch_title') ?></h4>
                                <p class="text-danger"><?= t('modal_delete_branch_text') ?></p>
                                <input type="hidden" name="id_sucursal" id="delete_sucursal_id">
                                <div id="delete-error-message" class="alert alert-danger d-none mb-3"></div>
                                <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-secondary border-radius-100 btn-block" data-dismiss="modal">
                                            <i class="fa fa-times"></i> <?= t('button_no') ?>
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-danger border-radius-100 btn-block" id="confirm-delete">
                                            <i class="fa fa-check"></i> <?= t('button_yes') ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
            function setDeleteId(id) {
                document.getElementById('delete_sucursal_id').value = id;
            }
            </script>
        </div>
        <div class="footer-wrap pd-20 mb-20 card-box">
            <?= t('footer_text') ?>
        </div>
    </div>
</div>
<?php
// The closing </body> and </html> tags are in barras.php
?>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($sucursales as $suc): ?>
<!-- Modal Ver Detalles -->
<div class="modal fade" id="view-sucursal-modal-<?= $suc['id_sucursal'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalles de la Sucursal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">ID</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= $suc['id_sucursal'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Código</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= $suc['codigo'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nombre</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= $suc['nombre_sucursal'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Dirección</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= $suc['direccion'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Teléfono</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= $suc['telefono'] ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="edit-sucursal-modal-<?= $suc['id_sucursal'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="index.php?c=sucursal&a=editar">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Sucursal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sucursal" value="<?= $suc['id_sucursal'] ?>">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nombre_sucursal" value="<?= $suc['nombre_sucursal'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Código</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="codigo" value="<?= $suc['codigo'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Dirección</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="direccion" value="<?= $suc['direccion'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Teléfono</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="telefono" value="<?= $suc['telefono'] ?>" required>
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

<!-- Modal Eliminar -->
<div class="modal fade" id="delete-sucursal-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="index.php?c=sucursal&a=eliminar" id="delete-sucursal-form">
                <div class="modal-body text-center font-18">
                    <h4 class="padding-top-30 mb-30 weight-500">¿Está seguro que desea eliminar esta sucursal?</h4>
                    <p class="text-danger">Esta acción no se puede deshacer y eliminará todos los datos asociados.</p>
                    <input type="hidden" name="id_sucursal" id="delete_sucursal_id">
                    <div id="delete-error-message" class="alert alert-danger d-none mb-3"></div>
                    <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                        <div class="col-6">
                            <button type="button" class="btn btn-secondary border-radius-100 btn-block" data-dismiss="modal">
                                <i class="fa fa-times"></i> NO
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-danger border-radius-100 btn-block" id="confirm-delete">
                                <i class="fa fa-check"></i> SI
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setDeleteId(id) {
    document.getElementById('delete_sucursal_id').value = id;
}
</script>

<div class="footer-wrap pd-20 mb-20 card-box">
    RapiExpress © 2025 - Sistema de Gestión de Paquetes                
</div>
			</div>
		</div>
	</body>
</html>