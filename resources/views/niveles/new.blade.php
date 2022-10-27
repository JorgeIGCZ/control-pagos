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
        $('#submit_nivel').on('click',function(){
            createNivel();
        });    
    }); 
    
    function clearNivelForm(){
        $('#nombre').val('');
        $('#region').val('');
    }
    
    function createNivel(){
        $('.loader').show();
        const nombre  = $('#nombre').val();
        const plantel = $("#plantel").children("option:selected").val();
        
        let nivel = {
            'nombre'  : nombre,
            'plantel' : plantel
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/newnivel',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'nivel': nivel
            },
            success: function (result) {
                $('.loader').hide();
                if(result[0] == 'success'){
                    clearNivelForm();
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
                    <div>Nuevo Nivel
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
                                        <h5 class="card-title">Datos Del Nivel</h5>
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
                                        </div>
                                    </form>
                                    <button id="submit_nivel" class="btn btn-primary">Guardar</button>
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