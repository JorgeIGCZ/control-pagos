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
                            <div class="card-body"><h5 class="card-title nombre-colegiatura" ordenId =""></h5>
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
@include('partials.header')
<style type="text/css" media="screen">
    #pagoscontrol .btn {
        width: 67px;
        font-size: 11px;
    }  
    .datepicker table{
        width: 100%;
    }
    .dt-buttons{
        height: 60px;
    }
    #buscar-alumnos{
        cursor: pointer;
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
            $('#pagoscontrol').DataTable().ajax.reload();
            getReporteRecaudacion({'tipo':'current_month','month':'','fecha_inicio':'','fecha_final':''});
        });
        $('.input-daterange').datepicker({
            language: 'es'
        });
        $('#rango_corte_caja').change(function(e){
            const range    = $(this).children("option:selected").val();

            if(range == 'current_month'){
                $('.monthly').hide();
                $('.date_range').hide();
            }else if(range == 'monthly'){
                $('.monthly').show();
                $('.date_range').hide();
            }else if(range == 'date_range'){
                $('.date_range').show();
                $('.monthly').hide();
            }

            $('.search_range').show();
        });
        function getFileName(){
            let fileName = 'ControlPagos';
            fileName += ($('#plantel').children("option:selected").val() !== "0") ? $('#plantel').children("option:selected").html() : ' ' ;
            fileName += ($('#nivel').children("option:selected").val() !== "0") ? $('#nivel').children("option:selected").html() : '' ;
            fileName += ($('#licenciatura').children("option:selected").val() !== "0") ? $('#licenciatura').children("option:selected").html() : '' ;
            fileName += ($('#sistema').children("option:selected").val() !== "0") ? $('#sistema').children("option:selected").html() : '' ;

            return fileName;
        }

        let table = $('#pagoscontrol').DataTable({
            dom: 'lBfrtip',
            pageLength: 50,
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
                    $('row c[r^="F"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',5).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
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
                    $('row c[r^="G"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',6).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
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
                    $('row c[r^="H"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',7).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
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
                    $('row c[r^="I"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',8).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
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
                    $('row c[r^="J"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',9).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
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
                    $('row c[r^="K"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',10).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
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
                    $('row c[r^="L"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',11).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
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
                    $('row c[r^="M"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',12).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
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
                    $('row c[r^="N"]', sheet).each( function () {
                        if (skippedHeader) {
                            var className = $(table.cell(':eq('+count+')',13).node())[0].childNodes[0].className;//$(table.cell(':eq('+count+')',2).node()).css('background-color');
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
                }
                
                   /*function () {
                        let plantel      = ($('#plantel').children("option:selected").val()      != 0) ? $('#plantel').children("option:selected").html() : '';
                        let nivel        = ($('#nivel').children("option:selected").val()        != 0) ? $('#nivel').children("option:selected").html() : '';
                        let licenciatura = ($('#licenciatura').children("option:selected").val() != 0) ? $('#licenciatura').children("option:selected").html() : '';
                        let sistema      = ($('#sistema').children("option:selected").val()      != 0) ? $('#sistema').children("option:selected").html() : '';
                        let grupo        = ($('#grupo').children("option:selected").val()        != 0) ? $('#grupo').children("option:selected").html() : '';
                        let title        = `${plantel} ${nivel} ${licenciatura} ${sistema} ${grupo}`;
                        return title;
                }*/
            }],
            ajax: {
                type: 'POST',
                url: '/ajax/getallpagoscontrol',
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
                "info": "Mostrando pagina _PAGE_ de _PAGES_ total _TOTAL_ alumnos",
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
                { data: 'provId', },
                { data: 'Nombre',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let nombre = `<a href='/alumnos/view?alumno=${row.Alumno_id}#colegiaturas-t' target="_blank" >${row.Nombre}</a> `
                        return  nombre;
                    } 
                },
                { data: 'Enero',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase   = "";
                        let pago  = (row.CantidadPagoEnero == null ? 0 : row.CantidadPagoEnero);
                        switch (row.Enero){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase    = 'btn-secondary';
                                break;
                            case 2:
                                clase    = 'btn-success';
                                break;
                            case 3:
                                clase    = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                },
                { data: 'Febrero',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase   = "";
                        let pago  = (row.CantidadPagoFebrero == null ? 0 : row.CantidadPagoFebrero);
                        switch (row.Febrero){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase    = 'btn-secondary';
                                break;
                            case 2:
                                clase    = 'btn-success';
                                break;
                            case 3:
                                clase    = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                },
                { data: 'Marzo',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase   = "";
                        let pago  = (row.CantidadPagoMarzo == null ? 0 : row.CantidadPagoMarzo);
                        switch (row.Marzo){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase    = 'btn-secondary';
                                break;
                            case 2:
                                clase    = 'btn-success';
                                break;
                            case 3:
                                clase    = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                },
                { data: 'Abril',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase   = "";
                        let pago  = (row.CantidadPagoAbril == null ? 0 : row.CantidadPagoAbril);
                        switch (row.Abril){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase    = 'btn-secondary';
                                break;
                            case 2:
                                clase    = 'btn-success';
                                break;
                            case 3:
                                clase    = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                },
                { data: 'Mayo',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase   = "";
                        let pago  = (row.CantidadPagoMayo == null ? 0 : row.CantidadPagoMayo);
                        switch (row.Mayo){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase    = 'btn-secondary';
                                break;
                            case 2:
                                clase    = 'btn-success';
                                break;
                            case 3:
                                clase    = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                },
                { data: 'Junio',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase   = "";
                        let pago  = (row.CantidadPagoJunio == null ? 0 : row.CantidadPagoJunio);
                        switch (row.Junio){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase    = 'btn-secondary';
                                break;
                            case 2:
                                clase    = 'btn-success';
                                break;
                            case 3:
                                clase    = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                },
                { data: 'Julio',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase   = "";
                        let pago  = (row.CantidadPagoJulio == null ? 0 : row.CantidadPagoJulio);
                        switch (row.Julio){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase    = 'btn-secondary';
                                break;
                            case 2:
                                clase    = 'btn-success';
                                break;
                            case 3:
                                clase    = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                },
                { data: 'Agosto',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase = "";
                        let pago  = (row.CantidadPagoAgosto == null ? 0 : row.CantidadPagoAgosto);
                        switch (row.Agosto){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase = 'btn-secondary';
                                break;
                            case 2:
                                clase = 'btn-success';
                                break;
                            case 3:
                                clase = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                },
                { data: 'Septimebre',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase   = "";
                        let pago  = (row.CantidadPagoSeptiembre == null ? 0 : row.CantidadPagoSeptiembre);
                        switch (row.Septimebre){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase    = 'btn-secondary';
                                break;
                            case 2:
                                clase    = 'btn-success';
                                break;
                            case 3:
                                clase    = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                },
                { data: 'Octubre',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase   = "";
                        let pago  = (row.CantidadPagoOctubre == null ? 0 : row.CantidadPagoOctubre);
                        switch (row.Octubre){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase    = 'btn-secondary';
                                break;
                            case 2:
                                clase    = 'btn-success';
                                break;
                            case 3:
                                clase    = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                },
                { data: 'Novienbre',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase   = "";
                        let pago  = (row.CantidadPagoNoviembre == null ? 0 : row.CantidadPagoNoviembre);
                        switch (row.Novienbre){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase    = 'btn-secondary';
                                break;
                            case 2:
                                clase    = 'btn-success';
                                break;
                            case 3:
                                clase    = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                },
                { data: 'Diciembre',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let clase   = "";
                        let pago  = (row.CantidadPagoDiciembre == null ? 0 : row.CantidadPagoDiciembre);
                        switch (row.Diciembre){
                            case 0:
                                clase = 'hidden';
                                break;
                            case 1:
                                clase    = 'btn-secondary';
                                break;
                            case 2:
                                clase    = 'btn-success';
                                break;
                            case 3:
                                clase    = 'btn-warning';
                                break;
                        }
                        return  `<span class="mb-2 mr-2 btn-hover-shine btn ${clase} ">${formatter.format(pago)}</span>`;
                    }  
                }
                /*
                { data: 'Cantidad_pago',defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        return  formatter.format(row.Cantidad_pago);
                    } 
                },
                { data: 'updated_at' },
                { data: 'Notas' }
                */
            ]
        });
        getReporteRecaudacion({'tipo':'current_month','month':'','fecha_inicio':'','fecha_final':''});
    });

    function getAlumnoFilters(){
        alumno = {
            'plantel'      : <?php echo(@$_GET['Id']); ?>,
            'nivel'        : $('#nivel').children("option:selected").val(),
            'licenciatura' : $('#licenciatura').children("option:selected").val(),
            'sistema'      : $('#sistema').children("option:selected").val(),
            'grupo'        : $('#grupo').children("option:selected").val(),
            'fecha'        : $('#grupo').children("option:selected").val(),
            'mes'          : $('#mes').val(),
            'generacionEscolar' : $('#ciclo-escolar').val()
        }
        return alumno;
    }

    function getReporteRecaudacion(datos){
        $.ajax({
            type: 'POST',
            url: '/ajax/getpagosreportes',
            dataType: 'json',
            data:
            {
                '_token': '{{ csrf_token() }}',
                'datos': datos.tipo,
                'datosBusqueda' : function() { 
                        return JSON.stringify(getAlumnoFilters())     
                    }
            },
            success: function (result) {
                $('.loader').hide();
                let recaudacionEfectivo   = (result.recaudacionEfectivo == undefined ? 0 : result.recaudacionEfectivo);
                let recaudacionBancaria   = (result.recaudacionBancaria   == undefined ? 0 : result.recaudacionBancaria);
                let recaudacionTotal      = (result.recaudacionTotal      == undefined ? 0 : result.recaudacionTotal);
                let recaudacionBecas      = (result.recaudacionBecas      == undefined ? 0 : result.recaudacionBecas);
                let recaudacionDescuentos = (result.recaudacionDescuentos == undefined ? 0 : result.recaudacionDescuentos);
                let total                 = (result.total                 == undefined ? 0 : result.total);
                
                $('#recaudacion_bancaria').html(formatter.format(recaudacionBancaria));
                $('#recaudacion_efectivo').html(formatter.format(recaudacionEfectivo));
                $('#recaudacion_total').html(formatter.format(recaudacionTotal));
                $('#recaudacion_becas').html(formatter.format(recaudacionBecas));
                $('#recaudacion_descuentos').html(formatter.format(recaudacionDescuentos));
                $('#total').html(formatter.format(total));
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al cargar reporte'
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
                        <i class="pe-7s-cash icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Control De Pagos - Colegiaturas ({{$plantel}})
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
                                <div class="col-md-3">
                                    <form>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="mes">Ciclo Escolar</label>
                                                <select class="form-control" name="ciclo-escolar" id="ciclo-escolar" >
                                                    @foreach ($ciclosEscolares as $cicloEscolar)
                                                        <option value="{{$cicloEscolar->year}}" @if(date("Y") == $cicloEscolar->year) selected="selected" @endif>{{$cicloEscolar->year}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <form>
                                    <div class="form-row filters" style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr 90px;">
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

                            <div class="col-md-12">
                                <table id="pagoscontrol" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Alumno</th>
                                            <th>E</th>
                                            <th>F</th>
                                            <th>M</th>
                                            <th>A</th>
                                            <th>M</th>
                                            <th>J</th>
                                            <th>J</th>
                                            <th>A</th>
                                            <th>S</th>
                                            <th>O</th>
                                            <th>N</th>
                                            <th>D</th>
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
        <div class="divider mt-0" style="margin-bottom: 30px;"></div>
        <div class="row" style="display: none;">
            <div class="col-md-7">
                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header-tab-animation card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                            Reporte de Recaudación
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="col-lg-12 m-b-30">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control" id="rango_corte_caja" name="actionType">
                                        <option value="current_month">Mes Actual</option>
                                        <option value="monthly">Mes</option>
                                        @if(session()->get('user_roles')['role'] == 'Administrador')
                                        <option value="date_range">Rango de fechas</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-6 monthly" style="display:none;">
                                    <input type="month" class="form-control" min="{{date('Y')}}-01" max="{{date('Y')}}-12" id="mes">
                                </div>

                                @if(session()->get('user_roles')['role'] == 'Administrador')
                                <div class="col-sm-6 date_range" style="display:none;">
                                    <div class="input-group input-daterange">
                                        <input id="start_date" name="start_date" type="text" class="form-control" readonly="readonly" placeholder="mm/dd/yyyy"> 
                                        
                                        <span class="input-group-addon" style="padding: 8px;">Al</span> 
                                        <input id="end_date" name="end_date" type="text" class="form-control" readonly="readonly" placeholder="mm/dd/yyyy">
                                        
                                    </div>
                                </div>
                                @endif

                                <div class="col-sm-2 search_range" style="display:none;">
                                    <button type="button" id="search_range" class="form-control btn btn-default btn-primary waves-effect float-left-button" data-toggle="modal" data-target="#addContactModal">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div style="margin-bottom: 30px;"></div>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Recaudación de pagos</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div id="recaudacion_total" class="widget-numbers text-primary">$0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Cantidad en becas otorgadas</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div id="recaudacion_becas" class="widget-numbers text-success">$0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Cantidad en descuentos otorgados</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div id="recaudacion_descuentos" class="widget-numbers text-success">$0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Total</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div id="total" class="widget-numbers text-success">$0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header-tab-animation card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                            Reporte de Recaudación
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Recaudación bancaria</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div id="recaudacion_bancaria" class="widget-numbers text-success">$0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Recaudación en Efectivo</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div id="recaudacion_efectivo" class="widget-numbers text-success">$0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.footer')