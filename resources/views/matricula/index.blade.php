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
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" type="text/css" media="all">
<script type='text/javascript'>
    $(function() {
        let alumno;
        
        $('#buscar-alumnos').click(function(e){
            $('#alumnos').DataTable().ajax.reload();
        });
        $('#generar-pdf').click(function(e){
            $('.loader').show();
            $.ajax({
                type: 'POST',
                url: '/ajax/creatematriculapdf',
                dataType: 'json',
                data:
                {
                    '_token': '{{ csrf_token() }}',
                    'datos' : function() { 
                        return JSON.stringify(getAlumnoFilters())     
                    }
                },
                success: function (result) {
                    $('.loader').hide();
                    window.open('https://controlpagos.ceusjic.edu.mx/Matricula.xlsx', '_blank').focus();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('.loader').hide();
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'Error al generar PDF'
                    });
                }
            });
        });
        
        $('#alumnos').DataTable( {
            processing: true,
            responsive: true,
            ajax: {
                url: '/ajax/getalumnosmatricula',
                method: 'POST',
                data:{
                    '_token': '{{ csrf_token() }}',
                    'datos' : function() { 
                        return JSON.stringify(getAlumnoFilters())     
                    }
                }
            },
            language: {
                    "info": "Mostrando pagina _PAGE_ de _PAGES_ total _TOTAL_ alumnos",
                    "loadingRecords": "Cargando...",
                    "processing":     "Procesando...",
                    "search":         "Busqueda:",
                    "zeroRecords":    "Ningún alumno encontrado",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    }
            },
            columns: [
                { data: 'Id' },
                { data: 'Nombre' },
                { data: 'Email' }
            ]
        });
    });
    
    function getAlumnoFilters(){
        alumno = {
            'plantel'      : $('#plantel').children("option:selected").val(),
            'nivel'        : $('#nivel').children("option:selected").val(),
            'licenciatura' : $('#licenciatura').children("option:selected").val(),
            'sistema'      : $('#sistema').children("option:selected").val(),
            'grupo'        : $('#grupo').children("option:selected").val(),
            'generacion'   : $('#generacion').children("option:selected").val(),
        }
        return alumno;
    }
</script>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-server icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Matrícula
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
                                    <form>
                                        <div class="form-row filters">
                                            <div class="form-group  ">
                                                <label for="plantel">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel">
                                                    @foreach ($planteles as $plantel)
                                                        <option value="{{$plantel->Id}}" @if(session()->get('user_roles')['Matrícula']->Plantel_id == $plantel->Id) selected="selected" @endif >{{$plantel->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="nivel">Nivel</label>
                                                <select class="form-control" name="nivel" id="nivel">
                                                    <option value="0" selected="selected">Seleccionar nivel</option>
                                                    @foreach ($niveles as $nivel)
                                                        <option value="@php echo($nivel->Id); @endphp">@php echo($nivel->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="licenciaturas">Licenciatura</label>
                                                <select class="form-control" name="licenciatura" id="licenciatura">
                                                    <option value="0" selected="selected">Seleccionar licenciatura</option>
                                                    @foreach ($licenciaturas as $licenciatura)
                                                        <option value="@php echo($licenciatura->Id); @endphp">@php echo($licenciatura->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="sistema">Sistema</label>
                                                <select class="form-control" name="sistema" id="sistema">
                                                    <option value="0" selected="selected">Seleccionar sistema</option>
                                                    @foreach ($sistemas as $sistema)
                                                        <option value="@php echo($sistema->Id); @endphp">@php echo($sistema->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!--div class="form-group  ">
                                                <label for="grupo">Grupo</label>
                                                <select class="form-control" name="grupo" id="grupo">
                                                    <option value="0" selected="selected">Seleccionar grupo</option>
                                                    @foreach ($grupos as $grupo)
                                                        <option value="@php echo($grupo->Id); @endphp">@php echo($grupo->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                            </div-->
                                            <div class="form-group  ">
                                                <label for="generacion">Generación</label>
                                                <select class="form-control" name="generacion" id="generacion">
                                                    <option value="0" selected="selected">Seleccionar generación</option>
                                                    @foreach ($generaciones as $generacion)
                                                        <option value="@php echo($generacion->Id); @endphp">@php echo($generacion->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group buscar-button " style="text-align: center;">
                                                <button id="buscar-alumnos" type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary" style="margin-top: 33px;"> 
                                                    <i class="fas fa-search"></i> Buscar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12" style="text-align: right;">
                                    <button id="generar-pdf" type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary" style="margin: 20px 0;"> 
                                        Generar PDF
                                    </button>
                                </div>
                            </div>
                            <table id="alumnos" class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
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