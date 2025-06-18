<!DOCTYPE html>
<html lang="<?= getCurrentLanguage() ?>">
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title><?= t('app_title') ?> - <?= t('nav_dashboard') ?></title>
    <link rel="icon" href="assets/img/logo-rapi.ico" type="image/x-icon">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="vendor/twbs/bootstrap/css/core.css" />
    <link rel="stylesheet" type="text/css" href="vendor/twbs/bootstrap/css/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="vendor/twbs/bootstrap/css/style.css" />
        <link rel="stylesheet" href="assets/css/password-validation.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <div class="header">
        <div class="header-left">
            <div class="menu-icon bi bi-list"></div>
            <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
            <div class="header-search">
                <form>
                    <div class="form-group mb-0">
                        <i class="dw dw-search2 search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="<?= t('search_placeholder') ?>" />
                        <div class="dropdown">
                            <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                                <i class="ion-arrow-down-c"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label"><?= t('search_form_from') ?></label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label"><?= t('search_form_to') ?></label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label"><?= t('search_form_subject') ?></label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary"><?= t('search_button') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="header-right">
            <div class="dashboard-setting user-notification">
                <div class="dropdown">
                    <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                        <i class="dw dw-settings2"></i>
                    </a>
                </div>
            </div>
            <div class="user-notification"> <!-- Language Switcher -->
                <a href="<?= generate_lang_url('en') ?>" style="margin-right: 5px; color: white;"><?= t('lang_english') ?></a> |
                <a href="<?= generate_lang_url('es') ?>" style="margin-left: 5px; color: white;"><?= t('lang_spanish') ?></a>
            </div>
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-icon">
                            <img src="assets/img/logo-rapi.ico" alt="Foto de perfil" />
                        </span>
                        <span class="user-name">
                            <?= isset($_SESSION['nombre_completo']) ? htmlspecialchars($_SESSION['nombre_completo']) : t('user_menu_guest') ?>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <?php if(isset($_SESSION['usuario'])): ?>
                            <a class="dropdown-item" href="index.php?c=auth&a=logout">
                                <i class="dw dw-logout"></i> <?= t('user_menu_logout') ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="right-sidebar">
        <div class="sidebar-title">
            <h3 class="weight-600 font-16 text-blue">
                <?= t('settings_title') ?>
                <span class="btn-block font-weight-400 font-12"><?= t('settings_ui_settings') ?></span>
            </h3>
            <div class="close-sidebar" data-toggle="right-sidebar-close">
                <i class="icon-copy ion-close-round"></i>
            </div>
        </div>
        <div class="right-sidebar-body customscroll">
            <div class="right-sidebar-body-content">
                <h4 class="weight-600 font-18 pb-10"><?= t('settings_header_background') ?></h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-white active"><?= t('settings_theme_light') ?></a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-dark"><?= t('settings_theme_dark') ?></a>
                </div>
                <h4 class="weight-600 font-18 pb-10"><?= t('settings_sidebar_background') ?></h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light"><?= t('settings_theme_light') ?></a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active"><?= t('settings_theme_dark') ?></a>
                </div>
                
                <div class="reset-options pt-30 text-center">
                    <button class="btn btn-danger" id="reset-settings">
                        <?= t('settings_reset') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="left-side-bar">
        <div class="brand-logo">
            <a href="index.php?c=dashboard&a=index">
                <img src="assets/img/logo.png" alt="" class="dark-logo" />
                <img src="assets/img/logo.png" alt="" class="light-logo"/>
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li>
                        <a href="index.php?c=dashboard&a=index" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-speedometer2"></span>
                            <span class="mtext"><?= t('nav_dashboard') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?c=usuario&a=index" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-person-square"></span>
                            <span class="mtext"><?= t('nav_employees') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?c=cliente&a=index" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-people-fill"></span>
                            <span class="mtext"><?= t('nav_clients') ?></span>
                        </a>
                    </li>       
                    <li>
                        <a href="index.php?c=sucursal&a=index" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-shop"></span>
                            <span class="mtext"><?= t('nav_branches') ?></span>
                        </a>
                    </li>         
                    <li>
                        <a href="index.php?c=tienda&a=index" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-shop"></span>
                            <span class="mtext"><?= t('nav_stores') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?c=courier&a=index" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-truck"></span>
                            <span class="mtext"><?= t('nav_courier') ?></span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-box2-heart"></span>
                            <span class="mtext"><?= t('nav_packages') ?></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="index.php?c=entrada&a=index"><?= t('nav_packages_entry') ?></a></li>
                            <li><a href="#"><?= t('nav_packages_consolidated') ?></a></li>
                            <li><a href="#"><?= t('nav_packages_status') ?></a></li>
                            <li><a href="#"><?= t('nav_packages_delivered') ?></a></li>
                            <li><a href="#"><?= t('nav_packages_failed') ?></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-geo-alt"></span>
                            <span class="mtext"><?= t('nav_tracking') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-receipt-cutoff"></span>
                            <span class="mtext"><?= t('nav_reports') ?></span>
                        </a>
                    </li>						
                </ul>
            </div>
        </div>
    </div>

    

    


    <!-- JavaScript -->
    <script src="assets/js/password-validation.js"></script>
    <script src="assets/js/password_view.js"></script>
    <script src="vendor/twbs/bootstrap/js/core.js"></script>
    <script src="vendor/twbs/bootstrap/js/script.min.js"></script>
    <script src="vendor/twbs/bootstrap/js/process.js"></script>
    <script src="vendor/twbs/bootstrap/js/layout-settings.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/dataTables.responsive.min.js"></script>
    <script src="assets/js/responsive.bootstrap4.min.js"></script>		
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.flash.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>		
    <script src="vendor/twbs/bootstrap/js/datatable-setting.js"></script>
    
</body>
</html>