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
            editPlantel();
        });
    }); 
    
    function clearPlantelForm(){
        $('#nombre').val('');
        $('#region').val('');
    }
    
    function editPlantel(){
        $('.loader').show();
        let nombre          = $('#nombre').val();
        let region          = $('#region').val();
        
        let plantel = {
            'id'              : @php echo($_GET['plantel']) @endphp,
            'nombre'          : nombre,
            'region'          : region
        }
        $.ajax({
            type: 'POST',
            url: '/ajax/updateplantel',
            dataType: 'json',
            data:
            {
                '_token' : '{{ csrf_token() }}',
                'plantel': plantel
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
                  text: 'Error al guardar el plantel'
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
                            echo($plantel[0]->Nombre);
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
                                        <h5 class="card-title">Datos Del Plantel</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Nombre</label>
                                                <input type="test" class="form-control" id="nombre" disabled="disabled" value="@php echo($plantel[0]->Nombre); @endphp">
                                                <button class="edit-save-btn edit" input="nombre">Editar</button>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Region</label>
                                                <input type="test" class="form-control" id="region" disabled="disabled" value="@php echo($plantel[0]->Region); @endphp">
                                                <button class="edit-save-btn edit" input="region">Editar</button>
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