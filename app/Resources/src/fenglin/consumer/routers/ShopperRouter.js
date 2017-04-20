/**
 * Created by korman on 27.01.17.
 */

define(['marionette', 'consumer/controllers/ShopperController'], function(Marionette, ShopperController){

    var ConsumerRouter = Marionette.AppRouter.extend({
        controller: ShopperController,
        appRoutes: {
            'consumer/shopper/detail/:id':'showDetailPage',
            'consumer/shopper/join-page/:id':'shopperJoinPage'
        }
    });

    return new ConsumerRouter();
});