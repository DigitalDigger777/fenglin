/**
 * Created by korman on 27.01.17.
 */

define(['marionette', 'shopper/controllers/ConsumerController'], function(Marionette, ConsumerController){

    var ShopperRouter = Marionette.AppRouter.extend({
        controller: ConsumerController,
        appRoutes: {
            'consumer/search':'search'
        }
    });

    return new ShopperRouter();
});