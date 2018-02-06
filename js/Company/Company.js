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
     
    self.tableName="";
    self.columnName="";
    self.valueContent="";
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
            scrollX: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        dataTableShowDataCmp=self.div.find("#dataTableShowDataCmp").DataTable({
            oLanguage: Mbp.getDatatableLang(),
            scrollX: true,
            responsive: true,
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'print'
            ],
            "lengthMenu": [[10, 25, 50], [10, 25, 50]]
        });
        self.dataToEdit=[];
        self.div.find("#btnEditaCmp").hide();
        self.div.find("#btnCancelaCmp").hide();
        
        $("#entityedit-form #btnAgregaEmEdit").click(function(){
            if(Mbp.validateEmail($('#entityedit-form #input_email').val())){
                $("#email-form").append('<div><input type="text" name="email[]"  readonly value="'+$('#entityedit-form #input_email').val()+'"/><a href="#" class="remove_field">Remove</a></div>');
            }
            else{
                msg="You have to type a valid email   ";
                typeMsg="warn";
            $.notify(msg, typeMsg);
            }
        });
        $("#entityedit-form #btnAgregaRsocialEd").click(function(){
            var name='TypeSNetwork';
            var idVal = $('input[name='+name+']:checked').attr("id");
            
//            alert($("label[for='"+idVal+"']").text());
            
            if(self.div.find('#input_snet').val()!="" && $('input[name='+name+']:checked').length){
                $("#snetw-form").append('<div><input type="text" name="snetw[]"  readonly value="'+$('#entityedit-form #input_snet').val()+'"/><input size="10" type="text" readonly value="'+$("label[for='"+idVal+"']").text()+'"><input type="hidden" name="typesnet[]"  readonly value="'+$('input[name='+name+']:checked').val()+'"/><a href="#" class="remove_field_snet">Remove</a></div>');
            }
            else{
                msg="You have to type a social network and select a social network type ";
                typeMsg="warn";
            $.notify(msg, typeMsg);
            }
        });
        
        
        self.div.find("#btnAgregaEm").click(function(){
            if(Mbp.validateEmail(self.div.find('#input_email').val())){
                $("#email-form").append('<div><input type="text" name="email[]"  readonly value="'+self.div.find('#input_email').val()+'"/><a href="#" class="remove_field">Remove</a></div>');
            }
            else{
                msg="You have to type a valid email  ";
                typeMsg="warn";
            $.notify(msg, typeMsg);
            }
        });
        self.div.find("#Web_web").on('blur',function(){
            if(self.div.find("#Web_web").val()!=""){
                if(!Mbp.validateUrl(self.div.find("#Web_web").val())){
                    msg="You have to type a valid web ";
                    typeMsg="warn";
                    $.notify(msg, typeMsg);
                }
            }
        });
        self.div.find("#btnAgregaRsocial").click(function(event){
            var name='TypeSNetwork';
            
//            alert($("label[for='"+idVal+"']").text());
            
            if(self.div.find('#input_snet').val()!="" && $('input[name='+name+']:checked').length){
                var idVal = $('input[name='+name+']:checked').attr("id");
                if(!Mbp.validateSNetwork($("label[for='"+idVal+"']").text(),self.div.find('#input_snet').val())){
                    msg="You have to type a valid "+$("label[for='"+idVal+"']").text();
                        typeMsg="warn";
                        $.notify(msg, typeMsg);
                        return false;
                }
                    $("#snetw-form").append('<div><input type="text" name="snetw[]"  readonly value="'+self.div.find('#input_snet').val()+'"/><input size="10" type="text" readonly value="'+$("label[for='"+idVal+"']").text()+'"><input type="hidden" name="typesnet[]"  readonly value="'+$('input[name='+name+']:checked').val()+'"/><a href="#" class="remove_field_snet">Remove</a></div>');
            
            }
            else{
                msg="You have to type a social network and select a social network type  ";
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
        
        self.div.find("#entitysearch-form #Company_city").on("keydown",function(e){
            if(e.which==8){
                self.div.find("#entitysearch-form #Company_id_city").val("");
             }
        });
        self.div.find("#entitysearch-form #Company_country").on("keydown",function(e){
            if(e.which==8){
                self.div.find("#entitysearch-form #Company_id_country").val("");
             }
        });
        /* <manage places content*/
        self.div.find("#entityedit-form #Continent_continent_name").on("keydown",function(e){
             if(e.which==8){
                $("#entityedit-form #Continent_id_continent").val("");
                localStorage.setItem("saveContinent", 0);
             }
        });
        self.div.find("#entityedit-form #Country_country_name").on("keydown",function(e){
             if(e.which==8){
                 console.log("borra");
                $("#entityedit-form #Country_id_country").val("");
                localStorage.setItem("saveCountry", 0);
             }
        });
        self.div.find("#entityedit-form #State_state_name").on("keydown",function(e){
             if(e.which==8){
                $("#entityedit-form #State_id_state").val("");
                localStorage.setItem("saveState", 0);
             }
        });
        self.div.find("#entityedit-form #City_city_name").on("keydown",function(e){
             if(e.which==8){
                $("#entityedit-form #City_id_city").val("");
                localStorage.setItem("saveCity", 0);
             }
        });
        /* manage places content >*/
        
        self.div.find("#entityreg-form #Continent_continent_name").on("keydown",function(e){
             if(e.which==8){
                self.div.find("#entityreg-form #Continent_id_continent").val("");
                localStorage.setItem("saveContinent", 0);
             }
        });
        self.div.find("#entityreg-form #Continent_continent_name").on("blur",function(e){
             if(self.div.find("#entityreg-form #Continent_id_continent").val()==""&&localStorage.getItem("saveContinent")==0){
                self.div.find("#entityreg-form #Continent_continent_name").val("");
             }
        });
        self.div.find("#entityreg-form #Country_country_name").on("keydown",function(e){
             if(e.which==8){
                self.div.find("#entityreg-form #Country_id_country").val("");
                localStorage.setItem("saveCountry", 0);
             }
        });
        self.div.find("#entityreg-form #Country_country_name").on("blur",function(e){
             if(self.div.find("#entityreg-form #Country_id_country").val()==""&&localStorage.getItem("saveCountry")==0){
                self.div.find("#entityreg-form #Country_country_name").val("");
             }
        });
        
        self.div.find("#entityreg-form #State_state_name").on("keydown",function(e){
             if(e.which==8){
                self.div.find("#entityreg-form #State_id_state").val("");
                localStorage.setItem("saveState", 0);
             }
        });
        self.div.find("#entityreg-form #State_state_name").on("blur",function(e){
             if(self.div.find("#entityreg-form #State_id_state").val()==""&&localStorage.getItem("saveState")==0){
                self.div.find("#entityreg-form #State_state_name").val("");
             }
        });
        self.div.find("#entityreg-form #City_city_name").on("keydown",function(e){
             if(e.which==8){
                self.div.find("#entityreg-form #City_id_city").val("");
                localStorage.setItem("saveCity", 0);
             }
        });
        self.div.find("#entityreg-form #City_city_name").on("blur",function(e){
             if(self.div.find("#entityreg-form #City_id_city").val()==""&&localStorage.getItem("saveCity")==0){
                self.div.find("#entityreg-form #City_city_name").val("");
                self.div.find('.ui-helper-hidden-accessible').hide();
             }
        });
        self.div.find("#entityreg-form").change(function (){
            Mbp.estadoGuarda=false;
        });
        self.div.find("#btnRegCmp").click(function (){
           var data=self.div.find("#entityreg-form").serialize();
            self.div.find("#btnRegCmp").hide();
            var saveContinent=localStorage.getItem("saveContinent");
            var saveCountry=localStorage.getItem("saveCountry");
            var saveState=localStorage.getItem("saveState");
            var saveCity=localStorage.getItem("saveCity");
            data=data+'&saveContinent='+saveContinent;
            data=data+'&saveCountry='+saveCountry;
            data=data+'&saveState='+saveState;
            data=data+'&saveCity='+saveCity;
            self.registerCompany(data);
        });
        localStorage.setItem("saveContinent", 0);
        localStorage.setItem("saveCountry", 0);
        localStorage.setItem("saveState", 0);
        localStorage.setItem("saveCity", 0);
        localStorage.setItem('dataSearch',"");
        localStorage.setItem("idcompany", 0);
        /*Show hide company searh criterials  */
        self.div.find("#aSearchCriteria").on('click',function(){
            if(self.div.find("#aSearchCriteria").is(':checked')){
                self.div.find("#divSearchCrit").show();
            }
            else{
                self.div.find("#divSearchCrit").hide();
            }
        });
        self.div.find("#criteriCmp").hide();
        self.div.find("#chCmp").on('click',function(){
            if(self.div.find("#chCmp").is(':checked')){
                self.div.find("#criteriCmp").show();
            }
            else{
                self.div.find("#criteriCmp").hide();
            }
        });
        self.div.find("#criteriaTl").hide();
        self.div.find("#chTl").on('click',function(){
            if(self.div.find("#chTl").is(':checked')){
                self.div.find("#criteriaTl").show();
            }
            else{
                self.div.find("#criteriaTl").hide();
            }
        });
        self.div.find("#criteriaWeb").hide();
        self.div.find("#chWeb").on('click',function(){
            if(self.div.find("#chWeb").is(':checked')){
                self.div.find("#criteriaWeb").show();
            }
            else{
                self.div.find("#criteriaWeb").hide();
            }
        });
        self.div.find("#criteriaEm").hide();
        self.div.find("#chEm").on('click',function(){
            if(self.div.find("#chEm").is(':checked')){
                self.div.find("#criteriaEm").show();
            }
            else{
                self.div.find("#criteriaEm").hide();
            }
        });
        self.div.find("#criteriaSN").hide();
        self.div.find("#chSN").on('click',function(){
            if(self.div.find("#chSN").is(':checked')){
                self.div.find("#criteriaSN").show();
            }
            else{
                self.div.find("#criteriaSN").hide();
            }
        });
        self.div.find("#btnSearchCmp").click(function (){
            self.searchDataCompany();
        });
        self.div.find("#btnCleanCmp").click(function (){
            self.div.find("#entitysearch-form").trigger("reset");
            self.div.find("#Company_id_city").val("");
        });
       $('.ui-dialog').css('z-index',100003);
                $('.ui-widget-overlay').css('z-index',100002);
        /*Funciones para guardar cambios por campo*/
        
        $('#entityedit-form #btnEditCmpName').on('click',function(){
            var tableName="company";
            var columnName="company_name";
            var valueContent=$("#entityedit-form #Company_company_name").val();
//            console.log( localStorage.getItem("idcompany"));
            self.saveDataCompany(tableName,columnName,valueContent,localStorage.getItem("idcompany"));
        });
        $('#entityedit-form #btnEditCmpNumber').on('click',function(){
            var tableName="company";
            var columnName="company_number";
            var valueContent=$("#entityedit-form #Company_company_number").val();
//            console.log( localStorage.getItem("idcompany"));
            self.saveDataCompany(tableName,columnName,valueContent,localStorage.getItem("idcompany"));
        });
        $('#entityedit-form #btnEditCmpAdd').on('click',function(){
            var tableName="company";
            var columnName="company_address";
            var valueContent=$("#entityedit-form #Company_company_address").val();
//            console.log( localStorage.getItem("idcompany"));
            self.saveDataCompany(tableName,columnName,valueContent,localStorage.getItem("idcompany"));
        });
        $('#entityedit-form #btnEditCmpTel').on('click',function(){
            var tableName="telephone";
            var columnName="telephone_number";
            var valueContent=$("#entityedit-form #Telephone_telephone_number").val();
//            console.log( localStorage.getItem("idcompany"));
            self.saveDataCompany(tableName,columnName,valueContent,localStorage.getItem("idcompany"));
        });
        $('#entityedit-form #btnEditCmpFDesc').on('click',function(){
            var tableName="company";
            var columnName="company_fest_desc";
            var valueContent=$("#entityedit-form #Company_company_fest_desc").val();
//            console.log( localStorage.getItem("idcompany"));
            self.saveDataCompany(tableName,columnName,valueContent,localStorage.getItem("idcompany"));
        });
        $('#entityedit-form #btnEditCmpWeb').on('click',function(){
            var tableName="web";
            var columnName="web";
            var valueContent=$("#entityedit-form #Web_web").val();
//            console.log( localStorage.getItem("idcompany"));
            self.saveDataCompany(tableName,columnName,valueContent,localStorage.getItem("idcompany"));
        });
        $('#entityedit-form #btnEditCmpObs').on('click',function(){
            var tableName="company";
            var columnName="company_observations";
            var valueContent=$("#entityedit-form #Company_company_observations").val();
//            console.log( localStorage.getItem("idcompany"));
            self.saveDataCompany(tableName,columnName,valueContent,localStorage.getItem("idcompany"));
        });
        $('#entityedit-form #btnEditCmpEmls').on('click',function(){
            var tableName="email";
            var columnName="email";
            var valueContent=$("#entityedit-form #email-form :input").serialize();
//            console.log( valueContent);
            self.saveDataCompany(tableName,columnName,valueContent,localStorage.getItem("idcompany"));
        });
        $('#entityedit-form #btnEditCmpSNet').on('click',function(){
            var tableName="social_network";
            var columnName="snetwork";
            var valueContent=$("#entityedit-form #snetw-form :input").serialize();
//            console.log( $.param(valueContent));
            self.saveDataCompany(tableName,columnName,valueContent,localStorage.getItem("idcompany"));
        });
        $('#entityedit-form #btnEditCmpCity').on('click',function(){
            var tableName="city";
            var columnName="city_name";
            var valueContent=$("#entityedit-form #groupUbication :input").serialize();
            var saveContinent=localStorage.getItem("saveContinent");
            var saveCountry=localStorage.getItem("saveCountry");
            var saveState=localStorage.getItem("saveState");
            var saveCity=localStorage.getItem("saveCity");
            valueContent=valueContent+'&saveContinent='+saveContinent;
            valueContent=valueContent+'&saveCountry='+saveCountry;
            valueContent=valueContent+'&saveState='+saveState;
            valueContent=valueContent+'&saveCity='+saveCity;
//            console.log( $.param(valueContent));
            self.saveDataUbication(tableName,columnName,valueContent,localStorage.getItem("idcompany"));
        });
        $('#entityedit-form #btnEditCmpTc').on('click',function(){
            var tableName="company_tcompany";
            var columnName="id_typecompany";
            var valueContent=$("#entityedit-form #typeCmpEdit :input").serialize();
//            console.log( $.param(valueContent));
            self.saveDataCompany(tableName,columnName,valueContent,localStorage.getItem("idcompany"));
        });
        
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    self.getLatLong=function(){
         
            var myLatlng = new google.maps.LatLng(24.18061975930,79.36565089010);
            var myOptions = {
                zoom:7,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("gmap"), myOptions);
            // marker refers to a global variable
            marker = new google.maps.Marker({
                position: myLatlng,
                map: map
            });

            google.maps.event.addListener(map, "click", function(event) {
                // get lat/lon of click
                var clickLat = event.latLng.lat();
                var clickLon = event.latLng.lng();

                // show in input box
                document.getElementById("lat").value = clickLat.toFixed(5);
                document.getElementById("lon").value = clickLon.toFixed(5);

                  var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(clickLat,clickLon),
                        map: map
                     });
            });
    };
      
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    /**
     * Consume servicio para registrar la compañía o empresa
     */
    self.registerCompany=function(data){
        if(self.div.find("#Web_web").val()!=""){
            if(!Mbp.validateUrl(self.div.find("#Web_web").val())){
                msg="You have to type a valid web ";
                typeMsg="warn";
                $.notify(msg, typeMsg);
                self.div.find("#btnRegCmp").show();
                event.preventDefault();
                event.stopPropagation();
            }
        }
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'registerCompany',
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
                    msg="Company saved";
                    typeMsg="success";
                    self.div.find("#entityreg-form").trigger("reset");
                    $("#email-form").html("");$("#snetw-form").html("");
                    Mbp.estadoGuarda=true;
                    $(".errorMessage").hide();
                    $(".errorSummary").hide();
                    $.notify(msg, typeMsg);
                }
                else{
                    if(response.status=="noexito"){
                        msg=response.msg;
                        typeMsg="warn";
                    }
                    else{
                        msg="Check the form validation";
                        typeMsg="warn";
                        var errores="Check the form validation<br/><ul>";
                        $.each(response, function(key, val) {
                            errores+="<li>"+val+"</li>";
                            $("#entityreg-form #"+key+"_em_").text(val);                                                    
                            $("#entityreg-form #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        self.div.find("#entityreg-form #entityreg-form_es_").html(errores);                                                    
                        self.div.find("#entityreg-form #entityreg-form_es_").show(); 
                        $.notify(msg, typeMsg);
                    }
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error, contact support ";
            typeMsg="error";
            $.notify(msg, typeMsg);
        }).always(function(){
            self.div.find("#btnRegCmp").show();
        });
    };
    
    /*
     * 
     * @returns {undefined}
     */
    self.saveDataCompany=function(tableName,columnName,valueContent,idCompany){
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'editDataCompany',
            data:{'DCmp[tableName]':tableName,'DCmp[columnName]':columnName,'DCmp[valueContent]':valueContent,'DCmp[idCompany]':idCompany}
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("The session has expired, you have to login again", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                Mbp.estadoGuarda=true;
                return;
            }
            else{
                if(response.status=="exito"){
                    msg="Updated Data ";
                    typeMsg="success";
                }
                else{
                    msg="Nothing to update ";
                    typeMsg="warn";
                }
                self.searchDataCompany();
                $.notify(msg, typeMsg);
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error, contact support ";
            typeMsg="error";
            $.notify(msg, typeMsg);
        }).always(function(){
            self.div.find("#btnRegCmp").show();
        });
    };
    self.saveDataUbication=function(tableName,columnName,valueContent,idCompany){
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'editDataUbication',
            data:{'DCmp[tableName]':tableName,'DCmp[columnName]':columnName,'DCmp[valueContent]':valueContent,'DCmp[idCompany]':idCompany}
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("The session has expired, you have to login again", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                Mbp.estadoGuarda=true;
                return;
            }
            else{
                if(response.status=="exito"){
                    msg="Updated data";
                    typeMsg="success";
//                    Mbp.estadoGuarda=true;
                    $.notify(msg, typeMsg);
                    $(".errorMessage").hide();
                    self.searchDataCompany();
                }
                else{
                    if(response.status=="noexito"){
                        msg="Nothing to update";
                        typeMsg="warn";
                        $.notify(msg, typeMsg);
                    }
                    else{
                        msg="Check the form validation";
                        typeMsg="warn";
                        var errores="Check the form validation<br/><ul>";
                        $.each(response, function(key, val) {
                            $("#entityedit-form #"+key+"_em_").text(val);                                                    
                            $("#entityedit-form #"+key+"_em_").show();                                                
                        });
                        $.notify(msg, typeMsg);
                    }
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error, contact support ";
            typeMsg="error";
            $.notify(msg, typeMsg);
        }).always(function(){
            self.div.find("#btnRegCmp").show();
        });
    };
    /*
     * Search company from search criteria
     * @returns {json- for data table}
     */
    self.searchDataCompany=function(){
        var msg="";
        var typeMsg="";
        var dataCompany=self.div.find("#entitysearch-form").serialize();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'searchDataCompany',
            data:dataCompany
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("The session has expired, you have to login again", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                Mbp.estadoGuarda=true;
                return;
            }
            else{
                if(response.status=="exito"){
                    if(response.data!=""){
                        dataTableShowDataCmp.clear();
                        self.dataToEdit=response.data;
    //                    localStorage.setItem('dataSearch',response.data);
                        $.each(response.data,function(key,value){
//                            console.log(value.emails);
                            var emails=""; 
                            var i=1;
                            $.each(value.emails,function(keye,valuee){
                                console.log(valuee.email);
                                if(i<=3){
                                   emails+="-."+valuee.email+"</br>"; 
                                }
                                   i++;
                                 
                            });
                            console.log("------||");
                            dataTableShowDataCmp.row.add([
                                value.company_number,
                                value.company_name,
                                value.company_address,
                                value.company_fest_desc,
                                value.country_name,
                                value.city_name,
                                value.telephone_number,
                                value.web,
                                emails,
                                value.snetwork,
                                "<a href='javascript:Company.editDataCompany("+value.id_company+");'>View more/Edit</a>"
                            ]).draw();
                        });
                    }
                    else{
                        dataTableShowDataCmp.clear().draw();;
                        msg="No results for this search";
                        typeMsg="warn";
                        $.notify(msg, typeMsg);
                    }
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
            $.notify(msg, typeMsg);
        });
    };
  /**
     * Llama a editar datos de company
     */
    
    self.editDataCompany=function(idCompany){
        console.log(self.dataToEdit);
//        var dataToEdit=JSON.parse(JSON.stringify(localStorage.getItem('dataSearch')));
        $("#entityedit-form").trigger("reset");
        $("#email-form").html("");
        $("#snetw-form").html("");
        $.each(self.dataToEdit, function(i, v) {
            if (v.id_company == idCompany) {
//                console.log(self.dataToEdit[i].snewtorks);
                localStorage.setItem("idcompany", v.id_company);
                $.each(self.dataToEdit[i].snewtorks,function(keyi,vali){
                    $("#snetw-form").append('<div><input type="text" name="snetw[]"  readonly value="'+vali.snetwork+'"/><input size="10" type="text" readonly value="'+vali.typesnetwork_name+'"><input type="hidden" name="typesnet[]"  readonly value="'+vali.id_typesnetwork+'"/><a href="#" class="remove_field_snet">Remove</a></div>');
//                    console.log(vali.snetwork+" "+vali.typesnetwork_name+" "+vali.id_typesnetwork);
                });
                $.each(self.dataToEdit[i].emails,function(keyii,valii){
                    
                    $("#email-form").append('<div><input type="text" name="email[]"  readonly value="'+valii.email+'"/><a href="#" class="remove_field">Remove</a></div>');
            
//                    console.log(valii.email);
                });
                $.each(self.dataToEdit[i].tcompanys,function(keyiii,valiii){
                    $('.checktc').each(function(){ 
                        if(this.value==valiii.id_typecompany){
                            this.checked = true;
                        }
                    });
//                    console.log(valiii.id_typecompany+" "+valiii.typecompany_name+"#company_type_"+keyiii);
                });
                $('#entityedit-form #Company_company_name').val(self.dataToEdit[i].company_name);
                $('#entityedit-form #Company_company_number').val(self.dataToEdit[i].company_number);
                $('#entityedit-form #Company_company_address').val(self.dataToEdit[i].company_address);
                $('#entityedit-form #Telephone_telephone_number').val(self.dataToEdit[i].telephone_number);
                $('#entityedit-form #Company_company_fest_desc').text(self.dataToEdit[i].company_fest_desc);
                $('#entityedit-form #Web_web').val(self.dataToEdit[i].web);
                $('#entityedit-form #Company_company_observations').text(self.dataToEdit[i].company_observations);
                //carga lugar a form
                $('#entityedit-form #Continent_continent_name').val(self.dataToEdit[i].continent_name);
                $('#entityedit-form #Continent_id_continent').val(self.dataToEdit[i].id_continent);
                $('#entityedit-form #Country_country_name').val(self.dataToEdit[i].country_name);
                $('#entityedit-form #Country_id_country').val(self.dataToEdit[i].id_country);
                $('#entityedit-form #State_state_name').val(self.dataToEdit[i].state_name);
                $('#entityedit-form #State_id_state').val(self.dataToEdit[i].id_state);
                $('#entityedit-form #City_city_name').val(self.dataToEdit[i].city_name);
                $('#entityedit-form #City_id_city').val(self.dataToEdit[i].id_city);
            }
            
        });
        $("#editDataCmp").dialog("open");
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
     * Filtra por Continentes disponibles para realizar un autocomplet
     * @param {type} param
     */
    
    self.filterContinent=function(){
        self.div.find("#entityreg-form #Continent_continent_name").autocomplete({
            source: function(request, response){
                $.ajax({
                    type: "POST",
                    url:"searchContinent",
                    data: {stringcontinent:self.div.find("#entityreg-form #Continent_continent_name").val()},
                    beforeSend:function (){
                        self.div.find("#entityreg-form #Continent_id_continent").val("");
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
                    self.div.find("#entityreg-form #Continent_id_continent").val();
                    localStorage.setItem("saveContinent", 1);
//                    alert(localStorage.getItem("saveContinent"));
                }
                else{
                    self.div.find("#entityreg-form #Continent_id_continent").val(ui.item.id);
                    localStorage.setItem("saveContinent", 0);
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
     * Filtra por Paises disponibles para realizar un autocomplet
     * @param {type} param
     */
    
    self.filterCountry=function(){
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
                    localStorage.setItem("saveCountry", 1);
                }
                else{
                    self.div.find("#entityreg-form #Country_id_country").val(ui.item.id);
                    localStorage.setItem("saveCountry", 0);
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
                        data: {stringstate:self.div.find("#entityreg-form #State_state_name").val()},
                        beforeSend:function (){
                            self.div.find("#entityreg-form #State_id_state").val("");
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
                        localStorage.setItem("saveState", 1);
                    }
                    else{
                        self.div.find("#entityreg-form #State_id_state").val(ui.item.id);
                        localStorage.setItem("saveState", 0);
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
                        data: {stringcity:self.div.find("#entityreg-form #City_city_name").val()},
                        beforeSend:function (){
                            self.div.find("#entityreg-form #City_id_city").val("");
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
                        localStorage.setItem("saveCity", 1);
                    }
                    else{
                        self.div.find("#entityreg-form #City_id_city").val(ui.item.id);
                        localStorage.setItem("saveCity", 0);
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
     * Filtra por Continentes disponibles para realizar un autocomplet
     * @param {type} param
     */
    
    self.filterContinentEdit=function(){
        
        $("#entityedit-form #Continent_continent_name").autocomplete({
            source: function(request, response){
                $.ajax({
                    type: "POST",
                    url:"searchContinent",
                    data: {stringcontinent:$("#entityedit-form #Continent_continent_name").val()},
                    beforeSend:function (){
                        $("#entityedit-form #Continent_id_continent").val("");
                    },
                    success: response,
                    dataType: 'json',
                    minLength: 1,
                    delay: 100
                });
            },
            minLength: 1,
            select: function(event, ui) {
                console.log("pasa");
                if(ui.item.id=="#"){
                    $("#entityedit-form #Continent_id_continent").val();
                    localStorage.setItem("saveContinent", 1);
//                    alert(localStorage.getItem("saveContinent"));
                }
                else{
                    $("#entityedit-form #Continent_id_continent").val(ui.item.id);
                    localStorage.setItem("saveContinent", 0);
                }
                $(".ui-helper-hidden-accessible").hide();
            },
            html: true,
            open: function(event, ui) {
                $(".ui-autocomplete").css("z-index", 100010);
            }
        });
    };
    /*
     * Filtra por Paises disponibles para realizar un autocomplet
     * @param {type} param
     */
    
    self.filterCountryEdit=function(){
        $("#entityedit-form #Country_country_name").autocomplete({
            source: function(request, response){
                $.ajax({
                    type: "POST",
                    url:"searchCountry",
                    data: {stringcountry:$("#entityedit-form #Country_country_name").val()},
                    beforeSend:function (){
                        $("#entityedit-form #Country_id_country").val("");
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
                    $("#entityedit-form #Country_id_country").val();
                    localStorage.setItem("saveCountry", 1);
                }
                else{
                    $("#entityedit-form #Country_id_country").val(ui.item.id);
                    localStorage.setItem("saveCountry", 0);
                }
                $(".ui-helper-hidden-accessible").hide();
            },
            html: true,
            open: function(event, ui) {
                $(".ui-autocomplete").css("z-index", 100010);
            }
        });
    };
    
    /*
     * Filtra por Estados o departamentos disponibles para realizar un autocomplet
     * @param {type} param
     */
    
    self.filterStateEdit=function(){
//        console.log("pasa");
        
            $("#entityedit-form #State_state_name").autocomplete({
                source: function(request, response){
                    $.ajax({
                        type: "POST",
                        url:"searchState",
                        data: {stringstate:$("#entityedit-form #State_state_name").val()},
                        beforeSend:function (){
                            $("#entityedit-form #State_id_state").val("");
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
                        $("#entityedit-form #State_id_state").val("");
                        localStorage.setItem("saveState", 1);
                    }
                    else{
                        $("#entityedit-form #State_id_state").val(ui.item.id);
                        localStorage.setItem("saveState", 0);
                    }
                    $(".ui-helper-hidden-accessible").hide();
                },
                html: true,
                open: function(event, ui) {
                    $(".ui-autocomplete").css("z-index", 100010);
                }
            });
        
    };
    /*
     * Filtra por ciudades disponibles para realizar un autocomplet
     * @param {type} param
     */
    
    self.filterCityEdit=function(){
        $("#entityedit-form #City_city_name").autocomplete({
            source: function(request, response){
                $.ajax({
                    type: "POST",
                    url:"searchCity",
                    data: {stringcity:$("#entityedit-form #City_city_name").val()},
                    beforeSend:function (){
                        $("#entityedit-form #City_id_city").val("");
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
                    $("#entityedit-form #City_id_city").val("");
                    localStorage.setItem("saveCity", 1);
                }
                else{
                    $("#entityedit-form #City_id_city").val(ui.item.id);
                    localStorage.setItem("saveCity", 0);
                }
                $(".ui-helper-hidden-accessible").hide();
            },
            html: true,
            open: function(event, ui) {
                $(".ui-autocomplete").css("z-index", 100010);
            }
        });
    };
    /*
     * Filtra por ciudades disponibles para realizar un autocomplet
     * @param {type} param
     */
    
    self.filterCityToSearch=function(){
//        console.log("pasa");
        
            self.div.find("#entitysearch-form #Company_city").autocomplete({
                source: function(request, response){
                    $.ajax({
                        type: "POST",
                        url:"searchCitySearch",
                        data: {stringcity:self.div.find("#entitysearch-form #Company_city").val()},
                        beforeSend:function (){
                            self.div.find("#entitysearch-form #Company_id_city").val("");
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
                        self.div.find("#entitysearch-form #Company_id_city").val("");
                    }
                    else{
                        self.div.find("#entitysearch-form #Company_id_city").val(ui.item.id);
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
    
    self.filterCountryToSearch=function(){
//        console.log("pasa");
        
            self.div.find("#entitysearch-form #Company_country").autocomplete({
                source: function(request, response){
                    $.ajax({
                        type: "POST",
                        url:"searchCountry",
                        data: {stringcountry:self.div.find("#entitysearch-form #Company_country").val()},
                        beforeSend:function (){
                            self.div.find("#entitysearch-form #Company_id_country").val("");
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
                        self.div.find("#entitysearch-form #Company_id_country").val("");
                    }
                    else{
                        self.div.find("#entitysearch-form #Company_id_country").val(ui.item.id);
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
    Company.filterContinent();
    Company.filterCityToSearch();
    Company.filterCountryEdit();
    Company.filterStateEdit();
    Company.filterCityEdit();
    Company.filterContinentEdit();
    Company.filterCountryToSearch();
});