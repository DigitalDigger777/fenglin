/**
 * Created by korman on 27.01.17.
 */

define(['marionette', 'shopper/controllers/StaffManagementController'], function(Marionette, StaffManagementController){

    var StaffManagementRouter = Marionette.AppRouter.extend({
        controller: StaffManagementController,
        appRoutes: {
            'shopper/staff-management':'staffManagement',
            'shopper/staff-save': 'save',
            'shopper/staff-delete/:staffId': 'deleteStaff'
        }
    });

    return new StaffManagementRouter();
});