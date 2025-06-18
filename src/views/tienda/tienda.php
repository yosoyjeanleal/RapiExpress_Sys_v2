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
                            <h4><?= t('stores_page_title') ?></h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php?c=dashboard&a=index&lang=<?= getCurrentLanguage() ?>"><?= t('breadcrumb_home') ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= t('stores_page_title') ?>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <?php /* <div class="title pb-20"><h2 class="h3 mb-0"><?= t('stores_page_title') ?></h2></div> */ ?>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4"><?= t('stores_list_title') ?></h4>
                    <?php
                    // The old alert display is removed as toasts will be handled by barras.php
                    // if (isset($_SESSION['toast_message']) && isset($_SESSION['toast_type'])):
                    // No direct display here, barras.php handles it via JavaScript
                    // endif;
                    ?>
                    <div class="pull-right">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tiendaModal">
                            <i class="fa fa-store"></i> <?= t('add_store_button') ?>
                        </button>
                    </div>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap" id="tiendasTable">
                        <thead>
                            <tr>
                                <th><?= t('table_header_id') ?></th>
                                <th><?= t('table_header_tracking') ?></th>
                                <th><?= t('table_header_name') ?></th>
                                <th class="datatable-nosort"><?= t('table_header_actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tiendas as $tienda): ?>
                            <tr>
                                <td><?= htmlspecialchars($tienda['id_tienda']) ?></td>
                                <td><?= htmlspecialchars($tienda['tracking']) ?></td>
                                <td class="table-plus"><?= htmlspecialchars($tienda['nombre_tienda']) ?></td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-tienda-modal-<?= $tienda['id_tienda'] ?>">
                                                <i class="dw dw-eye"></i> <?= t('action_view_details') ?>
                                            </a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-tienda-modal-<?= $tienda['id_tienda'] ?>">
                                                <i class="dw dw-edit2"></i> <?= t('action_edit') ?>
                                            </a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-tienda-modal"
                                               onclick="setDeleteId(<?= $tienda['id_tienda'] ?>)">
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

            <!-- Modal Agregar Tienda -->
            <div class="modal fade" id="tiendaModal" tabindex="-1" role="dialog" aria-labelledby="tiendaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="POST" action="index.php?c=tienda&a=registrar">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tiendaModalLabel"><?= t('modal_register_store_title') ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_store_name') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="nombre_tienda" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_tracking_code') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="tracking" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t('button_cancel') ?></button>
                                <button type="submit" class="btn btn-primary"><?= t('button_register_store') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php foreach ($tiendas as $ti): ?>
            <!-- Modal Ver Detalles -->
            <div class="modal fade" id="view-tienda-modal-<?= $ti['id_tienda'] ?>" tabindex="-1" role="dialog" aria-labelledby="viewTiendaModalLabel-<?= $ti['id_tienda'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="viewTiendaModalLabel-<?= $ti['id_tienda'] ?>"><?= t('modal_view_store_title') ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><?= t('table_header_id') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $ti['id_tienda'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><?= t('table_header_tracking') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $ti['tracking'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><?= t('table_header_name') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $ti['nombre_tienda'] ?>" readonly>
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
            <div class="modal fade" id="edit-tienda-modal-<?= $ti['id_tienda'] ?>" tabindex="-1" role="dialog" aria-labelledby="editTiendaModalLabel-<?= $ti['id_tienda'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" action="index.php?c=tienda&a=editar">
                            <div class="modal-header">
                                <h4 class="modal-title" id="editTiendaModalLabel-<?= $ti['id_tienda'] ?>"><?= t('modal_edit_store_title') ?></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id_tienda" value="<?= $ti['id_tienda'] ?>">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_store_name') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="nombre_tienda" value="<?= $ti['nombre_tienda'] ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><?= t('form_label_tracking_code') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="tracking" value="<?= $ti['tracking'] ?>" required>
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

            <div class="modal fade" id="delete-tienda-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" action="index.php?c=tienda&a=eliminar" id="delete-tienda-form">
                            <div class="modal-body text-center font-18">
                                <h4 class="padding-top-30 mb-30 weight-500"><?= t('modal_delete_store_title') ?></h4>
                                <p class="text-danger"><?= t('modal_delete_store_text') ?></p>
                                <input type="hidden" name="id_tienda" id="delete_tienda_id">
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
                document.getElementById('delete_tienda_id').value = id;
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

<?php foreach ($tiendas as $ti): ?>
<!-- Modal Ver Detalles -->
<div class="modal fade" id="view-tienda-modal-<?= $ti['id_tienda'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalles de la Tienda</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">ID</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= $ti['id_tienda'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tracking</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= $ti['tracking'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nombre</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= $ti['nombre_tienda'] ?>" readonly>
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
<div class="modal fade" id="edit-tienda-modal-<?= $ti['id_tienda'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="index.php?c=tienda&a=editar">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Tienda</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_tienda" value="<?= $ti['id_tienda'] ?>">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nombre_tienda" value="<?= $ti['nombre_tienda'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tracking</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="tracking" value="<?= $ti['tracking'] ?>" required>
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


<div class="modal fade" id="delete-tienda-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="index.php?c=tienda&a=eliminar" id="delete-tienda-form">
                <div class="modal-body text-center font-18">
                    <h4 class="padding-top-30 mb-30 weight-500">¿Está seguro que desea eliminar esta tienda?</h4>
                    <p class="text-danger">Esta acción no se puede deshacer y eliminará todos los datos asociados.</p>
                    <input type="hidden" name="id_tienda" id="delete_tienda_id">
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
    document.getElementById('delete_tienda_id').value = id;
}
</script>





				
				<div class="footer-wrap pd-20 mb-20 card-box">
					RapiExpress © 2025 - Sistema de Gestión de Paquetes				
				</div>
			</div>
		</div>
	 
	 
		 
	</body>
</html>
