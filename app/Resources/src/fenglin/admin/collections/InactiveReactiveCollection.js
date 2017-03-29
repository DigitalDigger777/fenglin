/**
 * Created by korman on 29.01.17.
 */

define(['backbone', 'consumer/models/ShopperModel'], function(Backbone, ShopperModel){


    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);
    return Backbone.Collection.extend({
        apikey: match[1],
        url: Routing.generate('panda_shopper_rest_list', {
            apikey: match[1]
        }),
        model: ShopperModel
    });


});