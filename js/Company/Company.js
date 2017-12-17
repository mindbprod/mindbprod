/**
 * Actividad v.1.6.2
 * Pseudo-Class to manage all the Actividad process
 * @changelog
 *      - 1.6.2: Se reduce la cantidad de consultas para el barrio
 *      - 1.6.1: Función lambda para retornar la dirección
 *      - 1.6.0: Se agrega notificaciones y búsqueda de barrios
 *      - 1.5.1: Se agrega la verificación de si un elemento existe
 * @param {object} params Object with the class parameters
 * @param {function} callback Function to return the results
 */
var Company = function(){
    
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
    var Company = function() {
        self.div=$("#divCompany");
        setDefaults();
    }();
     
    /**************************************************************************/
    /****************************** SETUP METHODS *****************************/
    /**************************************************************************/
    /**
     * Set defaults for Actividad
     * @returns {undefined}
     */
    function setDefaults(){
        //Inicializa datatable
//       
        dataTableAct=self.div.find("#dataTableCompany").DataTable({
            oLanguage: Mbp.getDatatableLang(),
            scrollX: true
        });
        
        self.div.find("#btnEditaCmp").hide();
        self.div.find("#btnCancelaCmp").hide();
        
        self.div.find("#btnAgregaEm").click(function(){
            if(Mbp.validateEmail(self.div.find('#Email_email').val())){
                $("#email-form").append('<div><input type="text" name="email[]"  readonly value="'+self.div.find('#Email_email').val()+'"/><a href="#" class="remove_field">Remove</a></div>');
            }
            else{
                msg="Debe digitar un e-mail válido ";
            typeMsg="warn";
            $.notify(msg, typeMsg);
            }
        });
        self.div.find("#btnAgregaRsocial").click(function(){
            var name='TypeSNetwork';
            var idVal = $('input[name='+name+']:checked').attr("id");
            
//            alert($("label[for='"+idVal+"']").text());
            
            if(self.div.find('#SocialNetwork_snetwork').val()!="" && $('input[name='+name+']:checked').length){
                $("#snetw-form").append('<div><input type="text" name="snetw[]"  readonly value="'+self.div.find('#SocialNetwork_snetwork').val()+'"/><input size="10" type="text" readonly value="'+$("label[for='"+idVal+"']").text()+'"><input type="hidden" name="typesnet[]"  readonly value="'+$('input[name='+name+']:checked').val()+'"/><a href="#" class="remove_field_snet">Remove</a></div>');
            }
            else{
                msg="Debe digitar una red social y seleccionar tipo de red social ";
                typeMsg="warn";
            $.notify(msg, typeMsg);
            }
        });
        $("#email-form").on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove();
        });
        $("#snetw-form").on("click",".remove_field_snet", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove();
        });
        self.div.find("#entityreg-form #Country_country_name").on("blur",function(){
             if(self.div.find("#entityreg-form #Country_country_name").val()==""){
                 self.div.find("#entityreg-form #Country_id_country").val("");
                 self.div.find("#entityreg-form #State_state_name").val("");
                 self.div.find("#entityreg-form #State_id_state").val("");
                 self.div.find("#entityreg-form #City_city_name").val("");
                 self.div.find("#entityreg-form #City_id_city").val("");
             }
        });
        self.div.find("#entityreg-form #State_state_name").on("blur",function(){
             if(self.div.find("#entityreg-form #State_state_name").val()==""){
                 self.div.find("#entityreg-form #State_id_state").val("");
                 self.div.find("#entityreg-form #City_city_name").val("");
                 self.div.find("#entityreg-form #City_id_city").val("");
             }
        });
        self.div.find("#entityreg-form #City_city_name").on("blur",function(){
             if(self.div.find("#entityreg-form #City_city_name").val()==""){
                 self.div.find("#entityreg-form #City_id_city").val("");
             }
        });
        
