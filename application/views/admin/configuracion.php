<div class="container">
    <?php include_once('nav.php'); ?>

    <div class="row">
        <div class="container">
            <form action="" name="frm-configuracion" id="frm-configuracion" method="post" enctype="multipart/form-data" target="myframe">
                <div class="tabbable-panel">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#tab_default_1" data-toggle="tab">PDF</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_default_1">
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <img src="<?php echo $pdf->valor; ?>?v=2" alt="" />
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <div class="col-md-6">
                                        <input class="form-control" type="file" name="pdf" id="pdf" title="Seleccionar pdf" onchange="config.readerFile();" data-type="pdf" data-config="pdf">
                                    </div>
                                    <div class="col-md-6">
                                        <a href="javascript:change(<?php echo $pdf->id; ?>, '<?php echo $pdf->opcion; ?>', 'file');" class="btn btn-success btn-sm">Guardar</a>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="field">
            <input type="hidden" name="id">
            <input type="hidden" name="file">
            </form>
        </div>
    </div>
</div>
    <iframe src="" frameborder="0" name="myframe" style="width:800px; height:400px; display:none;"></iframe>
    <!--  Editar Campos personalizados -->
    <div class="modal fade" id="fields" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo base_url(); ?>categorias/save" name="frm-campos_personalizados" id="frm-campos_personalizados" method="post" enctype="multipart/form-data" target="myframe">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title custom_align" id="Heading">Editar detalle</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <input class="form-control" type="text" placeholder="Nombre de campo" name="nombre" id="nombre">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Campo de comparación 1" name="campo1" id="campo1">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Campo de comparación 2" name="campo2" id="campo2">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Campo de comparación 3" name="campo3" id="campo3">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Campo de comparación 4" name="campo4" id="campo4">
                        </div>
                        <div class="form-group" id="cont_parent">
                            <input type="hidden" value="" name="categoria" id="categoria">
                            <select id="lacategoria" class="form-control">
                                <?php 
                                echo "<option value=''>Categoría</option>";
                                foreach ($nocategorias as $nocategoria) {
                                    echo "<option value='".$nocategoria->id."'>".$nocategoria->nombre."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="update('campos_personalizados', '')">
                            <span class="glyphicon glyphicon-ok-sign"></span>
                            <span id="btn-save"> Actualizar</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--  Editar Redes Sociales -->
    <div class="modal fade" id="rrss" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo base_url(); ?>categorias/save" name="frm-rrss" id="frm-rrss" method="post" enctype="multipart/form-data" target="myframe">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title custom_align" id="Heading">Editar detalle</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <input class="form-control" type="text" placeholder="Nombre de campo" name="nombre" id="nombre">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="URL completa" name="enlace" id="enlace">
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="update('rrss', '')">
                            <span class="glyphicon glyphicon-ok-sign"></span>
                            <span id="btn-save"> Actualizar</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--  Editar Fuentes -->
    <div class="modal fade" id="fuentes" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" name="frm-fuentes" id="frm-fuentes" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title custom_align" id="Heading">Editar detalle</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="idf">
                            <input class="form-control" type="text" placeholder="Nombre de campo" id="seccion" readonly>
                            <input type="hidden" name="url">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="fuente" id="fuente">
                                <option value="">Seleccione el tipo de fuente</option>
                                <option value="PT Sans">PT Sans</option>
                                <option value="Oswald">Oswald</option>
                                <option value="PT Sans Narrow">PT Sans Narrow</option>
                                <option value="Arial">Arial</option>
                                <option value="Verdana">Verdana</option>
                                <option value="Lucida Console">Lucida Console</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="update('fuentes', '')">
                            <span class="glyphicon glyphicon-ok-sign"></span>
                            <span id="btn-save"> Actualizar</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--  Editar Menu -->
    <div class="modal fade" id="menu" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" name="frm-menu" id="frm-menu" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title custom_align" id="Heading">Editar detalle</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <input class="form-control" type="text" placeholder="Nombre de campo" name="nombre" id="nombre">
                            <input type="hidden" name="url">
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="update('menu', '')">
                            <span class="glyphicon glyphicon-ok-sign"></span>
                            <span id="btn-save"> Actualizar</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--  Editar Mensajes -->
    <div class="modal fade" id="mensajes" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog w700">
            <div class="modal-content">
                <form action="" name="frm-mensajes" id="frm-mensajes" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title custom_align" id="Heading">Editar detalle</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <input class="form-control" type="text" name="nombre" id="nombre" readonly>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="10" placeholder="Mensaje" style="width:100%; height:300px;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="update('mensajes', '')">
                            <span class="glyphicon glyphicon-ok-sign"></span>
                            <span id="btn-save"> Actualizar</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal delete --> 
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title custom_align" id="Heading">Eliminar registro</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-warning-sign"></span> Está seguro de eliminar este registro?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="eliminar('campos_personalizados', event);">
                        <span class="glyphicon glyphicon-ok-sign"></span> Sí
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<script>
var tab = null;
$(document).ready(function() {
    $('#lacategoria').change(function(event) {
        $('#categoria').val($(this).val());
    });

    $('#fields').on('show.bs.modal', function (e) {
        if ($(e.relatedTarget).attr('id')=="new") {
            $('#cont_parent').show();
            id = "new";
        }
        else {
            $('#cont_parent').hide();
            id = "";
        }
    });

    $('.nav-tabs li').click(function(event) {
        i = $('.nav-tabs li').index(this);
        localStorage.setItem('tab', i);
    });

    if (localStorage) {
        tab = localStorage.getItem('tab');
        $('.nav-tabs a').eq(tab).tab('show');
    }

    $('textarea#descripcion').tinymce({
        // Location of TinyMCE script
        script_url : PATH + 'js/tinymce3/tiny_mce.js',

        // General options
        theme : "advanced",
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,fontselect,fontsizeselect,|,forecolor,|,undo,redo,|,image,|,code",
        //theme_advanced_buttons2 : "cut,copy,paste,pastetext,|,search,replace,|,bullist,numlist,|,undo,redo,|,image",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false,
        skin : "bootstrap",

        // Example content CSS (should be your site CSS)
        content_css : PATH + "css/content.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
            username : "Some User",
            staffid : "991234"
        }
    });

    $('#acciones-mensajes').change(function(){
        actions('mensajes', $(this).val());
    });

    $('#pdf').bootstrapFileInput();
});
var form = document.forms['frm-configuracion'];

