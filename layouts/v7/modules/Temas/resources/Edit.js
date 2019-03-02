/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Edit_Js("Temas_Edit_Js", {}, {
    
    initTemas : function(container) {
        $("#Temas_editView_fieldName_temas_tks_regla").attr("readonly",true);
        $("[name='cf_900']").on("change",this.completarNombreCaso);
        $("[name='ticketcategories']").on("change",this.completarNombreCaso);
    },

    llenarRoles : function (container) {
        var elm = $("[name='temas_tks_rolresponsable']");
        var val_inicial = elm.attr("data-selected-value");
        var params = {
            module: 'Vtiger',
            source_module: 'Temas',
            action: 'GetRoles'
        };
        $.each($("[name='temas_tks_rolresponsable'] option"), function(k,v){
            $(v).remove();
        });
        elm.append(new Option('Selecciona una Opción', ''));
        app.request.get({data:params}).then(
            function(err, res){
                var data = res.data;
                console.log("res",val_inicial)
                $.each(data, function(k,rol){
                    var value = rol.roleid+"-"+rol.rolename;
                    if ( value == val_inicial ) {
                        elm.append(`<option value="`+value+`" selected>`+value+`</option>`);
                    } else{
                        elm.append(new Option(value, value));
                    }
                });
                elm.trigger("change");
            },
            function(error){
            }
        );
    },

    completarNombreCaso : function(e){
        var nombre = $("[name='cf_900']").val().trim() + " - " +
                    $("[name='ticketcategories']").val().trim();
        $("#Temas_editView_fieldName_temas_tks_regla").val(nombre);
    },
    
    registerBasicEvents : function(container) {
        this._super(container);
        this.initTemas(container);
        this.llenarRoles(container);
    }
});