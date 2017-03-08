/**
 * Created by korman on 27.01.17.
 */

define(['backbone'], function(Backbone){
    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);

    return Backbone.Model.extend({
        apikey: match[1],
        urlRoot: Routing.generate('panda_consumer_rest_index'),
        url: function(){
            var url = this.urlRoot + '/' + this.id;
            url = url + "?apikey=" + match[1];

            return url;
        }
    });

});