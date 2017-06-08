<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->


        <!-- search form (Optional) -->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Produccion</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>{{ trans('adminlte_lang::message.home') }}</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa  fa-building-o'></i> <span>PRODUCTOS</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('registrarproducto')}}"><i class="fa fa-plus-square"></i>REGISTRAR</a></li>
                    <li><a href="{{url('editarproductos')}}"><i class="fa fa-eraser"></i>EDITAR</a></li>
                    <li><a  href="{{url('buscarproductos')}}"><i class='fa  fa-search'></i> <span>BUSCAR</span></a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-users'></i> <span>CLIENTES</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('registrarcliente')}}"><i class="fa fa-user-plus"></i>REGISTAR</a></li>
                    <li><a href="{{url('clientes')}}"><i class="fa fa-user-times"></i>EDITAR</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-calendar-o'></i> <span>PEDIDOS</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('registrarpedido')}}">REGISTAR</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-exchange'></i> <span>MOVIMIENTOS</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('registrarmovimiento')}}"><i class="fa fa-plus"></i>Registrar</a></li>
                    <li><a href="{{ url('buscarmovimiento')}}"><i class="fa fa-search"></i>Buscar</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-exchange'></i> <span>INVENTARIO</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('inventario')}}"><i class="fa fa-plus"></i>Buscar</a></li>
                    <li><a href="{{ url('bodegas')}}"><i class="fa fa-search"></i>Buscar</a></li>
                </ul>
            </li>

            @if(Auth::user()->id_perfil==1)

                        <li class="treeview">
                            <a href="#"><i class='fa fa-industry'></i> <span>BODEGAS</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="{{ url('registarbodega')}}">REGISTAR</a></li>
                                <li><a href="{{ url('editarbodega')}}">EDITAR</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"><i class='fa fa-industry'></i> <span>CATEGORIAS</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="{{url('registarcategoria')}}">REGISTAR</a></li>
                                <li><a href="{{url('editarcategoria')}}">EDITAR</a></li>
                                <li><a href="{{url('categorias')}}">BUSCAR</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#"><i class='fa fa-child'></i> <span>USUARIOS</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                            <li><a  href="{{ url('usuarios')}}"><i class='fa  fa-users'></i> <span>Buscar</span></a></li>
                        <li><a  href="{{ url('registrarusuario')}}"><i class='fa fa-user-plus'></i><span>Registrar</span></a></li>
                            </ul>
                        </li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
