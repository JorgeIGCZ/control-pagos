@include('partials.header')        
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-home icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Panel de control
                    </div>  
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">

                <div class="col-md-12">
                    <div class="container">
                        <ul class="tabs-animated-shadow tabs-animated nav nav-justified tabs-rounded-lg">
                            <li class="nav-item">
                                <a class="nav-link" href="/alumnos/new">
                                    <span>Nuevo Alumno</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/pagos">
                                    <span>Pagos (Corte Caja)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/controlpagos">
                                    <span>Control Pagos</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-4">
                    <div class="card mt-3 mb-3 widget-content">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total De Estudiantes</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-primary"><span>{{$alumnos[0]->Alumnos}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-4">
                    <div class="card mt-3 mb-3 widget-content">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading">Estudiantes Activos</div>
                                <div class="widget-subheading">Numero de estudiantes </div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-success"><span>{{$alumnosActivos[0]->Alumnos}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-4">
                    <div class="card mt-3 mb-3 widget-content">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading">Estudiantes Inactivos</div>
                                <div class="widget-subheading">Numero de estudiantes </div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-danger"><span>{{$alumnosInactivos[0]->Alumnos}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider mt-0" style="margin-bottom: 30px;"></div>
                @if (session()->get('user_roles')['role'] === 'Administrador')
                    <div class="col-md-6">
                        <div id="accordion" class="accordion-wrapper mb-3">
                            <div class="card">
                                <div id="headingRecaudacion" class="card-header">
                                    <button type="button" data-toggle="collapse" data-target="#collapseRecaudacion" aria-expanded="true" aria-controls="collapseOne" class="card-header-title text-left m-0 p-0" style="">
                                        <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                                        Reporte de Recaudación
                                    </button>
                                </div>
                                <div data-parent="#accordion" id="collapseRecaudacion" aria-labelledby="headingRecaudacion" class="collapse" style="">
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Recaudación total mensual</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers text-primary">${{ number_format($recaudacionMensualTotal,2) }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Recaudación bancaria</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers text-success">${{ number_format($recaudacionMensualBancaria,2) }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Recaudación en efectivo</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers text-success">${{ number_format($recaudacionMensualEfectivo,2) }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="divider mt-0" style="margin-bottom: 30px;"></div>
                <!--
                <div class="col-md-6">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                                    </div>
                                </div>
                                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0">
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title">Vista Mensual</h5>
                            <canvas id="chart-horiz-bar" height="494" width="990" class="chartjs-render-monitor" style="display: block; height: 247px; width: 495px;"></canvas>
                        </div>
                    </div>
                </div>
                -->
            </div>    
        </div>   
    </div>
</div>
@include('partials.footer')