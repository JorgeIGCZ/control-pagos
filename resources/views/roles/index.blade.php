@include('partials.header')
<script type='text/javascript'>
    $(function() {
        $('#guardar-administrador-role').click(function(e){
            const data = [
                {
                    id:1,
                    data:{
                        Ver     : ($("#administrador .matricula-ver"          ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:2,
                    data:{
                        Ver       : ($("#administrador .alumnos-ver"            ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#administrador .alumnos-crear"          ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#administrador .alumnos-modificar"      ).is(':checked') ) ?'Y':'N',
                        Estatus   : ($("#administrador .alumnos-estatus"        ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:3,
                    data:{
                        Ver       : ($("#administrador .pagos-ver"              ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#administrador .pagos-modificar"        ).is(':checked') ) ?'Y':'N',
                    }
                },
                {
                    id:4,
                    data:{
                        Ver         : ($("#administrador .becas-ver"              ).is(':checked') ) ?'Y':'N',
                        Crear       : ($("#administrador .becas-crear"            ).is(':checked') ) ?'Y':'N',
                        Modificar   : ($("#administrador .becas-modificar"        ).is(':checked') ) ?'Y':'N',
                        Eliminar    : ($("#administrador .becas-eliminar"         ).is(':checked') ) ?'Y':'N',
                        Estatus     : ($("#administrador .becas-estatus"          ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:5,
                    data:{
                        Ver       : ($("#administrador .planteles-ver"          ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#administrador .planteles-crear"        ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#administrador .planteles-modificar"    ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:6,
                    data:{
                        Ver       : ($("#administrador .niveles-ver"            ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#administrador .niveles-crear"          ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#administrador .niveles-modificar"      ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:7,
                    data:{
                        Ver       : ($("#administrador .licenciaturas-ver"      ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#administrador .licenciaturas-crear"    ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#administrador .licenciaturas-modificar").is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:8,
                    data:{
                        Ver       : ($("#administrador .sistemas-ver"           ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#administrador .sistemas-crear"         ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#administrador .sistemas-modificar"     ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:9,
                    data:{
                        Ver        : ($("#administrador .grupos-ver"             ).is(':checked') ) ?'Y':'N',
                        Crear      : ($("#administrador .grupos-crear"           ).is(':checked') ) ?'Y':'N',
                        Modificar  : ($("#administrador .grupos-modificar"       ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:10,
                    data:{
                        Ver       : ($("#administrador .conceptos-ver"          ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#administrador .conceptos-crear"        ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#administrador .conceptos-modificar"    ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:11,
                    data:{
                        Ver       : ($("#administrador .generaciones-ver"             ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#administrador .generaciones-crear"           ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#administrador .generaciones-modificar"       ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:12,
                    data:{
                        Ver       : ($("#administrador .configuracion-ver"      ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#administrador .configuracion-crear"    ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#administrador .configuracion-modificar").is(':checked') ) ?'Y':'N'
                    }
                }
            ];
            guardarRoles(data,1);
        });
        $('#guardar-responsable-role').click(function(e){
            const data = [
                {
                    id:1,
                    data:{
                        Ver     : ($("#responsable .matricula-ver"          ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:2,
                    data:{
                        Ver       : ($("#responsable .alumnos-ver"            ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable .alumnos-crear"          ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable .alumnos-modificar"      ).is(':checked') ) ?'Y':'N',
                        Estatus   : ($("#responsable .alumnos-estatus"        ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:3,
                    data:{
                        Ver       : ($("#responsable .pagos-ver"              ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable .pagos-modificar"        ).is(':checked') ) ?'Y':'N',
                    }
                },
                {
                    id:4,
                    data:{
                        Ver         : ($("#responsable .becas-ver"              ).is(':checked') ) ?'Y':'N',
                        Crear       : ($("#responsable .becas-crear"            ).is(':checked') ) ?'Y':'N',
                        Modificar   : ($("#responsable .becas-modificar"        ).is(':checked') ) ?'Y':'N',
                        Eliminar    : ($("#responsable .becas-eliminar"         ).is(':checked') ) ?'Y':'N',
                        Estatus     : ($("#responsable .becas-estatus"          ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:5,
                    data:{
                        Ver       : ($("#responsable .planteles-ver"          ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable .planteles-crear"        ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable .planteles-modificar"    ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:6,
                    data:{
                        Ver       : ($("#responsable .niveles-ver"            ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable .niveles-crear"          ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable .niveles-modificar"      ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:7,
                    data:{
                        Ver       : ($("#responsable .licenciaturas-ver"      ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable .licenciaturas-crear"    ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable .licenciaturas-modificar").is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:8,
                    data:{
                        Ver       : ($("#responsable .sistemas-ver"           ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable .sistemas-crear"         ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable .sistemas-modificar"     ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:9,
                    data:{
                        Ver        : ($("#responsable .grupos-ver"             ).is(':checked') ) ?'Y':'N',
                        Crear      : ($("#responsable .grupos-crear"           ).is(':checked') ) ?'Y':'N',
                        Modificar  : ($("#responsable .grupos-modificar"       ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:10,
                    data:{
                        Ver       : ($("#responsable .conceptos-ver"          ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable .conceptos-crear"        ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable .conceptos-modificar"    ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:11,
                    data:{
                        Ver       : ($("#responsable .generaciones-ver"             ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable .generaciones-crear"           ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable .generaciones-modificar"       ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:12,
                    data:{
                        Ver       : ($("#responsable .configuracion-ver"      ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable .configuracion-crear"    ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable .configuracion-modificar").is(':checked') ) ?'Y':'N'
                    }
                }
            ];
            guardarRoles(data,2);
        });
        $('#guardar-p-administrativo-role').click(function(e){
            const data = [
                {
                    id:1,
                    data:{
                        Ver     : ($("#p-administrativo .matricula-ver"          ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:2,
                    data:{
                        Ver       : ($("#p-administrativo .alumnos-ver"            ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#p-administrativo .alumnos-crear"          ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#p-administrativo .alumnos-modificar"      ).is(':checked') ) ?'Y':'N',
                        Estatus   : ($("#p-administrativo .alumnos-estatus"        ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:3,
                    data:{
                        Ver       : ($("#p-administrativo .pagos-ver"              ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#p-administrativo .pagos-modificar"        ).is(':checked') ) ?'Y':'N',
                    }
                },
                {
                    id:4,
                    data:{
                        Ver         : ($("#p-administrativo .becas-ver"              ).is(':checked') ) ?'Y':'N',
                        Crear       : ($("#p-administrativo .becas-crear"            ).is(':checked') ) ?'Y':'N',
                        Modificar   : ($("#p-administrativo .becas-modificar"        ).is(':checked') ) ?'Y':'N',
                        Eliminar    : ($("#p-administrativo .becas-eliminar"         ).is(':checked') ) ?'Y':'N',
                        Estatus     : ($("#p-administrativo .becas-estatus"          ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:5,
                    data:{
                        Ver       : ($("#p-administrativo .planteles-ver"          ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#p-administrativo .planteles-crear"        ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#p-administrativo .planteles-modificar"    ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:6,
                    data:{
                        Ver       : ($("#p-administrativo .niveles-ver"            ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#p-administrativo .niveles-crear"          ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#p-administrativo .niveles-modificar"      ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:7,
                    data:{
                        Ver       : ($("#p-administrativo .licenciaturas-ver"      ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#p-administrativo .licenciaturas-crear"    ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#p-administrativo .licenciaturas-modificar").is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:8,
                    data:{
                        Ver       : ($("#p-administrativo .sistemas-ver"           ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#p-administrativo .sistemas-crear"         ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#p-administrativo .sistemas-modificar"     ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:9,
                    data:{
                        Ver        : ($("#p-administrativo .grupos-ver"             ).is(':checked') ) ?'Y':'N',
                        Crear      : ($("#p-administrativo .grupos-crear"           ).is(':checked') ) ?'Y':'N',
                        Modificar  : ($("#p-administrativo .grupos-modificar"       ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:10,
                    data:{
                        Ver       : ($("#p-administrativo .conceptos-ver"          ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#p-administrativo .conceptos-crear"        ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#p-administrativo .conceptos-modificar"    ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:11,
                    data:{
                        Ver       : ($("#p-administrativo .generaciones-ver"             ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#p-administrativo .generaciones-crear"           ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#p-administrativo .generaciones-modificar"       ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:12,
                    data:{
                        Ver       : ($("#p-administrativo .configuracion-ver"      ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#p-administrativo .configuracion-crear"    ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#p-administrativo .configuracion-modificar").is(':checked') ) ?'Y':'N'
                    }
                }
            ];
            guardarRoles(data,3);
        });

        $('#guardar-responsable-general-role').click(function(e){
            const data = [
                {
                    id:1,
                    data:{
                        Ver     : ($("#responsable-general .matricula-ver"          ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:2,
                    data:{
                        Ver       : ($("#responsable-general .alumnos-ver"            ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable-general .alumnos-crear"          ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable-general .alumnos-modificar"      ).is(':checked') ) ?'Y':'N',
                        Estatus   : ($("#responsable-general .alumnos-estatus"        ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:3,
                    data:{
                        Ver       : ($("#responsable-general .pagos-ver"              ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable-general .pagos-modificar"        ).is(':checked') ) ?'Y':'N',
                    }
                },
                {
                    id:4,
                    data:{
                        Ver         : ($("#responsable-general .becas-ver"              ).is(':checked') ) ?'Y':'N',
                        Crear       : ($("#responsable-general .becas-crear"            ).is(':checked') ) ?'Y':'N',
                        Modificar   : ($("#responsable-general .becas-modificar"        ).is(':checked') ) ?'Y':'N',
                        Eliminar    : ($("#responsable-general .becas-eliminar"         ).is(':checked') ) ?'Y':'N',
                        Estatus     : ($("#responsable-general .becas-estatus"          ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:5,
                    data:{
                        Ver       : ($("#responsable-general .planteles-ver"          ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable-general .planteles-crear"        ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable-general .planteles-modificar"    ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:6,
                    data:{
                        Ver       : ($("#responsable-general .niveles-ver"            ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable-general .niveles-crear"          ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable-general .niveles-modificar"      ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:7,
                    data:{
                        Ver       : ($("#responsable-general .licenciaturas-ver"      ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable-general .licenciaturas-crear"    ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable-general .licenciaturas-modificar").is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:8,
                    data:{
                        Ver       : ($("#responsable-general .sistemas-ver"           ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable-general .sistemas-crear"         ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable-general .sistemas-modificar"     ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:9,
                    data:{
                        Ver        : ($("#responsable-general .grupos-ver"             ).is(':checked') ) ?'Y':'N',
                        Crear      : ($("#responsable-general .grupos-crear"           ).is(':checked') ) ?'Y':'N',
                        Modificar  : ($("#responsable-general .grupos-modificar"       ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:10,
                    data:{
                        Ver       : ($("#responsable-general .conceptos-ver"          ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable-general .conceptos-crear"        ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable-general .conceptos-modificar"    ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:11,
                    data:{
                        Ver       : ($("#responsable-general .generaciones-ver"             ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable-general .generaciones-crear"           ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable-general .generaciones-modificar"       ).is(':checked') ) ?'Y':'N'
                    }
                },
                {
                    id:12,
                    data:{
                        Ver       : ($("#responsable-general .configuracion-ver"      ).is(':checked') ) ?'Y':'N',
                        Crear     : ($("#responsable-general .configuracion-crear"    ).is(':checked') ) ?'Y':'N',
                        Modificar : ($("#responsable-general .configuracion-modificar").is(':checked') ) ?'Y':'N'
                    }
                }
            ];
            guardarRoles(data,4);
        });
    });
    function guardarRoles(data,roleId){
        $.ajax({
            type: 'POST',
            url: '/ajax/updaterole',
            dataType: 'json',
            data:
            {
                '_token'      : '{{ csrf_token() }}',
                'data'        : data,
                'roleId'      : roleId
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
                  text: 'Error al cargar la beca'
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
                        <i class="pe-7s-id icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Roles
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Administrador</h5>
                            <div class="row roles-box" id="administrador">
                                <div class="col-md-2">
                                    <strong>Matrícula</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="matricula-ver" type="checkbox" @if ($roles[0]->Ver == 'Y') checked="checked" @endif >
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Alumnos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-ver" type="checkbox" @if ($roles[1]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-crear" type="checkbox" @if ($roles[1]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-modificar" type="checkbox" @if ($roles[1]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-estatus" type="checkbox" @if ($roles[1]->Estatus == 'Y') checked="checked" @endif>
                                        <label for="estatus">
                                            Estatus  
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Pagos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="pagos-ver" type="checkbox" @if ($roles[2]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            ver
                                        </label>
                                    </div>

                                    <div class="checkbox checkbox-primary">
                                        <input class="pagos-modificar" type="checkbox" @if ($roles[2]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Becas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-ver" type="checkbox" @if ($roles[3]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-crear" type="checkbox" @if ($roles[3]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-modificar" type="checkbox" @if ($roles[3]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-eliminar" type="checkbox" @if ($roles[3]->Eliminar == 'Y') checked="checked" @endif>
                                        <label for="eliminar">
                                            Eliminar
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-estatus" type="checkbox" @if ($roles[3]->Estatus == 'Y') checked="checked" @endif>
                                        <label for="estatus">
                                            Estatus  
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Planteles</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-ver" type="checkbox" @if ($roles[4]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-crear" type="checkbox" @if ($roles[4]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-modificar" type="checkbox" @if ($roles[4]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Niveles</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-ver" type="checkbox" @if ($roles[5]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-crear" type="checkbox" @if ($roles[5]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-modificar" type="checkbox" @if ($roles[5]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Licenciaturas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-ver" type="checkbox" @if ($roles[6]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-crear" type="checkbox" @if ($roles[6]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-modificar" type="checkbox" @if ($roles[6]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Sistemas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-ver" type="checkbox" @if ($roles[7]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-crear" type="checkbox" @if ($roles[7]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-modificar" type="checkbox" @if ($roles[7]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Grupos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-ver" type="checkbox" @if ($roles[8]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-crear" type="checkbox" @if ($roles[8]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-modificar" type="checkbox" @if ($roles[8]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Conceptos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-ver" type="checkbox" @if ($roles[9]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-crear" type="checkbox" @if ($roles[9]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-modificar" type="checkbox" @if ($roles[9]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Generaciones</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-ver" type="checkbox" @if ($roles[10]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-crear" type="checkbox" @if ($roles[10]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-modificar" type="checkbox" @if ($roles[10]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <h6>Configuración</h6>
                                    <div class="checkbox checkbox-primary">
                                        <input class="configuracion-ver" type="checkbox" @if ($roles[11]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="configuracion-modificar" type="checkbox" @if ($roles[11]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary float-right-button" id="guardar-administrador-role">Guardar</button>
                        </div>
                    </div>
                    
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Responsable General</h5>
                            <div class="row roles-box" id="responsable-general">
                                <div class="col-md-2">
                                    <strong>Matrícula</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="matricula-ver" type="checkbox" @if ($roles[36]->Ver == 'Y') checked="checked" @endif >
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Alumnos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-ver" type="checkbox" @if ($roles[37]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-crear" type="checkbox" @if ($roles[37]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-modificar" type="checkbox" @if ($roles[37]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-estatus" type="checkbox" @if ($roles[37]->Estatus == 'Y') checked="checked" @endif>
                                        <label for="estatus">
                                            Estatus  
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Pagos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="pagos-ver" type="checkbox" @if ($roles[38]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            ver
                                        </label>
                                    </div>

                                    <div class="checkbox checkbox-primary">
                                        <input class="pagos-modificar" type="checkbox" @if ($roles[38]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Becas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-ver" type="checkbox" @if ($roles[39]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-crear" type="checkbox" @if ($roles[39]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-modificar" type="checkbox" @if ($roles[39]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-eliminar" type="checkbox" @if ($roles[39]->Eliminar == 'Y') checked="checked" @endif>
                                        <label for="eliminar">
                                            Eliminar
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-estatus" type="checkbox" @if ($roles[39]->Estatus == 'Y') checked="checked" @endif>
                                        <label for="estatus">
                                            Estatus  
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Planteles</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-ver" type="checkbox" @if ($roles[40]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-crear" type="checkbox" @if ($roles[40]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-modificar" type="checkbox" @if ($roles[40]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Niveles</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-ver" type="checkbox" @if ($roles[41]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-crear" type="checkbox" @if ($roles[41]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-modificar" type="checkbox" @if ($roles[41]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Licenciaturas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-ver" type="checkbox" @if ($roles[42]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-crear" type="checkbox" @if ($roles[42]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-modificar" type="checkbox" @if ($roles[42]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Sistemas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-ver" type="checkbox" @if ($roles[43]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-crear" type="checkbox" @if ($roles[43]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-modificar" type="checkbox" @if ($roles[43]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Grupos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-ver" type="checkbox" @if ($roles[44]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-crear" type="checkbox" @if ($roles[44]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-modificar" type="checkbox" @if ($roles[44]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Conceptos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-ver" type="checkbox" @if ($roles[45]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-crear" type="checkbox" @if ($roles[45]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-modificar" type="checkbox" @if ($roles[45]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Generaciones</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-ver" type="checkbox" @if ($roles[46]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-crear" type="checkbox" @if ($roles[46]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-modificar" type="checkbox" @if ($roles[46]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <h6>Configuración</h6>
                                    <div class="checkbox checkbox-primary">
                                        <input class="configuracion-ver" type="checkbox" @if ($roles[47]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="configuracion-modificar" type="checkbox" @if ($roles[47]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary float-right-button" id="guardar-responsable-general-role">Guardar</button>
                        </div>
                    </div>
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Responsable</h5>
                            <div class="row roles-box" id="responsable">
                                <div class="col-md-2">
                                    <strong>Matrícula</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="matricula-ver" type="checkbox" @if ($roles[12]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Alumnos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-ver" type="checkbox" @if ($roles[13]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-crear" type="checkbox" @if ($roles[13]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-modificar" type="checkbox" @if ($roles[13]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-estatus" type="checkbox" @if ($roles[13]->Estatus == 'Y') checked="checked" @endif>
                                        <label for="estatus">
                                            Estatus  
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Pagos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="pagos-ver" type="checkbox" @if ($roles[14]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            ver
                                        </label>
                                    </div>

                                    <div class="checkbox checkbox-primary">
                                        <input class="pagos-modificar" type="checkbox" @if ($roles[14]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Becas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-ver" type="checkbox" @if ($roles[15]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-crear" type="checkbox" @if ($roles[15]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-modificar" type="checkbox" @if ($roles[15]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-eliminar" type="checkbox" @if ($roles[15]->Eliminar == 'Y') checked="checked" @endif>
                                        <label for="eliminar">
                                            Eliminar
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-estatus" type="checkbox" @if ($roles[15]->Estatus == 'Y') checked="checked" @endif>
                                        <label for="estatus">
                                            Estatus  
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Planteles</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-ver" type="checkbox" @if ($roles[16]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-crear" type="checkbox" @if ($roles[16]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-modificar" type="checkbox" @if ($roles[16]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Niveles</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-ver" type="checkbox" @if ($roles[17]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-crear" type="checkbox" @if ($roles[17]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-modificar" type="checkbox" @if ($roles[17]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Licenciaturas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-ver" type="checkbox" @if ($roles[18]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-crear" type="checkbox" @if ($roles[18]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-modificar" type="checkbox" @if ($roles[18]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Sistemas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-ver" type="checkbox" @if ($roles[19]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-crear" type="checkbox" @if ($roles[19]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-modificar" type="checkbox" @if ($roles[19]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Grupos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-ver" type="checkbox" @if ($roles[20]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-crear" type="checkbox" @if ($roles[20]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-modificar" type="checkbox" @if ($roles[20]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Conceptos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-ver" type="checkbox" @if ($roles[21]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-crear" type="checkbox" @if ($roles[21]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-modificar" type="checkbox" @if ($roles[21]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Generaciones</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-ver" type="checkbox" @if ($roles[22]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-crear" type="checkbox" @if ($roles[22]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-modificar" type="checkbox" @if ($roles[22]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <h6>Configuración</h6>
                                    <div class="checkbox checkbox-primary">
                                        <input class="configuracion-ver" type="checkbox" @if ($roles[23]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="configuracion-modificar" type="checkbox" @if ($roles[23]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary float-right-button" id="guardar-responsable-role">Guardar</button>
                        </div>
                    </div>
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">P. Administrativo</h5>
                            <div class="row roles-box" id="p-administrativo">
                                <div class="col-md-2">
                                    <strong>Matrícula</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="matricula-ver" type="checkbox" @if ($roles[24]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Alumnos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-ver" type="checkbox" @if ($roles[25]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-crear" type="checkbox" @if ($roles[25]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-modificar" type="checkbox" @if ($roles[25]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="alumnos-estatus" type="checkbox" @if ($roles[25]->Estatus == 'Y') checked="checked" @endif>
                                        <label for="estatus">
                                            Estatus  
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Pagos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="pagos-ver" type="checkbox" @if ($roles[26]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver
                                        </label>
                                    </div>


                                    <div class="checkbox checkbox-primary">
                                        <input class="pagos-modificar" type="checkbox" @if ($roles[26]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Becas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-ver" type="checkbox" @if ($roles[27]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-crear" type="checkbox" @if ($roles[27]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-modificar" type="checkbox" @if ($roles[27]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-eliminar" type="checkbox" @if ($roles[27]->Eliminar == 'Y') checked="checked" @endif>
                                        <label for="eliminar">
                                            Eliminar
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="becas-estatus" type="checkbox" @if ($roles[27]->Estatus == 'Y') checked="checked" @endif>
                                        <label for="estatus">
                                            Estatus  
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Planteles</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-ver" type="checkbox" @if ($roles[28]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-crear" type="checkbox" @if ($roles[28]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="planteles-modificar" type="checkbox" @if ($roles[28]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Niveles</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-ver" type="checkbox" @if ($roles[29]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-crear" type="checkbox" @if ($roles[29]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="niveles-modificar" type="checkbox" @if ($roles[29]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Licenciaturas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-ver" type="checkbox" @if ($roles[30]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-crear" type="checkbox" @if ($roles[30]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="licenciaturas-modificar" type="checkbox" @if ($roles[30]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Sistemas</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-ver" type="checkbox" @if ($roles[31]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-crear" type="checkbox" @if ($roles[31]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="sistemas-modificar" type="checkbox" @if ($roles[31]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Grupos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-ver" type="checkbox" @if ($roles[32]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-crear" type="checkbox" @if ($roles[32]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="grupos-modificar" type="checkbox" @if ($roles[32]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Conceptos</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-ver" type="checkbox" @if ($roles[33]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-crear" type="checkbox" @if ($roles[33]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="conceptos-modificar" type="checkbox" @if ($roles[33]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>Generaciones</strong>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-ver" type="checkbox" @if ($roles[34]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-crear" type="checkbox" @if ($roles[34]->Crear == 'Y') checked="checked" @endif>
                                        <label for="crear">
                                            Crear 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="generaciones-modificar" type="checkbox" @if ($roles[34]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <h6>Configuración</h6>
                                    <div class="checkbox checkbox-primary">
                                        <input class="configuracion-ver" type="checkbox" @if ($roles[35]->Ver == 'Y') checked="checked" @endif>
                                        <label for="ver">
                                            Ver 
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input class="configuracion-modificar" type="checkbox" @if ($roles[35]->Modificar == 'Y') checked="checked" @endif>
                                        <label for="modificar">
                                            Modificar 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary float-right-button" id="guardar-p-administrativo-role">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>    
        </div>   
    </div>
</div>
@include('partials.footer')