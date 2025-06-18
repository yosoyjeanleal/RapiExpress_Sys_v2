<?php
// barras.php provides the full HTML structure (<html>, <head>, opening <body>, title)
// This file should only contain the content specific to the client page.
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
                            <h4><?= t('clients_page_title') ?></h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php?c=dashboard&a=index&lang=<?= getCurrentLanguage() ?>"><?= t('breadcrumb_home') ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= t('clients_page_title') ?>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20"> <!-- Changed pd-30 to pd-20 for consistency with dashboard -->
                    <h4 class="text-blue h4"><?= t('clients_list_title') ?></h4>
                    <?php
                    // The old alert display is removed as toasts will be handled by barras.php
                    // if (isset($_SESSION['toast_message']) && isset($_SESSION['toast_type'])):
                    // No direct display here, barras.php handles it via JavaScript
                    // endif;
                    ?>

                    <div class="pull-right">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#clienteModal">
                            <i class="fa fa-user-plus"></i> <?= t('add_client_button') ?>
                        </button>
                    </div>
                </div>
                <div class="pb-20"> <!-- Changed pd-30 to pd-20 -->
                    <table class="data-table table stripe hover nowrap" id="clientesTable">
                        <thead>
                            <tr>
                                <th><?= t('table_header_id_card') ?></th>
                                <th><?= t('table_header_name_lastname') ?></th>
                                <th><?= t('table_header_phone') ?></th>
                                <th><?= t('table_header_email') ?></th>
                                <th><?= t('table_header_status') ?></th>
                                <th><?= t('table_header_registration_date') ?></th>
                                <th class="datatable-nosort"><?= t('table_header_actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?= htmlspecialchars($cliente['cedula']) ?></td>
                                <td class="table-plus"><?= htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido']) ?></td>
                                <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                                <td><?= htmlspecialchars($cliente['email']) ?></td>
                                <td>
                                    <span class="badge badge-<?= $cliente['estado'] == 'activo' ? 'success' : 'danger' ?>">
                                        <?= ucfirst(t($cliente['estado'] == 'activo' ? 'status_active' : 'status_inactive')) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($cliente['fecha_registro'])) ?></td>
                               <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-cliente-modal-<?= $cliente['id_cliente'] ?>">
                                            <i class="dw dw-eye"></i> <?= t('action_view_details') ?>
                                        </a>
                                       <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-cliente-modal-<?= $cliente['id_cliente'] ?>">
                                            <i class="dw dw-edit2"></i> <?= t('action_edit') ?>
                                        </a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-cliente-modal"
                                           onclick="document.getElementById('delete_cliente_id').value = <?= $cliente['id_cliente'] ?>">
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

<!-- Modal para agregar cliente -->
<div class="modal fade" id="clienteModal" tabindex="-1" role="dialog" aria-labelledby="clienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clienteModalLabel"><?= t('modal_register_client_title') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="index.php?c=cliente&a=registrar">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= t('form_label_id_card') ?></label>
                                <input type="text" pattern="\d{6,10}" class="form-control" name="cedula" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= t('form_label_status') ?></label>
                                <select class="form-control" name="estado" required>
                                    <option value="activo" selected><?= t('status_active') ?></option>
                                    <option value="inactivo"><?= t('status_inactive') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= t('form_label_names') ?></label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= t('form_label_lastnames') ?></label>
                                <input type="text" class="form-control" name="apellido" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= t('form_label_email') ?></label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= t('form_label_phone') ?></label>
                                <input type="text" class="form-control" name="telefono" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= t('form_label_address') ?></label>
                        <textarea class="form-control" name="direccion" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t('button_cancel') ?></button>
                    <button type="submit" class="btn btn-primary"><?= t('button_register_client') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalles del Cliente (Solo lectura) -->
