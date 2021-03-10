    <div class="container">
        <div class="row">
            <div class="container col-md-12 row">
                <div class="col-md-2">
                    <button class="btn btn-success" data-toggle="modal" data-target="#edit" id="new">
                        <span class="glyphicon glyphicon-file"></span> Nuevo producto
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
                        <th>Tipo</th>
                        <th>Categoría</th>
                        <th>Compartir</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($productos as $producto) {
                            ?>
                        <tr id="record-<?php echo $producto->id; ?>">
                            <td>
                                <input type="checkbox" class="checkthis" value="<?php echo $producto->id; ?>"/>
                            </td>
                            <td><?php echo $producto->nombre; ?></td>
                            <td><?php echo $producto->tipo; ?></td>
                            <td><?php echo $producto->categoria; ?></td>
                            <td><?php echo $producto->compartir; ?></td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Editar">
                                    <button class="btn btn-primary btn-xs" data-title="Editar" data-id="<?php echo $producto->id; ?>" onclick="productos.editar(<?php echo $producto->id; ?>)">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                </p>
                            </td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Eliminar">
                                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="<?php echo $producto->id; ?>"><span class="glyphicon glyphicon-trash"></span></button>
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
                    <form action="<?php echo base_url(); ?>productos/save" class="form form-horizontal" name="frm-productos" id="frm-productos" method="post" enctype="multipart/form-data" target="myframe">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre de la producto">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-sm-3 control-label">Descripción</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="5" placeholder="Descripción de la producto"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="caracteristicas" class="col-sm-3 control-label">Tipo</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="tipo" id="tipo" placeholder="Tipo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="compartir" class="col-sm-3 control-label">Precio</label>
                            <div class="col-sm-9">
                                <div class="fila">
                                    <a class="btn btn-primary add-price">Añadir</a>
                                </div>
                                <div class="row prices">
                                </div>
                            </div>
                            <input type="hidden" name="precio" id="precio">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-sm-3">Categoría</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="categoria" id="categoria">
                                    <option value="">Seleccione la categoría</option>
                                <?php foreach ($categorias as $categoria) {  
                                    ?>
                                    <option value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="compartir" class="col-sm-3 control-label">Compartir</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="compartir" id="compartir" cols="30" rows="2" placeholder="Texto a compartir en WhatsApp"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="foto" class="col-sm-3 control-label img-foto" id="img-foto">Foto</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="filename" id="filename">
                                <input type="hidden" name="id_file" id="id_file">
                                <input class="form-control" type="file" name="foto" id="foto" data-group="foto" onchange="productos.readerFile();" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-success btn-lg" style="width: 100%;" onclick="admin.save('productos', 'i')"><span class="glyphicon glyphicon-ok-sign"></span> Guardar</button>
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
                    <button type="button" class="btn btn-warning" onclick="productos.delete('productos');"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
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
        $('#img-foto').text('Foto');
        document.forms[0].reset();
    });
});

