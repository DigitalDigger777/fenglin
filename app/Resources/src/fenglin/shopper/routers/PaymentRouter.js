/**
 * Created by korman on 27.01.17.
 */

define(['marionette', 'shopper/controllers/PaymentController'], function(Marionette, PaymentController){

    var PaymentRouter = Marionette.AppRouter.extend({
        controller: PaymentController,
        appRoutes: {
            'payment/calculate':'calculate'
        }
    });

    return new PaymentRouter();
});