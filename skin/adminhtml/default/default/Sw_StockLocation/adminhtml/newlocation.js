
console.log('Sw StockLocation New location admin --- ');
// BASE_URL+'swstocklocation_admin/adminhtml_newlocation',


var newLocationModel = Class.create();
newLocationModel.prototype = {
    // printAdaptor: null,
    urlNewLocationController : null,
    initialize: function (urlNewLocationController='/') {
        // this.printAdaptor = printAdaptor;
        this.urlNewLocationController = urlNewLocationController;
    },

    takeCheckedValues: function(classOfCheckGroup) {
        var Objects = $$(""+classOfCheckGroup+":checkbox:checked");
        let ar = [];
        Objects.each(function(obj) {
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
        this.showProduct();
        //  this.showAvailableLocation();
    },

    showAvailableLocation: function(event) {

        // var arZone = this.takeCheckedValues('.zoneCheck');
        // console.log(arZone);
        // return;

        this.updateAvailableLocation('');

        new Ajax.Request(
            this.urlNewLocationController,
            {
                parameters: {
                    form_key: FORM_KEY,
                    ajax : '1',
                    operation : 'getAvailableLocation',
                    'param[filter][size][]': this.takeCheckedValues('.sizeOfBox'),
                    'param[filter][type][]': this.takeCheckedValues('.typeOfBox'),
                    'param[filter][zone][]': this.takeCheckedValues('.zoneCheck'),
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

    showProduct : function(event) {

        this.updateProductInformation('');

        new Ajax.Request(
            this.urlNewLocationController,
            {
                parameters: {
                    form_key: FORM_KEY,
                    ajax : '1',
                    operation : 'getProduct',
                    'param[searchLine]': $('searchLine').value,
                },
                evalScripts: true,
                onSuccess: function(transport) {
                    console.log(transport);
                    try {
                        if (transport.responseText.isJSON()) {
                            var response = transport.responseText.evalJSON();
                            console.log(response);
                            if (response.error) {
                                alert(response.message);
                            }

                            this.updateProductInformation(response.productInformation);

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


        //
        // new Ajax.Request(
        //     'https://r0pmf9m3ro-dsn.algolia.net/1/indexes/md_magento_default_products/query?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%20(lite)%203.31.0%3BMagento%20integration%20(1.16.0)&x-algolia-application-id=R0PMF9M3RO&x-algolia-api-key=MzQzMmIwNzViODJiYTJlMjA4NDIxZmFhNjkyMzFhMWIxNmY1NTAxMmY4OTZmNTNmYTM4M2I4Y2MwNDI1ODU2MGZpbHRlcnM9',
        //     {
        //         parameters: {
        //             form_key: FORM_KEY,
        //             // ajax : '1',
        //             operation : 'getProduct',
        //             'param[searchLine]': $('searchLine').value,
        //             params: 'query='+$('searchLine').value+'&hitsPerPage=6&analyticsTags=sw&clickAnalytics=false&facets=%5B%22categories.level0%22%5D&numericFilters=visibility_search%3D1'
        //         },
        //         evalScripts: true,
        //         onSuccess: function(transport) {
        //             console.log(transport);
        //             // try {
        //             //     if (transport.responseText.isJSON()) {
        //             //         var response = transport.responseText.evalJSON();
        //             //         console.log(response);
        //             //         if (response.error) {
        //             //             alert(response.message);
        //             //         }
        //             //
        //             //         this.updateProductInformation(response.locationsTable);
        //             //
        //             //         // if(response.ajaxExpired && response.ajaxRedirect) {
        //             //         //     setLocation(response.ajaxRedirect);
        //             //         // }
        //             //     } else {
        //             //         // $(tabContentElement.id).update(transport.responseText);
        //             //         // this.showTabContentImmediately(tab);
        //             //     }
        //             // }
        //             // catch (e) {
        //             //     // $(tabContentElement.id).update(transport.responseText);
        //             //     // this.showTabContentImmediately(tab);
        //             // }
        //         }.bind(this)
        //     }
        // );


    },

    eventFilterChange : function(event) {

        this.updateAvailableLocation('');
        this.showAvailableLocation();
        // var tab = Event.findElement(event, 'a');

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
        $('availableLocations').innerHTML = html;
    },

    updateProductInformation: function (html) {
        $('productInformation').innerHTML = html;
    },


}

// newLocation = new newLocationModel();


