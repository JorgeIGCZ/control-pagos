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
        $('.concepto').on('click', '.save', function(){
            editConcepto();
        });
        $('.relaciones').on('click', '.save', function(){
            editRelaciones();
        });

        validateTipo($("#tipo").children("option:selected").val())

        $('#tipo').change(function(e){
            validateTipo($(this).children("option:selected").val());
        })
    }); 

    

    function validateTipo(tipo){
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
    }
    
    function editConcepto(){
        $('.loader').show();
        let nombre = $('#nombre').val();
        let precio = $('#precio').attr("value");
        let tipo   = $("#tipo").children("option:selected").val();
        let estatus= $("#estatus").children("option:selected").val();
        let plantel= $("#plantel").children("option:selected").val();
        let dias   = $("#dias").val();
        
        let concepto = {
            'id'    : @php echo($_GET['concepto']) @endphp,
            'nombre': nombre,
            'precio': precio,
            'tipo'  : tipo,
            'estatus': estatus,
            'plantel':plantel,
            'dias'   :dias
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/updateconcepto',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'concepto': concepto
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
                  text: 'Error al guardar el concepto'
                });
            }
        });
    }
    /*
    function editRelaciones(){
        $('.loader').show();
        
        let plantel      = $("#plantel").children("option:selected").val();
        let nivel        = $("#nivel").children("option:selected").val();
        let licenciatura = $("#licenciatura").children("option:selected").val();
        let sistema      = $("#sistema").children("option:selected").val();
        let ciclo        = $("#ciclo").children("option:selected").val();
        let relaciones = {
            'concepto_id' : @php echo($_GET['concepto']) @endphp,
            'plantel'     : plantel,
            'nivel'       : nivel,
            'licenciatura': licenciatura,
            'sistema'     : sistema,
            'ciclo'       : ciclo
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/updateconceptorelaciones',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'relaciones': relaciones
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
                  text: 'Error al guardar el concepto'
                });
            }
        });
    }*/
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
                            echo($conceptos[0]->Nombre);
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
                                    <div class="edit-container">
                                        <h5 class="card-title">Datos Del Concepto</h5>
                                        <div class="form-row">
                                            <div class="form-group concepto col-md-3">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="test" class="form-control" id="nombre" disabled="disabled" value="@php echo($conceptos[0]->Nombre); @endphp">
                                                <button class="edit-save-btn edit" input="nombre">Editar</button>
                                            </div>
                                            <div class="form-group concepto col-md-3">
                                                <label for="rol">plantel</label>
                                                <select class="form-control" name="plantel" id="plantel" disabled="disabled">
                                                    <option value="0" >Seleccionar plantel</option>
                                                    @foreach ($planteles as $plantel)
                                                        <option value="{{$plantel->Id}}" @if($conceptos[0]->Plantel_id == $plantel->Id) selected="selected" @endif >{{$plantel->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                                <button class="edit-save-btn edit" input="plantel">Editar</button>
                                            </div>
                                            <div class="form-group concepto col-md-3">
                                                <label for="inputEmail4">Precio</label>
                                                <input type="test" class="form-control amount" id="precio" disabled="disabled" value="@php echo($conceptos[0]->Precio); @endphp">
                                                <button class="edit-save-btn edit" input="precio">Editar</button>
                                            </div>
                                            <div class="form-group concepto col-md-3">
                                                <label for="tipo" class="">Tipo</label>
                                                <select name="tipo" id="tipo" class="form-control" disabled="disabled">
                                                    <option disabled value="">Conceptos pago</option>
                                                        <option value="colegiatura" @if($conceptos[0]->Tipo == 'colegiatura') selected="selected" @endif>Colegiatura</option>
                                                        <option value="inscripcion" @if($conceptos[0]->Tipo == 'inscripcion') selected="selected" @endif>Inscripción</option>
                                                        <option value="titulacion" @if($conceptos[0]->Tipo == 'titulacion') selected="selected" @endif>Titulación</option>
                                                        <option value="cuota-personalizada-anual" @if($conceptos[0]->Tipo == 'cuota-personalizada-anual') selected="selected" @endif>Cuota personalizada anual</option>
                                                        <option value="pagos" @if($conceptos[0]->Tipo == 'pagos') selected="selected" @endif>Pagos</option>
                                                    <option disabled value="">Descuentos</option>
                                                    <option value="descuentos" @if($conceptos[0]->Tipo == 'descuentos') selected="selected" @endif>Descuentos</option>
                                                    <option value="pronto-pago" @if($conceptos[0]->Tipo == 'pronto-pago') selected="selected" @endif>Pronto pago (colegiatura, inscripción)</option>
                                                    <option value="pronto-pago-titulacion" @if($conceptos[0]->Tipo == 'pronto-pago-titulacion') selected="selected" @endif>Pronto pago (titulación)</option>
                                                    <option value="recargo-pago" @if($conceptos[0]->Tipo == 'recargo-pago') selected="selected" @endif>Recargo pago tardío</option>
                                                        <option value="otro" @if($conceptos[0]->Tipo == 'otro') selected="selected" @endif>Otro</option>
                                                        <option value="becas" @if($conceptos[0]->Tipo == 'becas') selected="selected" @endif>Becas</option>
                                                </select>
                                                <button class="edit-save-btn edit" input="tipo">Editar</button>
                                            </div>


                                            <div id="dias-container" class="form-group col-md-3 hidden concepto">
                                                <label for="dias">Dias activo</label>
                                                <input type="number" class="form-control" id="dias" min="1" max="31" disabled="disabled" value="@php echo($conceptos[0]->Dias); @endphp">
                                                <button class="edit-save-btn edit" input="dias">Editar</button>
                                            </div>
                                            
                                            <div class="form-group concepto col-md-3">
                                                <label for="estatus" class="">Estatus</label>
                                                <select name="estatus" id="estatus" class="form-control" disabled="disabled">
                                                    <option value="0" @if($conceptos[0]->Estatus == 0) selected="selected" @endif>Inactivo</option>
                                                    <option value="1" @if($conceptos[0]->Estatus == 1) selected="selected" @endif>Activo</option>
                                                    <option value="10" @if($conceptos[0]->Estatus == 10) selected="selected" @endif>Sólo administrador</option>
                                                </select>
                                                <button class="edit-save-btn edit" input="estatus">Editar</button>
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
</div>
@include('partials.footer')