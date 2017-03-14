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
            staffManagementCollection.add(new StaffModel());
            staffManagementCollection.add(new StaffModel());
            staffManagementCollection.add(new StaffModel());

            var staffManagementCompositeView = new StaffManagementCompositeView({
                collection: staffManagementCollection
            });
            staffManagementCompositeView.render();
        }
    };
});
