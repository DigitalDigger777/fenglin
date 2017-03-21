/**
 * Created by korman on 28.01.17.
 */

define([
    'shopper/views/staff_management/StaffManagementFormView',
    'shopper/views/staff_management/StaffManagementCompositeView',
    'shopper/collections/StaffManagementCollection',
    'shopper/models/StaffModel',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/LoadingToastView',
], function(StaffManagementFormView,
            StaffManagementCompositeView,
            StaffManagementCollection,
            StaffModel,
            ErrorToastView,
            LoadingToastView){

    var loadToast = new LoadingToastView();
    var errorToast = new ErrorToastView();

    loadToast.render();
    errorToast.render();

    return {
        staffManagement: function(){
            loadToast.show();
            var staffManagementFormView = new StaffManagementFormView();
            staffManagementFormView.render();

            var staffManagementCollection = new StaffManagementCollection();
            staffManagementCollection.fetch({
                success: function(collection){
                    var staffManagementCompositeView = new StaffManagementCompositeView({
                        collection: collection
                    });
                    staffManagementCompositeView.render();
                    loadToast.hide();
                },
                error: function(){
                    errorToast.show();
                    loadToast.hide();
                    setTimeout(function(){
                        errorToast.hide();
                    }, 3000);
                }
            });
            //staffManagementCollection.add(new StaffModel());
            //staffManagementCollection.add(new StaffModel());
            //staffManagementCollection.add(new StaffModel());


        },
        save: function(){
            loadToast.show();

            var name = $('#name').val();
            var tel = $('#tel').val();
            var password = $('#password').val();

            var model = new StaffModel();
            model.set('name', name);
            model.set('tel', tel);
            model.set('password', password);

            model.save(null, {
                success: function(){
                    loadToast.hide();
                    window.location.hash = 'shopper/staff-management';
                },
                error: function () {
                    errorToast.show();
                    loadToast.hide();
                    setTimeout(function(){
                        errorToast.hide();
                    }, 3000);
                }
            });

        },
        deleteStaff: function(staffId){
            loadToast.show();
            var model = new StaffModel();
            model.set('id', staffId);
            model.fetch({
                success: function(model){
                    model.destroy({
                        success: function(){
                            loadToast.hide();
                            window.location.hash = 'shopper/staff-management';
                        }
                    });
                },
                error: function(model){
                    errorToast.show();
                    loadToast.hide();
                    setTimeout(function(){
                        errorToast.hide();
                    }, 3000);
                }
            });
            //window.location.hash = 'shopper/staff-management';
        }
    };
});
