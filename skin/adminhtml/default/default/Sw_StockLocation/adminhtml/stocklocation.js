console.log('--- Sw StockLocation admin ---');
// BASE_URL+'swstocklocation_admin/adminhtml_newlocation',


var newStockLocationModel = Class.create();
newStockLocationModel.prototype = {
    // printAdaptor: null,
    urlNewLocationController : null,
    initialize: function (urlNewLocationController='') {
        // this.printAdaptor = printAdaptor;
        this.urlNewLocationController = urlNewLocationController;
    },

    checkAjax: function(event) {
        // console.log('checkJS');
        // alert('checkJS');
        // console.log(this.urlNewLocationController);
        // console.log(BASE_URL);
        this.showProduct();
        //  this.showAvailableLocation();
    },


    tackeOptionsForSelect: function (curObj, targetSelect) {
        // console.log(curObj);
        // console.log(targetSelect);
        // console.log(this.urlNewLocationController);

        if (this.urlNewLocationController=='') {
            this.urlNewLocationController = $('urlAjax').value;
        }

        new Ajax.Request(
            this.urlNewLocationController,
            {
                parameters: {
                    form_key: FORM_KEY,
                    ajax : '1',
                    operation : 'getOptionsForSelect',
                    'param[targetSelect]'   : targetSelect,
                    'param[curObj]'         : curObj,
                    'param[curObjId]'       : $(curObj).value
                },
                evalScripts: true,
                onSuccess: function(transport) {
                    // console.log(transport);
                    try {
                        if (transport.responseText.isJSON()) {
                            var response = transport.responseText.evalJSON();
                            // console.log(response);
                            if (response.error) {
                                alert(response.message);
                            }

                            this.updateOptions(response.targetSelect, response.OptionsForSelect);

                            // if(response.ajaxExpired && response.ajaxRedirect) {
                            //     setLocation(response.ajaxRedirect);
                            // }
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

    },

    updateOptions: function (targetSelect, Options) {
        // console.log($(targetSelect));
        //console.log(Options);

        document.getElementById(targetSelect).options.length = 0;

        if (Options.length>0) {
            for (var i=0; i < Options.length; i++) {
                // console.log(Options[i]);
                $(targetSelect).append(new Option(Options[i]['name'], Options[i]['id']));
            }
            document.getElementById(targetSelect).removeAttribute('disabled');

        } else {
            // console.log('else');
            $(targetSelect).append(new Option('Please select a previous element', '-1'));
            for (var i=0; i<document.getElementById(targetSelect).options.length; i++) {
                if (document.getElementById(targetSelect).options[i].value=='-1') {
                    document.getElementById(targetSelect).options[i].selected = true;
                }
            }
            // console.log('/else');
        }
    },

    updateProductInformation: function (html) {
        $('productInformation').innerHTML = html;
    },

}


newStockLocation = new newStockLocationModel();
