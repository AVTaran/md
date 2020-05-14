console.log('--- Sw StockLocation admin ---');
// BASE_URL+'swstocklocation_admin/adminhtml_newlocation',


var newStockLocationModel = Class.create();
newStockLocationModel.prototype = {
    // printAdaptor: null,
    urlNewLocationController : null,
    initialize: function (urlNewLocationController='') {
        // this.printAdaptor = printAdaptor;
        this.urlNewLocationController = urlNewLocationController;

        // this.setDefaultVal('id_zone');
    },

    setDefaultVal: function(obj){
        // console.log('defaultVal_'+obj);
        var defaultVal = $('defaultVal_'+obj).value;
        var selector = $(obj);
        for (var i=0; i<selector.options.length; i++) {
            selector.options[i].selected = false;
            if (selector.options[i].value==defaultVal) {
                selector.options[i].selected = true;
            }
        }
    },

    checkAjax: function(event) {
        // console.log('checkJS');
        // alert('checkJS');
        // console.log(this.urlNewLocationController);
        // console.log(BASE_URL);
        this.showProduct();
        //  this.showAvailableLocation();
    },

    changeOptions: function (arTargets) {
        // console.log(arTargets);
        // var arTargets = [{obj:'id_zone', target:'id_block'}, {obj:'id_block', target:'id_shelf'}];
        // console.log(arTargets);

        if (arTargets.length>0) {
                for (var i = 0; i < arTargets.length; i++) {
                    console.log(arTargets[i].obj, arTargets[i].target);
                    // $(targetSelect).append(new Option(Options[i]['name'], Options[i]['id']));
                    this.takeOptionsForSelect(arTargets[i].obj, arTargets[i].target);
                }
            }
        // this.takeOptionsForSelect('id_zone', 'id_block');
        // this.takeOptionsForSelect('id_block', 'id_shelf');
    },

    takeOptionsForSelect: function (curObj, targetSelect) {
        console.log(curObj, targetSelect);
        // console.log(targetSelect);
        // console.log(this.urlNewLocationController);

        if (this.urlNewLocationController=='') {
            this.urlNewLocationController = $('urlAjax').value;
        }
        var defaultVal = $('defaultVal_'+targetSelect).value;

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

                            this.updateOptions(response.targetSelect, response.OptionsForSelect, defaultVal);

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

    updateOptions: function (targetSelect, Options, selectedVal) {
        // console.log($(targetSelect));
        // console.log(Options);
        // console.log(selectedVal);

        $(targetSelect).options.length = 0;
        // document.getElementById(targetSelect).options.length = 0;

        if (Options.length>0) {
            for (var i=0; i < Options.length; i++) {
                // console.log(Options[i]);
                $(targetSelect).append(new Option(Options[i]['name'], Options[i]['id']));
            }
            $(targetSelect).removeAttribute('disabled');
            // document.getElementById(targetSelect).removeAttribute('disabled');
        } else {
            // console.log('else');
            $(targetSelect).append(new Option('Please select a previous element', '-1'));
            // console.log('/else');
            selectedVal = '-1';
        }

        for (var i=0; i<$(targetSelect).options.length; i++) {
            if ($(targetSelect).options[i].value==selectedVal) {
                $(targetSelect).options[i].selected = true;
            }
        }

    },

    updateProductInformation: function (html) {
        $('productInformation').innerHTML = html;
    },

}


newStockLocation = new newStockLocationModel();

window.onload = function () {
    newStockLocation.setDefaultVal('id_zone');
    newStockLocation.setDefaultVal('id_block');
};