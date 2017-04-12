/**
 * Created by korman on 27.01.17.
 */

define([
    'backbone',
    'marionette',
    'shopper/views/core/MenuHomeView',
    'shopper/models/CashBackConfirmModel',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/LoadingToastView',
    'consumer/views/core/CustomToastView'
], function(
    Backbone,
    Marionette,
    MenuHomeView,
    CashBackConfirmModel,
    ErrorToastView,
    LoadingToastView,
    CustomToastView
){
    var payable             = 0.00;
    var balance             = 0.00;

    var loadToast = new LoadingToastView();
    var errorToast = new ErrorToastView();


    loadToast.render();
    errorToast.render();
    //customToast.render();

    var _self = this;

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
            'click @ui.calculateButton': function(){
                var calcVal             = parseFloat($('#calculateInput').val());
                var calcCashBackValue   = window.localStorage.getItem('member_total_amount');


                if (calcVal > calcCashBackValue) {
                    payable = calcVal - calcCashBackValue;
                } else {
                    balance = calcCashBackValue - calcVal;
                    payable = 0;
                }

                $('#payable').text(Math.round10(payable, -2));
                //$('#calculateCashBackValue').text(balance);
                console.log(calcVal, '-', calcCashBackValue, '-payable:', payable, '-balance:', balance);
            },
            'click @ui.cashBackButton': function(e){
                e.preventDefault();

                var calculateInput = $('#calculateInput').val();
                if (calculateInput != '') {

                    var memberId = window.localStorage.getItem('member_id');
                    var spent = $('#calculateInput').val();
                    var cashBackConfirmModel = new CashBackConfirmModel();
                    cashBackConfirmModel.set('id', memberId);
                    cashBackConfirmModel.set('payable', payable);
                    cashBackConfirmModel.set('spent', spent);
                    cashBackConfirmModel.set('balance', balance);

                    console.log(payable);
                    if (payable != 0) {
                        loadToast.show();
                        cashBackConfirmModel.save(null, {
                            success: function(model){
                                window.localStorage.setItem('member_total_amount', model.get('balance'));
                                window.localStorage.setItem('payable', payable);
                                loadToast.hide();

                                $('#contentContainer').off('click', '#cashBackButton');
                                // console.log(model.toJSON());
                                window.location.hash = '#cashback/confirm/' + model.get('transactionId');

                            },
                            error: function(){
                                loadToast.hide();
                                errorToast.show();

                                setTimeout(function(){
                                    errorToast.hide();
                                }, 3000);
                            }
                        });
                    } else {
                        var toastModel = new Backbone.Model();
                        toastModel.set('message', '请先点击计算！');
                        toastModel.set('className', 'weui-icon-warn');
                        var customToast = new CustomToastView({
                            model: toastModel
                        });
                        customToast.render();
                        customToast.show();
                        setTimeout(function(){
                            customToast.hide();
                        }, 3000);
                    }
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