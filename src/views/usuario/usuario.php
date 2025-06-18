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
                            <h4><?= t('employees_page_title') ?></h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php?c=dashboard&a=index&lang=<?= getCurrentLanguage() ?>"><?= t('breadcrumb_home') ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= t('employees_page_title') ?>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4"><?= t('user_management_title') ?></h4>
                    <?php
                    // The old alert display is removed as toasts will be handled by barras.php
                    // if (isset($_SESSION['toast_message']) && isset($_SESSION['toast_type'])):
                    // No direct display here, barras.php handles it via JavaScript
                    // endif;
                    ?>

                    <div class="pull-right">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#usuarioModal">
                            <i class="fa fa-user-plus"></i> <?= t('add_user_button') ?>
                        </button>
                    </div>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap" id="usuariosTable">
                        <thead>
                            <tr>
                                <th><?= t('table_header_document') ?></th>
                                <th><?= t('table_header_user') ?></th>
                                <th><?= t('table_header_full_name') ?></th>
                                <th><?= t('table_header_email') ?></th>
                                <th><?= t('table_header_phone') ?></th>
                                <th><?= t('table_header_branch') ?></th>
                                <th><?= t('table_header_role') ?></th>
                                <th class="datatable-nosort"><?= t('table_header_actions') ?></th>
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
                                                <i class="dw dw-eye"></i> <?= t('action_view_details') ?>
                                            </a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-usuario-modal-<?= $usuario['id'] ?>">
                                                <i class="dw dw-edit2"></i> <?= t('action_edit') ?>
                                            </a>
                                            <?php if ($usuario['username'] !== ($_SESSION['usuario'] ?? '')): ?>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-usuario-modal"
                                               onclick="document.getElementById('delete_usuario_id').value = <?= $usuario['id'] ?>">
                                                <i class="dw dw-delete-3"></i> <?= t('action_delete') ?>
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
            </div>

            <!-- Modal para agregar usuario -->
            <div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="usuarioModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="usuarioModalLabel"><?= t('modal_register_user_title') ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="index.php?c=usuario&a=registrar">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_document') ?></label>
                                            <input type="text" pattern="\d{6,10}" class="form-control" name="documento" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_username') ?></label>
                                            <input type="text" class="form-control" name="username" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_names') ?></label>
                                            <input type="text" class="form-control" name="nombres" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_lastnames') ?></label>
                                            <input type="text" class="form-control" name="apellidos" required>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_branch') ?></label>
                                            <select class="form-control" name="sucursal" required>
                                                <option value="" disabled selected><?= t('form_select_branch') ?></option>
                                                <option value="sucursal_usa"><?= t('form_branch_usa') ?></option>
                                                <option value="sucursal_ec"><?= t('form_branch_ecuador') ?></option>
                                                <option value="sucursal_ven"><?= t('form_branch_venezuela') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_role') ?></label>
                                            <select class="form-control" name="cargo" required>
                                                <option value="" disabled selected><?= t('form_select_role') ?></option>
                                                <option value="encargado_bodega"><?= t('form_role_warehouse_manager') ?></option>
                                                <option value="jefe_logistica"><?= t('form_role_logistics_manager') ?></option>
                                                <option value="jefe_operaciones"><?= t('form_role_operations_manager') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_password') ?></label>
                                            <div class="input-group custom mb-0"> <!-- mb-4 removed to avoid extra space if validation appears below -->
                                                <input name="password" type="password" class="form-control form-control-lg password-input" placeholder="<?= t('password_placeholder') ?>" required>
                                                <div class="input-group-append custom toggle-password" style="cursor: pointer;">
                                                    <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t('button_cancel') ?></button>
                                <button type="submit" class="btn btn-primary"><?= t('button_register_user') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal para Eliminar Usuario -->
            <div class="modal fade" id="delete-usuario-modal" tabindex="-1" role="dialog" aria-labelledby="deleteUsuarioModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content text-center p-4">
                        <div class="modal-body">
                            <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                            <h4 class="mb-20 font-weight-bold text-danger" id="deleteUsuarioModalLabel"><?= t('modal_delete_user_title') ?></h4>
                            <p class="mb-30 text-muted"><?= t('modal_delete_user_text') ?></p>
                            <form method="POST" action="index.php?c=usuario&a=eliminar">
                                <input type="hidden" name="id" id="delete_usuario_id">
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

            <!-- Modal para Ver Detalles del Usuario (Solo lectura) -->
            <?php foreach ($usuarios as $usuario_modal): // Renamed to avoid conflict with outer loop variable if any ?>
            <div class="modal fade bs-example-modal-lg" id="view-usuario-modal-<?= $usuario_modal['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="viewUsuarioModalLabel-<?= $usuario_modal['id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="viewUsuarioModalLabel-<?= $usuario_modal['id'] ?>"><?= t('modal_view_user_title') ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= t('form_label_document') ?></label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($usuario_modal['documento']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= t('form_label_username') ?></label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($usuario_modal['username']) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= t('form_label_names') ?></label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($usuario_modal['nombres']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= t('form_label_lastnames') ?></label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($usuario_modal['apellidos']) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= t('form_label_email') ?></label>
                                        <input type="email" class="form-control" value="<?= htmlspecialchars($usuario_modal['email']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= t('form_label_phone') ?></label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($usuario_modal['telefono']) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= t('form_label_branch') ?></label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($usuario_modal['sucursal']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= t('form_label_role') ?></label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($usuario_modal['cargo']) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= t('table_header_registration_date') ?></label>
                                        <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($usuario_modal['fecha_registro'])) ?>" readonly>
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

            <!-- Modal para Editar Usuario -->
            <?php foreach ($usuarios as $usuario_modal_edit): // Renamed variable ?>
            <div class="modal fade" id="edit-usuario-modal-<?= $usuario_modal_edit['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editUsuarioModalLabel-<?= $usuario_modal_edit['id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="editUsuarioModalLabel-<?= $usuario_modal_edit['id'] ?>"><?= t('modal_edit_user_title') ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>">×</button>
                        </div>
                        <form method="POST" action="index.php?c=usuario&a=editar">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $usuario_modal_edit['id'] ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_document') ?></label>
                                            <input type="text" class="form-control" name="documento" value="<?= htmlspecialchars($usuario_modal_edit['documento']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                         <div class="form-group">
                                            <label><?= t('form_label_username') ?></label>
                                            <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($usuario_modal_edit['username']) ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_names') ?></label>
                                            <input type="text" class="form-control" name="nombres" value="<?= htmlspecialchars($usuario_modal_edit['nombres']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_lastnames') ?></label>
                                            <input type="text" class="form-control" name="apellidos" value="<?= htmlspecialchars($usuario_modal_edit['apellidos']) ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_email') ?></label>
                                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($usuario_modal_edit['email']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_phone') ?></label>
                                            <input type="text" class="form-control" name="telefono" value="<?= htmlspecialchars($usuario_modal_edit['telefono']) ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_branch') ?></label>
                                            <select class="form-control" name="sucursal" required>
                                                <option value="sucursal_usa" <?= $usuario_modal_edit['sucursal'] == 'sucursal_usa' ? 'selected' : '' ?>><?= t('form_branch_usa') ?></option>
                                                <option value="sucursal_ec" <?= $usuario_modal_edit['sucursal'] == 'sucursal_ec' ? 'selected' : '' ?>><?= t('form_branch_ecuador') ?></option>
                                                <option value="sucursal_ven" <?= $usuario_modal_edit['sucursal'] == 'sucursal_ven' ? 'selected' : '' ?>><?= t('form_branch_venezuela') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?= t('form_label_role') ?></label>
                                            <select class="form-control" name="cargo" required>
                                                <option value="encargado_bodega" <?= $usuario_modal_edit['cargo'] == 'encargado_bodega' ? 'selected' : '' ?>><?= t('form_role_warehouse_manager') ?></option>
                                                <option value="jefe_logistica" <?= $usuario_modal_edit['cargo'] == 'jefe_logistica' ? 'selected' : '' ?>><?= t('form_role_logistics_manager') ?></option>
                                                <option value="jefe_operaciones" <?= $usuario_modal_edit['cargo'] == 'jefe_operaciones' ? 'selected' : '' ?>><?= t('form_role_operations_manager') ?></option>
                                            </select>
                                        </div>
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
        </div>
        <div class="footer-wrap pd-20 mb-20 card-box">
            <?= t('footer_text') ?>
        </div>
    </div>
</div>
<?php
// The closing </body> and </html> tags are in barras.php
?>
