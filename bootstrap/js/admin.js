var id, action, 
    port = (window.location.hostname=="localhost") ? ":"+window.location.port:"",
    PATH = window.location.protocol+"//"+window.location.hostname + port + "/";
$(document).ready(function() {

    $('#edit').on('show.bs.modal', function (e) {
        action = $(e.relatedTarget).attr('id');
        if (action=="new") {
            document.forms[0].reset();
            $('#id').val('');
            $('#Heading').text('Nuevo registro');
            $('#btn-save').text('Guardar');
            $('#image-container').hide();
        }
        else {
            $('#Heading').text('Editar registro');
        }
        $('.file-input-name').remove();
    });

    $('#delete').on('show.bs.modal', function (e) {
      id = $(e.relatedTarget).data('id');
    });

});

var admin = {
    typeimages:['image/jpeg', 'image/png', 'image/gif'],
    onlyjpeg: 'image/jpeg',

    init: function()
    {
        $('#clave').keyup(function(event) {
            if (event.keyCode==13 || event.which==13) {
                $('#btn-login').click();
            }
        });

        $('#btn-login').click(function(event) {
            event.preventDefault();
            datos = $('#frm-login').serializeArray();
            //openAjax();
            $.post(PATH+'admin/login', datos, function(response, textStatus, xhr) {
                if (response.result=="success") {
                    admin.storage('set', 'email', datos[0].value);
                    location.href = PATH + "admin/home";
                }
                else {
                    //closeAjax();
                    $('#response')
                    .text(response.message)
                    .addClass('alert alert-danger')
                    .fadeIn(500);
                    setTimeout(function(){
                        $('#response').fadeOut(500);
                    }, 5000);
                }
            }, "json");
        });

        //storage username
        $('#correo').val( admin.storage('get', 'email') );
        if( $('#correo').val()!="")
            $('#password').focus();
    },

    loadImage: function(_src, _container)
    {
        image = new Image();
        $(_container).attr('src', null);
        $('#image-container').hide();
        if (_src!=null){
            image.onload = function(e){
                $(_container).attr('src', this.src);
                $('#image-container').show();
            }
            image.src = PATH + _src;
        }
    },

    save: function(_tabla, _tipo)
    {
        if (_tipo=="i") {
            //document.forms['frm-'+_tabla].submit();
            document.forms['frm-'+_tabla].submit();
        }
        else {
            console.log("iframe");
            $.post('/path/to/file', {param1: 'value1'}, function(response, textStatus, xhr) {
                /*optional stuff to do after success */
            });
        }
    },

    delete: function(_tabla)
    {
        params = {
            id: id,
            tabla: _tabla,
        };

        $.post(PATH+'admin/manager/delete', params, function(response, textStatus, xhr) {
            if (response.result == "success") {
                $('#record-'+id).remove();
                $('#delete').modal('hide');
            }
        }, "json");
    },

    actions: function(_tabla, _action)
    {
        //Get id's
        ids = [];
        $("input.checkthis:checked").each(function(index, el) {
            ids.push( $(el).val() );
        });
        //trace([ids.join(","), _action]); return;
        if (ids.length==0) 
            return;

        //myaction = $(event.target).find('option:selected').text();
        myaction = document.getElementById('acciones').options[document.getElementById('acciones').selectedIndex].text;
        if (confirm('Está seguro de '+myaction+', los elementos seleccionados?')) {
            params = {
                id: ids,
                tabla: _tabla,
                accion: _action,
            };

            $.post(PATH+'admin/actions', params, function(response, textStatus, xhr) {
                if (response.result == "success") {
                    location.reload();
                }
            }, "json");
        }
    },

    imagesize: function(_file, _size)
    {
        _files = _file.files;
        for(i=0; i<_files.length; i++) {
            this.readerFile( _files[i], _size, _file);
        }
    },

    readerFile: function(file, size, target)
    {
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
                //$('#uploadPreview').append('<img src="'+ this.src +'"> '+w+'x'+h+' '+s+' '+t+' '+n+'<br>');
                //trace('<img src="'+ this.src +'"> '+w+'x'+h+' '+s+' '+t+' '+n+'<br>');
                inputFile.removeClass('alert-danger');
                if (size != w+'x'+h){
                    inputFile.addClass('alert-danger');
                    alert('La imagen debe tener las siguientes dimensiones '+size);
                }
            };
            image.onerror= function() {
                inputFile.addClass('alert-danger');
                alert('Tipo de archivo no valido: '+ file.type+'\nUtilice solo imágenes con extensión .jpg');
            };      
        };
    },

    fileAjax: function(ele, x) { console.log('Cargando archivo');
        if (x==false){
            $("#"+ele).show();
        }
        else {
            $("#"+ele).hide();
        }
    },

    storage: function(_action, _key, _value) {
        if (localStorage) {
            switch(_action) {
                case 'set':
                    localStorage.setItem(_key, _value);
                    break;
                case 'get':
                    return (localStorage.getItem(_key)!="undefined") ?localStorage.getItem(_key):"";
                    break;
                case 'delete':
                    localStorage.removeItem(_key);
                    break;
            }
        }
        else {
            console.log('No localStorage');
        }
    }
}

var trace = function(msg) 
{
    console.log(msg);
}
admin.init();