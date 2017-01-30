/**
 * Created by korman on 27.01.17.
 */

define(['backbone'], function(Backbone){
    var urlRoot = requirejs.s.contexts._.config.urlRoot;

    return Backbone.Model.extend({
        urlRoot: urlRoot + 'en/pass/rest/coupon'
    });

});