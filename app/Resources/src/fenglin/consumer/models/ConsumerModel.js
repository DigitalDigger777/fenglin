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
            this.id = this.id == undefined ? 0 : this.id;

            var url = this.urlRoot + '/' + this.id;
            url = url + "?apikey=" + match[1];

            return url;
        },

        fetchByMemberId: function(success, error){
            //console.log(this.memberId);

            this.fetch({
                url: Routing.generate('panda_consumer_rest_load_by_member_id', {
                    apikey:this.apikey,
                    memberId: this.get('memberId')
                }),
                data: {},
                success: success,
                error: error
            });
        },
        joinToShopper: function (success, error) {
            $.ajax({
                url: Routing.generate('panda_consumer_rest_join_to_shopper', {
                    apikey: this.apikey,
                    shopperId: this.get('shopperId')
                }),
                data: 'json',
                method: 'post',
                success: success,
                error: error
            });
        },
        joinRefree: function(success, error) {
            $.ajax({
                url: Routing.generate('fenglin_fenglin_rest_index', {
                    apikey: this.apikey,
                    shopperId: this.get('shopperId'),
                    consumerId: this.get('consumerId')
                }),
                data: 'json',
                method: 'post',
                success: success,
                error: error
            });
        }
    });

});