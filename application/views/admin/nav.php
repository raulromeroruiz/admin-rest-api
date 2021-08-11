<?php
$current = $this->uri->segment(2);
?>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="javascript:;">Admin</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="<?php echo ($current=="home") ? "active":""; ?>"><a href="/admin/home">Inicio</a></li>
                    <li class="<?php echo ($current=="categorias") ? "active":""; ?>"><a href="<?php echo base_url(); ?>categorias">Categorías</a></li>
                    <li class="<?php echo ($current=="productos") ? "active":""; ?>"><a href="<?php echo base_url(); ?>productos">Productos</a></li>
                    <li class="<?php echo ($current=="banners") ? "active":""; ?>"><a href="<?php echo base_url(); ?>banners">Banners</a></li>
                    <li class="<?php echo ($current=="configuracion") ? "active":""; ?>"><a href="<?php echo base_url(); ?>configuracion">Configuración</a></li>
                </ul>
                
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $login->nombres; ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/perfil">Perfil</a></li>
                            <?php if (in_array($login->tipo, [1,2])) { ?>
                            <li><a href="/admin/usuarios">Usuarios</a></li>
                            <?php } ?>
                            <li class="divider"></li>
                            <li><a href="/admin/logout">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
                
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>