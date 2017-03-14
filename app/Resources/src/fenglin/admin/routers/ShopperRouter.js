
/**
 * Created by korman on 10.03.17.
 */

define(['marionette', 'admin/controllers/ShopperController'], function(Marionette, ShopperController){

    var ShopperRouter = Marionette.AppRouter.extend({
        controller: ShopperController,
        appRoutes: {
            'admin/shopper/inactive-reactive/account': 'inactiveReactiveAccount',
            'admin/shopper/new-shopper': 'newShopper',
            'admin/shopper/search/:name': 'search'
        }
    });

    return new ShopperRouter();
});