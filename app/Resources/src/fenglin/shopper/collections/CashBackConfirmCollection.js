/**
 * Created by korman on 29.01.17.
 */

define(['backbone', 'consumer/models/ShopperModel'], function(Backbone, ShopperModel){

    var urlRoot = requirejs.s.contexts._.config.urlRoot;

    return Backbone.Collection.extend({
        url: Routing.generate('panda_shopper_rest_list'),
        model: ShopperModel
    });
});