@include('partials.header')

<script type='text/javascript'>
    $(function() {
        $('#submit_alumno').on('click',function(){
            createAlumno();
        });    
    }); 
    
    function createAlumno(){
        $('.loader').show();
        let nombre          = $('#nombre').val();
        let apellidoPaterno = $('#apellido_paterno').val();
        let apellidoMaterno = $('#apellido_materno').val();
        let email           = $('#email').val();
        let telefono        = $('#telefono').val();
        let nombreTutor     = $('#nombre-tutor').val();
        let telefonoTutor   = $('#telefono-tutor').val();
        let plantel         = $('#plantel').children("option:selected").val();
        let nivel           = $('#nivel').children("option:selected").val();
        let licenciatura    = $('#licenciatura').children("option:selected").val();
        let sistema         = $('#sistema').children("option:selected").val();
        let grupo           = $('#grupo').children("option:selected").val();
        let ciclo           = $('#ciclo').children("option:selected").val();
        let concepto        = $('#concepto').children("option:selected").val();
        let fechaInicio     = $('#fecha-inicio').val();
        
        let alumno = {
            'nombre'          : nombre,
            'apellidoPaterno' : apellidoPaterno,
            'apellidoMaterno' : apellidoMaterno,
            'email'           : email,
            'telefono'        : telefono,
            'plantel'         : plantel,
            'nivel'           : nivel,
            'licenciatura'    : licenciatura,
            'sistema'         : sistema,
            'grupo'           : grupo,
            'ciclo'           : ciclo,
            'concepto'        : concepto,
            'fechaInicio'     : fechaInicio,
            'nombreTutor'     : nombreTutor,
            'telefonoTutor'   : telefonoTutor
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/newalumno',
            dataType: 'json',
            data:
            {
                '_token': '{{ csrf_token() }}',
                'alumno': alumno
            },
            success: function (result) {
                $('.loader').hide();
                if(result[0] == 'success'){
                    Swal.fire({
                          icon: result[0],
                          title: (result[0] == 'success' ? 'Exito' : 'Error'),
                          text: result[1],
                          timer: 1000,
                          timerProgressBar: true,
                          onClose: () => {
                            if(result[0] == 'success'){
                                location.reload();
                            }
                          }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al guardar al alumno'
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
                        <i class="pe-7s-add-user icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Nuevo Usuario
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-12 card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                	<form method="POST" action="{{ route('register') }}">
							            @csrf
							            <h5 class="card-title">Datos Del Usuario</h5>
                                        <div class="form-row">
                                        	<div class="form-group col-md-4">
                                        		<label for="nombre">{{ __('Name') }}</label>
                                        		<input type="test" class="form-control" name="name" :value="old('name')" required autofocus autocomplete="name" >
								            </div>
								            <div class="form-group col-md-4">
								            	<label for="nombre">{{ __('Email') }}</label>
								                <input type="email" class="form-control" name="email" :value="old('email')" required >
								            </div>
								            <div class="form-group col-md-4">
								            	<label for="nombre">{{ __('Password') }}</label>
								                <input type="password" class="form-control" name="password" :value="old('password')" required autocomplete="new-password" >
								            </div>
								            <div class="form-group col-md-4">
								                <label for="nombre">{{ __('Confirm Password') }}</label>
								                <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" >
								            </div>
								            <div class="form-group col-md-12">
								                <button id="submit_alumno" class="btn btn-primary float-right">{{ __('Register') }}</button>
								            </div>
								        </div>
							        </form>
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