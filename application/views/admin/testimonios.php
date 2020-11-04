    <div class="container">
        <div class="row">
            <div class="container col-md-12 row">
                <div class="col-md-2">
                    <button class="btn btn-success" data-toggle="modal" data-target="#edit" id="new">
                        <span class="glyphicon glyphicon-file"></span> Nueva testimonio
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
                        <th>
                            <input type="checkbox" id="checkall"/>
                        </th>
                        <th>Nombre</th>
                        <th>Cargo</th>
                        <th>Testimonio</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($testimonios as $testimonio) {
                            ?>
                        <tr id="record-<?php echo $testimonio->id; ?>">
                            <td>
                                <input type="checkbox" class="checkthis" value="<?php echo $testimonio->id; ?>"/>
                            </td>
                            <td><?php echo $testimonio->nombre; ?></td>
                            <td><?php echo $testimonio->cargo; ?></td>
                            <td><?php echo $testimonio->contenido; ?></td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <button class="btn btn-primary btn-xs" data-title="Editar" data-id="<?php echo $testimonio->id; ?>" onclick="testimonios.editar(<?php echo $testimonio->id; ?>)">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                </p>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Eliminar">
                                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="<?php echo $testimonio->id; ?>"><span class="glyphicon glyphicon-trash"></span></button>
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
                    <form action="<?php echo base_url(); ?>admin/testimonios/save" class="form form-horizontal" name="frm-testimonios" id="frm-testimonios" method="post" enctype="multipart/form-data" target="myframe">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Nombre</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="id">
                                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Autor del testimonio">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Cargo</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="cargo" id="cargo" placeholder="Cargo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Testimonio</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="contenido" id="contenido" cols="30" rows="3" placeholder="Texto del testimonio"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Foto</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="imagen" id="imagen" title="Foto"/>
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
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="admin.save('testimonios', 'i')"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
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
                    <button type="button" class="btn btn-success" onclick="admin.delete('testimonios');"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
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

var testimonios = {
    init: function()
    {
        $('#imagen, #logo, #icono, #banner').bootstrapFileInput();

        $('#acciones').change(function(event) {
            admin.actions('testimonios', $(this).val());
        });
    },

    editar: function(_id)
    {
        $.post(PATH+'admin/testimonios/get/'+_id, {}, function(response, textStatus, xhr) {
            if (response.result=="success") {
                testimonio = response.data;
                $('#id').val( testimonio.id );
                $('#nombre').val( testimonio.nombre );
                $('#cargo').val( testimonio.cargo );
                $('#contenido').val( testimonio.contenido );

                //Load image
                admin.loadImage(testimonio.imagen, '#img-preview');

                $('#edit').modal('show');
            }
        }, "json");
    }
}
testimonios.init();
</script>