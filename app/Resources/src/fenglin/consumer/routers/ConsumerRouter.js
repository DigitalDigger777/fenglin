/**
 * Created by korman on 27.01.17.
 */

define(['marionette', 'consumer/controllers/ConsumerController'], function(Marionette, ConsumerController){

    var ConsumerRouter = Marionette.AppRouter.extend({
        controller: ConsumerController,
        appRoutes: {
            'consumer/home':'homePage',
            'consumer/show-member-number': 'memberNumberPage',
            'consumer/member-id': 'memberNumberPage',
            'consumer/join-to-shopper/:shopperId': 'joinToShopper'
        }
    });

    return new ConsumerRouter();
});