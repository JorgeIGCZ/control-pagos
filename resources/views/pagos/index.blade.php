@include('partials.header')

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" type="text/css" media="all">
<script type='text/javascript'>
    $(function() {
        const niveles       = @php echo(json_encode($niveles)); @endphp;
        const licenciaturas = @php echo(json_encode($licenciaturas)); @endphp;
        const grupos        = @php echo(json_encode($grupos)); @endphp;
        const generaciones  = @php echo(json_encode($generaciones)); @endphp;

        displayOptions('nivel',[$('#plantel').children("option:selected").val()],niveles,['Plantel_id'],0);
        displayOptions('licenciatura',[$('#plantel').children("option:selected").val()],licenciaturas,['Plantel_id'],0);
        displayOptions('generacion',[$('#plantel').children("option:selected").val()],generaciones,['Plantel_id'],0);
        displayOptions('grupo',[$('#plantel').children("option:selected").val(),$('#licenciatura').children("option:selected").val(),$('#sistema').children("option:selected").val()],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],0);


        $('#plantel').on('change',function(){
            const selection    = $(this).children("option:selected").val();
            const licenciatura = $('#licenciatura').children("option:selected").val();
            const sistema      = $('#sistema').children("option:selected").val();
            displayOptions('nivel',[selection],niveles,['Plantel_id'],0);
            displayOptions('licenciatura',[selection],licenciaturas,['Plantel_id'],0);
            displayOptions('generacion',[selection],generaciones,['Plantel_id'],0);
            displayOptions('grupo',[selection,licenciatura,sistema],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],0);
            
        });
        $('#nivel').on('change',function(){
            const plantel   = $('#plantel').children("option:selected").val();
            const selection    = $(this).children("option:selected").val();
            const licenciatura = $('#licenciatura').children("option:selected").val();
            const sistema      = $('#sistema').children("option:selected").val();
            displayOptions('licenciatura',[plantel],licenciaturas,['Plantel_id'],0);
            displayOptions('generacion',[plantel],generaciones,['Plantel_id'],0);
            displayOptions('grupo',[plantel,selection,licenciatura,sistema],grupos,['Plantel_id','Nivel_id','Licenciatura_id','Sistema_id'],0);
            
        });

        $('#licenciatura').on('change',function(){
            const plantel   = $('#plantel').children("option:selected").val();
            const nivel     = $('#nivel').children("option:selected").val();
            const selection = $(this).children("option:selected").val();
            const sistema   = $('#sistema').children("option:selected").val();
            displayOptions('grupo',[plantel,nivel,selection,sistema],grupos,['Plantel_id','Nivel_id','Licenciatura_id','Sistema_id'],0);
        });
        $('#sistema').on('change',function(){
            const plantel      = $('#plantel').children("option:selected").val();
            const nivel     = $('#nivel').children("option:selected").val();
            const licenciatura = $('#licenciatura').children("option:selected").val();
            const selection    = $(this).children("option:selected").val();
            displayOptions('grupo',[plantel,nivel,licenciatura,selection],grupos,['Plantel_id','Nivel_id','Licenciatura_id','Sistema_id'],0);
        });

        $('#fecha').change(function(e){
            const range    = $(this).children("option:selected").val();
            if(range == 3){
                $('#rango-fecha').show();
            }else{
                $('#rango-fecha').hide();
            }
        });

        $('.input-daterange').datepicker({
            language: 'es'
        });
        $('#buscar-alumnos').click(function(e){
            $('#pagos').DataTable().ajax.reload();
        });
        $('#generar-excel').click(function(e){
            $('.loader').show();
            let fileName = '';
            debugger
            fileName += ($('#plantel').children("option:selected").val() !== "0") ? $('#plantel').children("option:selected").html() : ' ' ;
            fileName += ($('#nivel').children("option:selected").val() !== "0") ? $('#nivel').children("option:selected").html() : '' ;
            fileName += ($('#licenciatura').children("option:selected").val() !== "0") ? $('#licenciatura').children("option:selected").html() : ' ' ;
            fileName += ($('#sistema').children("option:selected").val() !== "0") ? $('#sistema').children("option:selected").html() : ' ' ;

            fileName += ($('#fecha').children("option:selected").val() !== "3") ? $('#fecha').children("option:selected").html() : $('#start_date').val().replaceAll("/", "-")+' Al '+$('#end_date').val().replaceAll("/", "-");

            $.ajax({
                type: 'POST',
                url: '/ajax/createCorteExcel',
                dataType: 'json',
                data:
                {
                    '_token': '{{ csrf_token() }}',
                    'filename' : fileName,
                    'datos' : function() { 
                        return JSON.stringify(getAlumnoFilters())     
                    }
                },
                success: function (result) {
                    $('.loader').hide();
                    window.open(`https://controlpagos.ceusjic.edu.mx/${fileName}.xlsx`, '_blank').focus();
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
        $('#pagos').DataTable({
            processing: true,
            responsive: true,
            /*dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5', 
                footer: true,
                text: 'Exportar excel',
                title: function () {
                        let plantel      = ($('#plantel').children("option:selected").val()      != 0) ? $('#plantel').children("option:selected").html() : '';
                        let nivel        = ($('#nivel').children("option:selected").val()        != 0) ? $('#nivel').children("option:selected").html() : '';
                        let licenciatura = ($('#licenciatura').children("option:selected").val() != 0) ? $('#licenciatura').children("option:selected").html() : '';
                        let sistema      = ($('#sistema').children("option:selected").val()      != 0) ? $('#sistema').children("option:selected").html() : '';
                        let grupo        = ($('#grupo').children("option:selected").val()        != 0) ? $('#grupo').children("option:selected").html() : '';
                        let title        = `${plantel} ${nivel} ${licenciatura} ${sistema} ${grupo}`;
                        return title;
                }
            }],*/
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
     
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
     
                // Total over all pages
                total = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                // Total over this page
                pageTotal = api
                    .column( 7, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                // Update footer
                $( api.column( 7 ).footer() ).html(
                    formatter.format(total)
                );
            },
            ajax: {
                type: 'POST',
                url: '/ajax/getallpagos',
                dataType: 'json',
                data:
                {
                    '_token': '{{ csrf_token() }}',
                    'datos' : function() { 
                        return JSON.stringify(getAlumnoFilters())     
                    }
                },
            },
            language: {
                "info": "Mostrando pagina _PAGE_ de _PAGES_ total _TOTAL_ pagos",
                "lengthMenu":     "Mostrando _MENU_ pagos",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Busqueda:",
                "zeroRecords":    "Ningún pago encontrado",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            },
            columns: [
                { data: 'Id' },
                { data: 'Nombre',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let nombre = `<a href='/alumnos/view?alumno=${row.Alumno_id}' target="_blank" >${row.Nombre}</a> `
                        return  nombre;
                    } 
                },
                { data: 'Descripcion' },
                { data: 'Descripcion_pago' },
                { data: 'updated_at' },
                { data: 'Tipo_pago' },
                { data: 'Notas' },
                { data: 'Usuario' },
                { data: 'Cantidad_pago',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        return  formatter.format(row.Cantidad_pago);
                    } 
                }
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
            'start_date'   : $('#start_date').val(),
            'end_date'     : $('#end_date').val(),
            'tipoPago'     : $('#tipo-pago').children("option:selected").val(),
            'fuente'       : $('#fuente').children("option:selected").val(),
            'fecha'        : $('#fecha').children("option:selected").val(),
            'tipo_corte_usuario' : $('#corte-usuario').children("option:selected").val(),
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
                        <i class="pe-7s-cash icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Pagos ({{$plantel}})
                    </div>  
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <button type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="pe-7s-cash fa-w-20"></i>
                            </span>
                            Nuevo Pago
                        </button>
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
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="fecha">Fecha</label>
                                                <select class="form-control fecha" name="fecha" id="fecha">
                                                    <option value="1" selected="selected">Día Actual</option>
                                                    <option value="2" >Mes Actual</option>
                                                    <option value="3" >Rango</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4" id="rango-fecha" style="display:none;">
                                                <label for="mes">Mes</label>
                                                <div class="input-group input-daterange">
                                                    <input id="start_date" name="start_date" type="text" class="form-control" readonly="readonly" placeholder="mm/dd/yyyy"> 
                                                    <span class="input-group-addon" style="padding: 8px;">Al</span> 
                                                    <input id="end_date" name="end_date" type="text" class="form-control" readonly="readonly" placeholder="mm/dd/yyyy">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="tipo-pago">Tipo</label>
                                                <select class="form-control" name="tipo-pago" id="tipo-pago">
                                                    <option value="1" selected="selected">Pagos</option>
                                                    <option value="0">Pagos y descuentos</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="fuente">Tipo de Pago</label>
                                                <select class="form-control" name="fuente" id="fuente">
                                                    <option value="0" selected="selected">Bancario y Efectivo</option>
                                                    <option value="1">Bancario</option>
                                                    <option value="2">Efectivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <form>
                                        <div class="form-row filters" style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 90px;">
                                            <div class="form-group " @if (count($planteles) == 1) style="display:none;" @endif>
                                                <label for="plantel">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel">
                                                    @foreach ($planteles as $plantel)
                                                        <option value="{{$plantel->Id}}" @if (count($planteles) == 1) selected="selected" @endif >{{$plantel->Nombre}}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                            <div class="form-group "  @if (count($niveles) == 1) style="display:none;" @endif>
                                                <label for="nivel">Nivel</label>
                                                <select class="form-control dinamic_filters" name="nivel" id="nivel">
                                                    <option value="0">Seleccionar nivel</option>
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="licenciaturas">Licenciatura</label>
                                                <select class="form-control dinamic_filters" name="licenciatura" id="licenciatura">
                                                    <option value="0" >Seleccionar licenciatura</option>
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="sistema">Sistema</label>
                                                <select class="form-control" name="sistema" id="sistema">
                                                    <option value="0" >Seleccionar sistema</option>
                                                    @foreach ($sistemas as $sistema)
                                                        <option value="@php echo($sistema->Id); @endphp">@php echo($sistema->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="grupo">Grupo</label>
                                                <select class="form-control" name="grupo" id="grupo">
                                                    <option value="0" >Seleccionar grupo</option>
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="generacion">Generación</label>
                                                <select class="form-control dinamic_filters" name="generacion" id="generacion">
                                                    <option value="0" >Seleccionar generación</option>
                                                </select>
                                            </div>

                                            <div class="form-group  ">
                                                <label for="generacion">Ejecutar Corte Cómo...</label>
                                                <select class="form-control dinamic_filters btn-outline-danger" name="corte-usuario" id="corte-usuario">
                                                    <option value="{{ Auth::user()->id }}" selected="selected">Corte Usuario actual</option>
                                                    <option value="0">Corte General</option>
                                                </select>
                                            </div>

                                            <div class="form-group buscar-button " style="text-align: center;">
                                                <button id="buscar-alumnos" type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary" style="margin-top: 33px;"> 
                                                    <i class="fas fa-search"></i> Generar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12" style="text-align: right;">
                                    <button id="generar-excel" type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary" style="margin: 20px 0;"> 
                                        Generar Excel
                                    </button>
                                </div>
                            </div>
                            <table id="pagos" class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Alumno</th>
                                        <th>Concepto</th>
                                        <th>Descripción Pago</th>
                                        <th>Fecha Pago</th>
                                        <th>Tipo Pago</th>
                                        <th>Notas</th>
                                        <th>Usuario</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">Total:</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>    
        </div>   
    </div>
</div>
@include('partials.footer')