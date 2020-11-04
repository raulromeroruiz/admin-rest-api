    <div class="container">
        <div class="row">
            <div class="container col-md-12 row">
                <div class="col-md-2">
                    <button class="btn btn-success" data-toggle="modal" data-target="#edit" id="new">
                        <span class="glyphicon glyphicon-file"></span> Nueva oficina
                    </button>
                </div>
                <div class="col-md-3">
                    <select name="acciones" id="acciones" class="form-control">
                        <option value="">Seleccione una acción</option>
                        <option value="delete">Eliminar</option>
                        <option value="available">Disponible</option>
                        <option value="unavailable">No disponible</option>
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
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Área</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($oficinas as $oficina) {
                            ?>
                        <tr id="record-<?php echo $oficina->id; ?>">
                            <td>
                                <input type="checkbox" class="checkthis" value="<?php echo $oficina->id; ?>"/>
                            </td>
                            <td><?php echo $oficina->nombre; ?></td>
                            <td><?php echo $oficina->tipo; ?></td>
                            <td><?php echo $oficina->precio; ?></td>
                            <td><?php echo $oficina->area; ?></td>
                            <td><?php echo ($oficina->estado==1) ? "Disponible":"No Disponible"; ?></td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <button class="btn btn-primary btn-xs" data-title="Editar" data-id="<?php echo $oficina->id; ?>" onclick="oficinas.editar(<?php echo $oficina->id; ?>)">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                </p>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Eliminar">
                                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="<?php echo $oficina->id; ?>"><span class="glyphicon glyphicon-trash"></span></button>
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
                    <form action="<?php echo base_url(); ?>admin/oficinas/save" class="form form-horizontal" name="frm-oficinas" id="frm-oficinas" method="post" enctype="multipart/form-data" target="myframe">
                        <div class="form-group">
                            <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="proyecto" id="proyecto" value="<?php echo $proyecto; ?>">
                                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="precio" class="col-sm-3 control-label">Precio</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="precio" id="precio" placeholder="Precio">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="area" class="col-sm-3 control-label">Área</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="area" id="area" placeholder="Área">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipo" class="col-sm-3 control-label">Tipo</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="tipo" id="tipo">
                                    <option value="">Seleccione el tipo de obra</option>
                                <?php foreach ($tipo_proyectos as $tipo) {
                                    ?>
                                    <option value="<?php echo $tipo->id; ?>"><?php echo $tipo->nombre; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="imagen3d" class="col-sm-3 control-label img-imagen3d" id="img-imagen3d">Imagen Plano 3D</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="imagen3d" id="imagen3d" title="Seleccionar imagen del plano 3D" data-group="planos"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="plano" class="col-sm-3 control-label img-plano" id="img-plano">Imagen Áreas</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="plano" id="plano" title="Seleccionar imagen de las Áreas" data-group="planos"/>
                            </div>
                        </div>
                        <div class="form-group" id="image-container">
                            <label for="concept" class="col-sm-3 control-label"></label>
                            <div class="col-sm-9" id="container-images">
                                <div class="col-sm-12 row fila">
                                    <div class="col-sm-3 row">
                                        <img src="<?php echo base_url(); ?>static/images/image.jpg" alt="" id="img-preview" class="img-work">
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
                                    </div>
                                </div>
                                <div id="abcde"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="admin.save('oficinas', 'i')"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
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
                    <button type="button" class="btn btn-success" onclick="oficinas.delete('oficinas');"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
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
    $('#edit').on('hide.bs.modal', function (e) {
        $('#img-imagen3d').text('Imagen Plano 3D');
        $('#img-plano').text('Imagen Áreas');
        $('#imagen3d, #plano').removeAttr('onchange');
        document.forms[0].reset();
    });
});

