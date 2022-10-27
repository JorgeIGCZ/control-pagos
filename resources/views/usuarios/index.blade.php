<div class="modal fade" id="nuevo-usuario" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div class="page-title-icon">
                                <i class="pe-7s-id icon-gradient bg-mean-fruit">
                                </i>
                            </div>
                            <div>Nuevo Usuario
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card card">
                            <div class="card-body">
                                <!--form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <h5 class="card-title">Datos Del Usuario</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="nombre">{{ __('Nombre') }}</label>
                                            <input type="test" class="form-control" name="name" :value="old('name')" required autofocus autocomplete="name" >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="nombre">{{ __('Correo') }}</label>
                                            <input type="email" class="form-control" name="email" :value="old('email')" required >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="nombre">{{ __('Contraseña') }}</label>
                                            <input type="password" class="form-control" name="password" :value="old('password')" required autocomplete="new-password" >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="nombre">{{ __('Confirmar Contraseña') }}</label>
                                            <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button id="submit_alumno" class="btn btn-primary float-right">{{ __('Guardar') }}</button>
                                        </div>
                                    </div>
                                </form-->
                                <form autocomplete="off">
                                    <h5 class="card-title">Datos Del Usuario</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" class="form-control nombre" id="nombre" name="name" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="email">Correo</label>
                                            <input type="email" class="form-control email" id="email" name="email" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="nombre">Rol</label>
                                            <select class="form-control rol" name="rol" id="rol">
                                                <option value="0" >Seleccionar rol</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{$role->Id}}">{{$role->Nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="nombre">Plantel</label>
                                            <select class="form-control plantel" name="plantel" id="plantel" multiple>
                                                <option value="0" >Seleccionar plantel</option>
                                                @foreach ($planteles as $plantel)
                                                    <option value="{{$plantel->Id}}">{{$plantel->Nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="nombre">Contraseña</label>
                                            <input type="password" class="form-control password" id="password" name="password" autocomplete="new-password">
                                        </div>
                                    </div>
                                </form>
                                <button id="submit_user" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.header')
<script type='text/javascript'>
    $(function() {
        $('#nuevo-usuario').on('click', '#submit_user', function(){
            saveDatos();
        });
        $('#usuarios').DataTable( {
            ajax: {
                url: '/ajax/getusuarios'
            },
            language: {
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "lengthMenu":     "Mostrando _MENU_ usuarios",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Busqueda:",
                "zeroRecords":    "Ningún usuario encontrado",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'plantel'},
                { data: 'role' },
                {  data: 'estatus', defaultContent: 'estatus', 'render': function ( data, type, row ) 
                    {
                        let estatus;
                        let tClass;
                        switch(row.estatus) {
                          case 1:
                            estatus = 'Activo';
                            tClass  = 'btn-success';
                            break;
                          default:
                            estatus = 'Baja';
                            tClass  = 'btn-secondary';
                            break;
                        }
                        let view = `<span class="mb-2 mr-2 btn-hover-shine btn ${tClass}">${estatus}</span>`;
                        return  view;
                    } 
                },
                { data: 'ultimo_ingreso' },
                { defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        const estatusText = row.estatus == 1 ? 'Baja' : 'Activar';
                        let view    =   `<small> 
                                            <a href="/usuarios/view?usuario=${row.id}">Ver</a>
                                        </small>`; 
                        return  view;
                    } 
                }
            ]
        } );
    });
    function saveDatos(){
        $('.loader').show();
        let datos = {
            'nombre'  : $('#nombre').val(),
            'email'   : $('#email').val(),
            'password': $('#password').val(),
            'rol'     : $('#rol').children("option:selected").val(),
            'plantel' : $('#plantel').val()
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/createusuario',
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
                        <i class="pe-7s-id icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Usuarios
                    </div>  
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="#" class="btn-shadow btn btn-primary" type="button" data-toggle="modal" data-target="#nuevo-usuario">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-user-plus fa-w-20"></i>
                            </span>
                            Nuevo Usuario
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-12 card">
                        <div class="card-body">
                            <table id="usuarios" class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Planteles</th>
                                        <th>Rol</th>
                                        <th>Estatus</th>
                                        <th>Último Ingreso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>    
        </div>   
    </div>
</div>
@include('partials.footer')