//        self.div.find("#Country_id_country").change(function (){
//            if(self.div.find("#Country_id_country").val().length==0){
//                self.div.find("#State_id_state").html("<option val=''>Debe seleccionar un departamento</option>");
//            }
//            else{
//                self.searchState(self.div.find("#Country_id_country").val());
//            }
//        });
//        self.div.find("#State_id_state").change(function (){
//            if(self.div.find("#State_id_state").val().length==0){
//                self.div.find("#CityEntity_id_city").html("<option val=''>Debe seleccionar una ciudad</option>");
//            }
//            else{
//                self.searchCity(self.div.find("#State_id_state").val());
//            }
//        });
        self.div.find("#entityreg-form").change(function (){
            Mbp.estadoGuarda=true;
        });
//        self.div.find("#entity-form").keyup(function (){
//            estadoGuarda=false;
//        });
//        self.div.find("#cityEntity-form").change(function (){
//            estadoGuarda=false;
//        });
        
//        self.div.find("#Entity_id_typeent").change(function(){
//            if(self.div.find("#Entity_id_typeent").val()==1){
//                self.div.find("#entityLastName").css("display","block");
//            }
//            else{
//                self.div.find("#entityLastName").css("display","none");
//                self.div.find("#Entity_entity_lastname").val("");
//            }
//        });
//        self.div.find("#btnRegCmp").click(function(){
//            self.registerEntity();
//        });
        self.div.find("#btnRegCmp").click(function (){
           var data=self.div.find("#entityreg-form").serialize();
//           var email=self.div.find("#email-form").serialize();
           console.log(data);
//           var dataSnet=snet+'&'+email;
           self.registerCompany(data);
        });
        
        
        
