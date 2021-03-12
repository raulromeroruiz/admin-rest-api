    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="<?php echo base_url(); ?>admin/perfil/save" class="form form-horizontal" name="frm-perfil" id="frm-perfil" method="post" enctype="multipart/form-data" target="myframe">
                    <div class="form-group">
                        <label for="concept" class="col-sm-3 control-label">Nombres</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" id="id" value="<?php echo $perfil->id; ?>">
                            <input class="form-control" type="text" name="nombres" id="nombres" placeholder="Nombres" value="<?php echo $perfil->nombres; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="concept" class="col-sm-3 control-label">Apellidos</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="apellidos" id="apellidos" placeholder="Apellidos" value="<?php echo $perfil->apellidos; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="concept" class="col-sm-3 control-label">Correo</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="correo" id="correo" placeholder="Correo para iniciar sesión" value="<?php echo $perfil->correo; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="concept" class="col-sm-3 control-label">Tipo de Usuario</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="tipo" id="tipo">
                                <option value="">Tipo de usuario</option>
                            <?php foreach ($tipo_usuarios as $tipo) {
                                $active = ($tipo->id==$perfil->tipo)  ? "selected":"";
                                ?>
                                <option value="<?php echo $tipo->id; ?>" <?php echo $active; ?> ><?php echo $tipo->nombre; ?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="concept" class="col-sm-3 control-label"></label>
                        <div class="col-sm-9">
                            Cambiar contraseña
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="concept" class="col-sm-3 control-label">Nueva contraseña</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="password" name="password" id="password" placeholder="Contraseña">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="concept" class="col-sm-3 control-label">Confirmar contraseña</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="password" name="cpassword" id="cpassword" placeholder="Confirmar contraseña">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="concept" class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-warning btn-lg" onclick="perfil.save()"><span class="glyphicon glyphicon-ok-sign"></span> Guardar</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

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
                    <button type="button" class="btn btn-success" onclick="admin.delete('perfil');"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
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

var perfil = {
    this: this,
    init: function()
    {
        
    },

    save: function()
    {
        target = event.target;
        var datos = $('#frm-perfil').serializeArray();
        $(target)
        .text('Guardando info...')
        .addClass('disabled');

        msg = "";
        for(x in datos) {
            switch(datos[x].name) {
                case "nombres":
                    msg += this.validate(datos[x].name, datos[x].value, 'name');
                    break
                case "apellidos":
                    msg += this.validate(datos[x].name, datos[x].value, 'name');
                    break
                case "password":
                    if ( $('#password').val()!="" || $('#cpassword').val()!="" ) {
                        msg += this.validate(datos[x].name, datos[x].value, 'pass');
                        msg += ( $('#password').val()!=$('#cpassword').val() ) ? "Debe confirmar su contraseña":"";
                    }
                    break
                case "correo":
                    msg += this.validate(datos[x].name, datos[x].value, 'email');
                    break
                case "tipo":
                    msg += this.validate(datos[x].name, datos[x].value, 'num');
                    break
            }
        }
        if (msg!="") {
            alert(msg);
            $(target)
            .html('Guardar')
            .removeClass('disabled');
            return false;
        }
        else {
            $.post(PATH+'admin/perfil/save', datos, function(response, textStatus, xhr) {
                if (response.result=="success") {
                    alert(response.message);
                    location.href = PATH+"admin/logout";
                }
                else {
                    alert(response.message);
                    $(target)
                    .html('Guardar')
                    .removeClass('disabled');
                    return false;
                }
            }, "json");
        }
    },

    validate: function(_field, _value, _rule) 
    {
        switch(_rule) {
            case "user":
                return (!ck_user.test(_value)) ? "El valor ingresado en el campo "+_field.toUpperCase()+" no es valido\n":"";
                break;
            case "name":
                return (!ck_name.test(_value)) ? "El valor ingresado en el campo "+_field.toUpperCase()+" no es valido\n":"";
                break;
            case "text":
                return (!ck_text.test(_value)) ? "El valor ingresado en el campo "+_field.toUpperCase()+" no es valido\n":"";
                break;
            case "email":
                return (!ck_email.test(_value)) ? "El valor ingresado en el campo "+_field.toUpperCase()+" no es valido\n":"";
                break;
            case "pass":
                return (!ck_password.test(_value)) ? "El valor ingresado en el campo "+_field.toUpperCase()+" no es valido\n":"";
                break;
            case "num":
                return (!ck_number.test(_value)) ? "El valor ingresado en el campo "+_field.toUpperCase()+" no es valido\n":"";
                break;
        }
    }
    
},
    ck_user = /^[A-Za-z0-9_]{4,20}$/,
    ck_name = /^[A-Za-zÁÉÍÓÚÑñáéíóú ]{3,255}$/,
    ck_text = /^[A-Za-z0-9ÁÉÍÓÚÑñáéíóú_.,#()\/\-+ ]{3,255}$/,
    ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i,
    ck_password = /^[A-Za-z0-9!@#$%^&*()_]{5,50}$/,
    ck_number = /^[0-9.]{1,20}$/;

perfil.init();
</script>