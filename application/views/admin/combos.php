    <div class="container">
        <div class="row">
            <div class="container col-md-12 row">
                <div class="col-md-2">
                    <button class="btn btn-success" data-toggle="modal" data-target="#edit" id="new">
                        <span class="glyphicon glyphicon-file"></span> Nuevo combo
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
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Compartir</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($combos as $combo) {
                            ?>
                        <tr id="record-<?php echo $combo->id; ?>">
                            <td>
                                <input type="checkbox" class="checkthis" value="<?php echo $combo->id; ?>"/>
                            </td>
                            <td><?php echo $combo->nombre; ?></td>
                            <td><?php echo nl2br($combo->descripcion); ?></td>
                            <td><?php echo $combo->tipo; ?></td>
                            <td><?php echo $combo->precio; ?></td>
                            <td><?php echo $combo->compartir; ?></td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <button class="btn btn-primary btn-xs" data-title="Editar" data-id="<?php echo $combo->id; ?>" onclick="combos.editar(<?php echo $combo->id; ?>)">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                </p>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Eliminar">
                                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="<?php echo $combo->id; ?>"><span class="glyphicon glyphicon-trash"></span></button>
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
                    <form action="<?php echo base_url(); ?>combos/save" class="form form-horizontal" name="frm-combos" id="frm-combos" method="post" enctype="multipart/form-data" target="myframe">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre de la combo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-sm-3 control-label">Descripción</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="5" placeholder="Descripción de la combo"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="caracteristicas" class="col-sm-3 control-label">Tipo</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="tipo" id="tipo" placeholder="Tipo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="compartir" class="col-sm-3 control-label">Compartir</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="compartir" id="compartir" cols="30" rows="2" placeholder="Texto a compartir en WhatsApp"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="compartir" class="col-sm-3 control-label">Precio</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="precio" id="precio" placeholder="Precio">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lista" class="col-sm-3 control-label img-lista" id="img-lista">Imagen Lista</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="lista" id="lista" data-group="lista" onchange="combos.readerFile();" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" onclick="admin.save('combos', 'i')"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
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
                    <button type="button" class="btn btn-success" onclick="combos.delete('combos');"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
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
<!--
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCGqaXaEB_cVXw64okDG9eE-ZaywU9-3Ks"></script>
-->
<script>
$(document).ready(function() {
    $('#edit').on('hide.bs.modal', function (e) {
        $('#img-lista').text('Imagen Listado');
        $('#img-banner').text('Imagen Banner');
        document.forms[0].reset();
    });
});

var combos = {
    size: {
        lista: '971x717',
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
            placeholder: "Imagen de "+combos.size['lista'], 
        });

        $('#banner').bootstrapFileInput();

        $('#lista').change(function(event) {
            // admin.imagesize(event.currentTarget, combos.size['lista']);
        });

        $('#banner').change(function(event) {
            //admin.imagesize(event.currentTarget, combos.size['banner']);
        });

        $('#acciones').change(function(event) {
            admin.actions('combos', $(this).val());
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
                combos.urbanEquipment(response);
            }, "json");
        });

        $('#save-establishment').click(function(event) {
            params = {
                id_establecimiento: $('#id_establecimiento').val(),
                combo: id,
                establecimiento: $('#establecimiento').val(),
                mapa: combos.urbanLatLng,
                tipo: $('#tipo').val()
            }
            $.post(PATH+'admin/urban/save', params, function(response, textStatus, xhr) {
                console.log(response);
                if (response.result!="success") {
                    alert("Se produjo un error vuelva a intentarlo más tarde!");
                    return;
                }
                var marker = new google.maps.Marker({
                  position: new google.maps.LatLng(combos.urbanLatLng),
                  map: combos.map,
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
                    combos.marker.setMap(null);
                }, "json");
            }
        });
    },

    editar: function(_id)
    {
        $.post(PATH+'admin/combos/get/'+_id, {}, function(response, textStatus, xhr) {
            if (response.result=="success") {
                combo = response.data;
                $('#id').val( combo.id );
                $('#nombre').val( combo.nombre );
                $('#descripcion').val( combo.descripcion );
                $('#tipo').val( combo.tipo );
                $('#compartir').val( combo.compartir );
                $('#precio').val( combo.precio );

                // checked = (combo.entrega==1) ? true:false;
                // $('#entrega').attr('checked', checked);
                // $('#area').val( combo.area );
                // $('#condicion'+combo.condicion).prop( 'checked', true );

                //Load image
                imagenes = (response.imagenes) ? response.imagenes:{};
                combos.loadImage(combo.lista, '#img-lista');
                // combos.loadImage(combo.banner, '#img-banner');
                // combos.loadImage(imagenes, '#img-preview');
                //console.log(imagenes);
                uri = combo.lista.split('/');
                $('#lista').attr({
                    // 'onchange': "combos.changeImage("+combo.id_lista+", "+combo.id+")", 
                    'data-file': uri[uri.length-1],
                    'data-combo': combo.id,
                    'data-lista': combo.id_lista
                });

                $('#edit').modal('show');
            }
        }, "json");
    },

    loadImage: function(_images, _container)
    {console.log(_images);
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
                    onchange: "combos.changeImage("+_images[x].id+","+combo.id+")",
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
        $.post(PATH+'admin/combos/delete', params, function(response, textStatus, xhr) {
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

    readerFile: function(params)
    {
        target = event.target;
        file = target.files[0];
        size = this.size.lista;
        combo = target.dataset.combo;
        lista = target.dataset.lista;

        var reader = new FileReader();
        var image = new Image();
        reader.readAsDataURL(file); 
        inputFile = ($(target).parent('a').length>0) ? $(target).parent('a'):$(target).next('.bootstrap-filestyle').find('label');
        reader.onload = function(_file) {
            image.src    = _file.target.result;              // url.createObjectURL(file);
            image.onload = function() {
                var w = this.width,
                    h = this.height,
                    t = file.type,                           // ext only: // file.type.split('/')[1],
                    n = file.name,
                    s = ~~(file.size/1024) +'KB';
                inputFile.removeClass('alert-danger');
                if (size != w+'x'+h){
                    inputFile.addClass('alert-danger');
                    alert('La imagen debe tener las siguientes dimensiones '+size);
                    return false;
                }
                combos.changeImage(target);
            };
            image.onerror= function() {
                inputFile.addClass('alert-danger');
                alert('Tipo de archivo no valido: '+ file.type+'\nUtilice solo imágenes con extensión .jpg');
                return false;
            };      
        };
    },

    changeImage: function(_file) {
        if (action=='new' || _file.dataset.lista==null) 
            return false;

        _target = _file;
        //Form data
        var formData = new FormData();
        formData.append(_target.id, _target.files[0]);
        formData.append('id', _target.dataset.lista);
        formData.append('grupo', _target.dataset.group);
        formData.append('seccion', _target.dataset.combo);
        formData.append('file', _target.dataset.file);
        //return;

        var request = new XMLHttpRequest();
        request.responseType = 'json';
        request.open('POST', PATH+'admin/combos/change_image');
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

            combos.map = new google.maps.Map(document.getElementById('googlemap'),
                mapOptions);

            /*map.addListener('click', function(e) {
                console.log(e);
            });*/

            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(mapa[0], mapa[1]),
              map: combos.map,
              title: _location.build.proyect,
            });

            google.maps.event.addListener(combos.map, 'click', function(e){
                combos.urbanLatLng = e.latLng.lat()+","+e.latLng.lng();
                //console.log(combos);

                var marker = new google.maps.Marker({
                    position: e.latLng, 
                    map: combos.map,
                    title: 'Indica el nombre y tipo de establecimiento'
                });

                console.log(combos.urbanLatLng);
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
                    map: combos.map,
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
                    combos.urbanLatLng = this.position.lat()+","+this.position.lng();
                    $('#delete-establishment').removeClass('disabled');
                    combos.marker = this;
                });
            }

        //};
    }
}
combos.init();
</script>