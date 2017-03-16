/**
 * Created by korman on 29.01.17.
 */

define(['backbone', 'consumer/models/ShopperModel'], function(Backbone, ShopperModel){


    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);
    return Backbone.Collection.extend({
        initialize: function(models, options){
            this.transactionId = options.transactionId;
        },
        apikey: match[1],
        url: function() {
            return Routing.generate('fenglin_cash_back_rest_confirm_cash_back_list', {
                apikey: match[1],
                transactionId: this.transactionId
            })
        },
        model: ShopperModel
    });
});