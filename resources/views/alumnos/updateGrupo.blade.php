@include('partials.header')
<style type="text/css" media="screen">
    .dt-buttons{
        height: 60px;
    }
    .buttons-html5{
        cursor: pointer;
        float: right;
        display: inline-block;
        font-weight: 400;
        color: #495057;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: .375rem .75rem;
        font-size: 0.8rem;
        line-height: 1.5;
        border-radius: .25rem;
        background-color: #3f6ad8;
        border-color: #3f6ad8;
        color: white;
    }
</style>
<script type='text/javascript'>
    const grupos    = @php echo(json_encode($grupos)); @endphp;
    $(function() {
        //let now         = new Date().toLocaleString('es-MX', { timeZone: 'CST' });
        const now       = new Date();
        const today     = now.getDate();

        $('#buscar-alumnos').click(function(e){
            $('#alumnos').DataTable().ajax.reload();
        });

        $('#mover-alumnos').click(function(e){
            $('.loader').show();
            const newGrupo   = $("#new-grupo").children("option:selected").val();

            $.ajax({
                type: 'POST',
                url: '/ajax/updateGrupoAlumnos',
                dataType: 'json',
                data:
                {
                    '_token': '{{ csrf_token() }}',
                    'datos': function() { 
                        return JSON.stringify(getAlumnoFilters())     
                    },
                    'newGrupo' : newGrupo
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
                                    $('#alumnos').DataTable().ajax.reload();
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
        });

        $('#licenciatura').on('change',function(){
            const licenciatura   = $(this).children("option:selected").val();
            displayGrupos(licenciatura);
        });

        $('#sistema').on('change',function(){
            const plantel      = $('#plantel').children("option:selected").val();
            const licenciatura = $('#licenciatura').children("option:selected").val();
            const selection    = $(this).children("option:selected").val();
            displayOptions('new-grupo',[plantel,licenciatura,selection],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],0);
            displayOptions('grupo',[plantel,licenciatura,selection],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],0);
        });

        $('#alumnos').DataTable( {
            processing: true,
            responsive: true,
            ajax: {
                url: '/ajax/getalumnos',
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
                "lengthMenu":     "Mostrando _MENU_ alumnos",
                "processing":     "Procesando...",
                "search":         "Busqueda:",
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
                { data: 'Grupo' },
                { defaultContent: 'Estatus_pago', className: 'dt-center', 'render': function ( data, type, row ) 
                    {
                        let estatus;
                        let tClass;
                        //if(row.Id == 23){
                        //    console.log(row);
                        //}
                        switch(row.Estatus_pago) {
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
                         default :
                            estatus = 'Finalizado';
                            tClass  = '';
                            break;
                        }
                        let view = `<span class="mb-2 mr-2 btn-hover-shine btn ${tClass}">${estatus}</span>`;
                        return  view;
                    } 
                },
                {  data: 'Estatus', defaultContent: 'Estatus', className: 'dt-center', 'render': function ( data, type, row ) 
                    {
                        let estatus;
                        let tClass;
                        switch(row.Estatus) {
                          case 1:
                            estatus = 'Activo';
                            tClass  = 'btn-success';
                            break;
                          case 2:
                            estatus = 'Baja';
                            tClass  = 'btn-secondary';
                            break;
                          default:
                            estatus = 'Finalizado';
                            tClass  = 'btn-secondary';
                            break;
                        }
                        let view = `<span class="mb-2 mr-2 btn-hover-shine btn ${tClass}">${estatus}</span>`;
                        return  view;
                    } 
                }
            ]
        } );
    }); 
    function displayGrupos(licenciatura){
        let gruposOptions = "";
        let gruposObj  = grupos.filter(function(grupos) {
            if(grupos.Licenciatura_id == licenciatura){
                return true;
            }
        });
        $('.grupo .dinamic').remove();

        gruposObj.forEach(function(nivel){
            gruposOptions += `<option class="dinamic" value="${nivel.Id}" >${nivel.Nombre}</option>`;
        });
        $('.grupo').append(gruposOptions);
    }
    function getAlumnoFilters(){
        alumno = {
            'plantel'      : {{@$_GET['Id']}},
            'nivel'        : $('#nivel').children("option:selected").val(),
            'licenciatura' : $('#licenciatura').children("option:selected").val(),
            'sistema'      : $('#sistema').children("option:selected").val(),
            'grupo'        : $('.grupo').children("option:selected").val(),
            'generacion'   : $('#generacion').children("option:selected").val(),
            'estatusAlumno': 1
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
                        <i class="pe-7s-users icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Cambio De Grupo Alumnos ({{$plantel}})
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
                                        <div class="form-row filters" style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr  90px;">
                                            <div class="form-group  " style="display: none;">
                                                <label for="plantel">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel">
                                                    @foreach ($planteles as $plantel)
                                                        <option value="{{$plantel->Id}}" selected="selected" >{{$plantel->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group"  @if (count($niveles) == 1) style="display:none;" @endif>
                                                <label for="nivel">Nivel</label>
                                                <select class="form-control dinamic_filters" name="nivel" id="nivel">
                                                    <option value="0">Seleccionar nivel</option>
                                                    @foreach ($niveles as $nivel)
                                                        <option value="{{$nivel->Id}}" @if (count($niveles) == 1) selected="selected" @endif >{{$nivel->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="licenciaturas">Licenciatura</label>
                                                <select class="form-control dinamic_filters" name="licenciatura" id="licenciatura">
                                                    <option value="0" selected="selected">Seleccionar licenciatura</option>
                                                    @foreach ($licenciaturas as $licenciatura)
                                                        <option value="@php echo($licenciatura->Id); @endphp">@php echo($licenciatura->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="sistema">Sistema</label>
                                                <select class="form-control dinamic_filters" name="sistema" id="sistema">
                                                    <option value="0" selected="selected">Seleccionar sistema</option>
                                                    @foreach ($sistemas as $sistema)
                                                        <option value="@php echo($sistema->Id); @endphp">@php echo($sistema->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group  ">
                                                <label for="grupo">Grupo</label>
                                                <select class="form-control grupo" name="grupo" id="grupo">
                                                    <option value="0" selected="selected">Seleccionar grupo</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group  ">
                                                <label for="generacion">Generación</label>
                                                <select class="form-control dinamic_filters" name="generacion" id="generacion">
                                                    <option value="0" selected="selected" >Seleccionar generación</option>
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
                                        <h5><strong>Mover A:</strong></h5>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group  ">
                                                    <label for="grupo">Grupo</label>
                                                    <select id="new-grupo" class="form-control grupo" name="grupo" >
                                                        <option value="0" selected="selected">Seleccionar grupo</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group buscar-button " style="text-align: center;">
                                                    <button id="mover-alumnos" type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary" style="margin-top: 33px;"> 
                                                        Mover de grupo
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table id="alumnos" class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Grupo</th>
                                        <th>Estatus Pago</th>
                                        <th>Estatus Alumno</th>
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