var config = {
    mimes: {
        pdf : "application/pdf"
    },

    readerFile: function(){
        _target = event.target;
        filetype = _target.files[0].type;
        type = _target.dataset.type;
        console.log(filetype);
        console.log(type);
        console.log(this.mimes[type]);
        if (this.mimes[type] != filetype){
            console.log('Solo se permite archivos ' + type);
            return false;
        }
        console.log('Go Upload');
    },

    setConfig: function(_params) {
        console.log(_params);
    }
};

var change = function(id, opcion, field) {
    form.action = PATH + "admin/configuracion/set";
    form.elements.namedItem("field").value = field;
    form.elements.namedItem("id").value = id;
    form.elements.namedItem("file").value = opcion;
    form.submit();
}

var editarCampo = function(id) {
    var html_="", selected="";
    $('#btn-save').text('Actualizar');
    openAjax();
    $.post(PATH + 'configuracion/get/campos_personalizados/'+id, {}, function(response, textStatus, xhr) {
        if (response.result=="success") {
            $('#id').val(response.data.id);
            $('#nombre').val(response.data.nombre);
            $('#campo1').val(response.data.precio);
            $('#campo2').val(response.data.oferta);
            $('#campo3').val(response.data.campo3);
            $('#campo4').val(response.data.campo4);
            $('#categoria').val(response.data.categoria);
            //$('#cont_parent').hide();
            $('#fields h4').text("Campos personalizados de "+$('#record-'+id+' td').eq(6).text());
            closeAjax();
            $('#fields').modal('show');
        }
    }, "json");
}

var editarRRSS = function(id) {
    var html_="", selected="";
    $('#btn-save').text('Actualizar');
    openAjax();
    $.post(PATH+'configuracion/get/rrss/'+id, {}, function(response, textStatus, xhr) {
        if (response.result=="success") {
            $('#frm-rrss #id').val(response.data.id);
            $('#frm-rrss #nombre').val(response.data.nombre);
            $('#frm-rrss #enlace').val(response.data.enlace);
            closeAjax();
            $('#rrss').modal('show');
        }
    }, "json");
}

var editarFuente = function(id) {
    var html_="", selected="";
    event.preventDefault();
    $('#btn-save').text('Actualizar');
    openAjax();
    $.post(PATH+'configuracion/get/fuentes/'+id, {}, function(response, textStatus, xhr) {
        if (response.result=="success") {
            $('#idf').val(response.data.id);
            $('#seccion').val(response.data.seccion);
            $('#fuente').val(response.data.fuente);
            closeAjax();
            $('#fuentes').modal('show');
        }
    }, "json");
}

var editarMenu = function(id) {
    var html_="", selected="";
    event.preventDefault();
    $('#btn-save').text('Actualizar');
    openAjax();
    $.post(PATH+'configuracion/get/menu/'+id, {}, function(response, textStatus, xhr) {
        if (response.result=="success") {
            $('#frm-menu #id').val(response.data.id);
            $('#frm-menu #nombre').val(response.data.nombre);
            closeAjax();
            $('#menu').modal('show');
        }
    }, "json");
}

var editarMensaje = function(id) {
    var html_="", selected="";
    event.preventDefault();
    $('#btn-save').text('Actualizar');
    openAjax();
    $.post(PATH+'configuracion/get/mensajes/'+id, {}, function(response, textStatus, xhr) {
        if (response.result=="success") {
            $('#frm-mensajes #id').val(response.data.id);
            $('#frm-mensajes #nombre').val(response.data.nombre);
            $('#frm-mensajes #descripcion').val(response.data.descripcion);
            closeAjax();
            $('#mensajes').modal('show');
        }
    }, "json");
}
</script>