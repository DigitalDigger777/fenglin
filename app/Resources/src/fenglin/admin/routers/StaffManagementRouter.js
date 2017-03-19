/**
 * Created by korman on 27.01.17.
 */

define(['marionette', 'admin/controllers/AdminManagementController'], function(Marionette, StaffManagementController){

    var StaffManagementRouter = Marionette.AppRouter.extend({
        controller: StaffManagementController,
        appRoutes: {
            'admin/staff-management':'staffManagement',
            'admin/staff-save': 'save',
            'admin/staff-delete/:staffId': 'deleteStaff'
        }
    });

    return new StaffManagementRouter();
});