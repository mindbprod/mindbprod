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
var User = function(params,callback){
    
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
    var dataTableUsuer;
    
    
    /**
     * Constructor Method 
     */
    var User = function() {
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
       
       dataTableUsuer=self.div.find("#dataTableUser").DataTable({
            oLanguage: Mbp.getDatatableLang(),
            scrollX: true,
//            scrollY: 400
        });
       /*
        * Validación de formulario
        */
       // validate the comment form when it is submitted

        
        self.div.find("#userreg-form").change(function (){
            Mbp.estadoGuarda=false;
        });
        
        self.div.find("#btnRegUser").click(function(){
            self.registerUser();
//            console.log("guarda");
        });
        
        self.div.find("#btnEditUser").css("display","none");
        
        
        self.div.find("#btnEditaUsuario").click(function(){
//            self.div.find("#idUsuario").rules('add',{
//                ignore:"",
//                required: true,
//                messages: {
//                    required: "No hay un id de usuario, vuelva a cargar el formulario"
//                }}
//            );
//            if (self.div.find(".formUsuario").valid()) {
//                 self.editaUsuario();
//            }
        });
        
        self.div.find("#btnCancel").css("display","none");
        
        self.div.find("#btnCancelEdicion").click(function(){            
//            self.cancelaEdicion();
        });
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
  
    /**
     * Carga noticia seleccionada en el formulario para editar
     */
    self.cargaUsuarioAForm=function(idUsuario){
        self.div.find("#btnCreaUsuario").css("display","none");
        self.div.find("#btnEditaUsuario").css("display","block");
        self.div.find("#btnCancelEdicion").css("display","block");
        $.each(self.arrayUsuarios,function(key,value){
            if(value.id_user==idUsuario){
                self.div.find(".formUsuario #userName").val(value.username);
                self.div.find(".formUsuario #idUsuario").val(value.id_user);
                self.div.find(".formUsuario #nombresUsuario").val(value.nombres);
                self.div.find(".formUsuario #apellidosUsuario").val(value.apellidos);
                self.div.find(".formUsuario #numDocUsuario").val(value.numero_documento);
                self.div.find(".formUsuario #emailUsuario").val(value.email);
                if(value.activo==1){
                    self.div.find(".formUsuario #activoUsuario").attr("checked",true);
                }
                else if(value.activo==2){
                    self.div.find(".formUsuario #noActivoUsuario").attr("checked",true);
                }
            }
        });
    };  
     
    /**
     * Envía formulario a servicio para crear noticia
     */
    self.registraUsuario=function (){
        console.debug("Crea usuario "+self.div.find(".formUsuario").serialize());
        self.div.find(".formUsuario").trigger("reset");
        self.div.find(".formUsuario #activoUsuario").attr("checked",false);
        self.div.find(".formUsuario #noActivoUsuario").attr("checked",false);
        
    };
    
    /**
     * Cancela edición de noticia y vuelve a botón de crear noticia
     */
    self.cancelaEdicion=function(){
        self.div.find("#btnCreaUsuario").css("display","block");
        self.div.find("#btnEditaUsuario").css("display","none");
        self.div.find("#btnCancelEdicion").css("display","none");
        self.div.find(".formUsuario").trigger("reset");
    };
    self.changeStatePre=function(state,personid){
        $.confirm({
            title: 'Confirm!',
            content: 'Are you shure you want to disable this user '+personid+'?',
            buttons: {
                confirm: function () {
                    self.changeState(state,personid);
                },
                cancel: function () {
                    return;
                }
            }
        });
    };
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/   
     /**
     * Carga datos del Dispositivo seleccionado en el formulario para editar
     */
    self.changeState=function(state,personid){
         $.ajax({
            type: "POST",
            dataType:'json',
            url: 'changeState',
            data:{"state":state,"personid":personid}
            
//            async:false
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("The session has expired, you have to login again", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
            }
            else{
                if(response.status=="exito"){
                    msg=response.msg;
                    typeMsg="success";
                    self.loadUserData();
                }
                else{
                    if(response.status=="noexito"){
                         msg=response.msg;
                        typeMsg="warn";
                    }
                    
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error, contact support ";
            typeMsg="error";
        }).always(function(){
            $.notify(msg, typeMsg);
        });
    }; 
    /**
     * Consume servicio para registrar un usuario
     */
    self.registerUser=function(){
        var data=$("#userreg-form").serialize();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'registerUser',
            data:data
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("The session has expired, you have to login again", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                Mbp.estadoGuarda=true;
                return;
            }
            else{
                if(response.status=="exito"){
                    msg="User saved";
                    typeMsg="success";
                    self.div.find("#userreg-form").trigger("reset");
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
                            $("#userreg-form #"+key+"_em_").text(val);                                                    
                            $("#userreg-form #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        self.div.find("#userreg-form #userreg-form_es_").html(errores);                                                    
                        self.div.find("#userreg-form #userreg-form_es_").show(); 
                        $.notify(msg, typeMsg);
                    }
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error, contact support";
            typeMsg="error";
            $.notify(msg, typeMsg);
        }).always(function(){
            self.div.find("#btnRegUser").show();
        });
    };
    self.eliminaUsuario=function(idUsuario){
        if(idUsuario===""){
            notif({
                type: "warning",
                msg: "Id de usuario no definida",
                position: "center",
                clickable: true
            });
            return;
        }
        else{
            var msg = confirm("Realmente desea eliminar el usuario?");
            if(msg===true){
                var msn="";
                var type="";
//                var dataPost="Usuario[id_user]="+idUsuario;
                var dataPost = new FormData();
                dataPost.append( "ajax", "1");
                dataPost.append( "Usuario[id_user]",idUsuario);
                $.ajax({
                    type:"POST",
                    dataType:'json',
                    data:dataPost,
                    url: 'eliminaUsuario',
                    cache: false,
                    contentType: false,
                    processData: false,
                    async:false
                }).done(function(response) {
                    if(response.status=='nosession'){
                        notif({
                            type: "warning",
                            msg: "la sesión ha caducado, ingrese de nuevo",
                            position: "center",
                            clickable: true
                        });
                        setTimeout(function(){document.location.href="site/login";}, 3000);
                        return;
                    }
                    else{
                        if(response.status=='success'){ 
                             type="info";
                             dataTableUsuer.ajax.reload();
                             msn=response.msg;
                        }
                        else if(response.status=='no success'){
                             type="error";
                             msn=response.msg; 
                        }
                    }
                }).fail(function(error) {
                    msn="Error al eliminar el usuario, intente de nuevo";
                    type="error";
                });
                notif({
                    type: type,
                    msg: msn,
                    position: "center",
                    clickable: true
                });
            }
        }
    };
    /**
     * Envía formulario a servicio para editar noticia
     */
    self.editaUsuario=function (){
        console.debug("Edita usuario "+self.div.find(".formUsuario").serialize());
        $.ajax({
            type: "POST",
            dataType:'json',
            url:IcetexApp.urlServiceYii+'index.php/usuarios/update',
            async:false,
            data:self.div.find(".formUsuario").serialize()
        }).done(function(data) {
            if(data.status=="true"){
                notif({
                    type: "info",
                    msg: "Datos de usuario modificados satisfactoriamente.",
                    position: "center",
                    clickable: true
                });
                self.div.find("#btnCreaUsuario").css("display","block");
                self.div.find("#btnEditaUsuario").css("display","none");
                self.div.find("#btnCancelEdicion").css("display","none");
                self.div.find(".formUsuario").trigger("reset");
                self.div.find(".formUsuario #activoUsuario").attr("checked",false);
                self.div.find(".formUsuario #noActivoUsuario").attr("checked",false);
            }
            else{
                notif({
                    type: "error",
                    msg: data.response,
                    position: "center",
                    width: 500,
                    height: 60,
                    clickable: true,
                    autohide: false
                });
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            IcetexApp.showErrorsAjax(jqXHR, textStatus, errorThrown);
        });
    };
    /*
    * Carga datos de dispositivo seleccionado al datatable
    * @param array data
    * @returns N.A
    */ 
    self.loadUserData=function(){
        var state;
        var codeState;
        var actualState;
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'listUsers'
//            async:false
        }).done(function(response) {
//            console.log(JSON.stringify(response));
            dataTableUsuer.clear();
            $.each(response,function(key,value){
//                console.log(value.usuario_activo);
                if(value.active_user==1){
                    state=2;
                    codeState="To disable";
                    actualState="Enabled";
                }
                else{
                    state=1;
                    codeState="To enable";
                    actualState="Disabled";
                }
                dataTableUsuer.row.add([
                    value.person_id,
                    value.person_name,
                    value.person_lastname,
                    value.typeuser_name,
                    value.username,
                    actualState,
                    "<a href=javascript:User.changeStatePre('"+state+"','"+value.person_id+"');>"+codeState+"</a>"
                ]).draw();
            });
        }).fail(function(error, textStatus, xhr) {
            msg="Error, can not change user state, contact personal suport: "+error.status+" "+xhr;
            typeMsg="error";
            $.notify(msg, typeMsg);
        });
//        self.arrayDevice=data;
//            
    };
    
    /**
     * Consume webservice de consulta de usuarios y 
     * devuelve un objeto json con todas ellas
     */
    self.buscaUsuarios=function(){
//        //User.showLoading();
//        $.ajax({
//            type: "POST",
//            dataType:'json',
//            url: 'cargaUsuarios',
//            async:false
//        }).done(function(response) {
//            self.arrayUsuarios=response.data;
//            dataTableUsuer.clear();
//            $.each(response.data,function(key,value){
//                dataTableUsuer.row.add([
//                    "<img src='"+value.imagen_url+"' height='42' width='80'>",
//                    value.nombres,
//                    value.apellidos,
//                    value.numero_documento,
//                    value.nombre,
//                    value.email,
//                    value.profesion,
//                    value.nacimiento,
//                    value.activo,
//                    "<a href='javascript:Usuarios.eliminaUsuario("+value.id_user+");'>Eliminar</a>"
//                ]).draw();
//            });
//        }).fail(function(error) {
//            if(error.status===403){
////                Usuarios.alertUsuarios("Su sesión ha terminado, por favor ingrese de nuevo.");
////                window.location=User.ajaxUrl;
//            }else{
////                if(callback)callback(error);
//            }
//        }).always(function(){
//            //User.hideLoading();
//        });
        dataTableUsuer=self.div.find("#dataTableUsuarios").DataTable({
            "bProcessing": true,
            "serverSide": true,
            "ajax":{
                url :"cargaUsuariosDataTable", // json datasource
                type: "post",  // type of method  ,GET/POST/DELETE
                error: function(){
                    console.debug("error");
                }
            },
            oLanguage: IcetexApp.getDatatableLang(),
            scrollX: true
        });  
    };
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
     
    /**
     * Consume webservice de consulta de usuarios y 
     * devuelve un objeto json con todas ellas
     */
    self.buscaUsuariosWSLocal=function(){
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: IcetexApp.urlService+'codeigniter/index.php/convenios/',
            async:false
        }).done(function(response) {
            self.arrayUsuarios=response.data;
            $.each(response.data,function(key,value){
                self.div.find("#dataTableUsuarios tbody").append("\
                <tr>\
                    <td><img src="+value.imagen_url+" height='42' width='80'> </td>\
                    <td>"+value.nombres+"</td>\
                    <td>"+value.apellidos+"</td>\
                    <td>"+value.numero_documento+"</td>\
                    <td>"+value.nombre+"</td>\
                    <td>"+value.email+"</td>\
                    <td>"+value.profesion+"</td>\
                    <td>"+value.nacimiento+"</td>\
                    <td>"+value.activo+"</td>\
                    <td><a href='javascript:Usuarios.cargaUsuarioAForm("+value.id_user+");'>Editar</a></td>\
                </tr>");
            });
        }).fail(function(error) {
            if(error.status===403){
//                Usuarios.alertUsuarios("Su sesión ha terminado, por favor ingrese de nuevo.");
//                window.location=User.ajaxUrl;
            }else{
//                if(callback)callback(error);
            }
        }).always(function(){
            //User.hideLoading();
        });
         self.div.find("#dataTableUsuarios").DataTable({
            oLanguage: IcetexApp.getDatatableLang(),
            scrollX: true,
            scrollY: "300px"
            
        });
    };
    
    
    /**
     * Consume webservice de consulta local de noticias y 
     * devuelve un objeto json con todas ellas 
     */
    self.buscaUsuariosLocal=function(){
        data=[{"id_user":"296","username":"julian1","pswd":"009d9f1d34cbb1ae66e77fbd114143a85967b77748d68286eaec2cf0d64f1ca1","id_facebook":null,"id_twitter":null,"id_google":null,"numero_documento":"97102414890","email":"montoyacaicedo@gmail.com","id_universidades":"2905","profesion":"ESPECIALIZACION DE CONDUCCION Y ADMINISTRACION DE UNIDADES MILITARES","nacimiento":"8\/30\/2016,","empresa":"","descripcion":null,"puntos":"0","imagen_url":"https:\/\/comunidad.icetex.gov.co\/api\/webservice\/uploads\/Zaz sur scene.jpg","genero":"1","id_tipoDocumento":"1","nombres":"Julian","apellidos":"Montoya","id_rol":null,"geo_posicion":null,"direccion":"","id_convenios":null,"email_solidario":"lozano.cardona@gmail.com","confirmacion":"confirmado","activo":"1","create_ad":"2016-09-13 09:34:15","personal_data_treatment":"1","nombre":"TARJETA DE IDENTIDAD"}];
        self.arrayUsuarios=data;
        $.each(data,function(key,value){
            self.div.find("#dataTableUsuarios tbody").append("\
            <tr>\
                <td><img src="+value.imagen_url+" height='42' width='80'> </td>\
                <td>"+value.nombres+"</td>\
                <td>"+value.apellidos+"</td>\
                <td>"+value.numero_documento+"</td>\
                <td>"+value.nombre+"</td>\
                <td>"+value.email+"</td>\
                <td>"+value.profesion+"</td>\
                <td>"+value.nacimiento+"</td>\
                <td>"+value.activo+"</td>\
                <td><a href='javascript:Usuarios.cargaUsuarioAForm("+value.id_user+");'>Editar</a></td>\
            </tr>");
        });
        self.div.find("#dataTableUsuarios").DataTable({
            oLanguage: IcetexApp.getDatatableLang(),
            scrollX: true,
            scrollY: 400
        });
    };
    
   
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
   
};
$(document).ready(function() {
    window.User=new User();
//    Usuarios.buscaUsuarios();
});