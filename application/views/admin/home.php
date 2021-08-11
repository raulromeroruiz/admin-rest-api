    <div class="container">
        <div class="row home col-md-12">
            <div class="col-xs-6 col-sm-4 col-md-3">
                <a href="../admin/categorias" class="btn">
                    <span class="glyphicon glyphicon-th" aria-hidden="true"></span>
                    <span class="label">Categorías</span>
                </a>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <a href="../admin/productos" class="btn">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="label">Productos</span>
                </a>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <a href="../admin/banners" class="btn">
                    <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                    <span class="label">Banners</span>
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