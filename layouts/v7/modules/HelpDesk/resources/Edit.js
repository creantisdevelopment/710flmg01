/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Edit_Js("HelpDesk_Edit_Js", {}, {
    
    initHelpDesk : function(){
        var source_module = this.getParameterByName('source_module');
        if (source_module == 'Apdalm'){
            this.vieneDesdeVistaLista();
        }
    },

    vieneDesdeVistaLista : function (){
        var source_id = this.getParameterByName('source_id');
        var source_module = this.getParameterByName('source_module');

        var params = {
            module: 'Apdalm',
            source_module: 'Apdalm',
            action: 'GetDataIncidencia',
            record: source_id
        };
        app.helper.showProgress();
        app.request.get({data: params}).then(function (error, data) {
            if ( data.success ) {
                var data = data.data;
                var alumno_seccion = data.alumno_seccion;
                if ( alumno_seccion.id != null ) {
                    $("[name='contact_id']").val(alumno_seccion.almsecc_tks_alumno);
                    $("#contact_id_display").val(alumno_seccion.fullname);
                    $("#contact_id_display").attr("disabled",true);
                    $("[name='contact_id']").parents(".input-group").find(".clearReferenceSelection").removeClass("hide");
                    $("[name='contact_id']").attr('data-json',JSON.stringify(alumno_seccion));
                } else {
                    app.helper.showAlertNotification({'message': "El alumno no tiene Sección!"});
                }

                var apoderado = data.apoderado;
                if ( apoderado.id != null ) {
                    $("[name='parent_id']").val(apoderado.id);
                    $("#parent_id_display").val(apoderado.accountname);
                    $("#parent_id_display").attr("disabled",true);
                    $("[name='parent_id']").parents(".input-group").find(".clearReferenceSelection").removeClass("hide");
                    $("[name='parent_id']").attr('data-json',JSON.stringify(apoderado));
                }
                // console.log("alumno_seccion", alumno_seccion, "apoderado", apoderado);
            }
            app.helper.hideProgress();
        });
    },
    
    registerEvents : function() {
        this._super();
        this.initHelpDesk();
    }
});