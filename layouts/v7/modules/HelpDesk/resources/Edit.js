/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Edit_Js("HelpDesk_Edit_Js", {}, {
    
    initHelpDesk : function(container){
        var source_module = this.getParameterByName('source_module');
        if (source_module == 'Apdalm'){
            this.vieneDesdeVistaLista();
        }

        $("[name='cf_900']").change(this.changeTipoIncidencia); // tipo de incidencia

        $.acciones = new Array();
        $.accion_selected = $("[name='cf_852']").val();
        $.acciones_user = new Object();
        $("[name='cf_852'] option").each(function(k,v){
            if($(v).val() != '') $.acciones.push($(v).val());
        });
        $("[name='cf_852']").change(function(){
            $.accion_selected = $(this).val();
            // console.log("$.accion_selected",$.accion_selected)
            if ( $.acciones_user[$.accion_selected] != null && $.acciones_user[$.accion_selected] != undefined ) {
                $("[name='assigned_user_id']").val( $.acciones_user[$.accion_selected] ).trigger("change");
            }
        });

        //---- traer valores del caso seleccionado
        var temaid = $("[name='cf_942']", container).val();
        var record = jQuery('[name="record"]', container).val();
        console.log("app.getRecordId()", record, temaid);
        if ( record != '' && temaid != '' ) { // Temas
            var params = {
                module: 'Vtiger',
                source_module: 'Temas',
                action: 'GetDataTemas',
                record: temaid,
                parent_id: $("[name='parent_id']", container).val(),
                contact_id: $("[name='contact_id']", container).val(),
                product_id: $("[name='product_id']", container).val(),
                accion_selected: $("[name='cf_852']", container).val()
            };
            app.helper.showProgress();
            var elm_acciones = $("[name='cf_852']");
            // $.accion_selected = elm_acciones.val();
            app.request.get({data: params}).then(function (error, data) {
                if ( data.success ) {
                    var data = data.data;
                    console.log("data", data, "acciones", data.acciones);
                    if ( data != null ) {
                        $("[name='cf_900']", container).val(data.cf_900).trigger("change");
                        $("[name='ticketcategories']", container).val(data.ticketcategories).trigger("change");
                    }
                    if ( data.acciones != null ) {
                        console.log("$.accion_selected", $.accion_selected)
                        $("[name='cf_852'] option", container).each(function(k,v){
                            $(v).remove();
                        });
                        elm_acciones.append(new Option('Selecciona una Opción', ''));
                        var acciones = data.acciones;
                        var arr_acciones = new Array();
                        var n_acciones = acciones.length;
                        $.acciones_user = new Object();
                        $.each(acciones, function(k,v){
                            if ( v.user_accion != null ) {
                                $.acciones_user[v.acciones_tks_accion] = v.user_accion.userid;
                            }
                            arr_acciones.push(v.acciones_tks_titulo);
                            var value = v.acciones_tks_titulo;
                            console.log("value == $.accion_selected", value == $.accion_selected, value , $.accion_selected)
                            if ( value == $.accion_selected || n_acciones == 1 ) {
                            // if ( n_acciones == 1 ) {
                                elm_acciones.append(`<option value="`+value+`" selected>`+value+`</option>`);
                            } else{
                                elm_acciones.append(new Option(value, value));
                            }
                        });
                        if ( n_acciones == 0 ) {
                            $.each($.acciones, function(k,v){
                                elm_acciones.append(new Option(v, v));
                            });
                        }
                        elm_acciones.trigger("change");
                    }
                }
                app.helper.hideProgress();
            });
        }
    },

    vieneDesdeVistaLista : function (){
        var thisInstance = this;
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
                
                $("[name='contact_id']").val(alumno_seccion.id);
                $("#contact_id_display").val( alumno_seccion.firstname + " " + alumno_seccion.lastname + " " + alumno_seccion.cf_908 );
                $("#contact_id_display").attr("disabled",true);
                $("[name='contact_id']").parents(".input-group").find(".clearReferenceSelection").removeClass("hide");
                $("[name='contact_id']").attr('data-json',JSON.stringify(alumno_seccion));
                if ( thisInstance.isEmpty(alumno_seccion.almsecc) ) {
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

    changeTipoIncidencia : function(e){
        var val = $(this).val();
        if ( val == 'Legal' ) {
            $("[name='ticketpriorities']").val('High').trigger("change"); // prioridad
            // $("[name='cf_852']").val('Legal').trigger("change"); // area reasponsable
        } else {
            $("[name='ticketpriorities']").val('Normal').trigger("change"); // prioridad
            // $("[name='cf_852']").val('').trigger("change"); // area reasponsable
        }
    },
    
    registerBasicEvents : function(container) {
        this._super(container);
        this.initHelpDesk(container);
    }
});