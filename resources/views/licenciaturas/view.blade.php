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
        $('.form-group').on('click', '.save', function(){
            editLicenciatura();
        });
    }); 
    
    function clearLicenciaturaForm(){
        $('#nombre').val('');
        $('#region').val('');
    }
    
    function editLicenciatura(){
        $('.loader').show();
        const nombre     = $('#nombre').val();
        const nivelId    = $('#nivel').children("option:selected").val();
        const plantelId  = $('#plantel').children("option:selected").val();
        
        let licenciatura = {
            'id'              : @php echo($_GET['licenciatura']) @endphp,
            'nombre'          : nombre,
            'plantelId'       : plantelId,
            'nivelId'         : nivelId
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/updatelicenciatura',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'licenciatura': licenciatura
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
                  text: 'Error al guardar la licenciatura'
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
                            echo($licenciatura[0]->Nombre);
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
                                        <h5 class="card-title">Datos De Licenciatura</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="test" class="form-control" id="nombre" disabled="disabled" value="@php echo($licenciatura[0]->Nombre); @endphp">
                                                <button class="edit-save-btn edit" input="nombre">Editar</button>
                                            </div>
                                            <div class="form-group col-md-4 datos-licenciatura edit-container">
                                                <label for="plantel">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel" disabled="disabled">
                                                    <option value="0" selected="selected" @if($licenciatura[0]->Plantel_id == 0) selected="selected"  @endif>Seleccionar plantel</option>
                                                    @foreach ($planteles as $plantel)
                                                        <option value="@php echo($plantel->Id); @endphp" @if($licenciatura[0]->Plantel_id == $plantel->Id) selected="selected"  @endif >@php echo($plantel->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                                <button class="edit-save-btn edit" input="plantel">Editar</button>
                                            </div>


                                            <div class="form-group col-md-4 datos-licenciatura edit-container" @if (count($niveles) == 1) style="display:none;" @endif>
                                                <label for="nivel">Nivel</label>
                                                <select class="form-control" name="nivel" id="nivel" disabled="disabled">
                                                    <option value="0" @if($licenciatura[0]->Nivel_id == 0) selected="selected"  @endif>Seleccionar nivel</option>
                                                    @foreach ($niveles as $nivel)
                                                        <option value="@php echo($nivel->Id); @endphp" @if($licenciatura[0]->Nivel_id == $nivel->Id) selected="selected"  @endif >@php echo($nivel->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                                <button class="edit-save-btn edit" input="nivel">Editar</button>
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