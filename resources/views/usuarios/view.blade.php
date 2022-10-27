@include('partials.header')

<script type='text/javascript'>

    $(function() {
        $('.datos-usuario').on('click', '.save', function(){
            editDatos();
        });
        
        $('#colegiaturas').DataTable( {
            ajax: {
                type: 'POST',
                url: '/ajax/getalumnoallcolegiaturas',
                dataType: 'json',
                data:
                {
                    '_token'  : '{{ csrf_token() }}'
                },
            },
            language: {
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "lengthMenu":     "Mostrando _MENU_ pagos",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Busqueda:",
                "zeroRecords":    "Ningún pagos encontrado",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            },
            columns: [
                { data: 'Id' },
                { data: 'Descripcion' },
                { defaultContent: 'Estatus', 'render': function ( data, type, row ) 
                    {
                        let estatus;
                        let tClass;
                        switch(row.Estatus) {
                          case 2:
                            estatus = 'Pagado';
                            tClass  = 'btn-success';
                            break;
                          case 1:
                            estatus = 'Parcial';
                            tClass  = 'btn-warning';
                            break;
                          case 0:
                            estatus = 'Pendiente';
                            tClass  = 'btn-secondary';
                            break;
                        }
                        let view = `<span class="mb-2 mr-2 btn-hover-shine btn ${tClass}">${estatus}</span>`;
                        return  view;
                    } 
                },
                { data: 'Fecha_creacion' }
            ]
        }); 
    }); 
    
    
    function editDatos(){
        $('.loader').show();
        let datos = {
            'id'      : {{$_GET['usuario']}},
            'nombre'  : $('#nombre').val(),
            'email'   : $('#email').val(),
            'password': $('#password').val(),
            'rol'     : $('#rol').children("option:selected").val(),
            'plantel' : $('#plantel').val(),
            'estatus' : $('#estatus').children("option:selected").val()
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/updateusuario',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'datos': datos
            },
            success: function (result) {
                $('.loader').hide();
                Swal.fire({
                      icon: result[0],
                      title: (result[0] == 'success' ? 'Éxito' : 'Error'),
                      text: result[1],
                      timer: 1000,
                      timerProgressBar: true,
                      onClose: () => {
                        if(result[0] == 'success'){
                            location.reload();
                        }
                      }
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al guardar el usuario'
                });
            }
        });
    }
</script>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-user icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>
                    {{$usuario[0]->name}}
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="edit-container" id="datos-alumnos">
                                        <h5 class="card-title">Datos Del Usuario</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-4 datos-usuario">
                                                <label for="nombre">Nombre</label>
                                                <input type="test" class="form-control" id="nombre" disabled="disabled" value="{{$usuario[0]->name}}">
                                                <button class="edit-save-btn edit" input="nombre">Editar</button>
                                            </div>
                                            <div class="form-group col-md-4 datos-usuario">
                                                <label for="email">Correo</label>
                                                <input type="email" class="form-control" id="email" disabled="disabled" value="{{$usuario[0]->email}}">
                                                <button class="edit-save-btn edit" input="email">Editar</button>
                                            </div>
                                            <div class="form-group col-md-4 datos-usuario">
                                                <label for="rol">Rol</label>
                                                <select class="form-control" name="rol" id="rol" disabled="disabled">
                                                    <option value="0" >Seleccionar rol</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{$role->Id}}"  @if(@$usuario_relaciones[0]->Role_id == $role->Id) selected="selected"  @endif>{{$role->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                                <button class="edit-save-btn edit" input="rol">Editar</button>
                                            </div>

                                            <div class="form-group col-md-4 datos-usuario planteles-container">
                                                <label for="rol">plantel</label>
                                                <select class="form-control" name="plantel" id="plantel" disabled="disabled" multiple>
                                                    <option value="0">Seleccionar plantel</option>
                                                    @foreach ($planteles as $plantel)
                                                        <option value="{{$plantel->Id}}" @if(@$usuario_relaciones[0]->Plantel_id == $plantel->Id) selected="selected"  @endif>{{$plantel->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                                <button class="edit-save-btn edit" input="plantel">Editar</button>
                                            </div>

                                            <div class="form-group col-md-4 datos-usuario">
                                                <label for="estatus">Estatus</label>
                                                <select class="form-control" name="estatus" id="estatus" disabled="disabled">
                                                    <option value="1" @if($usuario[0]->status == 0) selected="selected"  @endif>Activo</option>
                                                    <option value="0" @if($usuario[0]->status == 0) selected="selected"  @endif>Inactivo</option>
                                                </select>
                                                <button class="edit-save-btn edit" input="estatus">Editar</button>
                                            </div>
                                            <div class="form-group col-md-4 datos-usuario">
                                                <label for="password">Contraseña</label>
                                                <input type="password" class="form-control" id="password" autocomplete="new-password" disabled="disabled">
                                                <button class="edit-save-btn edit" input="password">Editar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>   
    </div>
</div>
@include('partials.footer')