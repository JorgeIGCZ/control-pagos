@include('partials.header')

<script type='text/javascript'>
    $(function() {
        
        $(document).on('click', '.edit-d', function(){
            let inputId      = $(this).attr('input');
            $(this).parent().append('<button class="edit-save-btn save-d" input="'+inputId+'">Guardar</button>');
            $(this).parent().find( ".edit-d" ).remove();
            editField(inputId);
        });
        $(document).on('click', '.save-d', function(){
            let inputId = $(this).attr('input');
            saveField(inputId);
            $(this).removeClass('save-d');
            $(this).addClass('edit-d');
            $(this).html('edit');
        });
    
    
    
        $('.datos-generacion').on('click', '.save', function(){
            editGeneracion();
        });
        $('.periodo-detalles').on('click', '.save-d', function(){
            editGeneracionPeriodo();
        });
        displayPeriodoDetalles();
    });
    
    function displayPeriodoDetalles(){
        const generacionPeriodos = <?php echo($generacionPeriodos); ?>;
        let periodoDetalle  = '';
        for(let i = 1;i <= generacionPeriodos.length;i++){
            className       = 'periodo-'+i;
            periodoDetalle +=   '<div class="form-group col-md-3 periodo-detalle">'+
                                '   <label for="periodo">Fecha Incio Periodo '+i+'</label>'+
                                '   <input type="date" disabled="disabled" class="form-control fecha-inicio-'+className+'" id="fecha-inicio-'+i+'" value="'+generacionPeriodos[i-1].Fecha_inicio+'">'+
                                '</div>'+
                                '<div class="form-group col-md-3 periodo-detalle">'+
                                '   <label for="periodo">Fecha Finalizacion Periodo '+i+'</label>'+
                                '   <input type="date"disabled="disabled"  class="form-control fecha-finalizacion-'+className+'" id="fecha-finalizacion-'+i+'" value="'+generacionPeriodos[i-1].Fecha_finalizacion+'">'+
                                '</div>';
        }
        $('.periodo-detalles').append(periodoDetalle);
        
    }
    
    function clearGeneracionForm(){
        $('#nombre').val('');
    }
    
    function editGeneracion(){
        $('.loader').show();
        let nombre            = $('#nombre').val();
        let plantel           = $('#plantel').children("option:selected").val();
        let fechaInicio       = $('#fecha-inicio').val();
        let fechaFinalizacion = $('#fecha-finalizacion').val();
        let generacion = {
            'id'               : @php echo($_GET['generacion']) @endphp,
            'nombre'           : nombre,
            'fechaInicio'      : fechaInicio,
            'fechaFinalizacion': fechaFinalizacion,
            'plantel'          : plantel
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/updategeneracion',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'generacion': generacion
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
                  text: 'Error al guardar el generacion'
                });
            }
        });
    }
    function editGeneracionPeriodo(){
        $('.loader').show();
        const generacionPeriodos  = <?php echo($generacionPeriodos); ?>;
        let newGeneracionPeriodos = [];
        
        for(let i = 1;i <= generacionPeriodos.length;i++){
            let generacionPeriodoObj = {};
            generacionPeriodoObj.periodoNumero     = i;
            generacionPeriodoObj.fechaInicio       = $('.fecha-inicio-periodo-'+i).val();
            generacionPeriodoObj.fechaFinalizacion = $('.fecha-finalizacion-periodo-'+i).val();
            newGeneracionPeriodos.push(generacionPeriodoObj);
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/updategeneracionperiodos',
            dataType: 'json',
            data:
            {
                '_token'       : '{{ csrf_token() }}',
                'generacionId'      : @php echo($_GET['generacion']) @endphp,
                'generacionPeriodos': newGeneracionPeriodos
            },
            success: function (result) {
                $('.loader').hide();
                if(result[0] == 'success'){
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
                }else{
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'Error al guardar el generacion'
                    })
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al guardar el generacion'
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
                        <i class="pe-7s-culture icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>
                        @php
                            echo($generacion[0]->Nombre);
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
                                    <div>
                                        <h5 class="card-title">Datos De La Generacion</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-3 datos-generacion edit-container">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="test" class="form-control" id="nombre" disabled="disabled" value="@php echo($generacion[0]->Nombre); @endphp">
                                                <button class="edit-save-btn edit" input="nombre">Editar</button>
                                            </div>
                                            <div class="form-group col-md-3 datos-generacion edit-container">
                                                <label for="plantel">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel" disabled="disabled">
                                                    <option value="0" selected="selected" @if($generacion[0]->Plantel_id == 0) selected="selected"  @endif>Seleccionar plantel</option>
                                                    @foreach ($planteles as $plantel)
                                                        <option value="@php echo($plantel->Id); @endphp" @if($generacion[0]->Plantel_id == $plantel->Id) selected="selected"  @endif >@php echo($plantel->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                                <button class="edit-save-btn edit" input="plantel">Editar</button>
                                            </div>
                                            <div class="form-group col-md-3 datos-generacion">
                                                <label for="fecha-inicio">Fecha Inicio</label>
                                                <input type="date" class="form-control" id="fecha-inicio" disabled="disabled" value="@php echo($generacion[0]->Fecha_inicio); @endphp">
                                            </div>
                                            <div class="form-group col-md-3 datos-generacion">
                                                <label for="fecha-finalizacion">Fecha Finalización</label>
                                                <input type="date" class="form-control" id="fecha-finalizacion" disabled="disabled" value="@php echo($generacion[0]->Fecha_finalizacion); @endphp">
                                            </div>
                                        </div>
                                        <h5 class="card-title">DATOS DEL PERIODO</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <!--strong>Sistema bimestral</strong-->
                                            </div>
                                        </div>
                                        <div class="form-row periodo-detalles">
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
</div>
@include('partials.footer')