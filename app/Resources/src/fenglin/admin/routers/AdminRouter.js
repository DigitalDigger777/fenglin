
/**
 * Created by korman on 10.03.17.
 */

define(['marionette', 'admin/controllers/AdminController'], function(Marionette, AdminController){

    var ShopperRouter = Marionette.AppRouter.extend({
        controller: AdminController,
        appRoutes: {
            'admin/login':'login'
        }
    });

    return new ShopperRouter();
});