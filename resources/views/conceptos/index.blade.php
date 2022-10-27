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
        $('#conceptos').DataTable( {
            ajax: {
                url: '/ajax/getconceptos'
            },
            language: {
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "lengthMenu":     "Mostrando _MENU_ conceptos",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Busqueda:",
                "zeroRecords":    "Ningún concepto encontrado",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            },
            columns: [
                { data: 'Id' },
                { data: 'Nombre' },
                { data: 'Precio' },
                { data: 'Tipo' },
                { data: 'Plantel' },
                { data: 'Alumnos' },
                { defaultContent: 'Estatus', 'render': function ( data, type, row ) 
                    {
                        let estatus = (row.Estatus == 1) ? 'Activo' : 'Inactivo';
                        return  estatus;
                    } 
                },
                { defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        let view    =   '<small> '+
	                                    '    <a href="/conceptos/view?concepto='+row.Id+'">Ver</a>'+
                                        '</small> ';
                        return  view;
                    } 
                }
            ]
        } );
    }); 
    
</script>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-note2 icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Conceptos
                    </div>  
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="{{ url('conceptos/new') }}" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-primary">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-plus fa-w-20"></i>
                            </span>
                            Nuevo Concepto
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-12 card">
                        <div class="card-body">
                            <table id="conceptos" class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Tipo</th>
                                        <th>Plantel</th>
                                        <th>#Alumnos</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>    
        </div>   
    </div>
</div>
@include('partials.footer')