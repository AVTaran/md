console.log('--- Sw StockLocation integrationModel admin ---');
// BASE_URL+'swstocklocation_admin/adminhtml_newlocation',


var integrationModel = Class.create();
integrationModel.prototype = {
    urlIntegrationController : null,

    initialize: function (urlIntegrationController='') {
        this.urlIntegrationController = urlIntegrationController;
        // console.log(this.urlIntegrationController);
    },

    OffWeGo: function() {
        document.getElementById('offwego_button').disabled = true;
        this.ShiftExistingLocations(0, this.urlIntegrationController);
    },

    ShiftExistingLocations: function (counter=0, urlI='', obj=this) {
        if (urlI=='') {
            // this.urlIntegrationController = $('urlAjax').value;
           console.log ('I need the url ');
           return;
        }

        var timeout    = 100000;
        var numberRow  = 10000;
        if(counter < 15) {
            counter++;

            setTimeout(function(){
                new Ajax.Request(
                    urlI,
                    {
                        parameters: {
                            form_key        : FORM_KEY,
                            ajax            : '1',
                            operation       : 'ShiftExistingLocations',
                            'param[number]' : numberRow,
                            'param[portion]': counter,
                        },
                        evalScripts: true,
                        onSuccess: function(transport) {    // console.log(transport);
                            try {
                                if (transport.responseText.isJSON()) {
                                    var response = transport.responseText.evalJSON();  // console.log(response);
                                    if (response.error) { alert(response.message); }

                                    obj.updateResultDiv(response);

                                    document.getElementById('resultOfIntegration').innerHTML =
                                        'Total: <b>'+ response.totalRows + '</b> records. '+
                                        'Copleted: <b>'+response.completeRows + '</b>'
                                    ;
                                    if (response.completeRows >= response.totalRows) {
                                        counter = counter+10000;
                                    }

                                } else {
                                    console.log(response);
                                }
                            } catch (e) {
                                console.log(e, transport);
                            }
                        }.bind(this)
                    }
                );

                obj.ShiftExistingLocations(counter, urlI);

            }, timeout);
        } else{
            console.log('Locations is Shifted');
            alert('Locations is Shifted');
            document.getElementById('offwego_button').disabled = false;
        }

    },

    updateResultDiv: function (res) {
        console.log(res);
     },

    countSizeOfLocations: function() {
        console.log('countSizeOfLocations');

        new Ajax.Request(
            this.urlIntegrationController,
            {
                parameters: {
                    form_key        : FORM_KEY,
                    ajax            : '1',
                    operation       : 'countSizeOfLocations',
                    'param[obj]'    : 'zones',
                    'param[objId]'  : '1',
                },
                evalScripts: true,
                onSuccess: function(transport) {    // console.log(transport);
                    try {
                        if (transport.responseText.isJSON()) {
                            var response = transport.responseText.evalJSON();  // console.log(response);
                            if (response.error) { alert(response.message); }

                            obj.updateResultDivSize(response);

                            document.getElementById('resultOfIntegration').innerHTML =
                                'Total: <b>'+ response.totalRows + '</b> records. '+
                                'Copleted: <b>'+response.completeRows + '</b>'
                            ;
                            if (response.completeRows >= response.totalRows) {
                                counter = counter+10000;
                            }

                        } else {
                            console.log(response);
                        }
                    } catch (e) {
                        console.log(e, transport);
                    }
                }.bind(this)
            }
        );

    },

    updateResultDivSize: function (res){
        console.log(res);
    },

}

