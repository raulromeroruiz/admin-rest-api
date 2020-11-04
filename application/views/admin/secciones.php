    <div class="container">
        <div class="row">
            <div class="container col-md-12 row">
                
            </div>
            <div class="col-md-12">
                <table id="mytable" class="table table-bordered table-striped">
                    <thead>
                        <th width="82%">Sección</th>
                        <th width="8%">Editar</th>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($secciones as $seccion) {
                            ?>
                        <tr id="record-<?php echo $seccion->id; ?>">
                            <td><?php echo $seccion->titulo; ?></td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <button class="btn btn-primary btn-xs" data-title="Editar" data-id="<?php echo $seccion->id; ?>" onclick="secciones.editar(<?php echo $seccion->id; ?>)">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                </p>
                            </td>
                        </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
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
                    <form action="<?php echo base_url(); ?>admin/secciones/save" class="form form-horizontal" name="frm-secciones" id="frm-secciones" method="post" enctype="multipart/form-data" target="myframe">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Banner</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="banner" id="banner" title="Seleccione la imagen para el Banner (970x277)"/>
                            </div>
                        </div>
                        <div class="form-group" id="image-container">
                            <label for="concept" class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <img src="<?php echo base_url(); ?>static/images/image.jpg" alt="" id="img-preview">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Contenido del banner</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="id">
                                <textarea class="form-control" name="contenido" id="contenido" cols="30" rows="3" placeholder="Descripción de la seccion" style="width:100%;"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="admin.save('secciones', 'i')"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
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
                    <button type="button" class="btn btn-success" onclick="admin.delete('secciones');"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <iframe src="" frameborder="0" name="myframe" style="width:100%; height:300px; display:none;"></iframe>
<script>
    $(document).ready(function() {
    });

var secciones = {
    size:'970x277',
    init: function()
    {
        $('#imagen, #logo, #icono, #banner').bootstrapFileInput();

        $('#banner').change(function(event) {
            admin.imagesize( event.currentTarget.files, secciones.size);
        });

        $('#contenido').tinymce({
            // Location of TinyMCE script
            script_url : PATH + 'bootstrap/js/tinymce3/tiny_mce.js',

            // General options
            //theme : "advanced",
            plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

            // Theme options
            theme_advanced_buttons1 : "fontselect,fontsizeselect,|,undo,redo,|,code",
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
    },

    editar: function(_id)
    {
        $.post(PATH+'admin/secciones/get/'+_id, {}, function(response, textStatus, xhr) {
            if (response.result=="success") {
                seccion = response.data;
                $('#id').val( seccion.id );
                $('#contenido').html( seccion.contenido );

                //Load image
                admin.loadImage(seccion.imagen, '#img-preview');

                $('#edit').modal('show');
            }
        }, "json");
    }
}
secciones.init();
</script>