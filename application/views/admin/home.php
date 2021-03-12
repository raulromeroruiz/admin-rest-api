    <div class="container">
        <div class="row home col-md-12">
            <div class="col-xs-6 col-sm-4 col-md-3">
                <a href="../admin/productos" class="btn">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="label">Productos</span>
                </a>
            </div>
        <?php if ($login->tipo != 3) { ?>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <a href="../admin/usuarios" class="btn">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    <span class="label">Usuarios</span>
                </a>
            </div>
        <?php } ?>
        </div>
    </div>