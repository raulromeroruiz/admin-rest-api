    <div class="container">
        <div class="row">
            <div class="container col-md-12 row">
                
            </div>
            <div class="col-md-12">
                <table id="mytable" class="table table-bordered table-striped">
                    <thead>
                        <th width="25%">Descripción</th>
                        <th width="55%">Contenido</th>
                        <th width="12%">Tipo</th>
                        <th width="8%">Editar</th>
                    </thead>
                    <tbody>
                        <?php 
                        $tipos = array('img' => "Imagen", "html"=> "Texto Enriquecido", "texto"=> "Texto");
                        foreach ($contenidos as $contenido) {
                            ?>
                        <tr id="record-<?php echo $contenido->id; ?>">
                            <td><?php echo $contenido->etiqueta; ?></td>
                            <td>
                            <?php 
                            switch ($contenido->tipo) {
                                case 'img':
                                    if (file_exists($contenido->contenido)) {
                                    echo "<img src='".base_url(). str_replace("full", "small", $contenido->contenido)."'>";
                                    }
                                    else {
                                        echo "";
                                    }
                                    break;
                                case 'html':
                                    echo $this->tools->wordlimit($contenido->contenido, 20);
                                    break;
                                case 'texto':
                                    echo $this->tools->wordlimit($contenido->contenido, 20);
                                    break;
                            }
                            ?>
                            </td>
                            <td><?php echo $tipos[$contenido->tipo]; ?></td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <button class="btn btn-primary btn-xs" data-title="Editar" data-id="<?php echo $contenido->id; ?>" onclick="contenidos.editar(<?php echo $contenido->id; ?>)">
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
                    <form action="<?php echo base_url(); ?>admin/contenidos/save" class="form form-horizontal" name="frm-contenidos" id="frm-contenidos" method="post" enctype="multipart/form-data" target="myframe">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="tipo" id="tipo">
                        <div class="form-group" id="contenido-texto">
                            <label for="concept" class="col-sm-3 control-label">Contenido</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="contenido-texto" id="texto" placeholder="Texto del contenido">
                            </div>
                        </div>
                        <div class="form-group" id="contenido-html">
                            <label for="concept" class="col-sm-3 control-label">Contenido</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="contenido-html" id="html" cols="30" rows="3" placeholder="Texto del contenido" style="width:100%; height:300px;"></textarea>
                            </div>
                        </div>
                        <div class="form-group" id="contenido-img">
                            <label for="concept" class="col-sm-3 control-label">Imagen</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="imagen" id="imagen" title="Seleccione la imagen para la sección"/>
                            </div>
                        </div>
                        <div class="form-group" id="image-container">
                            <label for="concept" class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <img src="<?php echo base_url(); ?>static/images/image.jpg" alt="" id="img-preview">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="admin.save('contenidos', 'i')"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
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
                    <button type="button" class="btn btn-success" onclick="admin.delete('contenidos');"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
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

var contenidos = {
    size:'970x277',
    init: function()
    {
        $('#imagen, #logo, #icono, #banner').bootstrapFileInput();

        $('#imagen').change(function(event) {
            //admin.imagesize( event.currentTarget.files, contenidos.size );
        });

        $('#html').tinymce({
            // Location of TinyMCE script
            script_url : PATH + 'bootstrap/js/tinymce3/tiny_mce.js',

            // General options
            //theme : "advanced",
            plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

            // Theme options
            theme_advanced_buttons1 : "bullist,numlist,|,outdent,indent,|,undo,redo,|,code",
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

        $('#image-container').hide();
    },

    editar: function(_id)
    {
        $('#contenido-texto, #contenido-html, #contenido-img, #image-container').hide();
        $.post(PATH+'admin/contenidos/get/'+_id, {}, function(response, textStatus, xhr) {
            if (response.result=="success") {
                contenido = response.data;
                $('#id').val( contenido.id );
                $('#tipo').val( contenido.tipo );
                $('#contenido-'+contenido.tipo).find('label').text( contenido.etiqueta );
                switch (contenido.tipo) {
                    case "img":
                        $('#texto, #html').prop('disabled', true);
                        admin.loadImage(contenido.contenido, '#img-preview');
                        break;
                    case "html":
                        $('#html').prop('disabled', false);
                        $('#html').html( (contenido.contenido!=null && contenido.contenido!="") ? contenido.contenido:"");
                        break;
                    case "texto":
                        $('#texto').prop('disabled', false);
                        $('#texto').val( contenido.contenido );
                        break;
                }
                $('#contenido-'+contenido.tipo).show();

                $('#edit').modal('show');
            }
        }, "json");
    }
}
contenidos.init();
</script>