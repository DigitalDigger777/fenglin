/**
 * Created by korman on 29.01.17.
 */

define(['backbone', 'consumer/models/ShopperModel'], function(Backbone, ShopperModel){

    // var urlRoot = requirejs.s.contexts._.config.urlRoot;
    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);

    return Backbone.Collection.extend({
        apikey: match[1],
        url: function() {
            return Routing.generate('fenglin_cash_back_rest_list', {
                apikey: match[1],
                transactionId: this.transactionId
            })
        },
        model: ShopperModel
    });
});