var oficinas = {
    size: {
        plano:  '480x470',
    },

    init: function()
    {
        $('#imagen3d, #plano').filestyle({
            buttonBefore: true,
            buttonText: "&nbsp;Examinar",
            //input: false, 
            //size: "sm",
            badge: false,
            placeholder: "Imagen de "+oficinas.size['plano'], 
        });
        //$('#banner, #imagen3d, #plano').bootstrapFileInput();

        $('#imagen3d').change(function(event) {
            admin.imagesize(event.currentTarget, oficinas.size['plano']);
        });

        $('#plano').change(function(event) {
            admin.imagesize(event.currentTarget, oficinas.size['plano']);
        });

        $('#acciones').change(function(event) {
            admin.actions('inmuebles', $(this).val());
        });

        $(document).on('click', '.remove_picture', function(event) {
            event.preventDefault();
            if( confirm('Esta seguro de eliminar la foto?')) {
                params = {
                    id: $(this).data('picture'),
                    tabla: 'fotos_oficinas',
                }
                $.post(PATH+'admin/oficinas/delete', params, function(response, textStatus, xhr) {
                    if (response.result == "success") {
                        $('#row-'+params.id).remove();
                        if ($('.fila').length==0){
                            $('#image-container').hide();
                        }
                    }
                }, "json");
            }
        });

        $('#mytable').dataTable();
    },

    editar: function(_id)
    {
        $.post(PATH+'admin/oficinas/get/'+_id, {}, function(response, textStatus, xhr) {
            if (response.result=="success") {
                oficina = response.data;
                $('#id').val( oficina.id );
                //$('#proyecto').val( oficina.proyecto );
                $('#nombre').val( oficina.nombre );
                $('#precio').val( oficina.precio );
                $('#area').val( oficina.area );
                $('#tipo').val( oficina.tipo );

                //Load image
                //imagenes = (response.imagenes) ? response.imagenes:{};
                if (oficina.id_imagen3d) {
                    uri = oficina.imagen3d.split('/');
                    oficinas.loadImage(oficina.thumb_imagen3d, '#img-imagen3d');
                    $('#imagen3d').attr({
                        'onchange': "oficinas.changeImage("+oficina.id_imagen3d+", "+oficina.proyecto+")",
                        'data-file': uri[uri.length-1]
                    });
                }
                //oficinas.loadImage(imagenes, '#img-preview');
                if (oficina.id_plano) {
                    uri = oficina.plano.split('/');
                    oficinas.loadImage(oficina.thumb_plano, '#img-plano');
                    $('#plano').attr({
                        'onchange': "oficinas.changeImage("+oficina.id_plano+", "+oficina.proyecto+")",
                        'data-file': uri[uri.length-1]
                    });
                }

                $('#edit').modal('show');
            }
        }, "json");
    },

    loadImage: function(_images, _container)
    {
        $('#image-container').hide();
        if (!_images) 
            return

        if (_images.length>0) {
            $(_container).html("<img src='/"+_images+"'>");
            return false;
            $('#image-container').show();
        }
        else {
            $(_container).text('Imagen Lista');
        }
    },

    delete:function() {
        var params = {
            id: id,
            tabla: 'archivos',
        }
        $.post(PATH+'admin/oficinas/delete', params, function(response, textStatus, xhr) { console.log(response);
            if (response.result == "success") {
                $('#record-'+params.id).remove();
                $('#delete').modal('hide');
                if ($('.fila').length==0){
                    $('#image-container').hide();
                }
            }
        }, "json");
    },

    changeImage: function(_id, _record) {
        if (action=='new' || _id==null) 
            return false;

        _target = event.target;
        //Form data
        var formData = new FormData();
        formData.append(_target.id, _target.files[0]);
        formData.append('id', _id);
        formData.append('grupo', _target.dataset.group);
        formData.append('seccion', _record);
        formData.append('file', _target.dataset.file);
        //return;

        var request = new XMLHttpRequest();
        request.responseType = 'json';
        request.open('POST', PATH+'admin/proyectos/change_image');
        request.onload = function() {
            //console.log(request.response);
            if (request.response.result=="success") {
                $('#img-'+_target.id).html("<img src='"+PATH + request.response.file+"'>");
            }
            $(_target.id).val('');
        };
        request.send(formData);
    }
}
oficinas.init();
</script>