
            $(document).ready(function() {
                $("#wizard").steps({
                    onStepChanging: function(event, currentIndex, newIndex){
                        var result = false;
                        
                        if (newIndex<currentIndex) {
                            result = true;
                        }else{
                            switch(currentIndex){
                            case 0:
                            //Comprobación en el primer paso
                             if (selectedTr === null) {
//                                    alert("Seleccione un empleado para continuar");
                                    $("#form_message_choose_customer").html("");
                                    $("#form_message_choose_customer").html('<p class="fadeIn animated alert alert-danger">Seleccione un cliente para continuar</p>');
                                   result = false;
                               }else{
                                   result = true;
                               };
                            break;

                            case 1:
                            //Comprobación en el segundo paso
                                if (productsRegistered.length == 0) {
//                                    alert("Debe agregar productos para poder continuar");
                                    $("#form_message_add_product").html("");
                                    $("#form_message_add_product").html('<p class="fadeIn animated alert alert-danger">Agregue productos para poder continuar</p>');
                                    result = false;
                                } else{                                    
                                    if (isAllProgramsFine) {
                                        result = true;                                        
                                    }else{
                                        result = false;
//                                        alert("Debe definir todos los programas necesarios");
                                        $("#form_message_add_product").html("");
                                        $("#form_message_add_product").html('<p class="fadeIn animated alert alert-danger">Debe definir todos los programas necesarios</p>');
                                    };
                                };
                            break;

                            default:
                                result = false; 
                            break;                           
                            };
                        };

                        return result;

                    },
                    onStepChanged: function(event, currentIndex, priorIndex){

                    },
                    onFinishing: function(event, currentIndex){                
                        finished = sendServiceOrder();   
                        return finished;                    
                    },
                    onFinished: function(event, currentIndex){
                        if(finished){
                            window.location.href = valueToReturn;
                        }                        
                        //Cargar nuevamente la pagina o enviar a gestor de ordenes
                    }
                })
            });
        