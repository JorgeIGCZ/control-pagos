<div class="modal fade" id="edit_order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <div>Editar Colegiatura 
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
                                <h5 class="card-title nombre-colegiatura" ordenId =""></h5>
                                <form class="">
                                    <div class="position-relative form-group codigo-container">
                                        <label for="precio-colegiatura" class="">Precio</label>
                                        <input type="text" name="precio" id="precio-colegiatura" class="form-control amount">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="estatus-colegiatura" class="">Estatus</label>
                                        <select name="select" id="estatus-colegiatura" class="form-control">
                                            <option value="2">Pagado</option>
                                            <option value="1">Parcial</option>
                                            <option value="0">Pendiente</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="update_orden" data-dismiss="modal">Actualizar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <div>Editar Pago 
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
                                <h5 class="card-title nombre-concepto" pagoId =""></h5>
                                <form class="">
                                    <div class="position-relative form-group codigo-container">
                                        <label for="cantidad-pago-edit" class="">Cantidad de pago</label>
                                        <input type="text" name="cantidad-pago-edit" id="cantidad-pago-edit" class="form-control amount">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="tipo-pago-edit class="">Tipo de pago</label>
                                        <select name="select" id="tipo-pago-edit" class="form-control">
                                            <option value="Efectivo">Efectivo</option>
                                            <option value="Cuenta bancaria">Cuenta bancaria</option>
                                        </select>
                                    </div>
                                    <div class="position-relative form-group codigo-container">
                                        <label for="notas-edit" class="">Notas</label>
                                        <textarea name="notas" id="notas-edit" class="form-control"> </textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="update_pago" data-dismiss="modal">Actualizar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new_descuento" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div class="page-title-icon">
                                <i class="pe-7s-rocket icon-gradient bg-mean-fruit">
                                </i>
                            </div>
                            <div>Descuentos
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
                                <h5 class="card-title">
                                    {{$alumno[0]->Nombre}}
                                </h5>
                                <form class="">
                                    <div class="position-relative form-group">
                                        <label for="tipo-descuento" class="">Descuento</label>
                                        <select name="select" id="tipo-descuento" class="form-control">
                                            @foreach ($prontoPago as $prontoP)
                                                <option value="{{$prontoP->Id}}" precio="{{$prontoP->Precio}}">{{$prontoP->Nombre}}</option>
                                            @endforeach
                                            <option value="p">Descuento personalizado</option>
                                        </select>
                                    </div>

                                    <div class="descuento-personalizado position-relative form-group" style="display:none;">
                                        <label for="mensualidad" class="">Mensualidad</label>
                                        <select name="select" id="mensualidad" class="form-control">
                                            <option value="0">Seleccionar mensualidades</option>
                                        </select>
                                    </div>
                                    <div class="descuento-personalizado position-relative form-group" style="display:none;">

                                        <label for="descuento" class="">Cantidad descuento</label>
                                        <input name="cantidad-descuento" id="cantidad-descuento" type="text" class="form-control amount" value="0.00">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="generar-descuento">Generar</button>
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
        const niveles       = @php echo(json_encode($niveles)); @endphp;
        const licenciaturas = @php echo(json_encode($licenciaturas)); @endphp;
        const grupos        = @php echo(json_encode($grupos)); @endphp;
        const generaciones  = @php echo(json_encode($generaciones)); @endphp;
        const conceptos     = @php echo(json_encode($conceptos)); @endphp;
        const inscripciones = @php echo(json_encode($inscripciones)); @endphp;
        const cuotas        = @php echo(json_encode($cuotas)); @endphp;

        displayOptions('nivel',[$('#plantel').children("option:selected").val()],niveles,['Plantel_id'],{{$informacion[0]->Nivel_id}});
        displayOptions('licenciatura',[$('#plantel').children("option:selected").val()],licenciaturas,['Plantel_id'],{{$informacion[0]->Licenciatura_id}});
        displayOptions('generacion',[$('#plantel').children("option:selected").val()],generaciones,['Plantel_id'],{{$informacion[0]->Generacion_id}});
        displayOptions('grupo',[$('#plantel').children("option:selected").val(),$('#licenciatura').children("option:selected").val(),$('#sistema').children("option:selected").val()],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],{{$informacion[0]->Grupo_id}});
        displayOptions('concepto',[$('#plantel').children("option:selected").val()],conceptos,['Plantel_id'],{{$informacion[0]->Concepto_id}});
        displayOptions('concepto-inscripcion',[$('#plantel').children("option:selected").val()],inscripciones,['Plantel_id'],{{$informacion[0]->Concepto_inscripcion_id}});
        displayOptions('concepto-cuota',[$('#plantel').children("option:selected").val()],cuotas,['Plantel_id'],{{$informacion[0]->Concepto_cuota_id}});
        $('#plantel').on('change',function(){
            const selection    = $(this).children("option:selected").val();
            const licenciatura = $('#licenciatura').children("option:selected").val();
            const sistema      = $('#sistema').children("option:selected").val();
            displayOptions('nivel',[selection],niveles,['Plantel_id'],{{$informacion[0]->Nivel_id}});
            displayOptions('licenciatura',[selection],licenciaturas,['Plantel_id'],{{$informacion[0]->Licenciatura_id}});
            displayOptions('generacion',[selection],generaciones,['Plantel_id'],{{$informacion[0]->Generacion_id}});
            displayOptions('grupo',[selection,licenciatura,sistema],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],{{$informacion[0]->Grupo_id}});
            displayOptions('concepto',[selection],conceptos,['Plantel_id'],{{$informacion[0]->Concepto_id}});
            displayOptions('concepto-inscripcion',[selection],inscripciones,['Plantel_id'],{{$informacion[0]->Concepto_inscripcion_id}});
            displayOptions('concepto-cuota',[selection],cuotas,['Plantel_id'],{{$informacion[0]->Concepto_cuota_id}});
        });
        $('#licenciatura').on('change',function(){
            const plantel   = $('#plantel').children("option:selected").val();
            const selection = $(this).children("option:selected").val();
            const sistema   = $('#sistema').children("option:selected").val();
            displayOptions('grupo',[plantel,selection,sistema],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],{{$informacion[0]->Grupo_id}});
        });
        $('#sistema').on('change',function(){
            const plantel      = $('#plantel').children("option:selected").val();
            const licenciatura = $('#licenciatura').children("option:selected").val();
            const selection    = $(this).children("option:selected").val();
            displayOptions('grupo',[plantel,licenciatura,selection],grupos,['Plantel_id','Licenciatura_id','Sistema_id'],{{$informacion[0]->Grupo_id}});
        });


        getMensualidades({{$_GET['alumno']}});
        $('#tipo-descuento').change(function(e){
            let descuento = $(this).children("option:selected").val();
            if(descuento == 'p'){
                $('.descuento-personalizado').show();
            }else{
                $('.descuento-personalizado').hide();
                $('#cantidad-descuento').val(0);
                $('#cantidad-descuento').attr('value',0.00);
            }
        });

        $('#create-proximas-colegiaturas').on('click',function(){
            createProximasColegiaturas({{$_GET['alumno']}});
        });

        $('.datos-personales').on('click', '.save', function(){
            const tipo = "personales";
            editDatos(tipo);
        });
        $('.datos-academicos').on('click', '.save', function(){
            const tipo = "academicos";
            editDatos(tipo);
        });

        $('#pagos').on('click', '.edit_pago', function(){
            const pagoId = $(this).attr('pagoId');
            clearPago()
            displayPago(pagoId);
        });

        $('#colegiaturas').on('click', '.edit_orden', function(){
            const ordenId = $(this).attr('ordenId');
            clearOrden()
            displayOrden(ordenId);
        });
        $('#update_orden').on('click',function(){
            const ordenId = $('.nombre-colegiatura').attr('ordenId');

            let datos = {
                'estatus': $('#estatus-colegiatura').children("option:selected").val(),
                'precio' : $('#precio-colegiatura').attr('value')
            }
            updateOrden(ordenId,datos);
        });

        $('#update_pago').on('click',function(){
            const pagoId = $('.nombre-concepto').attr('pagoId');

            let datos = {
                'cantidadPago': $('#cantidad-pago-edit').attr('value'),
                'tipoPago'    : $('#tipo-pago-edit').children("option:selected").val(),
                'notas'       : $('#notas-edit').val(),
            }
            updatePago(pagoId,datos);
        });

        $('#generar-descuento').on('click',function(){
            const descuento = $('#tipo-descuento').children("option:selected").val();
            if(descuento == 'p'){
                const ordenId = $('#mensualidad').children("option:selected").val();
                if(ordenId > 0){
                    const descuentoDetalles =  {
                        'alumnoId'     : {{$_GET['alumno']}},
                        'ordenId'      : ordenId,
                        'subConceptoId': 30,
                        'cantidadDescuento' : $('#cantidad-descuento').attr('value')
                    };
                    saveDescuento(descuentoDetalles);
                }else{
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error',
                        text: 'Seleccionar mensualidad'
                    });
                }
            }else{
                generarDescuento();
            }
        });
        $('#beca-alumno').DataTable( {
            ajax: {
                type: 'POST',
                url: '/ajax/getbecaalumno',
                dataType: 'json',
                data:
                {
                    '_token': '{{ csrf_token() }}',
                    'alumno':  {'id':{{$_GET['alumno']}} }
                }
            },
            language: {
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "lengthMenu":     "Mostrando _MENU_ beca",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Busqueda:",
                "zeroRecords":    "Ninguna beca encontrada",
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
                { data: 'Periodo' },
                { data: 'Cantidad_beca',defaultContent: 'Cantidad_beca', 'render': function ( data, type, row ) 
                    {
                        let view    = formatter.format(row.Cantidad_beca);
                        return  view;
                    } 
                },
                { data: 'Estatus',defaultContent: 'Estatus', 'render': function ( data, type, row ) 
                    {
                        let estatus;
                        let tClass;
                        
                        switch(row.Estatus) {
                          case 1:
                            estatus = 'Activo';
                            tClass  = 'btn-success';
                            break;
                          case 0:
                            estatus = 'Inactivo';
                            tClass  = 'btn-danger';
                            break;
                        }
                        let view = `<span class="mb-2 mr-2 btn-hover-shine btn ${tClass}">${estatus}</span>`;
                        return  view;
                    } 
                }
            ]
        } );
        
        $('#pagos').DataTable( {
            "order": [[ 0, "desc" ]],
            ajax: {
                type: 'POST',
                url: '/ajax/getalumnoallpagos',
                dataType: 'json',
                data:
                {
                    '_token'  : '{{ csrf_token() }}',
                    'alumnoId': @php echo($_GET['alumno']) @endphp
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
                { data: 'Cantidad_pago',defaultContent: 'Cantidad_pago', 'render': function ( data, type, row ) 
                    {
                        return  formatter.format(row.Cantidad_pago);
                    } 
                },
                { data: 'Tipo_pago' },
                { data: 'Descripcion_pago' },
                { data: 'Notas' },
                { data: 'updated_at' },
                @if (session()->get('user_roles')['role'] === 'Administrador')
                { defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let view    =  `<small>
                                            <a href="#" class="edit_pago" type="button" data-toggle="modal" data-target="#edit_pago" pagoId ="${row.Id}">
                                                Editar
                                            </a>
                                       </small>`;
                        return  view;
                    } 
                }
                @endif
            ]
        } );
        $('#titulacion').DataTable( {
            footerCallback: function ( row, data, start, end, display ) {
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
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
                }, 0 );
                let precio = {{$precioTitulacion[0]->precio}};
                balance = precio - total;
                $('#paymentTotal').html(formatter.format(balance));
                $('#balanceTotal').html(formatter.format(balance));
                // Total over this page
                pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
                }, 0 );
                // Update footer
                $( api.column( 2 ).footer() ).html(
                  formatter.format(pageTotal)
                  );
            },

            ajax: {
                type: 'POST',
                url: '/ajax/getalumnopagostitulacion',
                dataType: 'json',
                data:
                {
                    '_token'  : '{{ csrf_token() }}',
                    'alumnoId': @php echo($_GET['alumno']) @endphp
                },
            },
            language: {
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
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
                { data: 'Descripcion' },
                { data: 'Cantidad_pago',defaultContent: 'Cantidad_pago', 'render': function ( data, type, row ) 
                    {
                        return  formatter.format(row.Cantidad_pago);
                    } 
                },
                { data: 'Tipo_pago' },
                { data: 'Descripcion_pago' },
                { data: 'Notas' },
                { data: 'updated_at' }
            ]
        } );
        $('#adeudoBaja').DataTable( {
            "order": [[ 4, "desc" ]],
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5', 
                orientation: 'landscape',
                pageSize: 'LEGAL',
                footer: true,
                text: 'Exportar Excel',
                title: 'MESES ADEUDO EN BAJA @php echo($alumno[0]->Nombre." ".$alumno[0]->Apellido_paterno." ".$alumno[0]->Apellido_materno); @endphp',
            }],
            ajax: {
                type: 'POST',
                url: '/ajax/getalumnoallmesesadeudo',
                dataType: 'json',
                data:
                {
                    '_token'  : '{{ csrf_token() }}',
                    'alumnoId': @php echo($_GET['alumno']) @endphp
                },
            },
            language: {
                "info": "Mostrando pagina _PAGE_ de _PAGES_ total _TOTAL_ pagos",
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
                { data: 'precio',defaultContent: 'precio', 'render': function ( data, type, row ) 
                    {
                        return  formatter.format(row.precio);
                    } 
                },
                { data: 'Estatus',defaultContent: 'Estatus', 'render': function ( data, type, row ) 
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
                { data: 'Fecha_creacion' },
                
            ]
        }); 
        $('#colegiaturas').DataTable( {
            "pageLength" : 15,
            "lengthMenu": [15, 25, 50, 100],
            "order": [[ 6, "desc" ]],
            ajax: {
                type: 'POST',
                url: '/ajax/getalumnoallcolegiaturas',
                dataType: 'json',
                data:
                {
                    '_token'  : '{{ csrf_token() }}',
                    'alumnoId': @php echo($_GET['alumno']) @endphp
                },
            },
            language: {
                "info": "Mostrando pagina _PAGE_ de _PAGES_ total _TOTAL_ pagos",
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
                { data: 'precio',defaultContent: 'precio', 'render': function ( data, type, row ) 
                    {
                        return  formatter.format(row.precio);
                    } 
                },
                { data: 'Estatus',defaultContent: 'Estatus', 'render': function ( data, type, row ) 
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
                { data: 'Pagado',defaultContent: 'Pagado', 'render': function ( data, type, row ) 
                    {
                        return  formatter.format(row.Pagado);
                    } 
                },
                { data: 'Pendiente',defaultContent: 'Pendiente', 'render': function ( data, type, row ) 
                    {
                        return  formatter.format(row.precio-row.Pagado);
                    } 
                },
                { data: 'Fecha_creacion' },
                @if (session()->get('user_roles')['Pagos']->Modificar == 'Y')
                { defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        const estatusText = row.Estatus == 1 ? 'Baja' : 'Activar';
                        let view    =  `<small>
                                            <a href="#" class="edit_orden" type="button" data-toggle="modal" data-target="#edit_order" ordenId ="${row.Id}">
                                                Editar
                                            </a>
                                       </small>`;
                        return  view;
                    } 
                }
                @endif
            ]
        }); 
    });
    function saveDescuento(descuentoDetalles){
        $.ajax({
            type: 'POST',
            url: '/ajax/newalumnodescuento',
            dataType: 'json',
            data:
            {
                '_token': '{{ csrf_token() }}',
                'descuentoDetalles'  : descuentoDetalles
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
    function createProximasColegiaturas(alumnoId){
        $('.loader').show();
        $.ajax({
            type: 'POST',
            url: '/ajax/createOrdenPeriodo',
            dataType: 'json',
            data:
            {
                '_token'  : '{{ csrf_token() }}',
                'alumnoId': alumnoId
            },
            success: function (result) {
                Swal.fire({
                    icon: result[0],
                    title: (result[0] == 'success' ? 'Exito' : 'Error'),
                    text: result[1]
                });
                $('.loader').hide();
                $('#colegiaturas').DataTable().ajax.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al crear mensualidades'
                });
            }
        });
    }
    function getMensualidades(alumnoId){
        $.ajax({
            type: 'POST',
            url: '/ajax/getalumnopago',
            dataType: 'json',
            data:
            {
                '_token'  : '{{ csrf_token() }}',
                'alumnoId': alumnoId
            },
            success: function (result) {
                $('.loader').hide();
                if(result[0] == 'success'){
                    let mensualidades = result['mensualidades'];
                    createMensualidadesList(mensualidades);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al cargar mensualidades'
                });
            }
        });
    }
    function createMensualidadesList(mensualidades){
        let options = '';
        for(let i = 0; i < mensualidades.length;i++){
            options += `<option class="custom" value="${mensualidades[i].Id}" >${mensualidades[i].Descripcion}</option>`
        }
        $('#mensualidad .custom').remove();
        $(options).appendTo('#mensualidad');
    }

    function clearPago(){
        $('#tipo-pago-edit').val(0);
        $('#cantidad-pago-edit').val(formatter.format(0));
        $('#cantidad-pago-edit').attr('value','0.00');
        $('#notas-edit').val('');

    }
    function displayPago(pagoId){
        $.ajax({
            type: 'POST',
            url: '/ajax/getpago',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'pagoId': pagoId
            },
            success: function (result) {
                
                if(result[0] == 'success'){
                    let id      = result[1]['Id'];
                    let nombre  = result[1]['Nombre'];
                    let tipoPago = result[1]['Tipo_pago'];
                    let cantidadPago  = result[1]['Cantidad_pago'];
                    let notas = result[1]['Notas'];
                    

                    $('.nombre-concepto').attr('pagoId',id);
                    $('.nombre-concepto').html(nombre);

                    $('#tipo-pago-edit').val(tipoPago);
                    $('#cantidad-pago-edit').val(formatter.format(cantidadPago));
                    $('#cantidad-pago-edit').attr('value',cantidadPago);
                    $('#notas-edit').val(notas);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al cargar el pago'
                });
            }
        });
    }
    function updatePago(pagoId,datos){
        $('.loader').show();
        $.ajax({
            type: 'POST',
            url: '/ajax/updatepago',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'pagoId': pagoId,
                'datos'  : datos
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
                            $('#pagos').DataTable().ajax.reload();
                        }
                      }
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al actualizar pago'
                });
            }
        });
    }

    function clearOrden(){
        $('#nombre-colegiatura').attr('ordenId','');
        $('#nombre-colegiatura').html('');
        $('#estatus-colegiatura').val(0);
        $('#precio-colegiatura').val(formatter.format(0));
        $('#precio-colegiatura').attr('value','0.00');
    }
    function updateOrden(ordenId,datos){
        $('.loader').show();
        $.ajax({
            type: 'POST',
            url: '/ajax/updateorden',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'ordenId': ordenId,
                'datos'  : datos
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
                            $('#colegiaturas').DataTable().ajax.reload();
                        }
                      }
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al actualizar colegiatura'
                });
            }
        });
    }
    function displayOrden(ordenId){
        $.ajax({
            type: 'POST',
            url: '/ajax/getorden',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'ordenId': ordenId
            },
            success: function (result) {
                
                if(result[0] == 'success'){
                    let id      = result[1]['Id'];
                    let nombre  = result[1]['Descripcion'];
                    let estatus = result[1]['Estatus'];
                    let precio  = result[1]['Precio'];
                    
                    $('.nombre-colegiatura').attr('ordenId',id);
                    $('.nombre-colegiatura').html(nombre);

                    $('#precio-colegiatura').val(formatter.format(precio));
                    $('#precio-colegiatura').attr('value',precio);

                    $('#estatus-colegiatura').val(estatus);
                }
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al cargar el pago'
                });
            }
        });
    }
    function generarDescuento(){
        if($('#tipo-descuento').children("option:selected").val() > 0){
            $('.loader').show();
            let descuento = {
                'nombre'            : $('#tipo-descuento').children("option:selected").html(),
                'prontoPago'        : 1, 
                'conceptoId'        : $('#tipo-descuento').children("option:selected").val(),
                'cantidadDescuento' : $('#tipo-descuento').children("option:selected").attr('precio'),
            }
            $.ajax({
                type: 'POST',
                url: '/ajax/newdescuento',
                dataType: 'json',
                data:
                {
                    '_token' : '{{ csrf_token() }}',
                    'descuento': descuento,
                    'alumno': {{$_GET['alumno']}}
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
                      text: 'Error al guardar el alumno'
                    });
                }
            });
        }
    }
    function editDatos(tipo){
        let actualizarColegiatura = false;
        
        if(tipo === 'academicos'){
            Swal.fire({
                title: `Actualizar colegiaturas`,
                html: `¿Desea regenerar las colegiaturas del actual periodo?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1f3047',
                cancelButtonColor: '#d92550',
                confirmButtonText: `Actualizar!`,
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    actualizarColegiatura = true;
                }
            });
        }

        $('.loader').show();
        let nombre          = $('#nombre').val();
        let apellidoPaterno = $('#apellido_paterno').val();
        let apellidoMaterno = $('#apellido_materno').val();
        let email           = $('#email').val();
        let telefono        = $('#telefono').val();
        let plantel         = $('#plantel').children("option:selected").val();
        let nivel           = $('#nivel').children("option:selected").val();
        let licenciatura    = $('#licenciatura').children("option:selected").val();
        let sistema         = $('#sistema').children("option:selected").val();
        let grupo           = $('#grupo').children("option:selected").val();
        let generacion      = $('#generacion').children("option:selected").val();
        let concepto        = $('#concepto').children("option:selected").val();
        let nombreTutor     = $('#nombre-tutor').val();
        let telefonoTutor   = $('#telefono-tutor').val();
        let fechaInicio     = $('#fecha-inicio').val();
        let conceptoTitulacion  = $('#concepto-titulacion').val();
        let conceptoInscripcion = $('#concepto-inscripcion').val();
        let conceptoCuota       = $('#concepto-cuota').val();
        let datos = {
            'id'              : @php echo($_GET['alumno']) @endphp,
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
            'generacion'           : generacion,
            'concepto'        : concepto,
            'nombreTutor'     : nombreTutor,
            'telefonoTutor'   : telefonoTutor,
            'fechaInicio'     : fechaInicio,
            'conceptoTitulacion' : conceptoTitulacion,
            'conceptoInscripcion': conceptoInscripcion,
            'conceptoCuota'      : conceptoCuota
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/updatedpalumno',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'datos': datos,
                'actualizarColegiatura' actualizarColegiatura
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
                  text: 'Error al guardar el alumno'
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
                    @php echo($alumno[0]->Nombre." ".$alumno[0]->Apellido_paterno." ".$alumno[0]->Apellido_materno); @endphp
                    </div>

                    @if (session()->get('user_roles')['Becas']->Crear == 'Y')
                    <div class="d-inline-block dropdown" style="right: 13px;position: absolute;">
                        <button id="descuento-alumno" type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary" data-toggle="modal" data-target="#new_descuento"> 
                            <i class="fas fa-plus"></i> Descuentos
                        </button>
                    </div>
                    @endif

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
                                    <div class="@if (session()->get('user_roles')['Alumnos']->Modificar == 'Y') edit-container @endif" id="datos-alumnos">
                                        <h5 class="card-title">Datos Personales Del Alumno</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-4 datos-personales">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" disabled="disabled" value="@php echo($alumno[0]->Nombre); @endphp">
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="nombre">Editar</button> @endif
                                            </div>
                                            <div class="form-group col-md-4 datos-personales">
                                                <label for="inputEmail4">Apellido Paterno</label>
                                                <input type="test" class="form-control" id="apellido_paterno" disabled="disabled" value="@php echo($alumno[0]->Apellido_paterno); @endphp">
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="apellido_paterno">Editar</button>@endif
                                            </div>
                                            <div class="form-group col-md-4 datos-personales">
                                                <label for="inputEmail4">Apellido Materno</label>
                                                <input type="test" class="form-control" id="apellido_materno" disabled="disabled" value="@php echo($alumno[0]->Apellido_materno); @endphp">
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="apellido_materno">Editar</button>@endif
                                            </div>
                                            <div class="form-group col-md-4 datos-personales">
                                                <label for="inputEmail4">Email</label>
                                                <input type="email" class="form-control" id="email" disabled="disabled" value="@php echo($alumno[0]->Email); @endphp">
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="email">Editar</button>@endif
                                            </div>
                                            <div class="form-group col-md-4 datos-personales">
                                                <label for="inputEmail4">Teléfono</label>
                                                <input type="tel" class="form-control" id="telefono"  disabled="disabled" value="@php echo($alumno[0]->Telefono); @endphp">
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="telefono">Editar</button>@endif
                                            </div>
                                        </div>
                                        
                                        <h5 class="card-title">Datos Del Tutor</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-4 datos-personales">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="text" class="form-control" id="nombre-tutor" disabled="disabled" value="@php echo($alumno[0]->Nombre_tutor); @endphp">
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="nombre-tutor">Editar</button>@endif
                                            </div>
                                            <div class="form-group col-md-4 datos-personales">
                                                <label for="telefonoTutor">Teléfono</label>
                                                <input type="text" class="form-control" id="telefono-tutor" disabled="disabled" value="@php echo($alumno[0]->Telefono_tutor); @endphp">
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="telefono-tutor">Editar</button>@endif
                                            </div>
                                        </div>
                                        
                                        <h5 class="card-title">Información Academica</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-3 datos-academicos">
                                                <label for="plantel">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel" disabled="disabled">
                                                    <option value="0" selected="selected" @if($informacion[0]->Plantel_id == 0) selected="selected"  @endif>Seleccionar plantel</option>
                                                    @foreach ($planteles as $plantel)
                                                        <option value="@php echo($plantel->Id); @endphp" @if($informacion[0]->Plantel_id == $plantel->Id) selected="selected"  @endif >@php echo($plantel->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="plantel">Editar</button>@endif
                                            </div>
                                            <div class="form-group col-md-3 datos-academicos">
                                                <label for="nivel">Nivel</label>
                                                <select class="form-control" source="niveles" name="nivel" id="nivel" disabled="disabled">
                                                    <option value="0" selected="selected" @if($informacion[0]->Nivel_id == 0) selected="selected"  @endif>Seleccionar nivel</option>
                                                    
                                                </select>
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="nivel">Editar</button>@endif
                                            </div>
                                            <div class="form-group col-md-3 datos-academicos" @if(count($licenciaturas) == 0) style="display:none;"  @endif>
                                                <label for="licenciaturas">Licenciaturas</label>
                                                <select class="form-control" source="licenciaturas" name="licenciatura" id="licenciatura" disabled="disabled">
                                                    <option value="0" selected="selected" @if($informacion[0]->Licenciatura_id == 0) selected="selected"  @endif>Seleccionar licenciatura</option>
                                                    
                                                </select>
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="licenciatura">Editar</button>@endif
                                            </div>
                                            <div class="form-group col-md-3 datos-academicos">
                                                <label for="sistema">Sistema</label>
                                                <select class="form-control" name="sistema" id="sistema" disabled="disabled">
                                                    <option value="0" selected="selected" @if($informacion[0]->Sistema_id == 0) selected="selected"  @endif>Seleccionar sistema</option>
                                                    @foreach ($sistemas as $sistema)
                                                        <option value="@php echo($sistema->Id); @endphp" @if($informacion[0]->Sistema_id == $sistema->Id) selected="selected"  @endif>@php echo($sistema->Nombre); @endphp </option>
                                                    @endforeach
                                                </select>
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="sistema">Editar</button>@endif
                                            </div>
                                            <div class="form-group col-md-3 datos-academicos">
                                                <label for="grupo">Grupo</label>
                                                <select class="form-control " source="grupos" name="grupo" id="grupo" disabled="disabled">
                                                    <option value="0" selected="selected" @if($informacion[0]->Grupo_id == 0) selected="selected"  @endif>Seleccionar grupo</option>
                                                    
                                                </select>
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="grupo">Editar</button>@endif
                                                
                                            </div>
                                            <div class="form-group col-md-3 datos-academicos">
                                                <label for="generacion">Generacion</label>
                                                <select class="form-control" source="generaciones" name="generacion" id="generacion" disabled="disabled">
                                                    <option value="0" selected="selected" @if($informacion[0]->Generacion_id == 0) selected="selected"  @endif>Seleccionar generacion</option>
                                                    
                                                </select>
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="generacion">Editar</button>@endif
                                            </div>
                                            
                                            
                                            <div class="form-group col-md-3 datos-academicos">
                                                <label for="fecha-inicio">Fecha inicio</label>
                                                <input type="month" class="form-control" id="fecha-inicio" value="@php echo($alumno[0]->Fecha_inicio); @endphp" disabled="disabled">
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="fecha-inicio">Editar</button>@endif
                                            </div>



                                            <div class="form-group col-md-3 datos-academicos">
                                                <label for="concepto">Colegiatura concepto</label>
                                                <select class="form-control" name="concepto" id="concepto" disabled="disabled">
                                                    <option value="0" selected="selected" @if($informacion[0]->Concepto_id == 0) selected="selected"  @endif>Seleccionar concepto</option>
                                                    
                                                </select>
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="concepto">Editar</button>@endif
                                            </div>
                                            <div class="form-group col-md-3 datos-academicos" @if(count($licenciaturas) == 0) style="display:none;"  @endif>
                                                <label for="fecha-inicio">Titulación concepto</label>
                                                <select class="form-control" name="concepto-titulacion" id="concepto-titulacion" disabled="disabled">
                                                    <option value="0" selected="selected" @if(@$informacion[0]->Concepto_titulacion_id == 0) selected="selected"  @endif>Seleccionar concepto titulación</option>
                                                    @foreach ($titulaciones as $titulacion)
                                                        <option value="@php echo($titulacion->Id); @endphp" @if(@$informacion[0]->Concepto_titulacion_id == $titulacion->Id) selected="selected"  @endif>{{$titulacion->Nombre}} </option>
                                                    @endforeach
                                                </select>
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="concepto-titulacion">Editar</button>@endif
                                            </div>


                                            <div class="form-group col-md-3 datos-academicos">
                                                <label for="fecha-inicio">Inscripción concepto</label>
                                                <select class="form-control" name="concepto-inscripcion" id="concepto-inscripcion" disabled="disabled">
                                                    <option value="0" selected="selected" @if(@$informacion[0]->Concepto_inscripcion_id == 0) selected="selected"  @endif>Seleccionar concepto inscripción</option>
                                                    
                                                </select>
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="concepto-inscripcion">Editar</button>@endif
                                            </div>


                                            <div class="form-group col-md-3 datos-academicos">
                                                <label for="fecha-inicio">Cuota anual</label>
                                                <select class="form-control" name="concepto-cuota" id="concepto-cuota" disabled="disabled">
                                                    <option value="0" selected="selected" @if(@$informacion[0]->Concepto_inscripcion_id == 0) selected="selected"  @endif>Seleccionar concepto inscripción</option>
                                                    
                                                </select>
                                                @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')<button class="edit-save-btn edit" input="concepto-cuota">Editar</button>@endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12" id="colegiaturas-t">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">
                            Colegiaturas
                            @if (session()->get('user_roles')['Alumnos']->Modificar == 'Y')
                            <br>
                            <button id="create-proximas-colegiaturas" type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary"> 
                                Crear colegiaturas próximo periodo
                            </button>
                            @endif
                            </h5>
                            <table id="colegiaturas" class="mb-0 table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Concepto</th>
                                            <th>Colegiatura</th>
                                            <th>Estatus Pago</th>
                                            <th>Cantidad Pago</th>
                                            <th>Pendiente pago</th>
                                            <th>Fecha Pago</th>
                                            @if (session()->get('user_roles')['Pagos']->Modificar == 'Y')
                                            <th>Acciones</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Pagos</h5>
                            <table id="pagos" class="mb-0 table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Concepto</th>
                                            <th>Cantidad Pago</th>
                                            <th>Tipo Pago</th>
                                            <th>Descripcion Pago</th>
                                            <th>Notas</th>
                                            <th>Fecha</th>
                                            @if (session()->get('user_roles')['role'] === 'Administrador')
                                            <th>Acciones</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title" id="titulaciones">Titulación</h5>
                            <table id="titulacion" class="mb-0 table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Concepto</th>
                                            <th>Cantidad Pago</th>
                                            <th>Tipo Pago</th>
                                            <th>Descripcion Pago</th>
                                            <th>Notas</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"><strong>Total Pagado</strong></td>
                                            <td colspan="1" id="paymentTotal"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><strong>Precio</strong></td>
                                            <td colspan="1" id="precioTitulacion">${{number_format($precioTitulacion[0]->precio,2)}}</td>
                                        </tr>  
                                        <tr>
                                            <td colspan="2"><strong>Adeudo</strong></td>
                                            <td colspan="1" id="balanceTotal"></td>
                                        </tr>                                                          
                                    </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Becas</h5>
                            <table id="beca-alumno" class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Periodo</th>
                                        <th>Cantidad Beca</th>
                                        <th>Estatus Beca</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                
                
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Meses Adeudo Baja</h5>
                            <table id="adeudoBaja" class="mb-0 table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Concepto</th>
                                            <th>Colegiatura</th>
                                            <th>Estatus Pago</th>
                                            <th>Fecha Pago</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>    
        </div>   
    </div>
</div>
@include('partials.footer')