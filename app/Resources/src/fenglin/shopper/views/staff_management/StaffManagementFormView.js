/**
 * Created by korman on 14.03.17.
 */

define(['marionette',
    'shopper/views/core/MenuHomeView',
    'consumer/views/core/CustomToastView'
], function(Marionette, MenuHomeView, CustomToastView){

    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);

    return Marionette.View.extend({
        apikey: match[1],
        el:'#contentContainer',
        template: '#staffManagementFormView',
        ui: {
            telInput: '#tel'
        },
        events: {
            'change @ui.telInput': function (e) {
                e.preventDefault();
                console.log('sd');
                $.ajax({
                    url: Routing.generate('user_rest_validate_index'),
                    dataType: 'json',
                    data: {
                        apikey: this.apikey,
                        method: 'ISSET_TEL',
                        tel: $('#tel').val()
                    },
                    success: function (data) {
                        console.log(data.isset_tel);

                        if (data.isset_tel == 1) {
                            var model = new Backbone.Model({
                                message: '電話存在',
                                className: 'weui-icon-warn'
                            });
                            var customToast = new CustomToastView({
                                model: model
                            });
                            customToast.render();
                            customToast.show();

                            setTimeout(function () {
                                customToast.hide();
                            }, 2000);
                        }
                    },
                    error: function (error) {
                        errorToast.show();
                        setTimeout(function () {
                            errorToast.hide();
                        }, 3000);
                    }
                });
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