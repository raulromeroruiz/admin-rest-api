    <div class="container">
        <div class="row">
            <div class="menu-actions">
                <div class="col-md-2">
                    <button class="btn btn-success" data-toggle="modal" data-target="#edit" id="new">
                        <span class="glyphicon glyphicon-file"></span> Nueva noticia
                    </button>
                </div>
                <div class="col-md-3">
                    <select name="acciones" id="acciones" class="form-control">
                        <option value="">Seleccione una acción</option>
                        <option value="delete">Eliminar</option>
                        <option value="publish">Mostrar</option>
                        <option value="unpublish">Ocultar</option>
                        <!--
                        <option value="available">Activar</option>
                        <option value="unavailable">Desactivar</option>
                        -->
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <table id="mytable" class="table table-bordered table-striped">
                    <thead>
                        <th>
                            <input type="checkbox" id="checkall"/>
                        </th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Usuario</th>
                        <th>Creación</th>
                        <th>Modificación</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($noticias as $noticia) {
                            ?>
                        <tr id="record-<?php echo $noticia->id; ?>">
                            <td>
                                <input type="checkbox" class="checkthis" value="<?php echo $noticia->id; ?>"/>
                            </td>
                            <td><?php echo $noticia->titulo; ?></td>
                            <td><?php echo $noticia->autor; ?></td>
                            <td><?php echo $noticia->usuario; ?></td>
                            <td><?php echo $noticia->fecha_redaccion; ?></td>
                            <td><?php echo $noticia->fecha_modificacion; ?></td>
                            <td><?php echo ($noticia->publicado==1) ? "Publicado":"Oculto"; ?></td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <button class="btn btn-primary btn-xs" data-title="Editar" data-id="<?php echo $noticia->id; ?>" onclick="noticias.editar(<?php echo $noticia->id; ?>)">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                </p>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Eliminar">
                                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="<?php echo $noticia->id; ?>"><span class="glyphicon glyphicon-trash"></span></button>
                                </p>
                            </td>
                        </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php echo $paginacion; ?>
            </div>

        </div>

    </div>

    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <h4 class="modal-title custom_align" id="Heading">Editar</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url(); ?>admin/noticias/save" class="form form-horizontal" name="frm-noticias" id="frm-noticias" method="post" enctype="multipart/form-data" target="myframe">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Título</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="id">
                                <input class="form-control" type="text" name="titulo" id="titulo" placeholder="Título de la noticia">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Contenido</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="contenido" id="contenido" cols="30" rows="15" placeholder="Contenido de la noticia" style="width:100%;"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Imagen</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="imagen" id="imagen" title="Seleccionar Imagen. Recomendable 768px de ancho en adelante."/>
                            </div>
                        </div>
                        <div class="form-group" id="image-container">
                            <label for="concept" class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <img src="<?php echo base_url(); ?>static/images/image.jpg" alt="" id="img-preview" width="200">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Autor/Fuente</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="autor" id="autor" placeholder="Autor u origen de la noticia">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Enlace</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="enlace" id="enlace" placeholder="Link de la noticia">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Fecha de Creación</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="fecha_creacion" id="fecha_creacion">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Tipo</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="tipo" id="tipo">
                                    <option value="">Seleccione el tipo de noticia</option>
                                <?php foreach ($tipo_noticias as $tipo) {
                                    ?>
                                    <option value="<?php echo $tipo->id; ?>"><?php echo $tipo->nombre; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="admin.save('noticias', 'i')"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <h4 class="modal-title custom_align" id="Heading">Eliminar registro</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-warning-sign"></span> Esta seguro de eliminar el registro seleccionado?
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-success" onclick="admin.delete('noticias');"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <iframe src="" frameborder="0" name="myframe" style="width:100%; height:300px; display:;"></iframe>
<script>
    $(document).ready(function() {
    });

var noticias = {
    init: function()
    {
        $('#fecha_creacion').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true
        });
        $('#imagen, #logo, #icono, #banner').bootstrapFileInput();

        $('#acciones').change(function(event) {
            admin.actions('noticias', $(this).val());
        });

        var settings_title = {
            // Location of TinyMCE script
            script_url : PATH + 'bootstrap/js/tinymce3/tiny_mce.js',
            height:"200",
            // General options
            //theme : "advanced",
            //plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

            // Theme options
            theme_advanced_buttons1 : "bold",
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
        };

        var settings_content = {
            height: '250', 
            script_url : PATH + 'bootstrap/js/tinymce3/tiny_mce.js',
            plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
            theme_advanced_buttons1 : "bold,|,fontselect,fontsizeselect,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,|,image,|,code",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : false,
            skin : "bootstrap",
            content_css : PATH + "css/content.css",
            template_external_list_url : "lists/template_list.js",
            external_link_list_url : "lists/link_list.js",
            external_image_list_url : "lists/image_list.js",
            media_external_list_url : "lists/media_list.js",
            template_replace_values : {
                username : "Some User",
                staffid : "991234"
            }
        };

        $('#contenido').tinymce(settings_content);

        $('#mytablee').dataTable({
            "order": [[ 4, "as" ]]
        });
    },

    editar: function(_id)
    {
        $.post(PATH+'admin/noticias/get/'+_id, {}, function(response, textStatus, xhr) {
            if (response.result=="success") {
                noticia = response.data;
                $('#id').val( noticia.id );
                $('#titulo').val( noticia.titulo );
                $('#contenido').html( noticia.contenido );
                $('#autor').val( noticia.autor );
                $('#enlace').val( noticia.enlace );
                $('#fecha_creacion').val( noticia.fecha_creacion );
                $('#tipo').val( noticia.tipo );

                //Load image
                admin.loadImage(noticia.thumb, '#img-preview');

                $('#edit').modal('show');
            }
        }, "json");
    }
}
noticias.init();
</script>