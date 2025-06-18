<?php
// As barras.php now includes the overall HTML structure (<html>, <head>, opening <body>),
// this file should only contain the content specific to the dashboard.
// The <title> is also handled by barras.php.
?>
<?php include 'src/views/layout/barras.php'; ?>

<div class="main-container">
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20">
            <h2 class="h3 mb-0"><?= t('dashboard_main_title') ?></h2>
        </div>

        <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?= $totalClientes ?></div>
                            <div class="font-14 text-secondary weight-500">
                                <?= t('widget_clients') ?>
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#00eccf">
                                <i class="micon bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?= $totalUsuarios ?></div>
                            <div class="font-14 text-secondary weight-500">
                                <?= t('widget_employees') ?>
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#ff5b5b">
                                <span class="micon bi bi-person-square"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">000</div>
                            <div class="font-14 text-secondary weight-500">
                                <?= t('widget_deliveries') ?>
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon">
                                <i class="icon-copy bi bi-box-arrow-up" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">00</div>
                            <div class="font-14 text-secondary weight-500"><?= t('widget_failed_deliveries') ?></div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#09cc06">
                                <i class="icon-copy bi bi-x-octagon" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?= $totalTiendas ?? '0' ?></div>
                            <div class="font-14 text-secondary weight-500"><?= t('widget_stores') ?></div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#ff9f00">
                                <i class="micon bi bi-shop-window"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?= $totalCouriers ?? '0' ?></div>
                            <div class="font-14 text-secondary weight-500"><?= t('widget_couriers') ?></div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#3b7ddd">
                                <i class="micon bi bi-truck"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?= $totalPaquetes ?? '0' ?></div>
                            <div class="font-14 text-secondary weight-500"><?= t('widget_packages') ?></div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#6c757d">
                                <i class="micon bi bi-box-seam"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark"><?= $totalReportes ?? '0' ?></div>
                            <div class="font-14 text-secondary weight-500"><?= t('widget_reports') ?></div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#dc3545">
                                <i class="micon bi bi-bar-chart-line-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="title pb-20">
            <h2 class="h3 mb-0"><?= t('users_log_title') ?></h2>
        </div>
        
        <div class="card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4"><?= t('users_list_title') ?></h4>
            </div>
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap" id="usuariosTable">
                    <thead>
                        <tr>
                            <th><?= t('table_header_document') ?></th>
                            <th><?= t('table_header_name_lastname') ?></th>
                            <th><?= t('table_header_branch') ?></th>
                            <th><?= t('table_header_phone') ?></th>
                            <th><?= t('table_header_role') ?></th>
                            <th><?= t('table_header_email') ?></th>
                            <th><?= t('table_header_registration_date') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['documento']) ?></td>
                            <td class="table-plus"><?= htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']) ?></td>
                            <td><?= htmlspecialchars($usuario['sucursal']) ?></td>
                            <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                            <td><?= htmlspecialchars($usuario['cargo']) ?></td>
                            <td><?= htmlspecialchars($usuario['email']) ?></td>
                            <td><?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
