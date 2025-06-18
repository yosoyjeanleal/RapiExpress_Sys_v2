<!DOCTYPE html>
<html lang="<?= getCurrentLanguage() ?>">
<head>
    <meta charset="utf-8" />
    <title><?= t('app_title') ?> - <?= t('register') ?></title>
    <link rel="icon" href="assets/img/logo-rapi.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- CSS -->
    <link rel="stylesheet" href="vendor/twbs/bootstrap/css/core.css" />
    <link rel="stylesheet" href="vendor/twbs/bootstrap/css/icon-font.min.css" />
    <link rel="stylesheet" href="vendor/twbs/bootstrap/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-page">

    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="#"><img src="assets/img/logo.png" alt="RapiExpress Logo" /></a>
            </div>
        </div>
    </div>

    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 col-lg-4">
                    <!-- Espacio en blanco o imagen si se desea -->
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary"><?= t('register_title') ?></h2>
                        </div>

                        <?php if (isset($error) && !empty($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?c=auth&a=register">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                            <div class="input-group custom">
                                <input type="text" name="documento" class="form-control form-control-lg" placeholder="<?= t('document_id_placeholder') ?>" required value="<?= htmlspecialchars($_POST['documento'] ?? '') ?>">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-id-card"></i></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="text" name="username" class="form-control form-control-lg" placeholder="<?= t('username_placeholder') ?>" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="text" name="nombres" class="form-control form-control-lg" placeholder="<?= t('first_names_placeholder') ?>" required value="<?= htmlspecialchars($_POST['nombres'] ?? '') ?>">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user"></i></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="text" name="apellidos" class="form-control form-control-lg" placeholder="<?= t('last_names_placeholder') ?>" required value="<?= htmlspecialchars($_POST['apellidos'] ?? '') ?>">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user"></i></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="text" name="telefono" class="form-control form-control-lg" placeholder="<?= t('phone_placeholder') ?>" required value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-phone-call"></i></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="<?= t('email_placeholder') ?>" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-email1"></i></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="text" name="sucursal" class="form-control form-control-lg" placeholder="<?= t('branch_placeholder') ?>" required value="<?= htmlspecialchars($_POST['sucursal'] ?? '') ?>">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-shop"></i></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="text" name="cargo" class="form-control form-control-lg" placeholder="<?= t('position_placeholder') ?>" required value="<?= htmlspecialchars($_POST['cargo'] ?? '') ?>">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-briefcase"></i></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="<?= t('password_placeholder') ?>" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="<?= t('confirm_password_placeholder') ?>" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>

                            <div class="row pt-10">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block"><?= t('submit_register') ?></button>
                                    </div>
                                </div>
                            </div>
                             <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373"><?= t('or_separator') ?></div>
                             <div class="input-group mb-0">
                                 <a class="btn btn-outline-primary btn-lg btn-block" href="index.php?c=auth&a=login&lang=<?= getCurrentLanguage() ?>"><?= t('back_to_login') ?></a>
                             </div>
                        </form>
                        <div style="text-align: center; margin-top: 20px; padding-bottom: 20px;">
                            <a href="?c=auth&a=register&lang=en">English</a> | <a href="?c=auth&a=register&lang=es">Español</a>
                        </div>
                    </div>
                </div>
                 <div class="col-md-3 col-lg-4">
                    <!-- Espacio en blanco o imagen si se desea -->
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="vendor/twbs/bootstrap/js/core.js"></script>
    <script src="vendor/twbs/bootstrap/js/script.min.js"></script>
    <script src="vendor/twbs/bootstrap/js/layout-settings.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