//       
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    /**
     * Consume servicio para registrar la compañía o empresa
     */
    self.registerCompany=function(data){
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'registerCompany',
            data:data
        }).done(function(response) {
            
        }).fail(function(error, textStatus, xhr) {
            msg="Error al consultar los departaentos, código del error: "+error.status+" "+xhr;
            typeMsg="error";
            $.notify(msg, typeMsg);
        });
    };
    
    
    /**
     * Consume webservice createEntitypara registrar entidad
     */
    self.registerEntity=function(){
        var msg="";
        var typeMsg="";
        var dataEntity=self.div.find("#entity-form").serialize();
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'createEntity',
            data:dataEntity,
            beforeSend: function() {
                self.div.find("#entity-form #entity-form_es_").html("");                                                    
		self.div.find("#entity-form #entity-form_es_").show();
                self.div.find(".errorMessage").html("");                                                    
		self.div.find(".errorMessage").show();
                self.div.find("#btnRegEntity").hide();
            }
//            async:false
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("La sesión ha caducado, debe hacer login de nuevo", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
            }
            else{
                if(response.status=="exito"){
                    msg="Cliente registrado satisfactoriamente";
                    typeMsg="success";
//                    self.div.find("#divRegPerson").css("display","block");
                    self.div.find('#entity-form').find('input, textarea, select').attr('disabled','disabled');
                    self.div.find("#CityEntity_id_entity").val(response.idempresa);
                    estadoGuarda=true;
                }
                else{
                    msg="Revise la validación del formuario";
                    typeMsg="warn";
                    var errores="Revise lo siguiente<br/><ul>";
                    $.each(response, function(key, val) {
                        errores+="<li>"+val+"</li>";
                        $("#entity-form #"+key+"_em_").text(val);                                                    
                        $("#entity-form #"+key+"_em_").show();                                                
                    });
                    errores+="</ul>";
                    self.div.find("#entity-form #entity-form_es_").html(errores);                                                    
                    self.div.find("#entity-form #entity-form_es_").show(); 
                    self.div.find("#btnRegEntity").show();
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al crear el cliente, el código del error es: "+error.status+" "+xhr;
            typeMsg="error";
            self.div.find("#btnRegEntity").show();
        }).always(function(){
            $.notify(msg, typeMsg);
        });
         
    };
    /*
     * Filtra por Paises disponibles para realizar un autocomplet
     * @param {type} param
     */
    
    self.filterCountry=function(){
//        console.log("pasa");
        self.div.find("#entityreg-form #Country_country_name").autocomplete({
            source: function(request, response){
                $.ajax({
                    type: "POST",
                    url:"searchCountry",
                    data: {stringcountry:self.div.find("#entityreg-form #Country_country_name").val()},
                    beforeSend:function (){
                        self.div.find("#entityreg-form #Country_id_country").val("");
                    },
                    success: response,
                    dataType: 'json',
                    minLength: 1,
                    delay: 100
                });
            },
            minLength: 1,
            select: function(event, ui) {
                if(ui.item.id=="#"){
                    self.div.find("#entityreg-form #Country_id_country").val();
                }
                else{
                    self.div.find("#entityreg-form #Country_id_country").val(ui.item.id);
                }
                $(".ui-helper-hidden-accessible").hide();
            },
            html: true,
            open: function(event, ui) {
                $(".ui-autocomplete").css("z-index", 1000);
            }
        });
    };
    
    /*
     * Filtra por Estados o departamentos disponibles para realizar un autocomplet
     * @param {type} param
     */
    
    self.filterState=function(){
//        console.log("pasa");
        
            self.div.find("#entityreg-form #State_state_name").autocomplete({
                source: function(request, response){
                    $.ajax({
                        type: "POST",
                        url:"searchState",
                        data: {stringstate:self.div.find("#entityreg-form #State_state_name").val(),idcountry:self.div.find("#entityreg-form #Country_id_country").val()},
                        beforeSend:function (){
                            self.div.find("#entityreg-form #State_id_state").val("");
                            if(self.div.find("#entityreg-form #Country_id_country").val()==""&&self.div.find("#entityreg-form #Country_country_name").val()==""){
                                var msg="Debe seleccionar un País";
                                var typeMsg="warn";
                                $.notify(msg, typeMsg);
                                return false;
                            }
//                            return false;
                        },
                        success: response,
                        dataType: 'json',
                        minLength: 1,
                        delay: 100
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    if(ui.item.id=="#"){
                        self.div.find("#entityreg-form #State_id_state").val("");
                    }
                    else{
                        self.div.find("#entityreg-form #State_id_state").val(ui.item.id);
                    }
                    $(".ui-helper-hidden-accessible").hide();
                },
                html: true,
                open: function(event, ui) {
                    $(".ui-autocomplete").css("z-index", 1000);
                }
            });
        
    };
    /*
     * Filtra por ciudades disponibles para realizar un autocomplet
     * @param {type} param
     */
    
    self.filterCity=function(){
//        console.log("pasa");
        
            self.div.find("#entityreg-form #City_city_name").autocomplete({
                source: function(request, response){
                    $.ajax({
                        type: "POST",
                        url:"searchCity",
                        data: {stringcity:self.div.find("#entityreg-form #City_city_name").val(),idstate:self.div.find("#entityreg-form #State_id_state").val()},
                        beforeSend:function (){
                            self.div.find("#entityreg-form #City_id_city").val("");
                            if(self.div.find("#entityreg-form #State_id_state").val()==""&&self.div.find("#entityreg-form #State_state_name").val()==""){
                                var msg="Debe seleccionar un estado o departamento";
                                var typeMsg="warn";
                                $.notify(msg, typeMsg);
                                return false;
                            }
                        },
                        success: response,
                        dataType: 'json',
                        minLength: 1,
                        delay: 100
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    if(ui.item.id=="#"){
                        self.div.find("#entityreg-form #City_id_city").val("");
                    }
                    else{
                        self.div.find("#entityreg-form #City_id_city").val(ui.item.id);
                    }
                    $(".ui-helper-hidden-accessible").hide();
                },
                html: true,
                open: function(event, ui) {
                    $(".ui-autocomplete").css("z-index", 1000);
                }
            });
        
    };
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function() {
    window.Company=new Company();
    Company.filterCountry();
    Company.filterState();
    Company.filterCity();
});