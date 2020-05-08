@extends ('layouts.plane')
@section ('body')
    <link rel="stylesheet" href="{{ asset("assets/stylesheets/login/login.css") }}" />
    <link rel="stylesheet" href="{{ asset("assets/stylesheets/login/style.css") }}" />

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <form class="m-t" role="form" id="login">
            <div class="form-group">
                <input class="form-control" placeholder="Username" name="username" type="username" id="username" autofocus >
            </div>
            <div class="form-group">
                <input class="form-control" placeholder="Contraseña" name="password" type="password" id="password" value="" >
            </div>
            {{ Form::submit('Aceptar',['class' => 'btn btn-primary block full-width m-b']) }}
        </form>
    </div>

    @push('scripts')
    <script type="text/javascript">
        function login(){
            var data = {
                "username" : $('#username').val(),
                "password" : $('#password').val()
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:   "{{ action('UserController@auth') }}",
                data: data,
                type:  'post',
                success:  function (response) {
                    alertify.notify(response.message);
                    window.location.href = "{{ url('/') }}";   
                },
                error: function(response) { 
                    alertify.notify(response.responseJSON.message);               
                }
            });
        };

        $(document).ready(function() { 
            alertify.set('notifier','position', 'top-left'); 
            alertify.set('notifier','delay', 10);                              
            $('#login').submit(function () {
                login();
                return false;
            });                          
        });
    </script>  
    @endpush      
@stop