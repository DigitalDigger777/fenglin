/**
 * Created by korman on 28.01.17.
 */

define([
    'admin/views/staff_management/AdminManagementFormView',
    'admin/views/staff_management/AdminManagementCompositeView',
    'admin/collections/AdminManagementCollection',
    'admin/models/AdminModel'

], function(StaffManagementFormView, StaffManagementCompositeView, StaffManagementCollection, StaffModel){


    return {
        staffManagement: function(){
            console.log('sss');
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
                    window.location.hash = 'admin/staff-management';
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
                            window.location.hash = 'admin/staff-management';
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
