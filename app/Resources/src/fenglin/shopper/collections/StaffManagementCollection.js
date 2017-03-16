/**
 * Created by korman on 29.01.17.
 */

define(['backbone', 'shopper/models/StaffModel'], function(Backbone, StaffModel){


    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);
    return Backbone.Collection.extend({
        apikey: match[1],
        url: Routing.generate('panda_staff_rest_list', {
            apikey: match[1]
        }),
        model: StaffModel
    });
});