/**
 * Created by korman on 27.01.17.
 */

define(['backbone'], function(Backbone){
    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);

    return Backbone.Model.extend({
        apikey: match[1],
        urlRoot: Routing.generate('panda_shopper_rest_index'),
        url: function(){
            this.id = this.id == undefined ? 0 : this.id;

            var url = this.urlRoot + '/' + this.id;
            url = url + "?apikey=" + match[1];

            return url;
        },
        fetchByName: function(success, error){
            this.fetch({
                url: Routing.generate('panda_shopper_rest_load_by_name', {
                    apikey:this.apikey,
                    name: this.get('name')
                }),
                data: {},
                success: success,
                error: error
            });
        },
        fetchCurrentShopper: function(success, error){
            console.log(this.apikey);
            this.fetch({
                url: Routing.generate('panda_shopper_rest_load_current_shopper', {
                    apikey:this.apikey
                }),
                data: {},
                success: success,
                error: error
            });
        }
    });

});