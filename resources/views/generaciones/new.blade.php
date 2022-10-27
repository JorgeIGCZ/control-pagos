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
    "use strict";
    
    $(function() {
        $('#submit_generacion').on('click',function(){
            createGeneracion();
        });
        $('#periodo').change(function(e){
            displayPeriodoDetalles();
        });
    }); 
    
    function displayPeriodoDetalles(){
        const periodos          = $("#periodo").children("option:selected").attr('periodos');
        const fechaInicio       = new Date($("#fecha-inicio").val()+':00:00');
        const fechaFinalizacion = new Date($("#fecha-finalizacion").val()+':00:00');
        const yearsDiff         = fechaFinalizacion.getFullYear() - fechaInicio.getFullYear();
        $('#periodo-detalles div').remove();
        
        let periodoDetalle = '';
        let className      = '';
        let newDate        = fechaInicio;
        let formatedDate;
        let periodoNumber  = 0;
        for(let y = 1;y <= yearsDiff;y++){
            for(let i = 1;i <= periodos;i++){
                
                className       = 'periodo-'+periodoNumber;
                formatedDate    = newDate.getFullYear() + "-" + ((newDate.getMonth() + 1) < 10 ? "0"+(newDate.getMonth() + 1) : (newDate.getMonth() + 1)) + "-" + (newDate.getDate() < 10 ? "0"+newDate.getDate() : newDate.getDate());
                periodoDetalle +=   '<div class="form-group col-md-3">'+
                                    '   <label for="periodo">Fecha Incio Periodo '+(periodoNumber+1)+'-'+newDate.getFullYear()+'</label>'+   
                                    '   <input type="date" class="form-control fecha-inicio-'+className+'" value="'+formatedDate+'">'+
                                    '</div>';
                                    
                newDate.setMonth(newDate.getMonth() + (12 / periodos));
                
                formatedDate    = newDate.getFullYear() + "-" + ((newDate.getMonth() + 1) < 10 ? "0"+(newDate.getMonth() + 1) : (newDate.getMonth() + 1)) + "-" + (newDate.getDate() < 10 ? "0"+newDate.getDate() : newDate.getDate());
                periodoDetalle +=   '<div class="form-group col-md-3">'+
                                    '   <label for="periodo">Fecha Finalizacion Periodo '+(periodoNumber+1)+'-'+newDate.getFullYear()+'</label>'+
                                    '   <input type="date" class="form-control fecha-finalizacion-'+className+'"  value="'+formatedDate+'">'+
                                    '</div>';
                periodoNumber ++;                    
            }
        }
        $('#periodo-detalles').append(periodoDetalle);
    }
    function createGeneracion(){
        $('.loader').show();
        const nombre             = $('#nombre').val();
        const fechaInicio        = $("#fecha-inicio").val();
        const fechaFinalizacion  = $("#fecha-finalizacion").val();
        const periodoId          = $("#periodo").children("option:selected").val();
        const periodos           = $("#periodo").children("option:selected").attr('periodos');
        const plantel            = $("#plantel").children("option:selected").val();
        
        const fechaInicioD        = new Date($("#fecha-inicio").val()+':00:00');
        const fechaFinalizacionD  = new Date($("#fecha-finalizacion").val()+':00:00');
        const yearsDiff           = fechaFinalizacionD.getFullYear() - fechaInicioD.getFullYear();
        
        let generacionPeriodos        = [];
        
        const generacion = {
            'nombre'            : nombre,
            'periodo'           : periodoId,
            'fechaInicio'       : fechaInicio,
            'fechaFinalizacion' : fechaFinalizacion,
            'plantel'           : plantel
        };
        const iterator = periodos*yearsDiff;
        for(let i = 0;i < iterator;i++){
            let generacionPeriodoObj = {};
            generacionPeriodoObj.periodoNumero     = i;
            generacionPeriodoObj.fechaInicio       = $('.fecha-inicio-periodo-'+i).val();
            generacionPeriodoObj.fechaFinalizacion = $('.fecha-finalizacion-periodo-'+i).val();
            generacionPeriodos.push(generacionPeriodoObj);
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/newgeneracion',
            dataType: 'json',
            data:
            {
                '_token'       : '{{ csrf_token() }}',
                'generacion'        : generacion,
                'generacionPeriodos': generacionPeriodos
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
                      text: 'Error al guardar el sistema'
                    })
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al guardar el sistema'
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
                        <i class="pe-7s-gleam icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Nueva Generación
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
                                        <h5 class="card-title">Datos De La Generación</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="text" class="form-control" id="nombre">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="fecha-inicio">Fecha Inicio</label>
                                                <input type="date" class="form-control" id="fecha-inicio" placeholder="dd/mm/yyyy">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="fecha-finalizacion">Fecha Finalización</label>
                                                <input type="date" class="form-control" id="fecha-finalizacion" placeholder="dd/mm/yyyy">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="rol">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel">
                                                    <option value="0" selected="selected" >Seleccionar plantel</option>
                                                    @foreach ($planteles as $plantel)
                                                        <option value="{{$plantel->Id}}" >{{$plantel->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <h5 class="card-title">Datos Del Periodo</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="periodo">Periodo Anual</label>
                                                <select class="form-control" name="periodo" id="periodo">
                                                    <option value="0" selected="selected">Seleccionar periodo</option>
                                                    <option value="7" periodos="1" >Sistema anual (10 meses)</option>
                                                    <option value="6" periodos="6" >Sistema bimestral</option>
                                                    <option value="4" periodos="4" >Sistema trimestral</option>
                                                    <option value="3" periodos="3" >Sistema cuatrimestral</option>
                                                    <option value="2" periodos="2" >Sistema semestre</option>
                                                    <option value="1" periodos="1" >Sistema anual</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row" id="periodo-detalles">
                                        </div>
                                    </form>
                                    <button id="submit_generacion" class="btn btn-primary">Guardar</button>
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