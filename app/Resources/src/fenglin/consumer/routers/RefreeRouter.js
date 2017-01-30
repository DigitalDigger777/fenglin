/**
 * Created by korman on 27.01.17.
 */

define(['marionette',
        'consumer/controllers/RefreeController'
], function(Marionette, RefreeController){

    var RefreeRouter = Marionette.AppRouter.extend({
        controller: RefreeController,
        appRoutes: {
            'consumer/refree': 'refreePage'
        }
    });

    return new RefreeRouter();
});