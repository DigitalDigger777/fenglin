/**
 * Created by korman on 27.01.17.
 * deprecated
 */

define(['marionette',
    'shopper/views/core/MenuHomeView',
    'shopper/views/payment/PaymentConfirmView'
], function(Marionette, MenuHomeView, PaymentConfirmView){
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#paymentCalculateView',
        ui: {
            calculateInput: '#calculateInput',
            calculateCashBackValue: '#calculateCashBackValue',
            confirm: '[href="#payment/confirm"]'
        },
        events: {
            'keyup @ui.calculateInput': function(e){
                var amount = $('#calculateInput').val();
                var rebate = $('[data-rebate]').attr('data-rebate');
                var cashBack = (parseInt(amount)/100) * rebate;
                //$('#calculateCashBackValue').text(cashBack);
                //console.log(amount, '-', rebate, '-', cashBack);
            },
            'click @ui.confirm': function(e){
                e.preventDefault();
                var paymentConfirmView = new PaymentConfirmView();
                paymentConfirmView.render();
            }
        },
        onRender: function(){
            console.log('payment calculate');
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuHomeView();
            menu.render();

        }
    });
});