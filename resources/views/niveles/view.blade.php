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
@endif. 
        
<script type='text/javascript'>

    $(function() {
        $('.form-group').on('click', '.save', function(){
            editNivel();
        });
    }); 
    
    function clearNivelForm(){
        $('#nombre').val('');
        $('#region').val('');
    }
    
    function editNivel(){
        $('.loader').show();
        const nombre  = $('#nombre').val();
        const plantel = $('#plantel').children("option:selected").val();
        let nivel = {
            'id'              : @php echo($_GET['nivel']) @endphp,
            'nombre'          : nombre,
            'plantel'         : plantel
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/updatenivel',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'nivel': nivel
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
                  text: 'Error al guardar el nivel'
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
                            echo($nivel[0]->Nombre);
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
                                        <h5 class="card-title">Datos Del Nivel</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="test" class="form-control" id="nombre" disabled="disabled" value="@php echo($nivel[0]->Nombre); @endphp">
                                                <button class="edit-save-btn edit" input="nombre">Editar</button>
                                            </div>

                                            <div class="form-group col-md-4 datos-plantel edit-container">
                                                <label for="plantel">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel" disabled="disabled">
                                                    <option value="0" selected="selected" @if($nivel[0]->Plantel_id == 0) selected="selected"  @endif>Seleccionar nivel</option>
                                                    @foreach ($planteles as $plantel)
                                                        <option value="@php echo($plantel->Id); @endphp" @if($nivel[0]->Plantel_id == $plantel->Id) selected="selected"  @endif >@php echo($plantel->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                                <button class="edit-save-btn edit" input="plantel">Editar</button>
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