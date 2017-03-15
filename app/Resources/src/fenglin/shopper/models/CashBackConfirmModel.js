/**
 * Created by korman on 29.01.17.
 */

//fenglin_cash_back_rest_confirm_cash_back

define(['backbone'], function(Backbone){
    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);

    return Backbone.Model.extend({
        apikey: match[1],
        urlRoot: Routing.generate('fenglin_cash_back_rest_confirm_cash_back'),
        url: function(){
            this.id = this.id == undefined ? 0 : this.id;

            var url = this.urlRoot + '/' + this.id;
            url = url + "?apikey=" + match[1];

            return url;
        }
    });

});