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
                            // console.log(response);
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
                    form_key            : FORM_KEY,
                    ajax                : '1',
                    operation           : 'getProduct',
                    'param[searchLine]' : $('searchLine').value
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

    },

    eventFilterChange : function(event) {
        this.updateAvailableLocation('');
        this.showAvailableLocation();
    },

    updateAvailableLocation: function (html) {
        $('availableLocations').innerHTML = html;
    },

    updateProductInformation: function (html) {
        $('productInformation').innerHTML = html;
    },

    updateTableLinksLocationProduct: function(el) {
        // console.log(el.innerHTML);
        // console.log(el.getAttribute('locationId'));

        var locId = el.getAttribute('locationId');

        if($('placeForNewLinkProductAndLocation') == undefined) {
            console.log('Is which one product?');
            alert('Is which one product? Firstly find a product.');
        } else {

            var htmlObj =
                '<table class="listLocations" id="listLocations">' +
                    '<tr>' +
                        '<td class="name">' +
                            el.innerHTML +
                        '</td>' +
                        '<td class="qty">' +
                            '<input id="qty" type="text" value="1">' +
                        '</td>' +
                        '<td class="operation">' +
                            '<input id="updateQty" type="button" value="OK" onclick="newLocation.updateQtyLocationProduct('+locId+');">'+
                        '</td>' +
                    '</tr>' +
                '</table>'
            ;

            // console.log(htmlObj);
            $('placeForNewLinkProductAndLocation').innerHTML = htmlObj;
        }
        // console.log($('placeForNewLinkProductAndLocation'));
        // $('placeForNewLinkProductAndLocation').innerHTML = html;
    },


    updateQtyLocationProduct: function(locId) {
        var Qty     = $$('#placeForNewLinkProductAndLocation .qty input')[0].value;
        var prodId  = $$('.short-product-info input')[0].value;

        new Ajax.Request(
            this.urlNewLocationController,
            {
                parameters: {
                    form_key            : FORM_KEY,
                    ajax                : '1',
                    operation           : 'updateQtyLocationProduct',
                    'param[prodId]'     : prodId,
                    'param[locId]'      : locId,
                    'param[Qty]'        : Qty
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
        /* */
    }

}




// Event.observe(document, 'click', respondToClick);
// function respondToClick(event) {
//     var element = event.element();
//     alert("Tag Name : " + element.tagName );
// }


// $$('#tableLinksLocationProduction td a').each(function(element) {
//     // var ttt = $j('#tableLinksLocationProduction td a').text();
//     // console.log(ttt);
//     // ttt = 'ffff';
//     // newLocation.updateTableLinksLocationProduction(ttt);
//     element.observe('click', newLocation.updateTableLinksLocationProduction(element));
// })

// newLocation = new newLocationModel();


