/**
 * Created by korman on 27.01.17.
 */

define(['backbone'], function(Backbone){
    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(window.location.search);;

    return Backbone.Model.extend({
        urlRoot: Routing.generate('panda_consumer_rest_index', {
            apikey: match[1]
        })
    });

});