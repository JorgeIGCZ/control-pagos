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
    $(function() {
        const now       = new Date();
        const today     = now.getDate();
        const niveles       = @php echo(json_encode($niveles)); @endphp;
        const licenciaturas = @php echo(json_encode($licenciaturas)); @endphp;
        const grupos        = @php echo(json_encode($grupos)); @endphp;
        const generaciones  = @php echo(json_encode($generaciones)); @endphp;

        displayOptions('licenciatura',[$('#plantel').children("option:selected").val()],licenciaturas,['Plantel_id'],0);
        displayOptions('generacion',[$('#plantel').children("option:selected").val()],generaciones,['Plantel_id'],0);
        displayOptions('grupo',[$('#plantel').children("option:selected").val(),$('#licenciatura').children("option:selected").val(),$('#sistema').children("option:selected").val()],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],0);
        $('#plantel').on('change',function(){
            const selection    = $(this).children("option:selected").val();
            const licenciatura = $('#licenciatura').children("option:selected").val();
            const sistema      = $('#sistema').children("option:selected").val();
            displayOptions('licenciatura',[selection],licenciaturas,['Plantel_id'],0);
            displayOptions('generacion',[selection],generaciones,['Plantel_id'],0);
            displayOptions('grupo',[selection,licenciatura,sistema],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],0);
            
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



        $('#buscar-alumnos').click(function(e){
            $('#alumnos').DataTable().ajax.reload();
        });
        function getFileName(){
            let fileName = 'Titulaciones';
            fileName += ($('#plantel').children("option:selected").val() !== "0") ? $('#plantel').children("option:selected").html() : ' ' ;
            fileName += ($('#nivel').children("option:selected").val() !== "0") ? $('#nivel').children("option:selected").html() : '' ;
            fileName += ($('#licenciatura').children("option:selected").val() !== "0") ? $('#licenciatura').children("option:selected").html() : '' ;
            fileName += ($('#sistema').children("option:selected").val() !== "0") ? $('#sistema').children("option:selected").html() : '' ;

            return fileName;
        }
        let table = $('#alumnos').DataTable( {
            processing: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5', 
                orientation: 'landscape',
                pageSize: 'LEGAL',
                footer: true,
                text: 'Exportar Excel',
                title: getFileName(),
                customize: function(xlsx) {
                    let sheet = xlsx.xl.worksheets['sheet1.xml']; 
                    // Loop over the cells in column `K`
                    let count = 0;
                    let skippedHeader = false;
                    $('row c[r^="C"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',2).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
                            if(className.includes("btn-success")) {
                                $(this).attr( 's', '17' );
                            }else if(className.includes("btn-secondary")) {
                                $(this).attr( 's', '7' );
                            }else if(className.includes("btn-warning")) {
                                $(this).attr( 's', '12' );
                            }
                            count++;
                        }
                        else {
                            skippedHeader = true;
                        }
                    });
                    count = 0;
                    skippedHeader = false;
                    $('row c[r^="D"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',3).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
                            if(className.includes("btn-success")) {
                                $(this).attr( 's', '17' );
                            }else if(className.includes("btn-secondary")) {
                                $(this).attr( 's', '7' );
                            }else if(className.includes("btn-warning")) {
                                $(this).attr( 's', '12' );
                            }  
                            count++;
                        }
                        else {
                            skippedHeader = true;
                        }
                    });
                    count = 0;
                    skippedHeader = false;
                    $('row c[r^="E"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',4).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
                            if(className.includes("btn-success")) {
                                $(this).attr( 's', '17' );
                            }else if(className.includes("btn-secondary")) {
                                $(this).attr( 's', '12' );
                            }    
                            count++;
                        }
                        else {
                            skippedHeader = true;
                        }
                    });
                }
            }],
            ajax: {
                url: '/ajax/getalumnostitulaciones',
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
                { data: 'Alumno_id' },
                { data: 'Nombre',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let nombre = `<a href='/alumnos/view?alumno=${row.Alumno_id}#titulaciones' target="_blank" >${row.Nombre}</a> `
                        return  nombre;
                    } 
                },
                { defaultContent: 'Estatus_pago', 'render': function ( data, type, row ) 
                    {
                        let estatus;
                        let tClass;
                        const cantidadPago = formatter.format(row.Cantidad_pago);
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
                          default:
                            estatus = 'Pendiente';
                            tClass  = 'btn-secondary';
                            break;
                        }
                        let view = `<span class="mb-2 mr-2 btn-hover-shine btn ${tClass}">${cantidadPago}</span>`;
                        return  view;
                    } 
                },
                {  data: 'Costo_titulacion', defaultContent: 'Costo_titulacion', 'render': function ( data, type, row ) 
                    {
                        const costoTitulacion = row.Costo_titulacion;
                        const pagado          = row.Cantidad_pago;
                        const resta           = (costoTitulacion - pagado);
                        switch(resta) {
                          case 0:
                            estatus = 'Pagado';
                            tClass  = 'btn-success';
                            break;
                          case costoTitulacion:
                            estatus = 'Pendiente';
                            tClass  = 'btn-secondary';
                            break;
                          default:
                            estatus = 'Parcial';
                            tClass  = 'btn-warning';
                            break;
                        }
                        const view = `<span class="mb-2 mr-2 btn-hover-shine btn ${tClass}">${formatter.format(resta)}</span>`;
                        return view;
                    } 
                },
                {  data: 'Estatus', defaultContent: 'Estatus', 'render': function ( data, type, row ) 
                    {
                        let estatus;
                        let tClass;
                        switch(row.Estatus) {
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
                }
            ]
        } );
    }); 
    function getAlumnoFilters(){
        alumno = {
            'plantel'      : {{@$_GET['Id']}},
            'nivel'        : $('#nivel').children("option:selected").val(),
            'licenciatura' : $('#licenciatura').children("option:selected").val(),
            'sistema'      : $('#sistema').children("option:selected").val(),
            'grupo'        : $('#grupo').children("option:selected").val(),
            'generacion'   : $('#generacion').children("option:selected").val()
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
                    <div>Titulaciones ({{$plantel}})
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
                                        <div class="form-row filters" style="grid-template-columns: 1fr 1fr 1fr  1fr 1fr 90px;">
                                            <div class="form-group " style="display:none">
                                                <label for="plantel">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel">
                                                    @foreach ($planteles as $plantel)
                                                        <option value="{{$plantel->Id}}" selected="selected" >{{$plantel->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="nivel">Nivel</label>
                                                <select class="form-control" name="nivel" id="nivel">
                                                    <option value="1" selected="selected">Licenciatura</option>
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="licenciaturas">Licenciatura</label>
                                                <select class="form-control" name="licenciatura" id="licenciatura">
                                                    <option value="0" selected="selected">Seleccionar licenciatura</option>
                                                    
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
                                            <div class="form-group  ">
                                                <label for="grupo">Grupo</label>
                                                <select class="form-control" name="grupo" id="grupo">
                                                    <option value="0" selected="selected">Seleccionar grupo</option>
                                                    
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="generacion">Generación</label>
                                                <select class="form-control" name="generacion" id="generacion">
                                                    <option value="0" selected="selected">Seleccionar generación</option>
                                                    
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
                            </div>
                            <table id="alumnos" class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Estatus Pago</th>
                                        <th>Resta</th>
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