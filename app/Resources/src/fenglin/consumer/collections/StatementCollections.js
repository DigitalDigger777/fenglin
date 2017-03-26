/**
 * Created by korman on 27.01.17.
 */

define(['backbone', 'consumer/models/ShopperModel'], function(Backbone, ShopperModel){

    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);

    return Backbone.Collection.extend({
        apikey: match[1],
        url: function(){
            console.log(this.id);
            return Routing.generate('panda_shopper_rest_cash_back_list', {
                id: this.id,
                apikey: this.apikey
            });
        },
        model: ShopperModel,
        initialize: function(models, options){
            this.id = options.id;
        }
    });
});