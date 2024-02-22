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
        $('#submit_concepto').on('click',function(e){
            createConcepto();
        });    
        $('#nivel').change(function(e){
            let nivel = $(this).children("option:selected").html();
            displayLicenciaturas(nivel);
        });

        $('#tipo').change(function(e){
            let tipo = $(this).children("option:selected").val();
            const diasContainer = $('#dias-container');
            const dias = $('#dias');

            switch (tipo) {
                case 'pronto-pago-titulacion':
                case 'pronto-pago':
                    diasContainer.show();
                    diasContainer.find('label').html('Dias activo')
                    break;
            
                case 'recargo-pago':
                    diasContainer.show();
                    diasContainer.find('label').html('Dias sin recargo')
                    break;
            
                default:
                    diasContainer.hide();
                    dias.val(0);
                    break;
            }

        });
    }); 
    
    function displayLicenciaturas(nivel){
        if(nivel == 'Licenciatura'){
            $('.licenciaturas-select').show();
        }else{
            $('.licenciaturas-select').hide();
        }
    }
    
    function clearConceptoForm(){
        $('#nombre').val('');
        $('#precio').val(0);
        $('#precio').attr('value',0);
    }
    
    function createConcepto(){
        $('.loader').show();
        let nombre       = $('#nombre').val();
        let precio       = $('#precio').attr("value");
        let tipo         = $("#tipo").children("option:selected").val();
        let plantel      = $("#plantel").children("option:selected").val();
        let dias         = $("#dias").val();
        /*let nivel        = $("#nivel").children("option:selected").val();
        let licenciatura = $("#licenciatura").children("option:selected").val();
        let sistema      = $("#sistema").children("option:selected").val();
        let ciclo        = $("#ciclo").children("option:selected").val();*/
        
        let concepto = {
            'nombre'      : nombre,
            'precio'      : precio,
            'tipo'        : tipo,
            'plantel'     : plantel,
            'dias'        : dias/*,
            'nivel'       : nivel,
            'licenciatura': licenciatura,
            'sistema'     : sistema,
            'ciclo'       : ciclo*/
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/newconcepto',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'concepto': concepto
            },
            success: function (result) {
                $('.loader').hide();
                if(result[0] == 'success'){
                    clearConceptoForm();
                }
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
                  text: 'Error al guardar el concepto'
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
                    <div>Nuevo Concepto
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
                                        <h5 class="card-title">Datos Del Concepto</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="text" class="form-control" id="nombre">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Precio</label>
                                                <input type="text" class="form-control amount" id="precio">
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
                                            <div class="form-group col-md-3">
                                                <label for="tipo" class="">Tipo</label>
                                                <select name="tipo" id="tipo" class="form-control">
                                                    <option disabled value="">Conceptos pago</option>
                                                        <option value="colegiatura">Colegiatura</option>
                                                        <option value="inscripcion">Inscripción</option>
                                                        <option value="titulacion">Titulación</option>
                                                        <option value="cuota-personalizada-anual">Cuota personalizada anual</option>
                                                        <option value="pagos">Pagos</option>
                                                    <option disabled value="">Descuentos</option>
                                                        <option value="descuentos">Descuentos</option>
                                                        <option value="pronto-pago">Pronto pago (colegiatura, inscripción)</option>
                                                        <option value="pronto-pago-titulacion">Pronto pago (titulación)</option>
                                                        <option value="recargo-pago">Recargo pago tardío</option>
                                                    <option value="otro" disabled>Otro</option>
                                                    <option value="becas" disabled>Becas</option>
                                                </select>
                                            </div>

                                            <div id="dias-container" class="form-group col-md-3 hidden">
                                                <label for="dias">Dias activo</label>
                                                <input type="number" class="form-control" id="dias" min="1" max="31">
                                            </div>
                                        </div>
                                    </form>
                                    <button id="submit_concepto" class="btn btn-primary">Guardar</button>
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