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
var Companyaudit = function(){
    
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
        self.div=$("#divShowErrors");
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
        dataTableUsuer=self.div.find("#dataTableShowErrors").DataTable({
            "bProcessing": true,
            "serverSide": true,
            "ajax":{
                url :"loadErrorsTable", // json datasource
                type: "post",  // type of method  ,GET/POST/DELETE
                error: function(){
                    console.debug("error");
                }
            },
            oLanguage: Mbp.getDatatableLang(),
            scrollX: true,
            responsive: true,
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'print'
            ],
        });  
        dataTableUsuer=self.div.find("#dataTableShowFields").DataTable({
            "bProcessing": true,
            "serverSide": true,
            "ajax":{
                url :"loadFieldsTable", // json datasource
                type: "post",  // type of method  ,GET/POST/DELETE
                error: function(){
                    console.debug("error");
                }
            },
            oLanguage: Mbp.getDatatableLang(),
            scrollX: true,
            responsive: true,
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'print'
            ],
        }); 
        dataTableUsuer=self.div.find("#dataTableShowRequests").DataTable({
            "bProcessing": true,
            "serverSide": true,
            "ajax":{
                url :"loadRequestsTable", // json datasource
                type: "post",  // type of method  ,GET/POST/DELETE
                error: function(){
                    console.debug("error");
                }
            },
            oLanguage: Mbp.getDatatableLang(),
            scrollX: true,
            responsive: true,
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'print'
            ],
        }); 
        
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    
    
    
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function() {
    window.Companyaudit=new Companyaudit();
});