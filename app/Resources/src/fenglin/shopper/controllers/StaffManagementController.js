/**
 * Created by korman on 28.01.17.
 */

define([
    'shopper/views/staff_management/StaffManagementFormView',
    'shopper/views/staff_management/StaffManagementCompositeView',
    'shopper/collections/StaffManagementCollection',
    'shopper/models/StaffModel'

], function(StaffManagementFormView, StaffManagementCompositeView, StaffManagementCollection, StaffModel){


    return {
        staffManagement: function(){
            var staffManagementFormView = new StaffManagementFormView();
            staffManagementFormView.render();

            var staffManagementCollection = new StaffManagementCollection();
            staffManagementCollection.fetch({
                success: function(collection){
                    var staffManagementCompositeView = new StaffManagementCompositeView({
                        collection: collection
                    });
                    staffManagementCompositeView.render();
                },
                error: function(){

                }
            });
            //staffManagementCollection.add(new StaffModel());
            //staffManagementCollection.add(new StaffModel());
            //staffManagementCollection.add(new StaffModel());


        },
        save: function(){
            var name = $('#name').val();
            var tel = $('#tel').val();
            var password = $('#password').val();

            var model = new StaffModel();
            model.set('name', name);
            model.set('tel', tel);
            model.set('password', password);

            model.save(null, {
                success: function(){
                    window.location.hash = 'shopper/staff-management';
                }
            });

        },
        deleteStaff: function(staffId){
            var model = new StaffModel();
            model.set('id', staffId);
            model.fetch({
                success: function(model){
                    model.destroy({
                        success: function(){
                            window.location.hash = 'shopper/staff-management';
                        }
                    });
                },
                error: function(model){

                }
            });
            //window.location.hash = 'shopper/staff-management';
        }
    };
});