var productos = {
    size: {
        foto: '971x717',
        banner:  '790x470',
    },

    init: function()
    {
        $('#foto').filestyle({
            buttonBefore: true,
            buttonText: "&nbsp;Examinar",
            //input: false, 
            //size: "sm",
            badge: false,
            placeholder: "Imagen de "+productos.size['foto'], 
        });

        $('#banner').bootstrapFileInput();

        $('#acciones').change(function(event) {
            admin.actions('productos', $(this).val());
        });

        $('.add-price').click(function(event) {
            productos.addPrice({});
        });

        $(document).on('blur', '.costo, .detalle', function(event) {
            event.preventDefault();
            // console.log('blur');
            precios = $('.price');
            // console.log('total precios ' + precios.lenght);
            obj = [];
            precios.each(function(index, el) {
                // console.log(index, el);
                // console.log($(el).find('.costo').val());
                item = {costo: $(el).find('.costo').val(), descripcion: $(el).find('.detalle').val()};
                obj.push(item);

            });
            $('#precio').val(JSON.stringify(obj));
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
                productos.urbanEquipment(response);
            }, "json");
        });

        $('#save-establishment').click(function(event) {
            params = {
                id_establecimiento: $('#id_establecimiento').val(),
                producto: id,
                establecimiento: $('#establecimiento').val(),
                mapa: productos.urbanLatLng,
                tipo: $('#tipo').val()
            }
            $.post(PATH+'admin/urban/save', params, function(response, textStatus, xhr) {
                console.log(response);
                if (response.result!="success") {
                    alert("Se produjo un error vuelva a intentarlo más tarde!");
                    return;
                }
                var marker = new google.maps.Marker({
                  position: new google.maps.LatLng(productos.urbanLatLng),
                  map: productos.map,
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
                    productos.marker.setMap(null);
                }, "json");
            }
        });
    },

    editar: function(_id)
    {
        $.post(PATH+'admin/productos/get/'+_id, {}, function(response, textStatus, xhr) {
            if (response.result=="success") {
                producto = response.data;
                $('#id').val( producto.id );
                $('#nombre').val( producto.nombre );
                $('#descripcion').val( producto.descripcion );
                $('#tipo').val( producto.tipo );
                $('#compartir').val( producto.compartir );
                $('#precio').val( producto.precio );
                $('#categoria').val( producto.categoria );

                // Prices
                $('.prices').html('');
                if (producto.precio==""){
                    console.log('No precio');
                    // $('#precio2').prev().html('button');
                }
                else {
                    prices = JSON.parse(producto.precio);
                    console.log(typeof prices);
                    if (typeof prices == "number"){
                        console.log('unique price');
                        obj = {costo:producto.costo};
                        productos.addPrice(obj);
                    }
                    else {
                        console.log('multiple prices')
                        for(x in prices){
                            obj = {
                                costo: prices[x].costo,
                                descripcion: prices[x].descripcion
                            };
                            productos.addPrice(obj);
                        }
                    }
                }
                //Load image
                imagenes = (response.imagenes) ? response.imagenes:{};
                productos.loadImage(producto.foto, '#img-foto');
                // productos.loadImage(producto.banner, '#img-banner');
                // productos.loadImage(imagenes, '#img-preview');
                //console.log(imagenes);
                if (producto.foto) {
                    uri = producto.foto.split('/');
                    $('#foto').attr({
                        'data-file': uri[uri.length-1],
                        'data-producto': producto.id,
                        'data-foto': producto.id_foto
                    });
                    $('#filename').val( uri[uri.length-1] );
                    $('#id_file').val( producto.id_foto );
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
            if (typeof _images == "string" && _images!="") {
                $(_container).html("<img src='/"+_images+"?v=" + Math.random() + "'>");
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
                    onchange: "productos.changeImage("+_images[x].id+","+producto.id+")",
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
            $(_container).text('Foto');
        }
    },

    delete:function() {
        var params = {
            id: id,
            tabla: 'archivos',
        }
        $.post(PATH+'admin/productos/delete', params, function(response, textStatus, xhr) {
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
        size = this.size.foto;
        // producto = target.dataset.producto;
        foto = target.dataset.foto;
        container = document.getElementById("img-" + target.id);

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
                container.innerHTML = "";
                container.appendChild(this);
            };
            image.onerror= function() {
                inputFile.addClass('alert-danger');
                alert('Tipo de archivo no valido: '+ file.type+'\nUtilice solo imágenes con extensión .jpg');
                return false;
            };      
        };
    },

    changeImage: function(_file) {
        if (action=='new' || _file.dataset.foto==null) 
            return false;

        _target = _file;
        //Form data
        var formData = new FormData();
        formData.append(_target.id, _target.files[0]);
        formData.append('id', _target.dataset.foto);
        formData.append('grupo', _target.dataset.group);
        formData.append('seccion', _target.dataset.producto);
        formData.append('file', _target.dataset.file);
        //return;

        var request = new XMLHttpRequest();
        request.responseType = 'json';
        request.open('POST', PATH+'admin/productos/change_image');
        request.onload = function(data) {
            console.log(data);
            console.log(request);
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

    addPrice: function(_params){
        console.log(_params);
        costo = (_params.costo!="" && _params.costo) ? _params.costo:"";
        dscr = (_params.descripcion!="" && _params.descripcion) ? _params.descripcion:"";
        fila = `<div class="fila clear price">
            <div class="col-2">
                <input type="text" class="form-control costo" value="` + costo + `" placeholder="Precio">
            </div>
            <div class="col-4">
                <input type="text" class="form-control detalle" value="` + dscr + `" placeholder="Descripción">
            </div>
        </div>`;
        $('.prices').append(fila);
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

            productos.map = new google.maps.Map(document.getElementById('googlemap'),
                mapOptions);

            /*map.addListener('click', function(e) {
                console.log(e);
            });*/

            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(mapa[0], mapa[1]),
              map: productos.map,
              title: _location.build.proyect,
            });

            google.maps.event.addListener(productos.map, 'click', function(e){
                productos.urbanLatLng = e.latLng.lat()+","+e.latLng.lng();
                //console.log(productos);

                var marker = new google.maps.Marker({
                    position: e.latLng, 
                    map: productos.map,
                    title: 'Indica el nombre y tipo de establecimiento'
                });

                console.log(productos.urbanLatLng);
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
                    map: productos.map,
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
                    productos.urbanLatLng = this.position.lat()+","+this.position.lng();
                    $('#delete-establishment').removeClass('disabled');
                    productos.marker = this;
                });
            }

        //};
    }
}
productos.init();
</script>