<?php foreach ($clientes as $cli): ?>
<div class="modal fade bs-example-modal-lg" id="view-cliente-modal-<?= $cli['id_cliente'] ?>" tabindex="-1" role="dialog" aria-labelledby="viewClientModalLabel-<?= $cli['id_cliente'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="viewClientModalLabel-<?= $cli['id_cliente'] ?>"><?= t('modal_view_client_title') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= t('form_label_id_card') ?></label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($cli['cedula']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= t('form_label_status') ?></label>
                            <input type="text" class="form-control" value="<?= ucfirst(t($cli['estado'] == 'activo' ? 'status_active' : 'status_inactive')) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= t('form_label_names') ?></label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($cli['nombre']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= t('form_label_lastnames') ?></label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($cli['apellido']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= t('form_label_email') ?></label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($cli['email']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= t('form_label_phone') ?></label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($cli['telefono']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= t('form_label_address') ?></label>
                            <textarea class="form-control" rows="3" readonly><?= htmlspecialchars($cli['direccion']) ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= t('table_header_registration_date') ?></label>
                            <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($cli['fecha_registro'])) ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t('button_close') ?></button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal para Editar Cliente -->
<?php foreach ($clientes as $cli): ?>
<div class="modal fade" id="edit-cliente-modal-<?= $cli['id_cliente'] ?>" tabindex="-1" role="dialog" aria-labelledby="editClientModalLabel-<?= $cli['id_cliente'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editClientModalLabel-<?= $cli['id_cliente'] ?>"><?= t('modal_edit_client_title') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">×</button>
            </div>
            <form method="POST" action="index.php?c=cliente&a=editar">
                <div class="modal-body">
                    <input type="hidden" name="id_cliente" value="<?= $cli['id_cliente'] ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <label><?= t('form_label_id_card') ?></label>
                            <input type="text" class="form-control" name="cedula" value="<?= htmlspecialchars($cli['cedula']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label><?= t('form_label_status') ?></label>
                            <select class="form-control" name="estado" required>
                                <option value="activo" <?= $cli['estado'] == 'activo' ? 'selected' : '' ?>><?= t('status_active') ?></option>
                                <option value="inactivo" <?= $cli['estado'] == 'inactivo' ? 'selected' : '' ?>><?= t('status_inactive') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label><?= t('form_label_names') ?></label>
                            <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($cli['nombre']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label><?= t('form_label_lastnames') ?></label>
                            <input type="text" class="form-control" name="apellido" value="<?= htmlspecialchars($cli['apellido']) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label><?= t('form_label_email') ?></label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($cli['email']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label><?= t('form_label_phone') ?></label>
                            <input type="text" class="form-control" name="telefono" value="<?= htmlspecialchars($cli['telefono']) ?>" required>
                        </div>
                    </div>
                    <label><?= t('form_label_address') ?></label>
                    <textarea class="form-control" name="direccion" rows="3" required><?= htmlspecialchars($cli['direccion']) ?></textarea>
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

<!-- Modal para Eliminar Cliente -->
<div class="modal fade" id="delete-cliente-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content text-center p-4">
			<div class="modal-body">
				<i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
				<h4 class="mb-20 font-weight-bold text-danger"><?= t('modal_delete_client_title') ?></h4>
				<p class="mb-30 text-muted"><?= t('modal_delete_client_text') ?></p>

				<form method="POST" action="index.php?c=cliente&a=eliminar">
					<input type="hidden" name="id" id="delete_cliente_id">
					<div class="row justify-content-center gap-2" style="max-width: 200px; margin: 0 auto;">
						<div class="col-6 px-1">
							<button type="button" class="btn btn-secondary btn-lg btn-block border-radius-100" data-dismiss="modal">
								<i class="fa fa-times"></i> <?= t('button_no') ?>
							</button>
						</div>
						<div class="col-6 px-1">
							<button type="submit" class="btn btn-danger btn-lg btn-block border-radius-100">
								<i class="fa fa-check"></i> <?= t('button_yes') ?>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
        </div>
        <div class="footer-wrap pd-20 mb-20 card-box">
            <?= t('footer_text') ?>
        </div>
    </div>
</div>

<?php
// The closing </body> and </html> tags are in barras.php
?>
