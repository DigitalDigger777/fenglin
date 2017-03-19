/**
 * Created by korman on 29.01.17.
 */

define(['backbone', 'admin/models/AdminModel'], function(Backbone, AdminModel){


    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);
    return Backbone.Collection.extend({
        apikey: match[1],
        url: Routing.generate('fenglin_admin_rest_list', {
            apikey: match[1]
        }),
        model: AdminModel
    });


});