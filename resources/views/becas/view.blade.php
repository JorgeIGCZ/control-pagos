<div class="modal fade" id="edit_beca_alumno" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
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
                            <div>Editar Beca Alumno
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
                                <h5 class="card-title nombre-alumno-pago" becaId ="@php echo($becas[0]->Id); @endphp">
                                    @php
                                        echo($becas[0]->Nombre);
                                    @endphp
                                </h5>
                                <input type="hidden" id="beca-alumno" >
                                <form class="">
                                    <div class="position-relative form-group">
                                        <table style="width:100%">
                                            <tr>
                                                <th style="width:35%">Colegiatura:</th>
                                                <td>
                                                    <input type="text" id="cantidad-pagar-be"value ="$0.00" class="no_style" disabled="disabled">
                                                </td>
                                            </tr>
                                            <tr class="descuento-container">
                                                <th style="width:35%">Cantidad Beca:</th>
                                                <td>
                                                    <input type="text" id="descuento-be"value ="$0.00" class="no_style" disabled="disabled">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width:35%">Total:</th>
                                                <td>
                                                    <input type="text" id="resta-be"value ="$0.00" class="no_style" disabled="disabled">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="position-relative form-group">
                                        <h5>
                                            <input type="text" id="concepto-nombre-be" disabled="disabled" style="width: 100%;border: none;color: #556078;background: white;">
                                        </h5>
                                    </div>
                                    
                                    <div class="position-relative form-group">
                                        <h6>
                                            <input type="hidden" id="alumno-id-be">
                                            <input type="text" id="alumno-nombre-be" disabled="disabled" style="width: 100%;border: none;color: #556078;background: white;">
                                        </h6>
                                    </div>
                                    
                                    <div class="position-relative form-group">
                                        <label for="periodo" class="">Periodo</label>
                                        <select name="select" id="periodo-be" class="form-control">
                                            <option value="0">Seleccionar periodo</option>
                                        </select>
                                    </div>
                                    
                                    
                                    <div class="position-relative form-group">
                                        <label for="cantidad-beca" class="">Cantidad de beca</label>
                                        <input name="cantidad-beca" id="cantidad-beca-be" type="text" class="form-control amount">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="notas" class="">Notas</label>
                                        <textarea name="text" id="notas-be" class="form-control"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="editar-beca-alumno">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new_beca_alumno" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div class="page-title-icon">
                                <i class="pe-7s-rocket icon-gradient bg-mean-fruit">
                                </i>
                            </div>
                            <div>Nueva Beca Alumno
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
                                <h5 class="card-title nombre-alumno-pago" becaId ="@php echo($becas[0]->Id); @endphp">
                                    @php
                                        echo($becas[0]->Nombre);
                                    @endphp
                                </h5>
                                <form class="">
                                    <div class="position-relative form-group">
                                        <table style="width:100%">
                                            <tr>
                                                <th style="width:35%">Colegiatura:</th>
                                                <td>
                                                    <input type="text" id="cantidad-pagar"value ="$0.00" class="no_style" disabled="disabled">
                                                </td>
                                            </tr>
                                            <tr class="descuento-container">
                                                <th style="width:35%">Cantidad Beca:</th>
                                                <td>
                                                    <input type="text" id="descuento"value ="$0.00" class="no_style" disabled="disabled">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width:35%">Total:</th>
                                                <td>
                                                    <input type="text" id="resta"value ="$0.00" class="no_style" disabled="disabled">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="alumnos" class="">Seleccionar Alumno</label>
                                        <form>
                                            <div id="nuevaBeca" class="form-row filters" style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr;">
                                                <div class="form-group  ">
                                                    <label for="plantel">Plantel</label>
                                                    <select class="form-control" name="plantel" id="plantel" @if(session()->get('user_roles')['Matrícula']->Plantel_id > 0) xdisabled="disabled" @endif>
                                                        <option value="0">Seleccionar plantel</option>
                                                        @foreach ($planteles as $plantel)
                                                            <option value="{{$plantel->Id}}">{{$plantel->Nombre}}</option>
                                                        @endforeach
                                                        <!--option value="{{$plantel->Id}}" @if(session()->get('user_roles')['Matrícula']->Plantel_id == $plantel->Id) selected="selected" @endif >{{$plantel->Nombre}}</option-->
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
                                                    <button id="buscarNuevaBecaAlumnos" type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary" style="margin-top: 33px;"> 
                                                        <i class="fas fa-search"></i> Buscar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <table id="alumnos" class="mb-0 table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Selección</th>
                                                    <th>Nombre</th>
                                                    <th>Correo</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    
                                    <div class="position-relative form-group">
                                        <h5>
                                            <input type="text" id="concepto-nombre" disabled="disabled" style="width: 100%;border: none;color: #556078;background: white;">
                                        </h5>
                                    </div>
                                    
                                    <div class="position-relative form-group">
                                        <h6>
                                            <input type="hidden" id="alumno-id">
                                            <input type="text" id="alumno-nombre" disabled="disabled" style="width: 100%;border: none;color: #556078;background: white;">
                                        </h6>
                                    </div>
                                    
                                    <div class="position-relative form-group">
                                        <label for="periodo" class="">Periodo</label>
                                        <select name="select" id="periodo" class="form-control">
                                            <option value="0">Seleccionar periodo</option>
                                        </select>
                                    </div>
                                    
                                    
                                    <div class="position-relative form-group">
                                        <label for="cantidad-beca" class="">Cantidad de beca</label>
                                        <input name="cantidad-beca" id="cantidad-beca" type="text" class="form-control amount">
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
                <button type="button" class="btn btn-primary" id="generar-beca">Generar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
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

        
        $('#buscarNuevaBecaAlumnos').click(function(e){
            $('#alumnos').DataTable().ajax.reload();
        });
        $('#buscar-alumnos').click(function(e){
            $('#beca-alumnos').DataTable().ajax.reload();
        });
        $('#beca-alumnos').DataTable( {
            ajax: {
                type: 'POST',
                url: '/ajax/getbecaalumnos',
                data:
                {
                    '_token': '{{ csrf_token() }}',
                    'becaId': @php echo($becas[0]->Id); @endphp,
                    'datos' : function() { 
                        return JSON.stringify(getAlumnoFilters())     
                    }
                }
            },
            language: {
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "lengthMenu":     "Mostrando _MENU_ alumnos",
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
                { data: 'Plantel' },
                { data: 'Nivel' },
                { data: 'Licenciatura' },
                { data: 'Periodo' },
                { defaultContent: 'Cantidad_beca', 'render': function ( data, type, row ) 
                    {
                        let view    = formatter.format(row.Cantidad_beca);
                        return  view;
                    } 
                },
                { defaultContent: 'Estatus', 'render': function ( data, type, row ) 
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
                },
                { defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        const estatusText = row.Estatus == 0 ? 'Activar' : 'Suspender';
                        const view        =  ''+
                            '<small>'+
                            @if (session()->get('user_roles')['Becas']->Modificar == 'Y')
                            '    <a href="#" class="edit-beca-alumno" type="button" data-toggle="modal" data-target="#edit_beca_alumno" becaalumnoid="'+row.BecaAlumnoId+'" alumno-id="'+row.Id+'">Editar</a> | '+
                            @endif
                            @if (session()->get('user_roles')['Becas']->Estatus == 'Y')
                            '    <a href="#" class="susp-beca-alumno" estatus="'+row.Estatus+'" becaalumnoid ="'+row.BecaAlumnoId+'">'+estatusText+'</a> | '+
                            @endif
                            @if (session()->get('user_roles')['Becas']->Eliminar == 'Y')
                            '    <a href="#" class="delete-beca-alumno" becaalumnoid ="'+row.BecaAlumnoId+'">Eliminar</a> '+
                            @endif
                            '</small>';
                        return  view;
                    } 
                }
            ]
        } );
        $('#beca-alumnos').on('click','.edit-beca-alumno', function(){
            const becaAlumnoId = $(this).attr('becaalumnoid');
            const alumnnoId    = $(this).attr('alumno-id');
            $('#beca-alumno').val(0);
            $('#beca-alumno').val(becaAlumnoId);
            clearBecaAlumnoBe();
            selectAlumnoBe(alumnnoId,becaAlumnoId);
        });
        
        
        $('#beca-alumnos').on('click','.susp-beca-alumno', function(){
            const becaAlumnoId = $(this).attr('becaalumnoid');
            const estatus      = $(this).attr('estatus');
            const estatusText  = estatus == 0 ? 'Activar' : 'Suspender';
            Swal.fire({
                title: `${estatusText} Beca`,
                text: `¿Está seguro de ${estatusText} la beca?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1f3047',
                cancelButtonColor: '#d92550',
                confirmButtonText: `${estatusText}!`,
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    suspBecaAlumno(becaAlumnoId,estatus);
                }
            });
        });
        $('#beca-alumnos').on('click','.delete-beca-alumno', function(){
            const becaAlumnoId = $(this).attr('becaalumnoid');
            Swal.fire({
                title: 'Remover Beca',
                text: "¿Está seguro de remover la beca?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1f3047',
                cancelButtonColor: '#d92550',
                confirmButtonText: 'Eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteBecaAlumno(becaAlumnoId);
                }
            });
        });
        
        $('#generar-beca').on('click', function(){
            const becaAlumno = {
                'becaId'       : @php echo($becas[0]->Id); @endphp,
                'alumnoId'     : $('#alumno-id').val(),
                'periodoId'    : $('#periodo').children("option:selected").val(),
                'generacionId' : $('#periodo').children("option:selected").attr('generacion'),
                'cantidadBeca' : $('#cantidad-beca').attr('value'),
                'notas'        : $('#notas').val()
            }
            generarBecaAlumno(becaAlumno);
        });

        $('#editar-beca-alumno').on('click', function(){
            const becaAlumno = {
                'id'           : $('#beca-alumno').val(),
                'periodoId'    : $('#periodo-be').children("option:selected").val(),
                'generacionId' : $('#periodo-be').children("option:selected").attr('generacion'),
                'cantidadBeca' : $('#cantidad-beca-be').attr('value'),
                'notas'        : $('#notas-be').val()
            }
            updateBecaAlumno(becaAlumno);
        });
        $('#beca-alumno').on('click', function(){
            clearBecaAlumno();
        });
        
        $('.beca').on('click', '.save', function(){
            editBeca();
        });
        $('#cantidad-beca').keyup(function() {
            setTimeout(calcularTotal,500);
            
            $('#descuento').attr("value",$(this).val());
            $('#descuento').val(formatter.format($(this).val()));
        });
        $('#cantidad-beca-be').keyup(function() {
            setTimeout(calcularTotal,500);
            
            $('#descuento-be').attr("value",$(this).val());
            $('#descuento-be').val(formatter.format($(this).val()));
        });
        $('#alumnos').on('click', '.alumno-id', function(){
            $('#periodo .options').remove();
            $('#concepto-nombre').val('');
            $('#alumno-id').val('');
            $('#alumno-nombre').val('');
            $('#cantidad-beca').val('');
            
            if ($(this).is(":checked")) {
                $( "#alumnos .alumno-id" ).each(function( index ) {
                    $(this).prop( "checked", false );
                });
                $(this).prop( "checked", true );
                selectAlumno($(this).attr('alumnoId'));
            }else{
                
            }
        });
        $('#alumnos').DataTable( {
            ajax: {
                url: '/ajax/getalumnos',
                method: 'POST',
                data:{
                    '_token': '{{ csrf_token() }}',
                    'datos' : function() { 
                        return JSON.stringify(getNuevaBecaAlumnoFilters())     
                    }
                }
            },
            language: {
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "lengthMenu":     "Mostrando _MENU_ alumnos",
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
                { defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let view    = `<input type="checkbox" alumnoId="${row.Id}" class="alumno-id" style="width: 28px;height: 20px;">`;
                        return  view;
                    } 
                },
                { data: 'Nombre' },
                { data: 'Email' }
            ]
        } );
        
    });
    function getBecaAlumno(becaAlumnoId){
        
    }
    function clearBecaAlumno(){
        $('#periodo .options').remove();
        $('#concepto-nombre').val('');
        $('#alumno-id').val('');
        $('#alumno-nombre').val('');
        $('#cantidad-beca').val('');
        $('#cantidad-pagar').val('$0.00');
        $('#descuento').val('$0.00');
        $('#resta').val('$0.00');
        $('#notas').val('');
        $( "#alumnos .alumno-id" ).each(function( index ) {
            $(this).prop( "checked", false );
        });
        $('#periodo .options').remove();
    }
    function clearBecaAlumnoBe(){
        $('#periodo .options-be').remove();
        $('#concepto-nombre-be').val('');
        $('#alumno-id-be').val('');
        $('#notas-be').val('');
        $('#alumno-nombre-be').val('');
        $('#cantidad-beca-be').val('');
        $('#cantidad-pagar-be').val('$0.00');
        $('#descuento-be').val('$0.00');
        $('#resta-be').val('$0.00');
        $('#periodo-be .options').remove();
    }
    function selectAlumno(alumnnoId){
        $.ajax({
            type: 'POST',
            url: '/ajax/getalumnoall',
            dataType: 'json',
            data:
            {
                '_token': '{{ csrf_token() }}',
                'alumno': {'id':alumnnoId}
            },
            success: function (result) {
                $('.loader').hide();
                let periodos = "";
                for (periodo of result.periodos) {
                    periodos += `<option class="options" value="${periodo.Id}" generacion="${periodo.Generacion_id}">${periodo.fecha}</option>`;
                }
                $('#periodo').prepend(periodos);
                $("#concepto-nombre").val(result.concepto[0].Nombre);
                
                $('#alumno-id').val(result.alumno[0].Id);
                $('#alumno-nombre').val(result.alumno[0].Nombre+' '+result.alumno[0].Apellido_paterno+' '+result.alumno[0].Apellido_materno);
                
                displayPrecio(result.concepto[0].Precio);
                calcularTotal();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al cargar el alumno'
                });
            }
        });
    }
    function selectAlumnoBe(alumnnoId,becaAlumnoId){
        $.ajax({
            type: 'POST',
            url: '/ajax/getalumnoallbe',
            dataType: 'json',
            data:
            {
                '_token': '{{ csrf_token() }}',
                'alumno': {'id':alumnnoId},
                'becaAlumnoId':{'id':becaAlumnoId}
            },
            success: function (result) {
                $('.loader').hide();
                let periodos = '';
                let periodoSelect = '';
                for (periodo of result.periodos) {
                    if(periodo.Id == result.becaAlumno[0].Periodo_id){
                        periodoSelect = 'selected="selected" ';
                    }else{
                        periodoSelect = '';
                    }
                    periodos += `<option class="options" value="${periodo.Id}" generacion="${periodo.Generacion_id}" ${periodoSelect}>${periodo.fecha}</option>`;
                }
                $('#periodo-be').prepend(periodos);
                $("#concepto-nombre-be").val(result.concepto[0].Nombre);
                $('#alumno-id-be').val(result.alumno[0].Id);
                $('#alumno-nombre-be').val(result.alumno[0].Nombre+' '+result.alumno[0].Apellido_paterno+' '+result.alumno[0].Apellido_materno);
                $('#notas-be').val(result.becaAlumno[0].Notas);
                $('#cantidad-beca-be').attr("value",result.becaAlumno[0].Cantidad_beca);
                $('#cantidad-beca-be').val(formatter.format(result.becaAlumno[0].Cantidad_beca));
                $('#descuento-be').attr("value",result.becaAlumno[0].Cantidad_beca);
                $('#descuento-be').val(formatter.format(result.becaAlumno[0].Cantidad_beca));
                displayPrecioBe(result.concepto[0].Precio);
                calcularTotalBe();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al cargar el alumno'
                });
            }
        });
    }
    
    function suspBecaAlumno(becaAlumnoId,estatus){
        $.ajax({
            type: 'POST',
            url: '/ajax/suspbecaalumno',
            dataType: 'json',
            data:
            {
                '_token': '{{ csrf_token() }}',
                'becaAlumno':{'id':becaAlumnoId,'estatus':estatus}
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
                  text: 'Error al suspender la beca'
                });
            }
        });
    }
    function deleteBecaAlumno(becaAlumnoId){
        $.ajax({
            type: 'POST',
            url: '/ajax/deletebecaalumno',
            dataType: 'json',
            data:
            {
                '_token': '{{ csrf_token() }}',
                'becaAlumnoId':{'id':becaAlumnoId}
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
                  text: 'Error al remover la beca'
                });
            }
        });
    }
    
    function calcularTotal(){
        let totalConcepto = $('#cantidad-pagar').attr('value');
        let descuento     = 0;
        let total         = 0;
        
        descuento         = $('#cantidad-beca').attr('value');
        
        total = parseFloat(totalConcepto) - parseFloat(descuento);
        
        if(total < 0){
            if(descuento > totalConcepto){
                $('#cantidad-beca').attr('value',0);
                $('#cantidad-beca').val(0);
                $('#descuento').attr("value",0);
                $('#descuento').val(formatter.format(0));
            }
        }
        
        total = parseFloat(total).toFixed(2);
        $('#resta').attr("value",total);
        $('#resta').val(formatter.format(total));
    }
    function calcularTotalBe(){
        let totalConcepto = $('#cantidad-pagar-be').attr('value');
        let descuento     = 0;
        let total         = 0;
        
        descuento         = $('#cantidad-beca-be').attr('value');
        
        total = parseFloat(totalConcepto) - parseFloat(descuento);
        
        if(total < 0){
            if(descuento > totalConcepto){
                $('#cantidad-beca-be').attr('value',0);
                $('#cantidad-beca-be').val(0);
                $('#descuento-be').attr("value",0);
                $('#descuento-be').val(formatter.format(0));
            }
        }
        
        total = parseFloat(total).toFixed(2);
        $('#resta-be').attr("value",total);
        $('#resta-be').val(formatter.format(total));
    }
    function displayPrecio(precio){
        $('#cantidad-pagar').val(formatter.format(precio));
        $('#cantidad-pagar').attr('value',precio);
    }
    function displayPrecioBe(precio){
        $('#cantidad-pagar-be').val(formatter.format(precio));
        $('#cantidad-pagar-be').attr('value',precio);
    }
    function editBeca(){
        $('.loader').show();
        let nombre = $('#nombre').val();
        let estatus= $("#estatus").children("option:selected").val();
        
        let beca = {
            'id'    : @php echo($_GET['beca']) @endphp,
            'nombre': nombre,
            'estatus': estatus
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/updatebeca',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'beca'   : beca
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
                  text: 'Error al guardar la beca'
                });
            }
        });
    }
    function updateBecaAlumno(becaAlumno){
        $.ajax({
            type: 'POST',
            url: '/ajax/updatebecaalumno',
            dataType: 'json',
            data:
            {
                '_token': '{{ csrf_token() }}',
                'becaAlumno' : becaAlumno
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
    function generarBecaAlumno(becaAlumno){
        $.ajax({
            type: 'POST',
            url: '/ajax/newbecaalumno',
            dataType: 'json',
            data:
            {
                '_token': '{{ csrf_token() }}',
                'datos' : becaAlumno
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
    function getAlumnoFilters(){
        alumno = {
            'plantel'      : $('#becaAlumnos #plantel').children("option:selected").val(),
            'nivel'        : $('#becaAlumnos #nivel').children("option:selected").val(),
            'licenciatura' : $('#becaAlumnos #licenciatura').children("option:selected").val(),
            'sistema'      : $('#becaAlumnos #sistema').children("option:selected").val(),
            'grupo'        : $('#becaAlumnos #grupo').children("option:selected").val()
        }
        return alumno;
    }
    function getNuevaBecaAlumnoFilters(){
        alumno = {
            'plantel'      : $('#nuevaBeca #plantel').children("option:selected").val(),
            'nivel'        : $('#nuevaBeca #nivel').children("option:selected").val(),
            'licenciatura' : $('#nuevaBeca #licenciatura').children("option:selected").val(),
            'sistema'      : $('#nuevaBeca #sistema').children("option:selected").val(),
            'grupo'        : $('#nuevaBeca #grupo').children("option:selected").val()
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
                        <i class="pe-7s-rocket icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>
                        @php
                            echo($becas[0]->Nombre);
                        @endphp
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
                                    <div class="@if (session()->get('user_roles')['Becas']->Modificar == 'Y') edit-container @endif">
                                        <h5 class="card-title">Datos De La Beca</h5>
                                        <div class="form-row">
                                            <div class="form-group beca col-md-3">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="test" class="form-control" id="nombre" disabled="disabled" value="@php echo($becas[0]->Nombre); @endphp">
                                                @if (session()->get('user_roles')['Becas']->Modificar == 'Y')<button class="edit-save-btn edit" input="nombre">Editar</button>@endif
                                            </div>
                                            <div class="form-group beca col-md-3">
                                                <label for="estatus" class="">Estatus</label>
                                                <select name="estatus" id="estatus" class="form-control" disabled="disabled">
                                                    <option value="0" @if($becas[0]->Estatus == 0) selected="selected" @endif>Inactivo</option>
                                                    <option value="1" @if($becas[0]->Estatus == 1) selected="selected" @endif>Activo</option>
                                                </select>
                                                @if (session()->get('user_roles')['Becas']->Modificar == 'Y')<button class="edit-save-btn edit" input="estatus">Editar</button>@endif
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
        
        
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-12 card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-5">
                                    <h5 class="card-title" style="margin-button:20px;">Beca Alumnos
                                        @if (session()->get('user_roles')['Becas']->Crear == 'Y')
                                        <div class="d-inline-block dropdown" style="right: 13px;position: absolute;">
                                            <button id="beca-alumno" type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary" data-toggle="modal" data-target="#new_beca_alumno" becaId="@php echo($_GET['beca']) @endphp"> 
                                                <i class="fas fa-plus"></i> Nueva Beca Alumno
                                            </button>
                                        </div>
                                        @endif
                                    </h5>
                                </div>
                            </div>
                            <table id="beca-alumnos" class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Plantel</th>
                                        <th>Nivel</th>
                                        <th>Licenciatura</th>
                                        <th>Periodo</th>
                                        <th>Cantidad Beca</th>
                                        <th>Estatus Beca</th>
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