    <div class="container">
        <div class="row">
            <div class="container col-md-12 row">
                <div class="col-md-2">
                    <button class="btn btn-success" data-toggle="modal" data-target="#edit" id="new">
                        <span class="glyphicon glyphicon-file"></span> Nuevo proyecto
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
                        <th>Proyecto</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Ubicación</th>
                        <th>Oficinas Disponibles</th>
                        <th>Detalle Oficinas</th>
                        <th>Equipamiento Urbano</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($proyectos as $proyecto) {
                            ?>
                        <tr id="record-<?php echo $proyecto->id; ?>">
                            <td>
                                <input type="checkbox" class="checkthis" value="<?php echo $proyecto->id; ?>"/>
                            </td>
                            <td><?php echo $proyecto->proyecto; ?></td>
                            <td><?php echo $proyecto->nombre; ?></td>
                            <td><?php echo $this->tools->wordlimit($proyecto->descripcion, 25); ?></td>
                            <td><?php echo ($proyecto->estado==1) ? "Público":"Oculto"; ?></td>
                            <td><?php echo $proyecto->ubicacion; ?></td>
                            <td><?php echo $proyecto->oficinas; ?></td>
                            <td>
                                <a href="/admin/proyectos/oficinas/<?php echo $proyecto->id; ?>">Ver más</a>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip">
                                    <button class="btn btn-info btn-xs" data-title="Equipamiento Urbano" data-toggle="modal" data-target="#map" data-url="<?php echo $proyecto->url; ?>">
                                        <span class="glyphicon glyphicon-map-marker"></span>
                                    </button>
                                </p>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <button class="btn btn-primary btn-xs" data-title="Editar" data-id="<?php echo $proyecto->id; ?>" onclick="proyectos.editar(<?php echo $proyecto->id; ?>)">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                </p>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Eliminar">
                                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="<?php echo $proyecto->id; ?>"><span class="glyphicon glyphicon-trash"></span></button>
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
                    <form action="<?php echo base_url(); ?>admin/proyectos/save" class="form form-horizontal" name="frm-proyectos" id="frm-proyectos" method="post" enctype="multipart/form-data" target="myframe">
                        <div class="form-group">
                            <label for="proyecto" class="col-sm-3 control-label">Proyecto</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="id">
                                <input class="form-control" type="text" name="proyecto" id="proyecto" placeholder="Proyecto">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre de la proyecto">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-sm-3 control-label">Descripción</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="3" placeholder="Descripción de la proyecto"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="caracteristicas" class="col-sm-3 control-label">Características</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="caracteristicas" id="caracteristicas" cols="30" rows="3" placeholder="Características del proyecto"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direccion" class="col-sm-3 control-label">Dirección</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="direccion" id="direccion" placeholder="Dirección de la proyecto">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ubicacion" class="col-sm-3 control-label">Ubicación</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="ubicacion" id="ubicacion" placeholder="Ubicación de la proyecto">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ubicacion" class="col-sm-3 control-label">Oficinas disponibles</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="oficinas" id="oficinas" placeholder="Número de oficinas en la empresa">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ubicacion" class="col-sm-3 control-label">Mostrar en la página de inicio</label>
                            <div class="col-sm-9">
                                <input class="" type="checkbox" name="entrega" id="entrega">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lista" class="col-sm-3 control-label img-lista" id="img-lista">Imagen Listado</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="lista" id="lista" data-group="lista"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label" id="img-banner">Imagen Banner</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="banner[]" id="banner" title="Seleccionar las imágenes para el Banner del detalle (790x470)" data-group="banner" multiple/>
                            </div>
                        </div>
                        <div class="form-group" id="image-container">
                            <label for="concept" class="col-sm-3 control-label"></label>
                            <div class="col-sm-9" id="container-images">
                                <div class="col-sm-12 row fila">
                                    <div class="col-sm-3 row">
                                        <img src="" alt="" id="img-preview" class="img-work">
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
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="admin.save('proyectos', 'i')"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
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
                    <button type="button" class="btn btn-success" onclick="proyectos.delete('proyectos');"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="map" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <h4 class="modal-title custom_align" id="Heading">Equipamiento Urbano</h4>
                </div>
                <div class="modal-body">
                    <ol>
                        <li>Para Agregar un establecimiento; seleccione un lugar en el mapa, luego indique el nombre y tipo de establecimiento.</li>
                        <li>Para Eliminar un establecimiento; seleccione uno de los marcadores y haga click en el boton Eliminar.</li>
                    </ol>
                    <div id="googlemap" style="height:500px;"></div>
                    <p>&nbsp;</p>
                    <div class="form form-horizontal">
                        <div class="form-group">
                            <label for="" class="control-label col-sm-3">Establecimiento</label>
                            <div class="col-sm-5">
                                <input type="hidden" id="id_establecimiento" name="id_establecimiento">
                                <input type="text" class="form-control" id="establecimiento" name="establecimiento">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-sm-3">Tipo</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="tipo" id="tipo">
                                    <option value="">Seleccione el tipo de establecimiento</option>
                                <?php foreach ($tipo_establecimiento as $tipo) {  
                                    ?>
                                    <option value="<?php echo $tipo->id; ?>"><?php echo $tipo->nombre; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-sm-3">&nbsp;</label>
                            <div class="col-sm-5">
                                <button class="btn btn-success" id="save-establishment">Guardar</button>
                                <button class="btn btn-danger disabled" id="delete-establishment">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <iframe src="" frameborder="0" name="myframe" style="width:100%; height:300px; display:none;"></iframe>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCGqaXaEB_cVXw64okDG9eE-ZaywU9-3Ks"></script>
<script>
$(document).ready(function() {
    $('#edit').on('hide.bs.modal', function (e) {
        $('#img-lista').text('Imagen Listado');
        $('#img-banner').text('Imagen Banner');
        document.forms[0].reset();
    });
});

var proyectos = {
    size: {
        lista: '390x400',
        banner:  '790x470',
    },

    init: function()
    {
        $('#lista').filestyle({
            buttonBefore: true,
            buttonText: "&nbsp;Examinar",
            //input: false, 
            //size: "sm",
            badge: false,
            placeholder: "Imagen de "+proyectos.size['lista'], 
        });

        $('#banner').bootstrapFileInput();

        $('#lista').change(function(event) {
            admin.imagesize(event.currentTarget, proyectos.size['lista']);
        });

        $('#banner').change(function(event) {
            //admin.imagesize(event.currentTarget, proyectos.size['banner']);
        });

        $('#acciones').change(function(event) {
            admin.actions('proyectos', $(this).val());
        });

        $(document).on('click', '.remove_picture', function(event) {
            event.preventDefault();
            if( confirm('Esta seguro de eliminar la foto?')) {
                params = {
                    id: $(this).data('picture'),
                    tabla: 'archivos',
                }
                //console.log(params); return;
                $.post(PATH+'admin/banners/delete', params, function(response, textStatus, xhr) {
                    if (response.result == "success") {
                        $('#row-'+params.id).remove();
                        if ($('.fila').length==0){
                            $('#image-container').hide();
                        }
                    }
                }, "json");
            }
        });

        $('#map').on('show.bs.modal', function (e) {
            uri = $(e.relatedTarget).data('url');
            $.post('/geolocations', {proyect: uri }, function(response, textStatus, xhr) {
                proyectos.urbanEquipment(response);
            }, "json");
        });

        $('#save-establishment').click(function(event) {
            params = {
                id_establecimiento: $('#id_establecimiento').val(),
                proyecto: id,
                establecimiento: $('#establecimiento').val(),
                mapa: proyectos.urbanLatLng,
                tipo: $('#tipo').val()
            }
            $.post(PATH+'admin/urban/save', params, function(response, textStatus, xhr) {
                console.log(response);
                if (response.result!="success") {
                    alert("Se produjo un error vuelva a intentarlo más tarde!");
                    return;
                }
                var marker = new google.maps.Marker({
                  position: new google.maps.LatLng(proyectos.urbanLatLng),
                  map: proyectos.map,
                  title: $('#establecimiento').val(),
                  visible: true
                });
            }, "json");
        });

        $('#delete-establishment').click(function(event) {
            if (confirm("Desea eliminar el elemento seleccionado?")) {
                console.log('Eliminando');
                $.post(PATH+'admin/urban/delete', {id:$('#id_establecimiento').val()}, function(response, textStatus, xhr) {
                    if (response.result!="success") {
                        alert("Se produjo un error vuelva a intentarlo más tarde!");
                        return;
                    }
                    $('#id_establecimiento, #establecimiento').val('');
                    $('#tipo').prop('selectedIndex',0);
                    $('#delete-establishment').addClass('disabled');
                    proyectos.marker.setMap(null);
                }, "json");
            }
        });
    },

    editar: function(_id)
    {
        $.post(PATH+'admin/proyectos/get/'+_id, {}, function(response, textStatus, xhr) {
            if (response.result=="success") {
                proyecto = response.data;
                $('#id').val( proyecto.id );
                $('#proyecto').val( proyecto.proyecto );
                $('#nombre').val( proyecto.nombre );
                $('#descripcion').val( proyecto.descripcion );
                $('#caracteristicas').val( proyecto.caracteristicas );
                $('#ubicacion').val( proyecto.ubicacion );
                $('#direccion').val( proyecto.dire );
                $('#oficinas').val( proyecto.oficinas );

                checked = (proyecto.entrega==1) ? true:false;
                $('#entrega').attr('checked', checked);
                //$('#area').val( proyecto.area );
                //$('#tipo').val( proyecto.tipo );
                //$('#condicion'+proyecto.condicion).prop( 'checked', true );

                //Load image
                imagenes = (response.imagenes) ? response.imagenes:{};
                proyectos.loadImage(proyecto.lista, '#img-lista');
                proyectos.loadImage(proyecto.banner, '#img-banner');
                proyectos.loadImage(imagenes, '#img-preview');
                //console.log(imagenes);
                uri = proyecto.lista.split('/');
                $('#lista').attr({
                    'onchange': "proyectos.changeImage("+proyecto.id_lista+", "+proyecto.id+")", 
                    'data-file': uri[uri.length-1]
                });
                //$('#banner').attr('onchange', "proyectos.changeImage("+proyecto.id_banner+", "+proyecto.id+")");

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
            if (typeof _images == "string" && _images!="") {
                $(_container).html("<img src='/"+_images+"'>");
                return false;
            }

            $('.fila').remove();

            for(x=0; x<_images.length; x++){
                cont_image = $('<div></div>')
                .addClass('col-sm-3 row img-banner'+x);

                $('<img>')
                .addClass('img-work')
                //.attr('id', 'img-banner'+x)
                .appendTo(cont_image);

                cont_btn = $('<div></div>')
                .addClass('col-sm-2');

                //Add input file for change picture
                uri = _images[x].foto.split('/');
                $('<input>')
                .attr({
                    name: 'banner'+x, 
                    id: 'banner', 
                    type: "file",
                    class: "banners btn-sm",
                    title: "Cambiar",
                    'data-btn': "btn-primary",
                    'data-filename-placement': "none",
                    onchange: "proyectos.changeImage("+_images[x].id+","+proyecto.id+")",
                    'data-group': "banner",
                    'data-file': uri[uri.length-1],
                })
                .appendTo(cont_btn);
                //Add button Delete
                $('<button></button>')
                .addClass('btn btn-danger btn-xs remove_picture')
                .attr({
                    'data-picture': _images[x].id,
                    title: 'Eliminar foto'
                })
                //.attr('data-picture', _images[x].id)
                .html('<span class="glyphicon glyphicon-trash"></span>')
                .appendTo(cont_btn);

                fila = $('<div></div>')
                .addClass('col-sm-12 row fila')
                .attr('id', 'row-'+_images[x].id);

                fila.append(cont_image);
                fila.append(cont_btn);

                $('#abcde').before(fila); 
                //image = new Image();

                q = Math.ceil((Math.random() * 1000)) ;
                $('.img-work').eq(x).attr('src', PATH + _images[x].foto + "?" + q);

            }
            $('.banners').bootstrapFileInput();
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
        $.post(PATH+'admin/proyectos/delete', params, function(response, textStatus, xhr) {
            console.log(response);
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
        request.onload = function(data) {
            //console.log(request.response.result);
            //return;
            if (request.response.result=="success") {
                $('.img-'+_target.name).html("<img src='"+PATH + request.response.file+"?"+request.response.nocache+"' class='img-work'>");
                //$('.img-'+_target.name).attr('src',PATH + request.response.file);
                return;
            }
            alert(request.response.details.msg);
        };
        request.send(formData);
    },

    map: null,
    marker: null,
    urbanLatLng: null,
    urbanEquipment: function(_location) {
        //function initializeMaps(_location) {
            console.log(_location);
            id = _location.build.id;
            mapa = _location.build.map.split(",");
            var mapOptions = {
                zoom: 16,
                center: new google.maps.LatLng(mapa[0], mapa[1])
            };

            proyectos.map = new google.maps.Map(document.getElementById('googlemap'),
                mapOptions);

            /*map.addListener('click', function(e) {
                console.log(e);
            });*/

            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(mapa[0], mapa[1]),
              map: proyectos.map,
              title: _location.build.proyect,
            });

            google.maps.event.addListener(proyectos.map, 'click', function(e){
                proyectos.urbanLatLng = e.latLng.lat()+","+e.latLng.lng();
                //console.log(proyectos);

                var marker = new google.maps.Marker({
                    position: e.latLng, 
                    map: proyectos.map,
                    title: 'Indica el nombre y tipo de establecimiento'
                });

                console.log(proyectos.urbanLatLng);
                $('#id_establecimiento, #establecimiento').val('');
                $('#establecimiento').focus();
                $('#establecimiento').css({backgroundColor:'#73c273'});
                $('#tipo').prop('selectedIndex',0);
                $('#delete-establishment').addClass('disabled');
            });

            for(i=0; i<_location.equipment.length; i++) {
                //console.log(_location.equipment);
                mapa = _location.equipment[i].mapa.split(","); 
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(mapa[0], mapa[1]),
                    map: proyectos.map,
                    title: _location.equipment[i].establecimiento + " | Haz click aquí para cambiar el nombre o eliminar el establecimiento.",
                    id_establecimiento: _location.equipment[i].id,
                    tipo: _location.equipment[i].id_tipo,
                    establecimiento: _location.equipment[i].establecimiento,
                });
                marker.addListener('click', function(e){
                    //console.log(this);
                    $('#establecimiento').css({backgroundColor:'#fff'});
                    $('#id_establecimiento').val(this.id_establecimiento);
                    $('#tipo').val(this.tipo);
                    $('#establecimiento').val(this.establecimiento);
                    proyectos.urbanLatLng = this.position.lat()+","+this.position.lng();
                    $('#delete-establishment').removeClass('disabled');
                    proyectos.marker = this;
                });
            }

        //};
    }
}
proyectos.init();
</script>