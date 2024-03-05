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
    const niveles       = @php echo(json_encode($niveles)); @endphp;
    const licenciaturas = @php echo(json_encode($licenciaturas)); @endphp;

    $(function() {
        $('.form-group').on('click', '.save', function(){
            editGrupo();
        });

        displayNiveles($('#plantel').children("option:selected").val());
        displayLicenciaturas($('#plantel').children("option:selected").val());

        $('#plantel').on('change',function(){
            const plantel   = $(this).children("option:selected").val();
            displayNiveles(plantel);
            displayLicenciaturas(plantel);
        });
    }); 

    function displayLicenciaturas(plantel){
        let licenciaturasOptions = "";
        let licenciaturasObj  = licenciaturas.filter(function(licenciaturas) {
            if(licenciaturas.Plantel_id == plantel){
                return true;
            }
        });
        $('#licenciatura .dinamic').remove();

        licenciaturasObj.forEach(function(licenciatura){
            isSelected = (licenciatura.Id == {{$grupo[0]->Licenciatura_id}}) ? " selected='selected' " : "";
            licenciaturasOptions += `<option class="dinamic" ${isSelected} value="${licenciatura.Id}" >${licenciatura.Nombre}</option>`;
        });
        $('#licenciatura').append(licenciaturasOptions);
    }

    function displayNiveles(plantel){
        let nivelesOptions = "";
        let isSelected     = "";
        let nivelesObj  = niveles.filter(function(niveles) {
            if(niveles.Plantel_id == plantel){
                return true;
            }
        });
        $('#nivel .dinamic').remove();

        nivelesObj.forEach(function(nivel){
            isSelected = (nivel.Id == {{$grupo[0]->Nivel_id}}) ? " selected='selected' " : "";
            nivelesOptions += `<option class="dinamic" ${isSelected} value="${nivel.Id}" >${nivel.Nombre}</option>`;
        });
        $('#nivel').append(nivelesOptions);
    }
    
    function clearGrupoForm(){
        $('#nombre').val('');
    }
    
    function editGrupo(){
        $('.loader').show();
        let nombre          = $('#nombre').val();
        let plantel         = $('#plantel').children("option:selected").val();
        let nivel           = $('#nivel').children("option:selected").val();
        let licenciatura    = $('#licenciatura').children("option:selected").val();
        let sistema         = $('#sistema').children("option:selected").val();
        let estatus         = $('#estatus').children("option:selected").val();
        
        let grupo = {
            'id'              : @php echo($_GET['grupo']) @endphp,
            'nombre'          : nombre,
            'plantel'         : plantel,
            'nivel'           : nivel,
            'licenciatura'    : licenciatura,
            'sistema'         : sistema,
            'estatus'         : estatus
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/updategrupo',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'grupo': grupo
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
                  text: 'Error al guardar el grupo'
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
                            echo($grupo[0]->Nombre);
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
                                        <h5 class="card-title">Datos Del Grupo</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="test" class="form-control" id="nombre" disabled="disabled" value="@php echo($grupo[0]->Nombre); @endphp">
                                                <button class="edit-save-btn edit" input="nombre">Editar</button>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="plantel">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel" disabled="disabled">
                                                    <option value="0" selected="selected" @if($grupo[0]->Plantel_id == 0) selected="selected"  @endif>Seleccionar plantel</option>
                                                    @foreach ($planteles as $plantel)
                                                        <option value="@php echo($plantel->Id); @endphp" @if($grupo[0]->Plantel_id == $plantel->Id) selected="selected"  @endif >@php echo($plantel->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                                <button class="edit-save-btn edit" input="plantel">Editar</button>
                                            </div>

                                            <div class="form-group col-md-3 "  @if (count($niveles) == 1) style="display:none;" @endif>
                                                <label for="nivel">Nivel</label>
                                                <select class="form-control" name="nivel" id="nivel" disabled="disabled">
                                                    <option value="0">Seleccionar nivel</option>
                                                    
                                                </select>
                                                <button class="edit-save-btn edit" input="nivel">Editar</button>
                                            </div>
                                            <div class="form-group col-md-3" @if(count($licenciaturas) == 0) style="display:none;"  @endif>
                                                <label for="licenciaturas">Licenciaturas</label>
                                                <select class="form-control" name="licenciatura" id="licenciatura" disabled="disabled">
                                                    <option value="0" @if($grupo[0]->Licenciatura_id == 0) selected="selected"  @endif>Seleccionar licenciatura</option>
                                                    
                                                </select>
                                                <button class="edit-save-btn edit" input="licenciatura">Editar</button>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="sistema">Sistema</label>
                                                <select class="form-control" name="sistema" id="sistema" disabled="disabled">
                                                    <option value="0" @if($grupo[0]->Sistema_id == 0) selected="selected"  @endif>Seleccionar sistema</option>
                                                    @foreach ($sistemas as $sistema)
                                                        <option value="@php echo($sistema->Id); @endphp" @if($grupo[0]->Sistema_id == $sistema->Id) selected="selected"  @endif>@php echo($sistema->Nombre); @endphp </option>
                                                    @endforeach
                                                </select>
                                                <button class="edit-save-btn edit" input="sistema">Editar</button>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="estatus" class="">Estatus</label>
                                                <select name="estatus" id="estatus" class="form-control" disabled="disabled">
                                                    <option value="0" @if($grupo[0]->Estatus == 0) selected="selected"  @endif>Inactivo</option>
                                                    <option value="1" @if($grupo[0]->Estatus == 1) selected="selected"  @endif>Activo</option>
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