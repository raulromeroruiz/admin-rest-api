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
                    <li class="<?php echo ($current=="proyectos") ? "active":""; ?>"><a href="<?php echo base_url(); ?>combos">Combos</a></li>
                    <li class="<?php echo ($current=="banners") ? "active":""; ?>"><a href="<?php echo base_url(); ?>banners">Banners</a></li>
                    <li class="<?php echo ($current=="noticias") ? "active":""; ?>"><a href="<?php echo base_url(); ?>noticias">Noticias</a></li>
                </ul>
                
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $login->nombres; ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/perfil">Perfil</a></li>
                            <li><a href="/admin/usuarios">Usuarios</a></li>
                            <li class="divider"></li>
                            <li><a href="/admin/logout">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
                
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>