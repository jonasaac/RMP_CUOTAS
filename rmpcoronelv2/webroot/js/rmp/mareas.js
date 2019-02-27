var mareasJqueryInit = function (actions) {
    //variables globales usadas en mareas
    var idMarea = null;
    var idRecalada = null;
    var idDescarga = null;
    var idGuia = null;

    // carga variables globales
    var numRow = 0; //util para manejar el nro de lineas de detalle
    var especiesJson = {};
    var destinosJson = {};

    $('#mareas-table, #recaladas-table, #descargas-table').unselectable();

    var dataTableOptions = function (aoColumns, rowCallback, ajax) {

        return {
            "responsive": true,
            "scrollY": "150",
            "scrollCollapse": true,
            "ajax": ajax,
            "paging": false,
            "aLengthMenu": [
                [5, 10, 20, 100, -1],
                [5, 10, 20, 100, "Todas"]
            ],
            "iDisplayLength": 5,
            "sPaginationType": "bootstrap",
            "sDom": "Tfl<'action-buttons'>t<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",
            "language": {
                "search": "",
                "emptyTable": "",
                "zeroRecords": "No hay datos que coincidan",
                "info": "Mostrando de _START_ a _END_ de un total de _TOTAL_",
                "infoEmpty": "No hay datos que mostrar",
                "infoFiltered": "(filtrado desde _MAX_ datos)",
                "sLengthMenu": "_MENU_",
                "oPaginate": {
                    "sPrevious": "Anterior",
                    "sNext": "Siguiente",
                }
            },
            "aoColumns": aoColumns,
            "fnRowCallback": rowCallback,
        }
    }

    // crea las acciones para los botones
    var activateMareaBtns = function () {
        $('#delete-btn', '#mareas-table_wrapper').click(function (e) {
            e.preventDefault();
            if (!idMarea) {
                warningNotify("Debe seleccionar una marea primero!");
            } else {
                bootbox.confirm({
                    "message" : "¿Seguro de borrar la marea seleccionada?",
                    "size" : 'small',
                    "callback" : function (result) {
                        if (result) {
                            $.post( '/api/mareas/delete.json',
                                    {'id': idMarea},
                                    function (data) {
                                        if (data.success) {
                                            successNotify('Se ha borrado con exito la marea!');
                                            idMarea = null;
                                            loadMareas($('#mareas-year').val());
                                        } else {
                                            errorNotify('No se ha podido eliminar la marea! Posiblemente se deba a que existen recaladas asociadas a esta marea.')
                                        }
                                    }, 'json');
                        }
                    }
                });
            }
        });

        $('#edit-btn', '#mareas-table_wrapper').click(function (e) {
            e.preventDefault();
            if (!idMarea) {
                warningNotify("Debe seleccionar una marea primero!");
            } else {
                var editMareaModal = loadMareaModal("/api/mareas/edit.json");
                $.get('/api/mareas/edit/'+idMarea+'.json',
                      function (data) {
                          $('#nave-id', editMareaModal).val(data.nave_id);
                          $('.datetime-picker', editMareaModal).data("DateTimePicker").date(moment(data.fecha_zarpe).utcOffset(0));
                          $('#capitan-id', editMareaModal).val(data.capitan_id);
                          $('#puerto-id', editMareaModal).val(data.puerto_id);
                          $('#observaciones', editMareaModal).val(data.observaciones);
                          $('#new-marea-form', editMareaModal).append('<input type="hidden" name="id" value="'+idMarea+'">');
                      }, 'json');
            }
        });

        $('#details-btn', '#mareas-table_wrapper').click(function (e) {
            e.preventDefault();
            if (!idMarea) {
                warningNotify("Debe seleccionar una marea primero!");
            } else {
                var detailsMareaModal = loadMareaModal("/api/mareas/edit.json");
                $.get('/api/mareas/edit/'+idMarea+'.json',
                      function (data) {
                          $('#nave-id', detailsMareaModal).val(data.nave_id).readonly();
                          $('.datetime-picker', detailsMareaModal).data("DateTimePicker").date(moment(data.fecha_zarpe).utcOffset(0));
                          $('.datetime-picker', detailsMareaModal).readonly();
                          $('#capitan-id', detailsMareaModal).val(data.capitan_id).readonly();
                          $('#puerto-id', detailsMareaModal).val(data.puerto_id).readonly();
                          $('#observaciones', detailsMareaModal).val(data.observaciones).readonly();
                          $('.btn-mary').hide();
                      }, 'json');
            }
        });
    }

    var activateRecaladaBtns = function () {
        $('#delete-btn', '#recaladas-table_wrapper').click(function (e) {
            e.preventDefault();
            if (!idRecalada) {
                warningNotify("Debe seleccionar una recalada primero!");
            } else {
                bootbox.confirm({
                    "message" : "¿Seguro de borrar la recalada seleccionada?",
                    "size" : 'small',
                    "callback" : function (result) {
                        if (result) {
                            $.post( '/api/recaladas/delete.json',
                                    {'id': idRecalada},
                                    function (data) {
                                        if (data.success) {
                                            successNotify('Se ha borrado con exito la recalada!');
                                            idRecalada = null;
                                            loadRecaladas(idMarea);
                                        } else {
                                            errorNotify('No se ha podido eliminar la recalada! Posiblemente se deba a que existen recaladas asociadas a esta recalada.')
                                        }
                                    }, 'json');
                        }
                    }
                });
            }
        });

        $('#edit-btn', '#recaladas-table_wrapper').click(function (e) {
            e.preventDefault();
            if (!idRecalada) {
                warningNotify("Debe seleccionar una recalada primero!");
            } else {
                var editRecaladaModal = loadRecaladaModal("/api/recaladas/edit.json");
                $.get('/api/recaladas/edit/'+idRecalada+'.json',
                      function (data) {
                          $('.datetime-picker', editRecaladaModal).data("DateTimePicker").date(moment(data.fecha).utcOffset(0));
                          $('#ponton-id', editRecaladaModal).val(data.ponton_id);
                          $('#observaciones', editRecaladaModal).val(data.observaciones);
                          $('#new-recalada-form', editRecaladaModal).append('<input type="hidden" name="id" value="'+idRecalada+'">');
                      }, 'json');
            }
        });

        $('#details-btn', '#recaladas-table_wrapper').click(function (e) {
            e.preventDefault();
            if (!idRecalada) {
                warningNotify("Debe seleccionar una recalada primero!");
            } else {
                var detailsRecaladaModal = loadRecaladaModal("/api/recaladas/edit.json");
                $.get('/api/recaladas/edit/'+idRecalada+'.json',
                      function (data) {
                          $('#nave-id', detailsRecaladaModal).val(data.nave_id).readonly();
                          $('.datetime-picker', detailsRecaladaModal).data("DateTimePicker").date(moment(data.fecha_zarpe));
                          $('.datetime-picker', detailsRecaladaModal).readonly();
                          $('#capitan-id', detailsRecaladaModal).val(data.capitan_id).readonly();
                          $('#puerto-id', detailsRecaladaModal).val(data.puerto_id).readonly();
                          $('#observaciones', detailsRecaladaModal).val(data.observaciones).readonly();
                          $('.btn-mary').hide();
                      }, 'json');
            }
        });
    }
    var activateDescargaBtns = function () {}
    var activateGuiaBtns = function () {}

    var mareasTable = $('#mareas-table').dataTable(dataTableOptions(
        [
            {"mData": "data.id"},
            {"mData": "data.nave"},
            {"mData": "data.fecha_zarpe"},
            {"mData": "data.capitan"},
            {"mData": "data.puerto"},
            {"mData": "data.estado"}
        ],
        function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td:eq(2)', nRow).data("fecha", aData.data.raw_fecha_zarpe);
            return nRow;
        },
        "/api/mareas/"+ $("#mareas-year").val() +".json"
    ));
    $(".action-buttons", '#mareas-table_wrapper').addClass('pull-right').html(actions.mareasButtons);
    activateMareaBtns();

    var recaladasTable = $('#recaladas-table').dataTable(dataTableOptions(
        [
            {"mData": "id"},
            {"mData": "fecha", 'class': 'col-md-2'},
            {"mData": "ponton"},
            {"mData": "estado"},
        ],
        function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td:eq(1)', nRow).data("fecha", aData.raw_fecha);
            return nRow;
        }));
    $(".action-buttons", "#recaladas-table_wrapper").addClass('pull-right').html(actions.recaladasButtons);
    activateRecaladaBtns();

    var descargasTable = $('#descargas-table').dataTable(dataTableOptions([
        {"mData": "id", "visible": false, "searchable": false},
        {"mData": "tipo_descarga"},
        {"mData": "compra"},
        {"mData": "fecha_pesca", 'class': 'col-md-2'},
        {"mData": "termino_desembarque", 'class': 'col-md-2'},
        {"mData": "observaciones", "visible": false},
        {"mData": "estado"},
    ]));
    var guiasTable = $('#guias-table').dataTable(dataTableOptions([
        {"mData": "id", "visible": false},
    ]));

    // MAREAS

    // abre el modal y pobla los selects
    var loadMareaModal = function (sendUrl) {
        populateSelect('.modal #nave-id', '/api/naves.json');
        populateSelect('.modal #capitan-id', '/api/auxiliares/capitan.json');
        populateSelect('.modal #puerto-id', '/api/puertos.json');

        var finishedRequest = true;

        var newMareaModal = createModal(
            "Nueva Marea",
            function() {
                var sFrm = $("#mareas-modal").html();
                var oFrm = $('<div/>').html(sFrm).contents();
                oFrm.find('.datetime-picker').datetimepicker(datetimeOptions());

                return oFrm;
            },
            function () {
                var modalForm = $(this);
                formData = serializeForm($('form', modalForm));
                if(finishedRequest) {
                    finishedRequest = false;
                $.post( sendUrl,
                        formData,
                        function ( data ) {
                            if ($.isEmptyObject(data)) {
                                loadMareas($('#mareas-year').val());
                                successNotify('Marea registrada con exito!');
                                modalForm.modal('hide');
                            } else {
                                parseErrors(data, $('form', modalForm));
                                errorNotify('No se pudo registrar la marea. Existen errores en el formulario!');
                                finishedRequest = true;
                            }
                        }, 'json');
                }
                return false;
            });

        newMareaModal.on('hidden.bs.modal', function () {
            $( $.fn.dataTable.tables(true) ).each (function () {
                $(this).dataTable().fnAdjustColumnSizing();
            });
        });
        return newMareaModal;
    }

    // carga las mareas por year
    var loadMareas = function (year) {
        mareasTable.DataTable().ajax.url( '/api/mareas/' + year + '.json').load(function () {
            $( $.fn.dataTable.tables(true) ).each (function () {
                $(this).dataTable().fnAdjustColumnSizing();
            });

            if (idMarea)
                $('#mareas-table td:first-child:contains("'+idMarea+'")').parent().addClass('selected');
        });
    }

    // cargar por year
    $('#mareas-year').change(function () {
        if ($(this).val())
            loadMareas($(this).val());
        else
            mareasTable.DataTable().clear().draw();
    });

    // seleccionar fila
    $('#mareas-table tbody').on('click', 'tr', function () {
        if($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            recaladasTable.DataTable().clear().draw();
            idMarea = null;
        } else {
            $(this).siblings().removeClass('selected');
            $(this).addClass('selected');
            idMarea = $(this).children().first().text();
            loadRecaladas(idMarea);
        }
    });

    // RECALADAS
    var loadRecaladas = function (idMarea) {
        recaladasTable.DataTable().ajax.url( '/api/recaladas/' + idMarea + '.json').load(function () {
            $( $.fn.dataTable.tables(true) ).each (function () {
                $(this).dataTable().fnAdjustColumnSizing();
            });

            if (idRecalada)
                $('#recaldas-table td:first-child:contains("'+idRecalada+'")').parent().addClass('selected');
        });
    }

    // abre el modal y pobla los selects
    var loadRecaladaModal = function (sendUrl) {
        populateSelect('.modal #ponton-id', '/api/pontones.json');
        var fechaMarea = $("#mareas-table tr.selected>td:nth-child(3)").data("fecha");
        var finishedRequest = true;

        var newRecaladaModal = createModal(
            "Nueva Recalada",
            function () {
                var sFrm = $("#recaladas-modal").html();
                var oFrm = $('<div/>').html(sFrm).contents();
                oFrm.find('.datetime-picker').datetimepicker(datetimeOptions()).data("DateTimePicker").minDate(moment(fechaMarea).utcOffset(0));

                return oFrm;
            },
            function () {
                var modalForm = $(this);
                formData = serializeForm($('form', modalForm));
                formData['marea_id'] = idMarea;
                if (finishedRequest) {
                    finishedRequest = false;
                $.post( sendUrl,
                        formData,
                        function ( data ) {
                            if ($.isEmptyObject(data)) {
                                loadRecaladas(idMarea);
                                modalForm.modal('hide');
                                successNotify('Recalada registrada con exito!');
                            } else {
                                parseErrors(data, $('form', modalForm));
                                errorNotify('No se pudo registrar la recalada. Existen errores en el formulario!');
                                finishedRequest = true;
                            }
                        }, 'json');
                }
                return false;
            }
        );
        newRecaladaModal.on('hidden.bs.modal', function () {
            $( $.fn.dataTable.tables(true) ).each (function () {
                $(this).dataTable().fnAdjustColumnSizing();
            });
        });
        return newRecaladaModal;
    }

    // nueva marea
    $("#new-recalada").on('click', function () {
        if(!idMarea){
            warningNotify('No se puede registrar una nueva recalada si no se ha seleccionado una marea primero!')
            return false;
        }
        loadRecaladaModal("/api/recaladas/add.json");
    });

    // seleccionar fila de recalada
    $('#recaladas-table tbody').on('click', 'tr', function () {
        if($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            descargasTable.DataTable().clear().draw();
            idRecalada = null;
        } else {
            $(this).siblings().removeClass('selected');
            $(this).addClass('selected');
            idRecalada = $(this).children().first().text();
            loadDescargas(idRecalada);

            // se preparan datos para las descargas
            $.ajax({"url": "/api/especies.json",
                    "dataType": "json",
                    "success": function (data) {
                        especiesJson = data;
                    }
                   });
            $.ajax({"url": "/api/auxiliares/destinatario.json",
                    "dataType": "json",
                    "success": function (data) {
                        destinosJson = data;
                    }
                   });
        }
    });

    // DESCARGAS
    //carga las descargas asociadas
    var loadDescargas = function (idRecalada) {
        return false; // XXX:
    }

    // abre el modal y pobla los selects
    var loadDescargaModal = function (sendUrl) {
        var idRecalada = $("#recaladas-table tr.selected").children().first().text();
        var fechaRecalada = $("#recaladas-table tr.selected>td:nth-child(2)").data("fecha");
        var fechaZarpe = $("#mareas-table tr.selected>td:nth-child(3)").data("fecha");

        if(!idRecalada || !fechaZarpe){
            warningNotify('No se puede registrar una nueva descarga si no se ha seleccionado una mareas y una recalada primero!')
            return false;
        }

        numRow = 0;

        populateSelect('.modal #arte-pesca-id', '/api/artePesca.json');

        /*var newDescargaModal = bootbox.dialog({
            message: function () {
                var sFrm = $("#descargas-modal").html();
                var oFrm = $('<div/>').html(sFrm).contents();
                oFrm.find('.datetime-picker').datetimepicker(datetimeOptions());
                oFrm.find('#fecha-pesca').parent().data("DateTimePicker").minDate(moment(fechaZarpe)).maxDate(moment(fechaRecalada));
                oFrm.find('#termino-desembarque').parent().data("DateTimePicker").minDate(moment(fechaRecalada));

                return oFrm;
            },
            title: "Nueva Descarga",
            className: "modal-darkorange",
            closeButton: false,
            size: 'large',
            buttons: {
                success: {
                    label: "Enviar",
                    className: "btn-mary",
                    callback: function () {
                        var modalForm = $('.modal');
                        $('.modal #new-descarga-form').append('<input type="hidden" name="recalada_id" value="'+idRecalada+'"');
                        formData = serializeForm('.modal #new-descarga-form');
                        formData['recalada_id'] = idRecalada;
                        $.post( sendUrl,
                                formData,
                                function ( data ) {
                                    console.log(data);
                                    if ($.isEmptyObject(data)) {
                                        loadDescargas(idRecalada);
                                        //modalForm.modal('hide');
                                        successNotify('Descarga registrada con exito!');
                                    } else {
                                        parseErrors(data, '.modal #new-descarga-form');
                                        errorNotify('No se pudo registrar la descarga. Existen errores en el formulario!');
                                    }
                                }, 'json');

                        return false;
                    }
                },
                "Cancelar": {
                    className: "btn-danger",
                    callback: function () {
                        var modalForm = $('.modal');
                        bootbox.confirm({
                            "message" : "¿Seguro de cerrar el formulario?",
                            "backdrop" : false,
                            "callback" : function (result) {
                                if (result)
                                    modalForm.modal('hide');
                                else
                                    modalForm.modal('handleUpdate')
                            }
                        });
                        return false;
                    }
                }
            }
        });*/

        var newDescargaModal = createModal(
            "Nueva Descarga",
            function () {
                var sFrm = $("#descargas-modal").html();
                var oFrm = $('<div/>').html(sFrm).contents();
                oFrm.find('.datetime-picker').datetimepicker(datetimeOptions());
                oFrm.find('#fecha-pesca').parent().data("DateTimePicker").minDate(moment(fechaZarpe)).maxDate(moment(fechaRecalada));
                oFrm.find('#termino-desembarque').parent().data("DateTimePicker").minDate(moment(fechaRecalada));

                return oFrm;
            },
            function () {
                var modalForm = $(this);
                formData = serializeForm($('#new-descarga-form', modalForm));
                formData['recalada_id'] = idRecalada;
                $.post( sendUrl,
                        formData,
                        function ( data ) {
                            console.log(unescape(data));
                            if ($.isEmptyObject(data)) {
                                loadDescargas(idRecalada);
                                //modalForm.modal('hide');
                                successNotify('Descarga registrada con exito!');
                            } else {
                                //parseErrors(data, '.modal #new-descarga-form');
                                errorNotify('No se pudo registrar la descarga. Existen errores en el formulario!');
                            }
                        });

                return false;
            },
            'large'
        );

        $("#new-detalle-descarga", newDescargaModal).click(function (e) {
            e.preventDefault();
            var specieSelect = createSelect('descarga_detalles['+numRow+'][especie_id]', especiesJson);
            var quantityInput = '<input type="number" name="descarga_detalles['+numRow+'][unidades][0][_joinData][cantidad]" required> <strong>TON</strong>';
            var zoneInput = '<input type="number" name="descarga_detalles['+numRow+'][zona_pesca]" required>';
            var destinationSelect = createSelect('descarga_detalles['+numRow+'][destinatario_id]', destinosJson);

            $('.modal #tblDetalles tbody').append('<tr><td>'+specieSelect+'</td><td>'+quantityInput+'</td><td>'+zoneInput+'</td><td>'+destinationSelect+'</td></tr>');
            numRow++;
        });
        $("#del-detalle-descarga", newDescargaModal).click(function (e) {
            e.preventDefault();
            bootbox.confirm({
                "message" : "¿Seguro de borrar un detalle de descarga?",
                "backdrop" : false,
                "callback" : function (result) {
                    if (result) {
                        $('.modal #tblDetalles tbody').children().last().remove();
                        newDescargaModal.data("bs.modal").toggle();
                    }
                }
            });
        });

        return newDescargaModal;
    }

    // nueva marea
    $("#new-descarga").on('click', function () {
        var idRecalada = $("#recaladas-table tr.selected").children().first().text();
        var fechaRecalada = $("#recaladas-table tr.selected>td:nth-child(2)").data("fecha");
        var fechaZarpe = $("#mareas-table tr.selected>td:nth-child(3)").data("fecha");
        if(!idRecalada || !fechaZarpe){
            warningNotify('No se puede registrar una nueva descarga si no se ha seleccionado una mareas y una recalada primero!')
            return false;
        }
        newEntity('Nueva Descarga', '/descarga_encabezados/add/')
        //loadDescargaModal("/api/descargas/add.json");
    });

}
