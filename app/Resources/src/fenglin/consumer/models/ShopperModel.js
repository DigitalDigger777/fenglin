/**
 * Created by korman on 27.01.17.
 */

define(['backbone'], function(Backbone){
    var urlRoot = requirejs.s.contexts._.config.urlRoot;

    return Backbone.Model.extend({
        urlRoot: Routing.generate('panda_shopper_rest_index')
    });

});