<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8"/>
        <title>Invernadero MSICU</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />        
        <link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />
        <link rel="stylesheet" href="{{ asset("assets/stylesheets/custom.css") }}" />
        <link rel="stylesheet" href="{{ asset("assets/pace/dataurl.css") }}" >
        <link rel="stylesheet" href="{{ asset("assets/stylesheets/form-wizard.css") }}" />
        <link rel="stylesheet" href="{{ asset("assets/stylesheets/jquery.steps.css") }}" />        
        <link rel="stylesheet" href="{{ asset("assets/scripts/tabs-products/jquery-ui.css") }}" />
        <link rel="stylesheet" href="{{ asset("assets/scripts/tabs-products/tabs-products.css") }}" />        
        <link rel="stylesheet" href="{{ asset("assets/stylesheets/login/animate.css") }}" />

        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/themes/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css"/>

    </head>
    <body>
        @yield('body')
        <script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/pace/pace.min.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/wizard/jquery.steps.min.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/wizard/form-wizard.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/add.remove.elements.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/sortable/jquery.sortable.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/sortable/sortable-table.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/tabs-products/jquery-ui.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/tabs-products/tabs-products.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/add.date.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/radiobuttons.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/selectProducts.js") }}" type="text/javascript"></script>              
        <script src="{{ asset("assets/scripts/failure.js") }}" type="text/javascript"></script>

        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
        @stack('scripts')
    </body>
</html>