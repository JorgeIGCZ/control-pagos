@include('partials.header')

@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@else
    @php
        /*header("Location: " . URL::to('/login'), true, 302);
        exit();*/
    @endphp
@endif

<script type='text/javascript'>

    $(function() {
        const niveles       = @php echo(json_encode($niveles)); @endphp;
        const licenciaturas = @php echo(json_encode($licenciaturas)); @endphp;
        const grupos        = @php echo(json_encode($grupos)); @endphp;
        const generaciones  = @php echo(json_encode($generaciones)); @endphp;
        const conceptos     = @php echo(json_encode($conceptos)); @endphp;
        const inscripciones = @php echo(json_encode($inscripciones)); @endphp;
        const cuotas        = @php echo(json_encode($cuotas)); @endphp;

        displayOptions('nivel',[$('#plantel').children("option:selected").val()],niveles,['Plantel_id'],0);
        displayOptions('licenciatura',[$('#plantel').children("option:selected").val()],licenciaturas,['Plantel_id'],0);
        displayOptions('generacion',[$('#plantel').children("option:selected").val()],generaciones,['Plantel_id'],0);
        displayOptions('grupo',[$('#plantel').children("option:selected").val(),$('#licenciatura').children("option:selected").val(),$('#sistema').children("option:selected").val()],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],0);
        displayOptions('concepto',[$('#plantel').children("option:selected").val()],conceptos,['Plantel_id'],0);
        displayOptions('concepto-inscripcion',[$('#plantel').children("option:selected").val()],inscripciones,['Plantel_id'],0);
        displayOptions('concepto-cuota',[$('#plantel').children("option:selected").val()],cuotas,['Plantel_id'],0);
        $('#plantel').on('change',function(){
            const selection    = $(this).children("option:selected").val();
            const licenciatura = $('#licenciatura').children("option:selected").val();
            const sistema      = $('#sistema').children("option:selected").val();
            displayOptions('nivel',[selection],niveles,['Plantel_id'],0);
            displayOptions('licenciatura',[selection],licenciaturas,['Plantel_id'],0);
            displayOptions('generacion',[selection],generaciones,['Plantel_id'],0);
            displayOptions('grupo',[selection,licenciatura,sistema],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],0);
            displayOptions('concepto',[selection],conceptos,['Plantel_id'],0);
            displayOptions('concepto-inscripcion',[selection],inscripciones,['Plantel_id'],0);
            displayOptions('concepto-cuota',[selection],cuotas,['Plantel_id'],0);
        });
        $('#licenciatura').on('change',function(){
            const plantel   = $('#plantel').children("option:selected").val();
            const selection = $(this).children("option:selected").val();
            const sistema   = $('#sistema').children("option:selected").val();
            displayOptions('grupo',[plantel,selection,sistema],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],0);
        });
        $('#sistema').on('change',function(){
            const plantel      = $('#plantel').children("option:selected").val();
            const licenciatura = $('#licenciatura').children("option:selected").val();
            const selection    = $(this).children("option:selected").val();
            displayOptions('grupo',[plantel,licenciatura,selection],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],0);
        });


        $('#submit_alumno').on('click',function(){
            createAlumno();
        }); 
        $('.add_alumnos').click(function(e){
            let numeroAlumnos = $("#numero_alumnos").val();
            if(numeroAlumnos < 100){
                addBlocksAlumno(numeroAlumnos);
            }
        });   
    }); 
    
    function isValidAlumno(){
        const numeroAlumnos = $("#numero_alumnos").val();
        const nivel         = $('#nivel').children("option:selected").val();
        const sistema       = $('#sistema').children("option:selected").val();
        const concepto      = $('#concepto').children("option:selected").val();
        let isValid         = true;
        let waningMessage   = '';

        if(numeroAlumnos < 1){
            waningMessage += '<br>Es necesario agregar por lo menos un alumno.';
            isValid = false;
        }
        if(nivel == 0){
            waningMessage += '<br>Es necesario seleccionar el nivel.';
            isValid = false;
        }
        if(sistema == 0){
            waningMessage += '<br>Es necesario seleccionar el sistema.';
            isValid = false;
        }
        if(concepto == 0){
            waningMessage += '<br>Es necesario seleccionar el concepto.';
            isValid = false;
        }

        if(!isValid){
            Swal.fire({
                icon: 'error',
                title: 'Porfavor verifica los siguientes campos',
                html: waningMessage
            });
            return false;
        }

        return true;
    }

    function createAlumno(){

        if(!isValidAlumno()){
            return false;
        }

        $('.loader').show();

        let numeroAlumnos = $("#numero_alumnos").val();

        let nombre          = [];
        let apellidoPaterno = [];
        let apellidoMaterno = [];
        let email           = [];
        let telefono        = [];
        let nombreTutor     = [];
        let telefonoTutor   = [];
        for (let i = 0; i < numeroAlumnos; i++) {
            nombre.push($(`#nombre_${i}`).val());
            apellidoPaterno.push($(`#apellido_paterno_${i}`).val());
            apellidoMaterno.push($(`#apellido_materno_${i}`).val());
            email.push($(`#email_${i}`).val());
            telefono.push($(`#telefono_${i}`).val());
            nombreTutor.push($(`#nombre-tutor_${i}`).val());
            telefonoTutor.push($(`#telefono-tutor_${i}`).val());
        }
        
        
        let plantel         = $('#plantel').children("option:selected").val();
        let nivel           = $('#nivel').children("option:selected").val();
        let licenciatura    = $('#licenciatura').children("option:selected").val();
        let sistema         = $('#sistema').children("option:selected").val();
        let grupo           = $('#grupo').children("option:selected").val();
        let generacion      = $('#generacion').children("option:selected").val();
        let concepto        = $('#concepto').children("option:selected").val();
        let titulacion      = $('#titulacion').children("option:selected").val();
        let inscripcion     = $('#concepto-inscripcion').children("option:selected").val();
        let cuota           = $('#concepto-cuota').children("option:selected").val();
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
            'generacion'      : generacion,
            'concepto'        : concepto,
            'titulacion'      : titulacion,
            'inscripcion'     : inscripcion,
            'cuota'           : cuota,
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
                'alumno': alumno,
                'numeroAlumnos' : numeroAlumnos
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

    function addBlocksAlumno(numeroAlumnos){

        alumnosContainertHTML = $("<div></div>");
        let alumno = "";
        for (let i = 0; i < numeroAlumnos; i++) {
            /*
            nameContainer.append($('<span>Room '+(i+1)+'</span>').addClass('room_name_label'));
            nameContainer.append($('<input></input>').addClass('form-control room_names').attr('type', 'text').attr('placeholder','Enter room name').attr('id','room_name_'+i));
            */
            alumno = `<section class="alumno_container">
                        <h5 class="card-title">Datos Personales Del Alumno ${i+1}</h5>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Nombre</label>
                                <input type="test" class="form-control" id="nombre_${i}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Apellido Paterno</label>
                                <input type="test" class="form-control" id="apellido_paterno_${i}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Apellido Materno</label>
                                <input type="test" class="form-control" id="apellido_materno_${i}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control" id="email_${i}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono_${i}" >
                            </div>
                        </div>
                        <h5 class="card-title">Datos Del Tutor</h5>
                        <div class="form-row">
                            <div class="form-group col-md-4 datos-personales">
                                <label for="inputEmail4">Nombre</label>
                                <input type="text" class="form-control" id="nombre-tutor_${i}" value="">
                            </div>
                            <div class="form-group col-md-4 datos-personales">
                                <label for="telefonoTutor">Teléfono</label>
                                <input type="text" class="form-control" id="telefono-tutor_${i}"  value="">
                            </div>
                        </div>
                        <span class="border"></span>
                    </section>`;

            alumnosContainertHTML.append(alumno);
        }
        $(".alumnos_container").html(alumnosContainertHTML); 
                
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
                    <div>Nuevo Alumno
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="{{ url('alumnos') }}" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-arrow-left fa-w-20"></i>
                            </span>
                            Alumnos
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-sm-3 col-xs-6">
                                        <div>
                                            <h4># Alumnos</h4>
                                            <div class="create_alumnos">
                                                <input data-parsley-type="number" type="number" class="form-control" id="numero_alumnos" placeholder="Enter only numbers" value="0" min="0" max="100">
                                                <button class="btn btn-default btn-block btn-primary waves-effect add_alumnos">
                                                    <i class="fa fa-retweet" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <form class="alumnos_container">
                                        
                                    </form>
                                    <br>
                                    <form>
                                        <h5 class="card-title">Información Academica</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-3 " @if (count($planteles) == 1) style="display:none;" @endif>
                                                <label for="plantel">Plantel</label>
                                                
                                                <select class="form-control" name="plantel" id="plantel">
                                                    <option value="0">Seleccionar plantel</option>
                                                    @foreach ($planteles as $plantel)
                                                        <option value="{{$plantel->Id}}" @if (count($planteles) == 1) selected="selected" @endif >{{$plantel->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 "  @if (count($niveles) == 1) style="display:none;" @endif>
                                                <label for="nivel">Nivel</label>
                                                <select class="form-control" name="nivel" id="nivel">
                                                    <option value="0">Seleccionar nivel</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3" @if(count($licenciaturas) == 0) style="display:none;"  @endif>
                                                <label for="licenciaturas">Licenciatura</label>
                                                <select class="form-control" name="licenciatura" id="licenciatura">
                                                    <option value="0" selected="selected">Seleccionar licenciatura</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label for="sistema">Sistema</label>
                                                <select class="form-control" name="sistema" id="sistema">
                                                    <option value="0" selected="selected">Seleccionar sistema</option>
                                                    @foreach ($sistemas as $sistema)
                                                        <option value="@php echo($sistema->Id); @endphp">@php echo($sistema->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label for="grupo">Grupo</label>
                                                <select class="form-control" name="grupo" id="grupo">
                                                    <option value="0" selected="selected">Seleccionar grupo</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label for="concepto">Colegiatura concepto</label>
                                                <select class="form-control" name="concepto" id="concepto">
                                                    <option value="0" selected="selected">Seleccionar concepto</option>
                                                </select>
                                            </div> 

                                            
                                            <div class="form-group col-md-3 " @if(count($licenciaturas) == 0) style="display:none;"  @endif>
                                                <label for="titulacion">Titulación concepto</label>
                                                <select class="form-control" name="titulacion" id="titulacion">
                                                    <option value="0" selected="selected">Seleccionar concepto</option>
                                                    @foreach ($titulaciones as $titulacion)
                                                        <option value="@php echo($titulacion->Id); @endphp" @if(@$informacion[0]->Concepto_titulacion_id == $titulacion->Id) selected="selected"  @endif>{{$titulacion->Nombre}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label for="concepto-inscripcion">Inscripción concepto</label>
                                                <select class="form-control" name="concepto-inscripcion" id="concepto-inscripcion">
                                                    <option value="0" selected="selected">Seleccionar concepto</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 " @if(count($licenciaturas) > 0) style="display:none;"  @endif>
                                                <label for="concepto-cuota">Cuota anual</label>
                                                <select class="form-control" name="concepto-cuota" id="concepto-cuota">
                                                    <option value="0" selected="selected">Seleccionar cuota</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 ">
                                                <label for="generacion">Generacion</label>
                                                <select class="form-control" name="generacion" id="generacion">
                                                    <option value="0" selected="selected">Seleccionar generacion</option>
                                                </select> 
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Fecha inicio</label>
                                                <input type="month" class="form-control" id="fecha-inicio" value="@php echo(date('Y-m')); @endphp">
                                            </div>
                                        </div>
                                    </form>
                                    <button id="submit_alumno" class="btn btn-primary">Guardar</button>
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