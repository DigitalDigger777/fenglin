/**
 * Created by korman on 27.01.17.
 */

define(['marionette',
        'admin/views/core/AdminMenuView',
        'consumer/models/ShopperModel',
        'consumer/views/core/LoadingToastView',
        'consumer/views/core/ErrorToastView',
        'consumer/views/core/SuccessToastView',
        'admin/views/shopper/PasswordView'], function(Marionette,
                                                        AdminMenuView,
                                                        ShopperModel,
                                                        LoadingToastView,
                                                        ErrorToastView,
                                                        SuccessToastView,
                                                        PasswordView){
    var loadToast  = new LoadingToastView();
    loadToast.render();

    var errorToast = new ErrorToastView();
    errorToast.render();

    var successToast = new SuccessToastView();
    successToast.render();

    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#newShopperView',
        ui: {
            saveButton: '#saveShopperButton'
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