/**
 * Created by korman on 27.01.17.
 */

define(['marionette', 'consumer/controllers/ConsumerController'], function(Marionette, ConsumerController){

    var ConsumerRouter = Marionette.AppRouter.extend({
        controller: ConsumerController,
        appRoutes: {
            'consumer/home':'homePage',
            'consumer/show-member-number': 'memberNumberPage'
        }
    });

    return new ConsumerRouter();
});