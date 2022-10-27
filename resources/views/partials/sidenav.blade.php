<div class="app-sidebar sidebar-shadow bg-royal sidebar-text-light">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div> 
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar ps ps--active-y">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu metismenu">
                <li class="app-sidebar__heading">Información</li>
                <li>
                    <a href="{{ url('/') }}" class="mm-active">
                        <i class="metismenu-icon pe-7s-home"></i>
                        Inicio
                    </a>
                    <!--<a href="#">
                        <i class="metismenu-icon pe-7s-graph2"></i>
                        Estadísticas
                    </a>-->
                </li>
                @if (session()->get('user_roles')['Matrícula']->Ver == 'Y')
                <!--li>
                    <a href="{{ url('matricula') }}">
                        <i class="metismenu-icon pe-7s-server"></i>
                        Matrícula
                    </a>
                </li-->
                @endif

                @if (session()->get('user_roles')['Alumnos']->Ver == 'Y')
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-users"></i>
                        Alumnos
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <?php
                        $planteles = (session()->get('user_roles')['Pagos']->Plantel_id);
                        $planteles = explode(",", $planteles);
                    ?>
                    <ul class="mm-collapse">
                        <?php
                        if (in_array(1, $planteles)) {
                        ?>
                        <li>
                            <a href="{{ url('alumnos') }}?Id=1">
                                <i class="metismenu-icon">
                                </i>
                                Ceusjic - Zihuatanejo
                            </a>
                        </li>
                        <?php
                        }
                        if (in_array(3, $planteles)) {
                        ?>
                        <li>
                            <a href="{{ url('alumnos') }}?Id=3">
                                <i class="metismenu-icon">
                                </i>
                                Ceusjic - Lázaro Cárdenas
                            </a>
                        </li>
                        <?php
                        }
                        if (in_array(32, $planteles)) {
                        ?>
                        <li>
                            <a href="{{ url('alumnos') }}?Id=32">
                                <i class="metismenu-icon">
                                </i>
                                Ceusjic - Huitzuco
                            </a>
                        </li>
                        <?php
                        }
                        if (in_array(31, $planteles)) {
                        ?>
                        <li>
                            <a href="{{ url('alumnos') }}?Id=31">
                                <i class="metismenu-icon">
                                </i>
                                Ceusjic - Iguala
                            </a>
                        </li>
                        <?php
                        }
                        if (in_array(33, $planteles)) {
                        ?>
                        <li>
                            <a href="{{ url('alumnos') }}?Id=33">
                                <i class="metismenu-icon">
                                </i>
                                Ceusjic - Chilapa
                            </a>
                        </li>
                        <?php
                        }
                        if (in_array(2, $planteles)) {
                        ?>
                        <li>
                            <a href="{{ url('alumnos') }}?Id=2">
                                <i class="metismenu-icon">
                                </i>
                                Roosevelt - Zihuatanejo
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
                @endif
                @if (session()->get('user_roles')['Pagos']->Ver == 'Y')
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-cash"></i>
                        Control De Pagos
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <?php
                        $planteles = (session()->get('user_roles')['Pagos']->Plantel_id);
                        $planteles = explode(",", $planteles);
                    ?>
                    <ul class="mm-collapse">
                        <?php
                        if (in_array(1, $planteles)) {
                        ?>
                        <li>
                            <a href="#">
                                <i class="metismenu-icon">
                                </i>
                                Ceusjic - Zihuatanejo
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul class="mm-collapse">
                                <a href="{{ url('pagos') }}?Id=1">
                                    <i class="metismenu-icon">
                                    </i>
                                    Pagos
                                </a>
                                <a href="{{ url('controlpagos') }}?Id=1">
                                    <i class="metismenu-icon">
                                    </i>
                                    Control
                                </a>
                                <a href="{{ url('titulaciones') }}?Id=1">
                                    <i class="metismenu-icon">
                                    </i>
                                    Titulación
                                </a>
                            </ul>
                        </li>
                        <?php
                        }
                        if (in_array(3, $planteles)) {
                        ?>
                        <li>
                            <a href="#">
                                <i class="metismenu-icon">
                                </i>
                                Ceusjic - Lázaro C.
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul class="mm-collapse">
                                <a href="{{ url('pagos') }}?Id=3">
                                    <i class="metismenu-icon">
                                    </i>
                                    Pagos
                                </a>
                                <a href="{{ url('controlpagos') }}?Id=3">
                                    <i class="metismenu-icon">
                                    </i>
                                    Control
                                </a>
                                <a href="{{ url('titulaciones') }}?Id=3">
                                    <i class="metismenu-icon">
                                    </i>
                                    Titulación
                                </a>
                            </ul>
                        </li>
                        <?php
                        }
                        if (in_array(32, $planteles)) {
                        ?>
                        <li>
                            <a href="{{ url('controlpagos') }}?Id=32">
                                <i class="metismenu-icon">
                                </i>
                                Ceusjic - Huitzuco
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul class="mm-collapse">
                                <a href="{{ url('pagos') }}?Id=32">
                                    <i class="metismenu-icon">
                                    </i>
                                    Pagos
                                </a>
                                <a href="{{ url('controlpagos') }}?Id=32">
                                    <i class="metismenu-icon">
                                    </i>
                                    Control
                                </a>
                                <a href="{{ url('titulaciones') }}?Id=32">
                                    <i class="metismenu-icon">
                                    </i>
                                    Titulación
                                </a>
                            </ul>
                        </li>
                        <?php
                        }
                        if (in_array(31, $planteles)) {
                        ?>
                        <li>
                            <a href="#">
                                <i class="metismenu-icon">
                                </i>
                                Ceusjic - Iguala
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul class="mm-collapse">
                                <a href="{{ url('pagos') }}?Id=31">
                                    <i class="metismenu-icon">
                                    </i>
                                    Pagos
                                </a>
                                <a href="{{ url('controlpagos') }}?Id=31">
                                    <i class="metismenu-icon">
                                    </i>
                                    Control
                                </a>
                                <a href="{{ url('titulaciones') }}?Id=31">
                                    <i class="metismenu-icon">
                                    </i>
                                    Titulación
                                </a>
                            </ul>
                        </li>
                        <?php
                        }
                        if (in_array(33, $planteles)) {
                        ?>
                        <li>
                            <a href="#">
                                <i class="metismenu-icon">
                                </i>
                                Ceusjic - Chilapa
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul class="mm-collapse">
                                <a href="{{ url('pagos') }}?Id=33">
                                    <i class="metismenu-icon">
                                    </i>
                                    Pagos
                                </a>
                                <a href="{{ url('controlpagos') }}?Id=33">
                                    <i class="metismenu-icon">
                                    </i>
                                    Control
                                </a>
                                <a href="{{ url('titulaciones') }}?Id=33">
                                    <i class="metismenu-icon">
                                    </i>
                                    Titulación
                                </a>
                            </ul>
                        </li>
                        <?php
                        }
                        if (in_array(2, $planteles)) {
                        ?>
                        <li>
                            <a href="#">
                                <i class="metismenu-icon">
                                </i>
                                Roosevelt - Zihuatanejo
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul class="mm-collapse">
                                <a href="{{ url('pagos') }}?Id=2">
                                    <i class="metismenu-icon">
                                    </i>
                                    Pagos
                                </a>
                                <a href="{{ url('controlpagos') }}?Id=2">
                                    <i class="metismenu-icon">
                                    </i>
                                    Control
                                </a>
                            </ul>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
                @endif

                @if (session()->get('user_roles')['Becas']->Ver == 'Y')
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Becas
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse">
                        <li>
                            <a href="{{ url('becas') }}">
                                <i class="metismenu-icon">
                                </i>Ver Becas
                            </a>
                        </li>
                        @if (session()->get('user_roles')['Becas']->Crear == 'Y')
                        <li>
                            <a href="{{ url('becas/new') }}">
                                <i class="metismenu-icon">
                                </i>Nueva Beca
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (session()->get('user_roles')['Planteles']->Ver == 'Y')
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-culture"></i>
                        Planteles
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse">
                        <li>
                            <a href="{{ url('planteles') }}">
                                <i class="metismenu-icon">
                                </i>Ver Planteles
                            </a>
                        </li>
                        @if (session()->get('user_roles')['Planteles']->Crear == 'Y')
                        <li>
                            <a href="{{ url('planteles/new') }}">
                                <i class="metismenu-icon">
                                </i>Nuevo Plantel
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (session()->get('user_roles')['Niveles']->Ver == 'Y')
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-graph1"></i>
                        Niveles
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse">
                        <li>
                            <a href="{{ url('niveles') }}">
                                <i class="metismenu-icon">
                                </i>Ver Niveles
                            </a>
                        </li>
                        @if (session()->get('user_roles')['Niveles']->Crear == 'Y')
                        <li>
                            <a href="{{ url('niveles/new') }}">
                                <i class="metismenu-icon">
                                </i>Nuevo Nivel
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (session()->get('user_roles')['Licenciaturas']->Ver == 'Y')
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-study"></i>
                        Licenciaturas
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse">
                        <li>
                            <a href="{{ url('licenciaturas') }}">
                                <i class="metismenu-icon">
                                </i>Ver Licencituras
                            </a>
                        </li>
                        @if (session()->get('user_roles')['Licenciaturas']->Crear == 'Y')
                        <li>
                            <a href="{{ url('licenciaturas/new') }}">
                                <i class="metismenu-icon">
                                </i>Nueva Licenciatura
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (session()->get('user_roles')['Sistemas']->Ver == 'Y')
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-notebook"></i>
                        Sistemas
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse">
                        <li>
                            <a href="{{ url('sistemas') }}">
                                <i class="metismenu-icon">
                                </i>Ver Sistemas
                            </a>
                        </li>
                        @if (session()->get('user_roles')['Sistemas']->Crear == 'Y')
                        <li>
                            <a href="{{ url('sistemas/new') }}">
                                <i class="metismenu-icon">
                                </i>Nuevo Sistema
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (session()->get('user_roles')['Grupos']->Ver == 'Y')
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-network"></i>
                        Grupos
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse">
                        <li>
                            <a href="{{ url('grupos') }}">
                                <i class="metismenu-icon">
                                </i>Ver Grupos
                            </a>
                        </li>
                        @if (session()->get('user_roles')['Conceptos']->Crear == 'Y')
                        <li>
                            <a href="{{ url('grupos/new') }}">
                                <i class="metismenu-icon">
                                </i>Nuevo Grupo
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (session()->get('user_roles')['Conceptos']->Ver == 'Y')
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-note2"></i>
                        Conceptos
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse">
                        <li>
                            <a href="{{ url('conceptos') }}">
                                <i class="metismenu-icon">
                                </i>Ver Conceptos
                            </a>
                        </li>
                        @if (session()->get('user_roles')['Conceptos']->Crear == 'Y')
                        <li>
                            <a href="{{ url('conceptos/new') }}">
                                <i class="metismenu-icon">
                                </i>Nuevo Concepto
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (session()->get('user_roles')['Generaciones']->Ver == 'Y')
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-gleam"></i>
                        Generaciones
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse">
                        <li>
                            <a href="{{ url('generaciones') }}">
                                <i class="metismenu-icon">
                                </i>Ver Generaciones
                            </a>
                        </li>
                        @if (session()->get('user_roles')['Generaciones']->Crear == 'Y')
                        <li>
                            <a href="{{ url('generaciones/new') }}">
                                <i class="metismenu-icon">
                                </i>Nueva Generación
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (session()->get('user_roles')['Configuración']->Ver == 'Y')
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-config"></i>
                        Configuración
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse">
                        <li>
                            <a href="{{ url('usuarios') }}">
                                <i class="metismenu-icon pe-7s-id"></i>
                                Usuarios
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('roles') }}">
                                <i class="metismenu-icon">
                                </i>Roles
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>