console.log('--- Sw StockLocation integrationModel admin ---');
// BASE_URL+'swstocklocation_admin/adminhtml_newlocation',


var integrationModel = Class.create();
integrationModel.prototype = {
    urlIntegrationController : null,

    initialize: function (urlIntegrationController='') {
        this.urlIntegrationController = urlIntegrationController;
        // console.log(this.urlIntegrationController);
    },

    OffWeGo: function(counter=0) {
        document.getElementById('offwego_button').disabled = true;
        this.ShiftExistingLocations(counter, this.urlIntegrationController);
        // this.Change...();
    },

    ShiftExistingLocations: function (counter=0, urlI='', obj=this) {
        if (urlI=='') {
            // this.urlIntegrationController = $('urlAjax').value;
           console.log ('I need the url ');
           return;
        }

        var timeout    = 100000; // 100000;
        var numberRow  = 10000;

        if(counter < 15) {
            counter++;

            setTimeout(function(){
                console.log(counter);

                //*
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
                        onSuccess: function(transport) {
                            // console.log(transport);
                            try {
                                if (transport.responseText.isJSON()) {
                                    var response = transport.responseText.evalJSON();
                                    // console.log(response);

                                    document.getElementById('resultOfIntegration').innerHTML =
                                        'Total: <b>'+ response.totalRows + '</b> records. '+
                                        'Copleted: <b>'+response.completeRows + '</b>';

                                    if (response.completeRows >= response.totalRows) {
                                        counter = counter+10000;
                                    }

                                    // this.updateResultDiv(response);

                                    if (response.error) {
                                        alert(response.message);
                                    }

                                } else {
                                    // $(tabContentElement.id).update(transport.responseText);
                                    // this.showTabContentImmediately(tab);
                                }
                            }
                            catch (e) {
                                // $(tabContentElement.id).update(transport.responseText);
                                // this.showTabContentImmediately(tab);
                            }
                        }.bind(this)
                    }
                );

                // integrat = new integrationModel(urlI);
                obj.ShiftExistingLocations(counter, urlI);

                /* */
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

}

