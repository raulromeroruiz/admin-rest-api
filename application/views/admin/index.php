<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrador de contenidos</title>
    <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap-theme.min.css">
    <script src="<?php echo base_url();?>bootstrap/js/jquery-1.11.0.js"></script>
    <script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" id="form-login">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Iniciar sesión</h3>
                    </div>
                    <div class="panel-body">
                        <form accept-charset="UTF-8" role="form" id="frm-login">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Correo" name="correo" id="correo" type="text">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="password" id="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me"> Recordarme
                                    </label>
                                </div>
                                <div class="form-group">
                                    <div id="response"></div>
                                </div>
                                <input class="btn btn-lg btn-success btn-block" type="submit" value="Login" id="btn-login">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url();?>bootstrap/js/admin.js"></script>
</body>
</html>