/**
 * Created by korman on 27.01.17.
 */

define(['marionette',
        'consumer/controllers/StatementController'
], function(Marionette, StatementController){

    var RefreeRouter = Marionette.AppRouter.extend({
        controller: StatementController,
        appRoutes: {
            'consumer/statement/:id': 'statementPage'
        }
    });

    return new RefreeRouter();
});