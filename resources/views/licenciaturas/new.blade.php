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

    const niveles = @php echo(json_encode($niveles)); @endphp;
    $(function() {
        $('#submit_licenciatura').on('click',function(){
            createLicenciatura();
        });
        $('#plantel').on('change',function(){
            const plantel   = $(this).children("option:selected").val();
            displayNiveles(plantel);
        });
    }); 
    
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
    function clearLicenciaturaForm(plantel){
        $('#nombre').val('');
    }
    
    function createLicenciatura(){
        $('.loader').show();
        const nombre  = $('#nombre').val();
        const plantel = $("#plantel").children("option:selected").val();
        const nivel   = $("#nivel").children("option:selected").val();

        let licenciatura = {
            'nombre'    : nombre,
            'plantelId' : plantel,
            'nivelId'   : nivel
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/newlicenciatura',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'licenciatura': licenciatura
            },
            success: function (result) {
                $('.loader').hide();
                if(result[0] == 'success'){
                    clearLicenciaturaForm();
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
                    <div>Nueva Licenciatura
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
                                        <h5 class="card-title">Datos De Licenciatura</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="text" class="form-control" id="nombre">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="rol">Plantel</label>
                                                <select class="form-control" name="plantel" id="plantel">
                                                    <option value="0" selected="selected" >Seleccionar plantel</option>
                                                    @foreach ($planteles as $plantel)
                                                        <option value="{{$plantel->Id}}" >{{$plantel->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="rol">Nivel</label>
                                                <select class="form-control" name="nivel" id="nivel">
                                                    <option value="0" selected="selected" >Seleccionar nivel</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                    <button id="submit_licenciatura" class="btn btn-primary">Guardar</button>
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