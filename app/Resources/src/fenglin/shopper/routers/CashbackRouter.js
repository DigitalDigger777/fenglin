/**
 * Created by korman on 27.01.17.
 */

define(['marionette', 'shopper/controllers/CashbackController'], function(Marionette, CashbackController){

    var CashbackRouter = Marionette.AppRouter.extend({
        controller: CashbackController,
        appRoutes: {
            'cashback/confirm/:memberId': 'confirm'
        }
    });

    return new CashbackRouter();
});