<div class="modal fade" id="new_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div class="page-title-icon">
                                <i class="pe-7s-cash icon-gradient bg-mean-fruit">
                                </i>
                            </div>
                            <div>Nuevo Pago
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card card">
                            <div class="card-body"><h5 class="card-title nombre-alumno-pago" alumnoId =""></h5>
                                <form class="">
                                    <div class="position-relative form-group">
                                        <table style="width:100%">
                                            <tr>
                                                <th style="width:45%">Cantidad a pagar:</th>
                                                <td>
                                                    <input type="text" id="cantidad-pagar"value ="$0.00" class="no_style" disabled="disabled">
                                                </td>
                                            </tr>
                                            <tr class="descuento-container">
                                                <th style="width:45%">Cantidad beca:</th>
                                                <td>
                                                    <input type="text" id="cantidad-beca-t"value ="$0.00" class="no_style" disabled="disabled">
                                                </td>
                                            </tr>
                                            <tr class="descuento-container">
                                                <th style="width:45%">Descuento:</th>
                                                <td>
                                                    <input type="text" id="cantidad-descuento-t"value ="$0.00" class="no_style" disabled="disabled">
                                                </td>
                                            </tr>

                                            <tr class="recargo-container">
                                                <th style="width:45%">Recargo:</th>
                                                <td>
                                                    <input type="text" id="cantidad-recargo-t"value ="$0.00" class="no_style" disabled="disabled">
                                                </td>
                                            </tr>

                                            <tr>
                                                <th style="width:45%">Resta:</th>
                                                <td>
                                                    <input type="text" id="resta"value ="$0.00" class="no_style" disabled="disabled">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="concepto" class="">Concepto</label>
                                        <select name="select" id="concepto" class="form-control">
                                            <option value="0">Seleccionar concepto</option>
                                        </select>
                                    </div>
                                    <div class="position-relative form-group mensualidad-container" style="display:none;">
                                        <label for="mensualidad" class="">Mensualidad o anualidad</label>
                                        <select name="select" id="mensualidad" class="form-control">
                                            <option value="0">Seleccionar mensualidades</option>
                                        </select>
                                    </div>
                                    @if (session()->get('user_roles')['Becas']->Crear == 'Y')
                                    <div class="position-relative form-group" >
                                        <label for="descuento-pronto-pago" class="">Descuento</label>
                                        <select name="select" id="descuento-pronto-pago" class="form-control">
                                            <option value="0" precio="0">Seleccionar descuento</option>
                                            @foreach ($prontoPago as $prontoPag)
                                                <option value="{{$prontoPag->Id}}" precio="{{$prontoPag->Precio}}">{{$prontoPag->Nombre}}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                    @else
                                    <div class="position-relative form-group descuento-pronto-pago-container"  style="display:none;">
                                        <label for="descuento-pronto-pago" class="">Descuento</label>
                                        <select name="select" id="descuento-pronto-pago" class="form-control">
                                            <option value="0" precio="0">Seleccionar descuento</option>
                                            @foreach ($prontoPago as $prontoPag)
                                                <option value="{{$prontoPag->Id}}" precio="{{$prontoPag->Precio}}">{{$prontoPag->Nombre}}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                    @endif



                                    @if ($_GET['Id'] == 2)
                                        @if (session()->get('user_roles')['Becas']->Crear == 'Y')
                                        <div class="position-relative form-group" >
                                            <label for="recargo-pago" class="">Recargo</label>
                                            <select name="select" id="recargo-pago" class="form-control">
                                                @foreach ($recargoPagos as $recargoPago)
                                                    <option value="0" precio="0">Seleccionar recargo</option>
                                                    <option value="{{$recargoPago->Id}}" precio="{{$recargoPago->Precio}}">{{$recargoPago->Nombre}}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                        @else
                                        <div class="position-relative form-group recargo-pago-container"  style="display:none;">
                                            <label for="recargo-pago" class="">Recargo</label>
                                            <select name="select" id="recargo-pago" class="form-control">
                                                @foreach ($recargoPagos as $recargoPago)
                                                    <option value="{{$recargoPago->Id}}" precio="{{$recargoPago->Precio}}">{{$recargoPago->Nombre}}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                        @endif
                                    @endif


                                    <!--<div class="position-relative form-group">
                                        <label for="tipo" class="">Tipo descuento</label>
                                        <select name="select" id="tipo" class="form-control">
                                            <option value="0">Sin descuento</option>
                                            <option value="codigo">Código</option>
                                            <option value="cantidad">Cantidad</option>
                                        </select>
                                    </div>-->
                                    <div class="position-relative form-group codigo-container" style="display:none;">
                                        <label for="codigo_descuento" class="">Código Descuento</label>
                                        <input type="text" name="codigo_descuento" id="codigo_descuento" class="form-control">
                                    </div>
                                    <div class="position-relative form-group cantidad-container">
                                        <label for="cantidad-beca" class="">Beca</label>
                                        <input name="cantidad-beca" id="cantidad-beca" becaId='' type="text" class="form-control amount" disabled="disabled">
                                    </div>

                                    <div class="position-relative form-group cantidad-container">
                                        <label for="cantidad-descuento" class="">Descuento</label>
                                        <input name="cantidad-descuento" id="cantidad-descuento" type="text" class="form-control amount" disabled="disabled">
                                    </div>

                                    <div class="position-relative form-group cantidad-container">
                                        <label for="cantidad-recargo" class="">Recargo</label>
                                        <input name="cantidad-recargo" id="cantidad-recargo" type="text" class="form-control amount" disabled="disabled">
                                    </div>

                                    <div class="position-relative form-group">
                                        <label for="cantidad-pago" class="">Cantidad de pago</label>
                                        <input name="cantidad-pago" id="cantidad-pago" type="text" class="form-control amount">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="tipo_pago" class="">Tipo de pago</label>
                                        <select name="tipo_pago" id="tipo_pago" class="form-control">
                                            <option val="Efectivo">Efectivo</option>
                                            <option val="Cuenta bancaria">Cuenta bancaria</option>
                                        </select>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="notas" class="">Notas</label>
                                        <textarea name="text" id="notas" class="form-control"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="guardar-pago">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
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
        //let now         = new Date().toLocaleString('es-MX', { timeZone: 'CST' });
        const now       = new Date();
        const today     = now.getDate();
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

        $('#buscar-alumnos').click(function(e){
            $('#alumnos').DataTable().ajax.reload();
            $('#bajas').DataTable().ajax.reload();
        });


        function cambiarEstatus(alumnoId,estatus){
            const estatusText  = estatus == 0 ? 'Alta' : 'Baja';
            let fechaBaja      = "0000-01-01";
            const bajaTexto    = (estatusText == 'Baja') ? `Seleccionar fecha baja <input type="date" class="form-control" id="fecha-baja" style="width: 170px;margin: auto;" value="<?php echo(date('Y-m-d')); ?>">` : '';
            Swal.fire({
                title: `${estatusText} Alumno`,
                html: `¿Está seguro de dar de ${estatusText} ? <br><br> ${bajaTexto}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1f3047',
                cancelButtonColor: '#d92550',
                confirmButtonText: `${estatusText}!`,
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    if(estatusText == 'Baja'){
                        fechaBaja = $('#fecha-baja').val();
                    }
                    suspAlumno(alumnoId,estatus,fechaBaja);
                }
            });
            $('#alumnos').DataTable().ajax.reload();
            $('#bajas').DataTable().ajax.reload();
        }
        $('#bajas').on('click','.susp-alumno', function(){
            const alumnoId     = $(this).attr('alumnoId');
            const estatus      = $(this).attr('estatus');
            cambiarEstatus(alumnoId,estatus);
        });
        $('#alumnos').on('click','.susp-alumno', function(){
            const alumnoId     = $(this).attr('alumnoId');
            const estatus      = $(this).attr('estatus');
            cambiarEstatus(alumnoId,estatus);
        });
        function suspAlumno(becaAlumnoId,estatus,fechaBaja){
            $.ajax({
                type: 'POST',
                url: '/ajax/suspalumno',
                dataType: 'json',
                data:
                {
                    '_token': '{{ csrf_token() }}',
                    'alumno':{'id':becaAlumnoId,'estatus':estatus,'fechaBaja':fechaBaja}
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
                      text: 'Error al dar de baja al alumno'
                    });
                }
            });
        }
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
                            estatus = 'En espera';
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
                },
                
                { defaultContent: 'Actions', className: 'dt-center', 'render': function ( data, type, row ) 
                    {
                        const estatusText = row.Estatus == 1 ? 'Baja' : 'Activar';

                        let  statusAction = '';
                        if('{{(@session()->get('user_roles')['Alumnos']->Estatus)}}' == 'Y'){
                            statusAction = `| <a href="#" class="susp-alumno" alumnoId="${row.Id}" estatus="${row.Estatus}">${estatusText}</a>`;
                        }
                        let view    =   `<small> 
	                                        <a href="/alumnos/view?alumno=${row.Id}">Ver</a>  |  
	                                        <a href="#" class="new-payment" type="button" data-toggle="modal" data-target="#new_payment" alumnoId ="${row.Id}"> 
	                                            Nuevo pago 
	                                        </a>
                                            ${statusAction}
                                        </small>`;
                        return  view;
                    } 
                }
            ]
        } );
        $('#bajas').DataTable( {
            processing: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5', 
                orientation: 'landscape',
                pageSize: 'LEGAL',
                footer: true,
                text: 'Exportar Excel',
                title: 'Pagos',
            }],
            ajax: {
                url: '/ajax/getbajaalumnos',
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
                { data: 'Fecha_baja', className: 'dt-center'},
                { data: 'Adeudo', className: 'dt-center'},
                { defaultContent: 'Actions', className: 'dt-center', 'render': function ( data, type, row ) 
                    {
                        const estatusText = row.Estatus == 1 ? 'Baja' : 'Activar';

                        let  statusAction = '';
                        if('{{(@session()->get('user_roles')['Alumnos']->Estatus)}}' == 'Y'){
                            statusAction = `| <a href="#" class="susp-alumno" alumnoId="${row.Id}" estatus="${row.Estatus}">${estatusText}</a> `;
                        }
                        let view    =  `<small> 
                                           <a href="/alumnos/view?alumno=${row.Id}#adeudoBaja" target="_blank">Ver</a> 
                                           ${statusAction}
                                       </small>`;
                        return  view;
                    } 
                }
            ]
        } );
        $('#descuento-pronto-pago').change(function(e){
            calcularDescuentos();
            calcularTotal();
        });
        $('#recargo-pago').change(function(e){
            calcularRecargos();
            calcularTotal();
        });

        function calcularDescuentos(){
            let alumnoId      = $('.nombre-alumno-pago').attr('alumnoId');
            let mensualidad   = $('#mensualidad').children("option:selected").val();
            let allDescuentos = getAllDescuentos(alumnoId,mensualidad);
            
            let descuentoProntoPago = ($('#descuento-pronto-pago').children("option:selected").attr('precio') == undefined) ? 0 : $('#descuento-pronto-pago').children("option:selected").attr('precio');
            descuentos              = (parseFloat(allDescuentos)+parseFloat(descuentoProntoPago));
            setDescuento(descuentos);
            
        }

        function calcularRecargos(){
            let alumnoId      = $('.nombre-alumno-pago').attr('alumnoId');
            let mensualidad   = $('#mensualidad').children("option:selected").val();
            //let allRecargos = getAllRecargos(alumnoId,mensualidad);
            
            let recargosPago = ($('#recargo-pago').children("option:selected").attr('precio') == undefined) ? 0 : $('#recargo-pago').children("option:selected").attr('precio');
            recargos         = parseFloat(recargosPago);
            setRecargo(recargos);
        }

        $('#mensualidad').change(function(e){
            clearCantidades()
            let alumnoId = $('.nombre-alumno-pago').attr('alumnoId');
            let tipo     = $('#concepto').children("option:selected").attr('tipo');
            let mensualidad     = $(this).children("option:selected").val();
            let mensualidadTipo = $(this).children("option:selected").attr('tipo');
            if(mensualidad > 0){
                if(tipo == 'colegiatura'){
                    //if(mensualidadTipo == 'colegiatura'){
                        getBeca(alumnoId,mensualidad);
                    //}

                    if(descuentoIsValid(alumnoId,mensualidad)){
                        $('.descuento-pronto-pago-container').show();
                    }else{
                        $('.descuento-pronto-pago-container').hide();
                        $("#descuento-pronto-pago").val('0');
                    }

                    if(recargoIsValid(alumnoId,mensualidad)){
                        $('.recargo-pago-container').show();
                        $("#recargo-pago :nth(0)").prop("selected","selected").change();
                    }else{
                        $('.recargo-pago-container').hide();
                        $("#recargo-pago").val('0');
                    }
                }
            }
            getColegiatura(mensualidad);
            calcularDescuentos();
            calcularRecargos();
            calcularTotal();
        });
        function setDescuento(descuento) {        
            $('#cantidad-descuento').val(formatter.format(descuento));
            $('#cantidad-descuento').attr('value',descuento);
            calcularTotal();
        }
        function setRecargo(recargo){
            $('#cantidad-recargo').val(formatter.format(recargo));
            $('#cantidad-recargo').attr('value',recargo);
            calcularTotal();
        }
        function getColegiatura(mensualidad){
            $.ajax({
                type: 'POST',
                url: 'ajax/getorden',
                dataType: 'json',
                async:false,
                data:
                {
                    '_token'  : '{{ csrf_token() }}',
                    'ordenId' :mensualidad
                },
                success: function (result) {
                    $('.loader').hide();
                    if(result[0]=='success'){
                        displayPrecio(result[1]['Precio']);
                        calcularTotal();
                    }else{
                        Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Error al cargar colegiatura'
                        });
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('.loader').hide();
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'Error al cargar colegiatura'
                    });
                }
            });
        }
        function getAllDescuentos(alumnoId,mensualidad){
            let result = 0;
            $.ajax({
                type: 'POST',
                url: '/ajax/getalldescuentos',
                dataType: 'json',
                async:false,
                data:
                {
                    '_token'      : '{{ csrf_token() }}',
                    'alumno'      : {'id':alumnoId},
                    'mensualidad' : {'id':mensualidad},
                },
                success: function (descuento) {
                    $('.loader').hide();
                    if(descuento.descuento > 1){
                        result = descuento.descuento;
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('.loader').hide();
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'Error al cargar descuentos'
                    });
                    result = 0;
                }
            });
            return result;
        }
        function getAllRecargos(alumnoId,mensualidad){
            let result = 0;
            $.ajax({
                type: 'POST',
                url: '/ajax/getallrecargos',
                dataType: 'json',
                async:false,
                data:
                {
                    '_token'      : '{{ csrf_token() }}',
                    'alumno'      : {'id':alumnoId},
                    'mensualidad' : {'id':mensualidad},
                },
                success: function (recargo) {
                    $('.loader').hide();
                    if(recargo.recargo > 1){
                        result = recargo.recargo;
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('.loader').hide();
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'Error al cargar recargos'
                    });
                    result = 0;
                }
            });
            return result;
        }
        function descuentoIsValid(alumnoId,mensualidad){
            let isValid = true;//(today < 11);
            //iguala y huixuco
            /*
            if(({{@$_GET['Id']}} == 31) || ({{@$_GET['Id']}} == 32)){
                isValid = (today < 11);
            }
            */
            let result  = false;
            if(isValid){
                //normal discount
                $.ajax({
                    type: 'POST',
                    url: '/ajax/descuentoIsValid',
                    dataType: 'json',
                    async:false,
                    data:
                    {
                        '_token'      : '{{ csrf_token() }}',
                        'alumno'      : {'id':alumnoId},
                        'mensualidad' : {'id':mensualidad},
                    },
                    success: function (isValid) {
                        $('.loader').hide();
                        result  = isValid.result;
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('.loader').hide();
                        Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Error al cargar el descuento'
                        });
                    }
                });
            }else{
                //customized discount by 1 day
                alert("Error: customized discount by 1 day");
                /*
                $.ajax({
                    type: 'POST',
                    url: '/ajax/getdescuento',
                    dataType: 'json',
                    async:false,
                    data:
                    {
                        '_token'      : '{{ csrf_token() }}',
                        'alumno'      : {'id':alumnoId},
                    },
                    success: function (descuento) {
                        $('.loader').hide();
                        if(descuento[0] == 'success'){
                            result  = true;
                            $("#descuento-pronto-pago").val(descuento[1][0]['Concepto_id']);
                            $("#descuento-pronto-pago").attr('disabled','disabled');
                            let descuento = $('#descuento-pronto-pago').children("option:selected").attr('precio');
                            setDescuento(descuento);
                            calcularTotal();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('.loader').hide();
                        Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Error al cargar el descuento'
                        });
                    }
                });
                */
            }
            return result;
        }
        function recargoIsValid(alumnoId,mensualidad){
            let isValid = true;

            let result  = false;
            if(isValid){
                //normal discount
                $.ajax({
                    type: 'POST',
                    url: '/ajax/recargoIsValid',
                    dataType: 'json',
                    async:false,
                    data:
                    {
                        '_token'      : '{{ csrf_token() }}',
                        'alumno'      : {'id':alumnoId},
                        'mensualidad' : {'id':mensualidad},
                    },
                    success: function (isValid) {
                        $('.loader').hide();
                        result  = isValid.result;
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('.loader').hide();
                        Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Error al cargar el recargo'
                        });
                    }
                });
            }else{
                //customized discount by 1 day
                $.ajax({
                    type: 'POST',
                    url: '/ajax/getrecargo',
                    dataType: 'json',
                    async:false,
                    data:
                    {
                        '_token'      : '{{ csrf_token() }}',
                        'alumno'      : {'id':alumnoId},
                    },
                    success: function (descuento) {
                        $('.loader').hide();
                        if(descuento[0] == 'success'){
                            result  = true;
                            $("#descuento-pronto-pago").val(descuento[1][0]['Concepto_id']);
                            $("#descuento-pronto-pago").attr('disabled','disabled');
                            let descuento = $('#descuento-pronto-pago').children("option:selected").attr('precio');
                            setDescuento(descuento);
                            calcularTotal();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('.loader').hide();
                        Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Error al cargar el descuento'
                        });
                    }
                });
            }
            return result;
        }
        $('#concepto').change(function(e){
            let tipo   = $(this).children("option:selected").attr('tipo');
            let precio = ($(this).children("option:selected").attr('precio') == undefined) ? 0 : $(this).children("option:selected").attr('precio');
            let alumnoId = $('.nombre-alumno-pago').attr('alumnoId');
            clearCantidades();
            
            displayMensualidadContainer(tipo);
            displayPrecio(precio);
            calcularTotal();
        });
        /*$('#tipo').change(function(e){
            let tipo   = $(this).children("option:selected").val();
            displayDescuentoContainer(tipo);
            setTimeout(calcularTotal,500);
        });*/
        
        $('#cantidad-beca').keyup(function() {
            setTimeout(calcularTotal,500);
        });
        $('#cantidad-pago').keyup(function() {
            setTimeout(calcularTotal,500);
        });
        $(document).on('click','.new-payment', function () {
            const alumnoId = $(this).attr('alumnoId');
            clearPago()
            displayAlumno(alumnoId);
        });
        $(document).on('click','#guardar-pago', function () {
            const alumnoId          = $('.nombre-alumno-pago').attr('alumnoId');
            const conceptoId        = $('#concepto').children("option:selected").val();
            const tipo              = $('#concepto').children("option:selected").attr('tipo');
            const ordenId           = ((tipo == 'colegiatura' || tipo == 'cuota-personalizada-anual') ? $('#mensualidad').children("option:selected").val() : 0);
            
            const tipoPago          = $('#tipo_pago').children("option:selected").val();
            const cantidadPago      = $('#cantidad-pago').attr('value');
            const cantidadBeca      = $('#cantidad-beca').attr('value');
            const cantidadBecaId    = $('#cantidad-beca').attr('becaId');
            const cantidadDescuento = $('#cantidad-descuento').attr('value');

            const cantidadRecargo   = $('#cantidad-recargo').attr('value');

            const notas             = $('#notas').val();
            let   pagoDetalles      = {};
            let   recargodetalles   = {};
            let   cantidadR         = [];
            const pago         =  {
                'alumnoId'     : alumnoId,
                'conceptoId'   : conceptoId,
                'tipo'         : tipo,
                'ordenId'      : ordenId,
                'tipoPago'     : tipoPago,
                'notas'        : notas
            };
            let cantidad         = [
                {
                    'subConceptoId'  : conceptoId,
                    'cantidadPago' : cantidadPago
                }
            ];
            if(cantidadBeca > 0){
                const beca = {
                    'subConceptoId'  : cantidadBecaId,
                    'cantidadPago' : cantidadBeca
                }
                cantidad.push(beca);
            }

            if(cantidadDescuento > 0){
                const descuento = {
                    'subConceptoId' : $('#descuento-pronto-pago').children("option:selected").val(),
                    'cantidadPago'  : $('#descuento-pronto-pago').children("option:selected").attr('precio')
                }
                cantidad.push(descuento);
            }

            

            if(cantidadRecargo > 0){
                const recargo = {
                    'subConceptoId' : $('#recargo-pago').children("option:selected").val(),
                    'cantidadRecargo'  : $('#recargo-pago').children("option:selected").attr('precio')
                }
                cantidadR.push(recargo);
            }

            recargodetalles.cantidad = cantidadR;

            pagoDetalles.detalles = pago
            pagoDetalles.cantidad = cantidad;
            savePago(pagoDetalles,recargodetalles);
        });
    }); 
    function clearPago(){
        $('.nombre-alumno-pago').attr('');
        $('#concepto .custom').remove();
        $('#cantidad-pago').val(formatter.format(0));
        $('#cantidad-pago').attr('value','0.00');
        $('#cantidad-beca').val(formatter.format(0));
        $('#cantidad-beca').attr('value','0.00');
        $('#cantidad-beca').attr('becaId',0);
        $('#cantidad-descuento').val(formatter.format(0));
        $('#cantidad-descuento').attr('value','0.00');

        $('#cantidad-recargo').val(formatter.format(0));
        $('#cantidad-recargo').attr('value','0.00');


        $("#descuento-pronto-pago").val("false");
        $('#cantidad-pagar').val(formatter.format(0));
        $('#cantidad-pagar').attr('value',0);
        $('#cantidad-descuento-t').val(formatter.format(0));
        $('#cantidad-descuento-t').attr('value',0);

        $('#cantidad-recargo-t').val(formatter.format(0));
        $('#cantidad-recargo-t').attr('value',0);

        $('#cantidad-beca-t').val(formatter.format(0));
        $('#cantidad-beca-t').attr('value',0);
        $('#resta').val(formatter.format(0));
        $('#resta').attr('value',0);
        $('#notas').val('');
    }
    function clearCantidades(){
        $('#cantidad-beca').val(formatter.format(0));
        $('#cantidad-beca').attr('value','0.00');
        $('#cantidad-beca').attr('becaId',0);
        $('#cantidad-descuento').val(formatter.format(0));
        $('#cantidad-descuento').attr('value','0.00');

        $('#cantidad-recargo').val(formatter.format(0));
        $('#cantidad-recargo').attr('value','0.00');


        $("#descuento-pronto-pago").val("false");
        $('#cantidad-pagar').val(formatter.format(0));
        $('#cantidad-pagar').attr('value',0);
        $('#cantidad-descuento-t').val(formatter.format(0));
        $('#cantidad-descuento-t').attr('value',0);

        $('#cantidad-recargo-t').val(formatter.format(0));
        $('#cantidad-recargo-t').attr('value',0);

        $('#cantidad-beca-t').val(formatter.format(0));
        $('#cantidad-beca-t').attr('value',0);
        $('#resta').val(formatter.format(0));
        $('#resta').attr('value',0);
    }
    function savePago(pago,recargo){
        $.ajax({
            type: 'POST',
            url: '/ajax/newalumnopago',
            dataType: 'json',
            data:
            {
                '_token': '{{ csrf_token() }}',
                'pago'  : pago,
                'recargo' : recargo
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
                }else{
                    Swal.fire({
                        icon: result[0],
                        title: (result[0] == 'success' ? 'Exito' : 'Error'),
                        text: result[1]
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al guardar el pago'
                });
            }
        });
    }
    function getBeca(alumnoId,mensualidad){
        $.ajax({
            type: 'POST',
            url: '/ajax/getbecaalumno',
            dataType: 'json',
            data:
            {
                '_token'      : '{{ csrf_token() }}',
                'alumno'      : {'id':alumnoId},
                'mensualidad' : {'id':mensualidad},
            },
            success: function (result) {
                $('.loader').hide();
                
                if(result.data.length > 0){
                    $('#cantidad-beca').val(formatter.format(result.data[0].Cantidad_beca));
                    $('#cantidad-beca').attr('value',result.data[0].Cantidad_beca);
                    $('#cantidad-beca').attr('becaId',result.data[0].Id);
                    calcularTotal();
                }
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al cargar la beca'
                });
            }
        });
    }
    function getDescuento(isValid) {
        /*
        let descuento = {$descuento[0]->Precio}};
        
        $('#cantidad-descuento').val(formatter.format(descuento));
        $('#cantidad-descuento').attr('value',descuento);
        */
        calcularTotal();
    }
    function displayAlumno(alumnoId){
        $.ajax({
            type: 'POST',
            url: '/ajax/getalumnopago',
            dataType: 'json',
            data:
            {
                '_token'  : '{{ csrf_token() }}',
                'alumnoId': alumnoId,
                'plantelId': {{@$_GET['Id']}}
            },
            success: function (result) {
                $('.loader').hide();
                if(result[0] == 'success'){
                    let alumno        = result['alumno'][0];
                    let mensualidades = result['mensualidades'];
                    let conceptos     = result['conceptos'];
                    
                    $('.nombre-alumno-pago').attr('alumnoId',alumnoId);
                    $('.nombre-alumno-pago').html(`${alumno.Nombre} ${alumno.Apellido_paterno} ${alumno.Apellido_materno}`);
                    createConceptosList(conceptos);
                    createMensualidadesList(mensualidades);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al cargar al alumno'
                });
            }
        });
    }
    function createMensualidadesList(mensualidades){
        let options = '';
        for(let i = 0; i < mensualidades.length;i++){
            options += `<option class="custom" tipo="${mensualidades[i].Tipo}" value="${mensualidades[i].Id}" >${mensualidades[i].Descripcion}</option>`
        }
        $('#mensualidad .custom').remove();
        $(options).appendTo('#mensualidad');
    }
    function createConceptosList(conceptos){
        let options = '';
        for(let i = 0; i < conceptos.length;i++){
            options += `<option class="custom" value="${conceptos[i].Id}" tipo="${conceptos[i].Tipo}" precio="${conceptos[i].Precio}">${conceptos[i].Nombre}</option>`
        }
        $('#concepto .custom').remove();
        $(options).appendTo('#concepto');
    }
    function calcularTotal(){
        let totalConcepto = $('#cantidad-pagar').attr('value');
        let beca          = 0;
        let descuento     = 0;
        let recargo       = 0;
        //let tipo          = $('#tipo').children("option:selected").val();
        let pago          = $('#cantidad-pago').attr('value');
        let total         = 0;
        /*
        switch(tipo) {
            case 'codigo':
                descuento = 0;
                break;
            case 'cantidad':
                descuento = $('#cantidad-beca').attr('value');
                break;
            default:
                descuento = 0;
        }*/
        beca      = $('#cantidad-beca').attr('value');
        descuento = $('#cantidad-descuento').attr('value');

        recargo   = $('#cantidad-recargo').attr('value');
        
        total = parseFloat(totalConcepto) - parseFloat(pago);
        total = parseFloat(total) - parseFloat(beca);
        total = parseFloat(total) - parseFloat(descuento);

        total = parseFloat(total) + parseFloat(recargo);
        
        if(total < 0){
            if(beca > totalConcepto){
                $('#cantidad-beca').attr('value',0);
                $('#cantidad-beca').val(0);
            }else{
                $('#cantidad-pago').attr('value',0);
                $('#cantidad-pago').val(0);
            }
        }
        
        total = parseFloat(total).toFixed(2);
        $('#resta').attr("value",total);
        $('#resta').val(formatter.format(total));
        $('#cantidad-beca-t').val(formatter.format(beca));
        $('#cantidad-beca-t').attr('value',beca);
        $('#cantidad-descuento-t').val(formatter.format(descuento));
        $('#cantidad-descuento-t').attr('value',descuento);

        $('#cantidad-recargo-t').val(formatter.format(recargo));
        $('#cantidad-recargo-t').attr('value',recargo);
    }
    function displayMensualidadContainer(tipo){
        if(tipo == 'colegiatura'){
            $('.mensualidad-container').show();
            //$('.descuento-pronto-pago-container').show();
        }else{
            $('.mensualidad-container').hide();
            //$('.descuento-pronto-pago-container').hide();
        }
    }
    function displayPrecio(precio){
        $('#cantidad-pagar').val(formatter.format(precio));
        $('#cantidad-pagar').attr('value',precio);
    }
    function displayDescuentoContainer(tipo){
        switch(tipo) {
            case 'codigo':
                $('.cantidad-container').hide();
                $('.codigo-container').show();
                break;
            case 'cantidad':
                $('.cantidad-container').show();
                $('.codigo-container').hide();
                break;
            default:
                $('.cantidad-container').hide();
                $('.codigo-container').hide();
        }
    }
    function verifyPlantelBillType(alumno){
        const plantel        =  alumno.plantel;
        const lazaroCardenas = 3;
        if(plantel == lazaroCardenas){
            $('#tipo_pago [val="Efectivo"]').hide();
            $('#tipo_pago [val="Cuenta bancaria"]').attr('selected','selected');
        }else{
            $('#tipo_pago [val="Efectivo"]').show();
            $('#tipo_pago [val="Efectivo"]').attr('selected','selected');
        }
    }
    function getAlumnoFilters(){
        alumno = {
            'plantel'      : {{@$_GET['Id']}},
            'nivel'        : $('#nivel').children("option:selected").val(),
            'licenciatura' : $('#licenciatura').children("option:selected").val(),
            'sistema'      : $('#sistema').children("option:selected").val(),
            'grupo'        : $('#grupo').children("option:selected").val(),
            'generacion'   : $('#generacion').children("option:selected").val(),
            'estatusAlumno': $('#estatusAlumno').children("option:selected").val()
        }
        verifyPlantelBillType(alumno);
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
                    <div>Alumnos ({{$plantel}})
                    </div>  
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        @if (session()->get('user_roles')['role'] === 'Administrador')
                        <a href="{{ url('alumnos/update-grupo?Id=') }}{{$_GET['Id']}}" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="metismenu-icon pe-7s-network"></i>
                            </span>
                            Actualizar Grupo
                        </a>
                        @endif
                        @if (session()->get('user_roles')['Alumnos']->Crear == 'Y')
                        <a href="{{ url('alumnos/new?Id=') }}{{$_GET['Id']}}" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-user-plus fa-w-20"></i>
                            </span>
                            Nuevo Alumno
                        </a>
                        @endif
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
                                    <div class="form-group">
                                        <label for="estatusAlumno">Estatus Alumnos</label>
                                        <select class="form-control" name="estatusAlumno" id="estatusAlumno" style="width: 200px;">
                                            <option value="1" selected="selected">Activos</option>
                                            <option value="3">Finalizados</option>
                                        </select>
                                    </div>
                                    <form>
                                        <div class="form-row filters" style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr  90px;">
                                            <div class="form-group " style="display: none;">
                                                <label for="plantel">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel">
                                                    @foreach ($planteles as $plantel)
                                                        <option value="{{$plantel->Id}}" selected="selected" >{{$plantel->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="nivel">Nivel</label>
                                                <select class="form-control dinamic_filters" name="nivel" id="nivel">
                                                    <option value="0" selected="selected">Seleccionar nivel</option>
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="licenciaturas">Licenciatura</label>
                                                <select class="form-control dinamic_filters" name="licenciatura" id="licenciatura">
                                                    <option value="0" selected="selected">Seleccionar licenciatura</option>
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
                                                <select class="form-control" name="grupo" id="grupo">
                                                    <option value="0" selected="selected">Seleccionar grupo</option>
                                                </select>
                                            </div>
                                            <div class="form-group  ">
                                                <label for="generacion">Generación</label>
                                                <select class="form-control dinamic_filters" name="generacion" id="generacion">
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
                                        <th>Grupo</th>
                                        <th>Estatus Pago</th>
                                        <th>Estatus Alumno</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                            <p style="font-size: 20px;font-weight: 700;margin: 35px 0 20px 0;">Bajas</p>
                            <table id="bajas" class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Fecha Baja</th>
                                        <th>Meses adeudo</th>
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