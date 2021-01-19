    <div class="container">
        <div class="row">
            <div class="container col-md-12 row">
                <div class="col-md-2">
                    <button class="btn btn-success" data-toggle="modal" data-target="#edit" id="new">
                        <span class="glyphicon glyphicon-file"></span> Nuevo usuario
                    </button>
                </div>
            <?php if ($login->tipo==1){ ?>
                <div class="col-md-3">
                    <select name="acciones" id="acciones" class="form-control">
                        <option value="">Seleccione una acción</option>
                        <option value="delete">Eliminar</option>
                        <option value="available">Activar</option>
                        <option value="unavailable">Desactivar</option>
                    </select>
                </div>
            <?php } ?>
            </div>
            <div class="col-md-12">
                <table id="mytable" class="table table-bordered table-striped">
                    <thead>
                        <th>
                            <input type="checkbox" id="checkall"/>
                        </th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Tipo</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($usuarios as $usuario) {
                            ?>
                        <tr id="record-<?php echo $usuario->id; ?>">
                            <td>
                                <input type="checkbox" class="checkthis" value="<?php echo $usuario->id; ?>"/>
                            </td>
                            <td><?php echo $usuario->usuario; ?></td>
                            <td><?php echo $usuario->correo; ?></td>
                            <td><?php echo $usuario->tipo_usuario; ?></td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <button class="btn btn-primary btn-xs" data-title="Editar" data-id="<?php echo $usuario->id; ?>" onclick="usuarios.editar(<?php echo $usuario->id; ?>)">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                </p>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Eliminar">
                                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="<?php echo $usuario->id; ?>"><span class="glyphicon glyphicon-trash"></span></button>
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
                    <form action="<?php echo base_url(); ?>usuarios/save" class="form form-horizontal" name="frm-usuarios" id="frm-usuarios" method="post" enctype="multipart/form-data" target="myframe">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Nombres</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="id">
                                <input class="form-control" type="text" name="nombres" id="nombres" placeholder="Nombres">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Apellidos</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="apellidos" id="apellidos" placeholder="Apellidos">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Correo</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="correo" id="correo" placeholder="Correo para iniciar sesión">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Tipo de Usuario</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="tipo" id="tipo">
                                    <option value="">Tipo de usuario</option>
                                <?php foreach ($tipo_usuarios as $tipo) {
                                    ?>
                                    <option value="<?php echo $tipo->id; ?>"><?php echo $tipo->nombre; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="admin.save('usuarios', 'i')"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
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
                    <button type="button" class="btn btn-success" onclick="admin.delete('usuarios');"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
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

var usuarios = {
    init: function()
    {
        $('#fecha_creacion').datepicker({
            format: "dd/mm/yy",
            language: "es",
            autoclose: true
        });

        $('#acciones').change(function(event) {
            admin.actions('usuarios', $(this).val());
        });
    },

    editar: function(_id)
    {
        $.post(PATH + 'admin/usuarios/get/'+_id, {}, function(response, textStatus, xhr) {
            if (response.result=="success") {
                usuario = response.data;
                $('#id').val( usuario.id );
                $('#nombres').val( usuario.nombres );
                $('#apellidos').val( usuario.apellidos );
                $('#correo').val( usuario.correo );
                $('#tipo').val( usuario.tipo );
                $('#edit').modal('show');
            }
        }, "json");
    },

    confirm: function(_response) {
        params = JSON.parse(_response);
        if (confirm("Desea enviar un correo con los datos registrados de "+params.nombres+",\nal correo "+params.correo )) {
            $.post(PATH + 'admin/usuarios/confirm/', params, function(response, textStatus, xhr) {
                if (response.result=="success") {
                    alert('Los datos registrados fueron enviados correctamente.');
                    location.reload();
                }
            }, "json");
        }
        else {
            msg = 'Anote los datos generados para ingresar al Administrador:\n'
                + '- Correo: ' + params.correo+'\n'
                + '- Contraseña: ' + params.clave;
            alert(msg);
            location.reload();
        }
    }
}
usuarios.init();
</script>