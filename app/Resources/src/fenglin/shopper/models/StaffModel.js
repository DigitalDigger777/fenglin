/**
 * Created by korman on 27.01.17.
 */

define(['backbone'], function(Backbone){
    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);

    return Backbone.Model.extend({
        apikey: match[1],
        urlRoot: Routing.generate('panda_staff_rest_index'),
        url: function(){
            this.id = this.id == undefined ? 0 : this.id;

            var url = this.urlRoot + '/' + this.id;
            url = url + "?apikey=" + match[1];

            return url;
        }
    });

});