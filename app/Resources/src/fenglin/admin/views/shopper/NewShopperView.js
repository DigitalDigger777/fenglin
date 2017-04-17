/**
 * Created by korman on 27.01.17.
 */

define(['marionette',
        'admin/views/core/AdminMenuView',
        'consumer/models/ShopperModel',
        'consumer/views/core/LoadingToastView',
        'consumer/views/core/ErrorToastView',
        'consumer/views/core/SuccessToastView',
        'admin/views/shopper/PasswordView',
        'consumer/views/core/CustomToastView'
], function(Marionette,
            AdminMenuView,
            ShopperModel,
            LoadingToastView,
            ErrorToastView,
            SuccessToastView,
            PasswordView,
            CustomToastView){
    var reg = /\?apikey=([\w\W]+)/;
    var match = reg.exec(location.search);

    var loadToast  = new LoadingToastView();
    loadToast.render();

    var errorToast = new ErrorToastView();
    errorToast.render();

    var successToast = new SuccessToastView();
    successToast.render();

    return Marionette.View.extend({
        apikey: match[1],
        el:'#contentContainer',
        template: '#newShopperView',
        ui: {
            saveButton: '#saveShopperButton',
            telInput: '#tel'
        },
        events: {
            'click @ui.saveButton': function(e){
                e.preventDefault();
                console.log('click');

                if (this.validate()) {
                    loadToast.show();

                    var shopperId       = $('#shopperId').val();
                    var name            = $('#name').val();
                    var address         = $('#address').val();
                    var tel             = $('#tel').val();
                    var shedule        = $('#schedule').val();
                    var rebate_level_1  = $('#rebate_level_1').val();
                    var rebate_level_2  = $('#rebate_level_2').val();
                    var rebate_level_3  = $('#rebate_level_3').val();
                    var preview_image   = $('#previewImage').attr('data-src');
                    var contactTel      = $('#contactTel').val();

                    var shopperModel = new ShopperModel();

                    if (shopperId != 0) {
                        shopperModel.set('id', shopperId);
                    }

                    shopperModel.set('name', name);
                    shopperModel.set('address', address);
                    shopperModel.set('tel', tel);
                    shopperModel.set('shedule', shedule);
                    shopperModel.set('rebateLevelRate', rebate_level_1);
                    shopperModel.set('rebateLevel2Rate', rebate_level_2);
                    shopperModel.set('rebateLevel3Rate', rebate_level_3);
                    shopperModel.set('logo', preview_image);
                    shopperModel.set('contactTel', contactTel);

                    console.log(shopperModel.toJSON());
                    shopperModel.save(null, {
                        success: function (data) {
                            console.log(data);
                            loadToast.hide();
                            successToast.show();
                            $('#shopperId').val(data.id);
                            setTimeout(function () {
                                successToast.hide();
                                var passwordView = new PasswordView({
                                    model: data
                                });
                                passwordView.render();
                            }, 2000);

                        },
                        error: function (error) {
                            console.log(error);
                            loadToast.hide();
                            errorToast.show();
                            setTimeout(function () {
                                errorToast.hide();
                            }, 3000);
                        }
                    });
                }
            },
            'change @ui.telInput': function (e) {
                e.preventDefault();

                $.ajax({
                    url: Routing.generate('user_rest_validate_index'),
                    dataType: 'json',
                    data: {
                        apikey: this.apikey,
                        method: 'ISSET_TEL',
                        tel: $('#tel').val()
                    },
                    success: function (data) {
                        console.log(data);

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

            var menu = new AdminMenuView();
            menu.render();


            // $('#uploadPhoto').click(function(){
            //     $('#photo').click();
            // });

            $('#uploaderInput').change(function(){
                loadToast.show();

                var fd = new FormData();
                fd.append("photo", $('input[type=file]')[0].files[0]);
                $.ajax({
                    url: Routing.generate('panda_shopper_rest_upload'),
                    type: "POST",
                    data: fd,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false   // tell jQuery not to set contentType
                }).done(function( data ) {
                    console.log("PHP Output:");
                    console.log( data );
                    $('#previewImage').attr('src', '/uploads/shoppers/' + data[0]);
                    $('#previewImage').attr('data-src', data[0]);
                    loadToast.hide();
                }).fail(function( error ){

                    loadToast.hide();
                    errorToast.show();
                    setTimeout(function () {
                        errorToast.hide();
                    }, 3000);
                });

            });
        },
        validate: function(){
            var valid   = true;
            $('.weui-cell').each(function(){

                var input   = $(this).find('input');
                var val     = input.val();

                if (input.attr('required') && val == '') {
                    $(this).addClass('weui-cell_warn');
                    valid = false;
                }
            });
            return valid;
        }
    });
});