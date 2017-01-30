/**
 * Created by korman on 27.01.17.
 */

define(['backbone', 'consumer/models/ShopperModel'], function(Backbone, ShopperModel){

    var urlRoot = requirejs.s.contexts._.config.urlRoot;

    return Backbone.Collection.extend({
        url: function(){
            console.log(this.id)
            return Routing.generate('panda_shopper_rest_cash_back_list', {id: this.id});
        },
        model: ShopperModel,
        initialize: function(models, options){
            this.id = options.id;
        }
    });
});