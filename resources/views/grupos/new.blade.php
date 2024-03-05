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
        $('#submit_grupo').on('click',function(){
            createGrupo();
        });    

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
            licenciaturasOptions += `<option class="dinamic" value="${licenciatura.Id}" >${licenciatura.Nombre}</option>`;
        });
        $('#licenciatura').append(licenciaturasOptions);
    }
    function displayNiveles(plantel){
        let nivelesOptions = "";
        let nivelesObj  = niveles.filter(function(niveles) {
            if(niveles.Plantel_id == plantel){
                return true;
            }
        });
        $('#nivel .dinamic').remove();

        nivelesObj.forEach(function(nivel){
            nivelesOptions += `<option class="dinamic" value="${nivel.Id}" >${nivel.Nombre}</option>`;
        });
        $('#nivel').append(nivelesOptions);
    }

    function clearGrupoForm(){
        $('#nombre').val('');
    }
    
    function createGrupo(){
        $('.loader').show();
        let nombre          = $('#nombre').val();
        let plantel         = $('#plantel').children("option:selected").val();
        let nivel           = $('#nivel').children("option:selected").val();
        let licenciatura    = $('#licenciatura').children("option:selected").val();
        let sistema         = $('#sistema').children("option:selected").val();
        
        let grupo = {
            'nombre'          : nombre,
            'plantel'         : plantel,
            'nivel'           : nivel,
            'licenciatura'    : licenciatura,
            'sistema'         : sistema
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/newgrupo',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'grupo': grupo
            },
            success: function (result) {
                $('.loader').hide();
                if(result[0] == 'success'){
                    clearGrupoForm();
                }
                Swal.fire({
                  icon: result[0],
                  title: (result[0] == 'success' ? 'Éxito' : 'Error'),
                  text: result[1]
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
                    <div>Nuevo Grupo
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
                                        <h5 class="card-title">Datos Del Grupo</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="text" class="form-control" id="nombre">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="plantel">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel">
                                                    <option value="0">Seleccionar plantel</option>
                                                    @foreach ($planteles as $plantel)
                                                        <option value="{{$plantel->Id}}">{{$plantel->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2 "  @if (count($niveles) == 1) style="display:none;" @endif>
                                                <label for="nivel">Nivel</label>
                                                <select class="form-control" name="nivel" id="nivel">
                                                    <option value="0" >Seleccionar nivel</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2" @if(count($licenciaturas) == 0) style="display:none;"  @endif>
                                                <label for="licenciaturas">Licenciatura</label>
                                                <select class="form-control" name="licenciatura" id="licenciatura">
                                                    <option value="0" >Seleccionar licenciatura</option>
                                                </select>
                                            </div>

                                            <div class="form-group  col-md-2">
                                                <label for="sistema">Sistema</label>
                                                <select class="form-control dinamic_filters" name="sistema" id="sistema">
                                                    <option value="0">Seleccionar sistema</option>
                                                    @foreach ($sistemas as $sistema)
                                                        <option value="@php echo($sistema->Id); @endphp">@php echo($sistema->Nombre); @endphp</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </form>
                                    <button id="submit_grupo" class="btn btn-primary">Guardar</button>
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