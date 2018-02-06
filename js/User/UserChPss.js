/**
 * Usuarios v.1.6.2
 * Pseudo-Class to manage all the Usuarios process
 * @changelog
 *      - 1.6.2: Se reduce la cantidad de consultas para el barrio
 *      - 1.6.1: Función lambda para retornar la dirección
 *      - 1.6.0: Se agrega notificaciones y búsqueda de barrios
 *      - 1.5.1: Se agrega la verificación de si un elemento existe
 * @param {object} params Object with the class parameters
 * @param {function} callback Function to return the results
 */
var UserChPss = function(params,callback){
    
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    
    //DOM attributes
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        ajaxUrl:'../'
    };
    
    /**
     * Constructor Method 
     */
    var UserChPss = function() {
        self.div=$("#divUser");
        setDefaults();
    }();
     
    /**************************************************************************/
    /****************************** SETUP METHODS *****************************/
    /**************************************************************************/
    /**
     * Set defaults for Usuarios
     * @returns {undefined}
     */
    function setDefaults(){
       
       
       /*
        * Validación de formulario
        */
       // validate the comment form when it is submitted

        
        self.div.find("#changepass-form").change(function (){
            Mbp.estadoGuarda=false;
        });
        
       
        self.div.find("#btnChangePss").click(function(){            
            self.changePassword();
        });
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
  
   
     
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/      
    /**
     * Carga datos del Dispositivo seleccionado en el formulario para editar
     */
    self.changePassword=function(){
        var dataCP=$("#changepass-form").serialize();
         $.ajax({
            type: "POST",
            dataType:'json',
            url: 'changePassword',
            data:dataCP
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("The session has expired, you have to login again", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
            }
            else{
                if(response.status=="exito"){
                    msg="Password changed";
                    typeMsg="success";
                    self.div.find("#changepass-form").trigger("reset");
                    Mbp.estadoGuarda=true;
                    $(".errorMessage").hide();
                    $(".errorSummary").hide();
                    $.notify(msg, typeMsg);
                    self.loadUserData();
                }
                else{
                    if(response.status=="noexito"){
                        msg=response.msg;
                        typeMsg="warn";
                    }
                    else{
                        msg="check the form validation";
                        typeMsg="warn";
                        var errores="Check the form validation<br/><ul>";
                        $.each(response, function(key, val) {
                            errores+="<li>"+val+"</li>";
                            $("#changepass-form #"+key+"_em_").text(val);                                                    
                            $("#changepass-form #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        self.div.find("#changepass-form #userreg-form_es_").html(errores);                                                    
                        self.div.find("#changepass-form #userreg-form_es_").show(); 
                        $.notify(msg, typeMsg);
                    }
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error, contact support ";
            typeMsg="error";
            $.notify(msg, typeMsg);
        });
    }; 
   
    
    
   
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
   
};
$(document).ready(function() {
    window.UserChPss=new UserChPss();
//    Usuarios.buscaUsuarios();
});