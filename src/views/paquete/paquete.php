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
                            <h4><?= t('packages_page_title') ?></h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php?c=dashboard&a=index&lang=<?= getCurrentLanguage() ?>"><?= t('breadcrumb_home') ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= t('package_entry_breadcrumb') ?>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4"><?= t('packages_list_title') ?></h4>
                    <?php
                    // The old alert display is removed as toasts will be handled by barras.php
                    // if (isset($_SESSION['toast_message']) && isset($_SESSION['toast_type'])):
                    // No direct display here, barras.php handles it via JavaScript
                    // endif;
                    ?>

                    <div class="pull-right">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#paqueteModal">
                            <i class="fa fa-plus"></i> <?= t('add_package_button') ?>
                        </button>
                    </div>
                </div>

                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap" id="paquetesTable">
                       <thead>
                            <tr>
                                <th><?= t('table_header_store_tracking') ?></th>
                                <th><?= t('table_header_new_tracking') ?></th>
                                <th><?= t('table_header_store') ?></th>
                                <th><?= t('nav_courier') ?></th>
                                <th><?= t('table_header_weight_kg') ?></th>
                                <th><?= t('table_header_weight_lb') ?></th>
                                <th><?= t('table_header_pieces') ?></th>
                                <th><?= t('table_header_client') ?></th>
                                <th><?= t('table_header_receiver') ?></th>
                                <th><?= t('table_header_description') ?></th>
                                <th><?= t('table_header_category') ?></th>
                                <th><?= t('table_header_status') ?></th>
                                <th class="datatable-nosort"><?= t('table_header_actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paquetes as $paquete): ?>
                            <tr>
                                <td><?= htmlspecialchars($paquete['tracking_tienda']) ?></td>
                                <td><?= htmlspecialchars($paquete['nuevo_tracking']) ?></td>
                                <td><?= htmlspecialchars($paquete['nombre_tienda']) ?></td>
                                <td><?= htmlspecialchars($paquete['nombre_courier']) ?></td>
                                <td><?= htmlspecialchars($paquete['peso_kilogramo']) ?> kg</td>
                                <td><?= htmlspecialchars($paquete['peso_libra']) ?> lb</td>
                                <td><?= htmlspecialchars($paquete['cantidad_piezas']) ?></td>
                                <td><?= htmlspecialchars($paquete['nombre_cliente']) ?></td>
                                <td><?= htmlspecialchars($paquete['nombre_receptor'] . ' ' . $paquete['apellido_receptor']) ?></td>
                                <td><?= htmlspecialchars($paquete['descripcion']) ?></td>
                                <td><?= htmlspecialchars($paquete['categoria']) ?></td>
                                <td>
                                    <?php
                                        $status_key = 'package_status_' . str_replace(' ', '_', strtolower($paquete['estado'] ?? 'entry'));
                                        $badge_class = 'warning'; // Default
                                        if ($paquete['estado'] === 'entregado') $badge_class = 'success';
                                        if ($paquete['estado'] === 'en tránsito') $badge_class = 'info';
                                        if ($paquete['estado'] === 'pendiente') $badge_class = 'secondary';
                                    ?>
                                    <span class="badge badge-<?= $badge_class ?>">
                                        <?= ucfirst(t($status_key, $paquete['estado'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-paquete-modal-<?= $paquete['id_paquete'] ?>">
                                                <i class="dw dw-eye"></i> <?= t('action_view_details') ?>
                                            </a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-paquete-modal-<?= $paquete['id_paquete'] ?>">
                                                <i class="dw dw-edit2"></i> <?= t('action_edit') ?>
                                            </a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-paquete-modal"
                                               onclick="document.getElementById('delete_paquete_id').value = <?= $paquete['id_paquete'] ?>">
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

            <!-- Modal: Registrar Paquete -->
            <div class="modal fade" id="paqueteModal" tabindex="-1" role="dialog" aria-labelledby="paqueteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="POST" action="index.php?c=paquete&a=registrar">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paqueteModalLabel"><?= t('modal_register_package_title') ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label><?= t('form_label_store_tracking') ?></label>
                                    <input type="text" name="tracking_tienda" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_new_tracking') ?></label>
                                    <input type="text" name="nuevo_tracking" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_store_select') ?></label>
                                    <select name="id_tienda" class="form-control">
                                        <?php foreach ($tiendas as $tienda): ?>
                                            <option value="<?= $tienda['id_tienda'] ?>"><?= htmlspecialchars($tienda['nombre_tienda']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_courier_select') ?></label>
                                    <select name="id_courier" class="form-control">
                                        <?php foreach ($couriers as $courier): ?>
                                            <option value="<?= $courier['id_courier'] ?>"><?= htmlspecialchars($courier['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_category') ?></label>
                                    <select name="categoria" class="form-control">
                                        <option value="4x4"><?= t('form_label_category_4x4') ?></option>
                                        <option value="C-Costo"><?= t('form_label_category_c_cost') ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_weight_lb') ?></label>
                                    <input type="number" step="0.01" name="peso_libra" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_pieces_quantity') ?></label>
                                    <input type="number" name="cantidad_piezas" class="form-control" required>
                                </div>
                                <!-- Campos adicionales para cliente y receptor, descripción, sede y estado deben agregarse aquí -->
                                <div class="form-group">
                                    <label><?= t('table_header_client') ?></label>
                                     <select name="id_cliente" class="form-control" required>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <option value="<?= $cliente['id_cliente'] ?>"><?= htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido']) ?> (<?= htmlspecialchars($cliente['cedula']) ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?= t('table_header_receiver') ?> (<?= t('form_label_names') ?>)</label>
                                    <input type="text" name="nombre_receptor" class="form-control" required>
                                </div>
                                 <div class="form-group">
                                    <label><?= t('table_header_receiver') ?> (<?= t('form_label_lastnames') ?>)</label>
                                    <input type="text" name="apellido_receptor" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_description') ?></label>
                                    <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                                </div>
                                 <div class="form-group">
                                    <label><?= t('nav_branches') ?></label> <!-- Sede / Branch -->
                                     <select name="sede" class="form-control" required>
                                        <?php foreach ($sucursales as $sucursal): ?>
                                            <option value="<?= $sucursal['id_sucursal'] ?>"><?= htmlspecialchars($sucursal['nombre_sucursal']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <input type="hidden" name="estado" value="entrada">


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t('button_cancel') ?></button>
                                <button class="btn btn-primary" type="submit"><?= t('button_register_package') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modales por cada Paquete -->
            <?php foreach ($paquetes as $paquete): ?>
            <!-- Ver Paquete -->
            <div class="modal fade" id="view-paquete-modal-<?= $paquete['id_paquete'] ?>" tabindex="-1" aria-labelledby="viewPaqueteModalLabel-<?= $paquete['id_paquete'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewPaqueteModalLabel-<?= $paquete['id_paquete'] ?>"><?= t('modal_view_package_title') ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p><strong><?= t('form_label_store_tracking') ?>:</strong> <?= htmlspecialchars($paquete['tracking_tienda']) ?></p>
                            <p><strong><?= t('form_label_new_tracking') ?>:</strong> <?= htmlspecialchars($paquete['nuevo_tracking']) ?></p>
                            <p><strong><?= t('table_header_store') ?>:</strong> <?= htmlspecialchars($paquete['nombre_tienda']) ?></p>
                            <p><strong><?= t('nav_courier') ?>:</strong> <?= htmlspecialchars($paquete['nombre_courier']) ?></p>
                            <p><strong><?= t('table_header_weight_lb') ?>:</strong> <?= htmlspecialchars($paquete['peso_libra']) ?></p>
                            <p><strong><?= t('table_header_weight_kg') ?>:</strong> <?= htmlspecialchars($paquete['peso_kilogramo']) ?></p>
                            <p><strong><?= t('table_header_pieces') ?>:</strong> <?= htmlspecialchars($paquete['cantidad_piezas']) ?></p>
                            <p><strong><?= t('table_header_client') ?>:</strong> <?= htmlspecialchars($paquete['nombre_cliente']) ?></p>
                            <p><strong><?= t('table_header_receiver') ?>:</strong> <?= htmlspecialchars($paquete['nombre_receptor'] . ' ' . $paquete['apellido_receptor']) ?></p>
                            <p><strong><?= t('form_label_description') ?>:</strong> <?= htmlspecialchars($paquete['descripcion']) ?></p>
                            <p><strong><?= t('table_header_category') ?>:</strong> <?= htmlspecialchars($paquete['categoria']) ?></p>
                            <p><strong><?= t('table_header_status') ?>:</strong>
                                <?php
                                    $status_key_view = 'package_status_' . str_replace(' ', '_', strtolower($paquete['estado'] ?? 'entry'));
                                ?>
                                <?= ucfirst(t($status_key_view, $paquete['estado'])) ?>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t('button_close') ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Editar Paquete -->
            <div class="modal fade" id="edit-paquete-modal-<?= $paquete['id_paquete'] ?>" tabindex="-1" aria-labelledby="editPaqueteModalLabel-<?= $paquete['id_paquete'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="POST" action="index.php?c=paquete&a=editar">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPaqueteModalLabel-<?= $paquete['id_paquete'] ?>"><?= t('modal_edit_package_title') ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="<?= t('button_close') ?>"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id_paquete" value="<?= $paquete['id_paquete'] ?>">
                                <div class="form-group">
                                    <label><?= t('form_label_store_tracking') ?></label>
                                    <input type="text" name="tracking_tienda" class="form-control" value="<?= htmlspecialchars($paquete['tracking_tienda']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_new_tracking') ?></label>
                                    <input type="text" name="nuevo_tracking" class="form-control" value="<?= htmlspecialchars($paquete['nuevo_tracking']) ?>" required>
                                </div>
                                 <div class="form-group">
                                    <label><?= t('form_label_store_select') ?></label>
                                    <select name="id_tienda" class="form-control">
                                        <?php foreach ($tiendas as $tienda): ?>
                                            <option value="<?= $tienda['id_tienda'] ?>" <?= ($tienda['id_tienda'] == $paquete['id_tienda']) ? 'selected' : '' ?>><?= htmlspecialchars($tienda['nombre_tienda']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_courier_select') ?></label>
                                    <select name="id_courier" class="form-control">
                                        <?php foreach ($couriers as $courier): ?>
                                            <option value="<?= $courier['id_courier'] ?>" <?= ($courier['id_courier'] == $paquete['id_courier']) ? 'selected' : '' ?>><?= htmlspecialchars($courier['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_category') ?></label>
                                    <select name="categoria" class="form-control">
                                        <option value="4x4" <?= ($paquete['categoria'] == '4x4') ? 'selected' : '' ?>><?= t('form_label_category_4x4') ?></option>
                                        <option value="C-Costo" <?= ($paquete['categoria'] == 'C-Costo') ? 'selected' : '' ?>><?= t('form_label_category_c_cost') ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_weight_lb') ?></label>
                                    <input type="number" step="0.01" name="peso_libra" class="form-control" value="<?= htmlspecialchars($paquete['peso_libra']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_pieces_quantity') ?></label>
                                    <input type="number" name="cantidad_piezas" class="form-control" value="<?= htmlspecialchars($paquete['cantidad_piezas']) ?>" required>
                                </div>
                                  <div class="form-group">
                                    <label><?= t('table_header_client') ?></label>
                                     <select name="id_cliente" class="form-control" required>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <option value="<?= $cliente['id_cliente'] ?>" <?= ($cliente['id_cliente'] == $paquete['id_cliente']) ? 'selected' : '' ?>><?= htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido']) ?> (<?= htmlspecialchars($cliente['cedula']) ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?= t('table_header_receiver') ?> (<?= t('form_label_names') ?>)</label>
                                    <input type="text" name="nombre_receptor" class="form-control" value="<?= htmlspecialchars($paquete['nombre_receptor']) ?>" required>
                                </div>
                                 <div class="form-group">
                                    <label><?= t('table_header_receiver') ?> (<?= t('form_label_lastnames') ?>)</label>
                                    <input type="text" name="apellido_receptor" class="form-control" value="<?= htmlspecialchars($paquete['apellido_receptor']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_description') ?></label>
                                    <textarea name="descripcion" class="form-control" rows="3" required><?= htmlspecialchars($paquete['descripcion']) ?></textarea>
                                </div>
                                 <div class="form-group">
                                    <label><?= t('nav_branches') ?></label> <!-- Sede / Branch -->
                                     <select name="sede" class="form-control" required>
                                        <?php foreach ($sucursales as $sucursal): ?>
                                            <option value="<?= $sucursal['id_sucursal'] ?>" <?= ($sucursal['id_sucursal'] == $paquete['sede']) ? 'selected' : '' ?>><?= htmlspecialchars($sucursal['nombre_sucursal']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?= t('form_label_status_select') ?></label>
                                    <select class="form-control" name="estado">
                                        <option value="entrada" <?= $paquete['estado'] == 'entrada' ? 'selected' : '' ?>><?= t('package_status_entry') ?></option>
                                        <option value="en tránsito" <?= $paquete['estado'] == 'en tránsito' ? 'selected' : '' ?>><?= t('package_status_in_transit') ?></option>
                                        <option value="pendiente" <?= $paquete['estado'] == 'pendiente' ? 'selected' : '' ?>><?= t('package_status_pending') ?></option>
                                        <option value="entregado" <?= $paquete['estado'] == 'entregado' ? 'selected' : '' ?>><?= t('package_status_delivered') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t('button_cancel') ?></button>
                                <button class="btn btn-primary" type="submit"><?= t('button_save_changes') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Modal: Eliminar Paquete -->
            <div class="modal fade" id="delete-paquete-modal" tabindex="-1" aria-labelledby="deletePaqueteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-center p-4">
                        <div class="modal-body">
                            <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                            <h4 class="mb-3 text-danger" id="deletePaqueteModalLabel"><?= t('modal_delete_package_title') ?></h4>
                            <p class="text-muted"><?= t('modal_delete_package_text') ?></p>
                            <form method="POST" action="index.php?c=paquete&a=eliminar">
                                <input type="hidden" name="id_paquete" id="delete_paquete_id">
                                <div class="row justify-content-center gap-2" style="max-width: 200px; margin: 0 auto;">
                                    <div class="col-6 px-1">
                                        <button type="button" class="btn btn-secondary btn-lg btn-block" data-dismiss="modal">
                                            <i class="fa fa-times"></i> <?= t('button_no') ?>
                                        </button>
                                    </div>
                                    <div class="col-6 px-1">
                                        <button type="submit" class="btn btn-danger btn-lg btn-block">
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