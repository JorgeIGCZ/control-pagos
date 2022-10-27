<div class="modal fade" id="edit_alumno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div class="page-title-icon">
                                <i class="pe-7s-magic-wand icon-gradient bg-mixed-hopes"></i>
                            </div>
                            <div>
                                Editar
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card card">
                            <div class="card-body"><h5 class="card-title nombre-alumno-pago" alumnoId =""></h5>
                                <form class="">
                                    <div class="position-relative form-group">
                                        <label for="concepto" class="">Concepto</label>
                                        <select name="select" id="concepto" class="form-control">
                                        </select>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="concepto" class="">Concepto Inscripción</label>
                                        <select name="select" id="concepto-inscripcion" class="form-control">
                                        </select>
                                    </div>

                                    <div class="position-relative form-group">
                                        <label for="tipo" class="">Tipo</label>
                                        <select name="tipo" id="tipo" class="form-control">
                                            <option val="futura">Futura</option>
                                            <option val="general">General</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="reestructurar">Reestructurar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
@include('partials.header')

<script type='text/javascript'>
    $(function() {
        //let now         = new Date().toLocaleString('es-MX', { timeZone: 'CST' });
        const now       = new Date();
        const today     = now.getDate();

        $('#reestructurar').click(function(e){
            reestructurar();
        });

        function suspAlumno(becaAlumnoId,estatus){
            $.ajax({
                type: 'POST',
                url: '/ajax/suspalumno',
                dataType: 'json',
                data:
                {
                    '_token': '{{ csrf_token() }}',
                    'alumno':{'id':becaAlumnoId,'estatus':estatus}
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
                      text: 'Error al dar de baja al alumno'
                    });
                }
            });
        }
        $('#alumnos').DataTable( {
            processing: true,
            responsive: true,
            ajax: {
                url: '/ajax/getallalumnos',
                method: 'POST',
                data:{
                    '_token': '{{ csrf_token() }}'
                }
            },
            language: {

                "info": "Mostrando pagina _PAGE_ de _PAGES_ total _TOTAL_ alumnos",
                "lengthMenu":     "Mostrando _MENU_ alumnos",
                "processing":     "Procesando...",
                "search":         "Busqueda:",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            },
            columns: [
                { data: 'provId' },
                { data: 'Nombre' },
                { data: 'Telefono' },
                {  data: 'Estatus', defaultContent: 'Estatus', 'render': function ( data, type, row ) 
                    {
                        let estatus;
                        let tClass;
                        switch(row.Estatus) {
                          case 1:
                            estatus = 'Activo';
                            tClass  = 'btn-success';
                            break;
                          default:
                            estatus = 'Baja';
                            tClass  = 'btn-secondary';
                            break;
                        }
                        let view = `<span class="mb-2 mr-2 btn-hover-shine btn ${tClass}">${estatus}</span>`;
                        return  view;
                    } 
                },
                
                { defaultContent: 'Actions', 'render': function ( data, type, row ) 
                    {
                        const estatusText = row.Estatus == 1 ? 'Baja' : 'Activar';
                        let view    =   '<small> '+
	                                    '    <a href="#" class="new-reestructura" type="button" data-toggle="modal" data-target="#edit_alumno" alumnoId ="'+row.Id+'">Editar</a>'+
                                        '</small> ';
                        return  view;
                    } 
                }
            ]
        } );

        $(document).on('click','.new-reestructura', function () {
            const alumnoId = $(this).attr('alumnoId');
            clearConceptos();
            displayConceptos(alumnoId);
            displayAlumno(alumnoId);
        });
    }); 
    function clearConceptos(){
        $('#concepto .custom').remove();
        $('#concepto-inscripcion .custom').remove();
    }
    function displayConceptos(alumnoId){
        $.ajax({
            type: 'POST',
            async: false,
            url: '/ajax/getalumnoconceptos',
            dataType: 'json',
            data:
            {
                '_token'  : '{{ csrf_token() }}',
                'alumno': {
                    'id':alumnoId
                }
            },
            success: function (result) {
                $('.loader').hide();
                createConceptosList(result);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al cargar al alumno'
                });
            }
        });
    }
    function displayAlumno(alumnoId){
        $.ajax({
            type: 'POST',
            url: '/ajax/getalumnoall',
            dataType: 'json',
            data:
            {
                '_token'  : '{{ csrf_token() }}',
                'alumno': {
                    'id':alumnoId
                }
            },
            success: function (result) {
                $('.loader').hide();
                let alumno        = result['alumno'][0];
                $('.nombre-alumno-pago').attr('alumnoId',alumnoId);
                $('.nombre-alumno-pago').html(`${alumno.Nombre} ${alumno.Apellido_materno} ${alumno.Apellido_paterno} `);
                
                $(`#concepto option[value='${result['concepto'][0]['Concepto_id']}']`).attr("selected","selected");
                $(`#concepto-inscripcion option[value='${result['concepto'][0]['Concepto_inscripcion_id']}']`).attr("selected","selected");

            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.loader').hide();
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error al cargar al alumno'
                });
            }
        });
    }
    function reestructurar(){
        const conceptoId            = $('#concepto').children("option:selected").val();
        const conceptoInscripcionId = $('#concepto-inscripcion').children("option:selected").val();
        const alumnoId              = $('.nombre-alumno-pago').attr('alumnoId');
        const tipo                  = $('#tipo').children("option:selected").val();
        $.ajax({
            type: 'POST',
            url: '/ajax/reestructuraralumno',
            dataType: 'json',
            data:
            {
                '_token'    : '{{ csrf_token() }}',
                'alumnoId'  : alumnoId,
                'detalles'  : {
                    'tipo'      : tipo,
                    'conceptoId': conceptoId,
                    'conceptoInscripcionId' : conceptoInscripcionId
                }
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
                  text: 'Error al reestructurar al alumno'
                });
            }
        });
    }
    function createConceptosList(result){
        let conceptosList              = '';
        let conceptosInscripcionList   = '';

        const conceptos                = result.conceptos;
        const conceptosInscripcion     = result.conceptosInscripcion;

        for(let i = 0; i < conceptos.length;i++){
            conceptosList += `<option class="custom" value="${conceptos[i].Id}" >${conceptos[i].Nombre}</option>`
        }
        $('#concepto .custom').remove();
        $(conceptosList).appendTo('#concepto');

        for(let i = 0; i < conceptosInscripcion.length;i++){
            conceptosInscripcionList += `<option class="custom" value="${conceptosInscripcion[i].Id}" >${conceptosInscripcion[i].Nombre}</option>`
        }
        $('#concepto-inscripcion .custom').remove();
        $(conceptosInscripcionList).appendTo('#concepto-inscripcion');
    }
</script>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-users icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Alumnos
                    </div>  
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-12 card">
                        <div class="card-body">
                            <table id="alumnos" class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Estatus Alumno</th>
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