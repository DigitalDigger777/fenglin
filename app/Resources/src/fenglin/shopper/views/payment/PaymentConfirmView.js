/**
 * Created by korman on 27.01.17.
 */

define(['marionette',
    'shopper/views/core/MenuHomeView',
    'shopper/models/CashBackConfirmModel',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/LoadingToastView'
], function(
    Marionette,
    MenuHomeView,
    CashBackConfirmModel,
    ErrorToastView,
    LoadingToastView
){
    var payable             = 0.00;
    var balance             = 0.00;

    var loadToast = new LoadingToastView();
    var errorToast = new ErrorToastView();

    loadToast.render();
    errorToast.render();

    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#paymentConfirmView',
        ui: {
            //calculateInput: '#calculateInput',
            calculateCashBackValue: '#calculateCashBackValue',
            confirm: '[href="#payment/confirm"]',
            cashBackButton: '#cashBackButton',
            calculateButton: '#calculateButton'
        },
        events: {
            //'keyup @ui.calculateInput': function(e){
            //    var amount = $('#calculateInput').val();
            //    var rebate = $('[data-rebate]').attr('data-rebate');
            //    var cashBack = (parseInt(amount)/100) * rebate;
            //    $('#calculateCashBackValue').text(cashBack);
            //    //console.log(amount, '-', rebate, '-', cashBack);
            //},
            'click @ui.calculateButton': function(){
                var calcVal             = parseFloat($('#calculateInput').val());
                var calcCashBackValue   = window.localStorage.getItem('member_total_amount');


                if (calcVal > calcCashBackValue) {
                    payable = calcVal - calcCashBackValue;
                } else {
                    balance = calcCashBackValue - calcVal;
                }

                $('#payable').text(payable);
                $('#calculateCashBackValue').text(balance);
                console.log(calcVal, '-', calcCashBackValue, '-payable:', payable, '-balance:', balance);
            },
            'click @ui.cashBackButton': function(e){
                e.preventDefault();
                var calculateInput = $('#calculateInput').val();
                if (calculateInput != '') {
                    var memberId = window.localStorage.getItem('member_id');
                    var cashBackConfirmModel = new CashBackConfirmModel();
                    cashBackConfirmModel.set('id', memberId);
                    cashBackConfirmModel.set('payable', payable);
                    cashBackConfirmModel.set('balance', balance);

                    loadToast.show();
                    cashBackConfirmModel.save(null, {
                        success: function(){
                            window.localStorage.removeItem('member_id');
                            window.localStorage.removeItem('member_total_amount');

                            window.location.hash = '#cashback/confirm/' + memberId;
                            loadToast.hide();
                        },
                        error: function(){
                            loadToast.hide();
                            errorToast.show();

                            setTimeout(function(){
                                errorToast.hide();
                            }, 3000);
                        }
                    });
                }
                //alert(payable + '-' + balance + '-memberId:' + memberId);
            },
            'click @ui.confirm': function(e){
                //e.preventDefault();
                //var paymentConfirmView = new PaymentConfirmView();
                //paymentConfirmView.render();
            }
        },
        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuHomeView();
            menu.render();

        }
    });
});