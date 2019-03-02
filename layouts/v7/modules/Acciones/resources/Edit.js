/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Edit_Js("Acciones_Edit_Js", {}, {
    
    initAcciones : function(container) {
        $("#Acciones_editView_fieldName_acciones_tks_titulo").attr("readonly",true);
        $("[name='cf_852']").on("change",this.completarNombreCaso);
    },

    completarNombreCaso : function(e){
        var nombre = $("[name='cf_852']").val().trim();
        $("#Acciones_editView_fieldName_acciones_tks_titulo").val(nombre);
    },

    llenarRoles : function (container) {
        var elm = $("[name='acciones_tks_rolresponsable']", container);
        console.log("elm",elm)
        var val_inicial = elm.attr("data-selected-value");
        var params = {
            module: 'Vtiger',
            source_module: 'Temas',
            action: 'GetRoles'
        };
        $.each($("[name='acciones_tks_rolresponsable'] option", container), function(k,v){
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
    
    registerBasicEvents : function(container) {
        this._super(container);
        this.initAcciones(container);
        this.llenarRoles(container);
    }
});