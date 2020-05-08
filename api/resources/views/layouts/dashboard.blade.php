@extends('layouts.plane')

@section('body')

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<div id="logo-filomedios"></div>-->
            <a class="navbar-brand" href="#">Invernadero MSICU</a>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    {{ Session::get('username') }}<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> Cambiar contraseña</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ action('UserController@deauth') }}"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li {{ (Request::is('/') ? 'class="active"' : '') }}>
                        <a href="{{ url('/') }}"><i class="fa fa-dashboard fa-fw"></i> Panel Principal</a>
                    </li>
                    @if (Session::get('readgreenhouse') == 1)
                    <li {{ (Request::is('/invernadero') ? 'class="active"' : '') }}>
                        <a href="{{ url('/invernadero') }}"><i class="fa fa-th fa-fw"></i> Invernadero</a>
                    </li>
                    @endif
                    <li {{ (Request::is('/parcelas') ? 'class="active"' : '') }}>
                        <a href="{{ url('/parcelas') }}"><i class="fa fa-leaf fa-fw"></i> Parcelas</a>
                    </li>

                    <li {{ (Request::is('/sensores') ? 'class="active"' : '') }}>
                        <a href="{{ url('/sensores') }}"><i class="fa fa-microchip  fa-fw"></i> Sensores</a>
                    </li>

                    <li {{ (Request::is('/actuadores') ? 'class="active"' : '') }}>
                        <a href="{{ url('/actuadores') }}"><i class="fa fa-toggle-on fa-fw"></i> Actuadores</a>
                    </li>

                    <li {{ (Request::is('/usuarios') ? 'class="active"' : '') }}>
                        <a href="{{ url('/usuarios') }}"><i class="fa fa-user fa-fw"></i> Usuarios</a>
                    </li>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">@yield('page_heading')</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            @yield('section')

        </div>
        <!-- /#page-wrapper -->
    </div>
<script>
    window.Engagespot={},q=function(e){return function(){(window.engageq=window.engageq||[]).push({f:e,a:arguments})}},f=["captureEvent","subscribe","init","showPrompt","identifyUser","clearUser"];for(k in f)Engagespot[f[k]]=q(f[k]);var s=document.createElement("script");s.type="text/javascript",s.async=!0,s.src="https://cdn.engagespot.co/EngagespotSDK.2.0.js";var x=document.getElementsByTagName("script")[0];x.parentNode.insertBefore(s,x);Engagespot.init('67VzxaRIwS1NciZZScbJrHHMbEWaUw');
    var data = "{{ Session::get('id') }}";
    Engagespot.identifyUser(data);
</script>
@stop
