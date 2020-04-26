
// console.log('Sw StockLocation New location admin --- ');
// BASE_URL+'swstocklocation_admin/adminhtml_newlocation',


var newLocationModel = Class.create();
newLocationModel.prototype = {
    // printAdaptor: null,
    urlNewLocationController : null,
    initialize: function (urlNewLocationController) {
        // this.printAdaptor = printAdaptor;
        this.urlNewLocationController = urlNewLocationController; // + 'swstocklocation_admin/adminhtml_newlocation/';
    },

    takeCheckedValues: function(classOfCheckGroup) {
        var Objects = $$(""+classOfCheckGroup+":checkbox:checked");
        // return  Objects;
        let ar = [];
        Objects.each(function(obj) {
            // console.log(obj);
            var r = /\[(.+)\]/.exec(obj.name);
            if (r[1]) {
                ar.push(r[1]);
            }
        });
        return ar;
    },

    checkAjax: function(event) {
        // console.log('checkJS');
        // alert('checkJS');
        // console.log(this.urlNewLocationController);
        // console.log(BASE_URL);

        this.updateAvailableLocation('');
        this.showAvailableLocation();
    },

    showAvailableLocation: function(event) {

        // var arZone = this.takeCheckedValues('.zoneCheck');
        // console.log(arZone);
        // return;

        new Ajax.Request(
            this.urlNewLocationController,
            {
                parameters: {
                    form_key: FORM_KEY,
                    ajax : '1',
                    operation : 'getAvailableLocation',
                    'param[filter][size][]': this.takeCheckedValues('.sizeOfBox'), // 'Any',
                    'param[filter][type][]': this.takeCheckedValues('.typeOfBox'), // Any,
                    'param[filter][zone][]': this.takeCheckedValues('.zoneCheck'), // 'M',
                    'param[limit]': '20'
                },
                evalScripts: true,
                onSuccess: function(transport) {
                    // console.log(transport);
                    try {
                        if (transport.responseText.isJSON()) {
                            var response = transport.responseText.evalJSON();
                            console.log(response);
                            if (response.error) {
                                alert(response.message);
                            }

                            this.updateAvailableLocation(response.locationsTable);


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

    filterMouseClick : function(event) {
        var tab = Event.findElement(event, 'a');

        /*
        var tab = Event.findElement(event, 'a');

        // go directly to specified url or switch tab
        if ((tab.href.indexOf('#') != tab.href.length-1)
            && !(Element.hasClassName(tab, 'ajax'))
        ) {
            location.href = tab.href;
        }
        else {
            this.showTabContent(tab);
        }
        Event.stop(event);
        */
    },

    updateAvailableLocation: function (html) {
        // console.log(html);
        $('availableLocations').innerHTML = html;

    },

    // the lazy show tab method
    showTabContent : function(tab) {
        var tabContentElement = $(this.getTabContentElementId(tab));
        if (tabContentElement) {
            if (this.activeTab != tab) {
                if (varienGlobalEvents) {
                    if (varienGlobalEvents.fireEvent('tabChangeBefore', $(this.getTabContentElementId(this.activeTab))).indexOf('cannotchange') != -1) {
                        return;
                    };
                }
            }
            // wait for ajax request, if defined
            var isAjax = Element.hasClassName(tab, 'ajax');
            var isEmpty = tabContentElement.innerHTML=='' && tab.href.indexOf('#')!=tab.href.length-1;
            var isNotLoaded = Element.hasClassName(tab, 'notloaded');

            if ( isAjax && (isEmpty || isNotLoaded) )
            {
                new Ajax.Request(tab.href, {
                    parameters: {form_key: FORM_KEY},
                    evalScripts: true,
                    onSuccess: function(transport) {
                        try {
                            if (transport.responseText.isJSON()) {
                                var response = transport.responseText.evalJSON();
                                if (response.error) {
                                    alert(response.message);
                                }
                                if(response.ajaxExpired && response.ajaxRedirect) {
                                    setLocation(response.ajaxRedirect);
                                }
                            } else {
                                $(tabContentElement.id).update(transport.responseText);
                                this.showTabContentImmediately(tab);
                            }
                        }
                        catch (e) {
                            $(tabContentElement.id).update(transport.responseText);
                            this.showTabContentImmediately(tab);
                        }
                    }.bind(this)
                });
            }
            else {
                this.showTabContentImmediately(tab);
            }
        }
    },

}




