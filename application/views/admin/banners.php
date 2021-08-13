    <div class="container">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="col-md-2">
                    <button class="btn btn-success" data-toggle="modal" data-target="#edit" id="new">
                        <span class="glyphicon glyphicon-file"></span> Nuevo banner
                    </button>
                </div>
                <div class="col-md-3">
                    <select name="acciones" id="acciones" class="form-control">
                        <option value="">Seleccione una acción</option>
                        <option value="delete">Eliminar</option>
                        <option value="available">Activar</option>
                        <option value="unavailable">Desactivar</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <table id="mytable" class="table table-bordered table-striped">
                    <thead>
                        <th width="5%">
                            <input type="checkbox" id="checkall"/>
                        </th>
                        <th>Nombre</th>
                        <th width="7%">Editar</th>
                        <th width="7%">Eliminar</th>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($banners as $banner) {
                            ?>
                        <tr id="record-<?php echo $banner->id; ?>">
                            <td>
                                <input type="checkbox" class="checkthis" value="<?php echo $banner->id; ?>"/>
                            </td>
                            <td><?php echo $banner->nombre; ?></td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <button class="btn btn-primary btn-xs" data-title="Editar" data-id="<?php echo $banner->id; ?>" onclick="banners.editar(<?php echo $banner->id; ?>)">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                </p>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Eliminar">
                                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="<?php echo $banner->id; ?>"><span class="glyphicon glyphicon-trash"></span></button>
                                </p>
                            </td>
                        </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php echo $pagination; ?>
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
                    <form action="<?php echo base_url(); ?>banners/save" class="form form-horizontal" name="frm-banners" id="frm-banners" method="post" enctype="multipart/form-data" target="myframe">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Título</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="id">
                                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Título del banner">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Imagen</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="imagen" id="imagen" multiple title="Seleccione la imagen para el Banner (1838x784)"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Imagen Mobile</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="mobile" id="imagen_mobile" title="Seleccione la imagen para el Banner versión mobile (720x1128)"/>
                            </div>
                        </div>
                        <div class="form-group" id="image-container">
                            <label for="concept" class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <img src="<?php echo base_url(); ?>static/images/image.jpg" alt="" id="img-preview">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">URL/Enlace</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="enlace" id="enlace">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="admin.save('banners', 'i')"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
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
                    <button type="button" class="btn btn-success" onclick="admin.delete('banners');"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <iframe src="" frameborder="0" name="myframe" style="width:100%; height:600px; display:none"></iframe>
<script>
    $(document).ready(function() {
    });

var banners = {
    sizes: ['1838x784', '720x1128'],
    init: function()
    {
        $('#imagen').bootstrapFileInput();
        $('#imagen_mobile').bootstrapFileInput();

        $('#imagen').change(function(event) {
            admin.imagesize(event.currentTarget, banners.sizes[0]);
        });

        $('#imagen_mobile').change(function(event) {
            admin.imagesize(event.currentTarget, banners.sizes[1]);
        });

        $('#edit').on('show.bs.modal', function (e) {
            _action = $(e.relatedTarget).attr('id');
            if (_action=="new") {
                $('#contenido').html('<div class="box"><div class="box-content"><h2><small>LOREM  </small><span> IPSUM  </span></h2></div><p>Sed ut - Perspiciatis</p>');
            }
            $('button.btn-warning').removeClass('disabled');
            $('#tipo_enlace').val("");
            $('#url').val("#").hide();
        });

        $('#acciones').change(function(event) {
            admin.actions('banners', $(this).val());
        });

        $('#tipo_enlace').change(function(event) {
            $('#url')
            .val('Cargando la info')
            .show();

            _tabla = $(this).val();
            if (_tabla!="") {
                $.post(PATH+'admin/banners/get_urls', {tabla: _tabla}, function(response, textStatus, xhr) {
                    $('#url').html(response.data);
                }, "json");
            }
            else {
                $('#url').hide();
            }
        });

        $('#url').change(function(event) {
            $('#enlace, #link').val( $(this).val() );
        });

    },

    editar: function(_id)
    {
        $.post(PATH+'admin/banners/get/'+_id, {}, function(response, textStatus, xhr) {
            if (response.result=="success") {
                banner = response.data;
                $('#id').val( banner.id );
                $('#nombre').val( banner.nombre );
                $('#contenido').val( banner.contenido );
                if (banner.enlace==null || banner.enlace=="#") {
                    $('#enlace, #link').val( "#" );
                }
                else {
                    $('#enlace, #link').val( banner.enlace );
                }

                //Load image
                admin.loadImage(banner.imagen, '#img-preview');

                $('#edit').modal('show');
            }
        }, "json");
    }
}
banners.init();
</script>