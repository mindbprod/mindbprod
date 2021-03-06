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
var Mbp = function(){
    
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    self.estadoGuarda=true;
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
    var Mbp = function() {
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
    
    
        
//       
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    self.validateEmail=function (email) {
        var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

        return $.trim(email).match(pattern) ? true : false;
    };
    
    self.validateUrl=function(web){
        var pattern=/^((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+(\.[a-z]{2,}){1,3}(#?\/?[a-zA-Z0-9#]+)*\/?(\?[a-zA-Z0-9-_]+=[a-zA-Z0-9-%]+&?)?$/;
        return $.trim(web).match(pattern) ? true : false;
    }
    self.validateSNetwork=function(typeSN,sNetwork){
        var pattern="";
//        console.log(typeSN);
        switch(typeSN){
            case "Facebook":
                pattern=/^(https?:\/\/)?(www\.)?facebook.com\/([A-Za-z0-9_]{1,15})$/;
                console.log($.trim(sNetwork).match(pattern) ? true : false);
                return $.trim(sNetwork).match(pattern) ? true : false;
                break;
            case "Twitter":
                pattern=/^@([A-Za-z0-9_]{1,15})$/;
                return $.trim(sNetwork).match(pattern) ? true : false;
                break;
            case "Instagram":
                pattern=/^(https?:\/\/)?(www\.)?instagram.com\/([A-Za-z0-9_]{1,15})$/;
                return $.trim(sNetwork).match(pattern) ? true : false;
                break;
            case "Google +":
//                pattern=/^https?:\/\/plus\.google\.com\/\+[^/]+|\d{21}$/;
                pattern=/^(https?:\/\/)?plus\.google\.com\/([0-9]{21})$/;
                return $.trim(sNetwork).match(pattern) ? true : false;
                break;
        }
    };
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    searchState=function(idCountry){
      console.log("consulta departamento");  
    };
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
        /**
         * Retorna la configuración del lenguaje para el plugin datatable
         * @returns {object} Objeto con la configuración de idioma para datatable
         */
        self.getDatatableLang=function(){
            return {
                "sProcessing":     "Processing...",
                "sLengthMenu":     "Show _MENU_ records",
                "sZeroRecords":    "No results found",
                "sEmptyTable":     "No data available in this table",
                "sInfo":           "_START_ to _END_ of _TOTAL_ records",
                "sInfoEmpty":      "0 records",
                "sInfoFiltered":   "(filtering a total of _MAX_ records)",
                "sInfoPostFix":    "",
                "sSearch":         "Search",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Load...",
                "oPaginate": {
                    "sFirst":    "First",
                    "sLast":     "Last",
                    "sNext":     "Next",
                    "sPrevious": "Previous"
                },
                "oAria": {
                    "sSortAscending":  ": Activate to order the column ascending",
                    "sSortDescending": ": Activate to order the column descending"
                },
                buttons: {
                    colvis: 'Visible columns',
                    copy: 'Copy to clipboard',
                    excel: 'Excel',
                    selectAll: 'Select all'
                },
                select: {
                    rows: {
                        _: "",
                        0: "",
                        1: ""
                    }
                }
            };
        };
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function() {
    
    window.Mbp=new Mbp();
    
    
});