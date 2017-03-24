/**
 * Created by korman on 27.01.17.
 */

define(['marionette'], function(Marionette){
    return Marionette.View.extend({
        el: '#menuContainer',
        onRender: function(){

        },
        initialize: function () {


            if ( /[\/app_dev.php\/shopper]/.test(window.location.pathname) ) {
                this.template = '#menuHomeView';
            }

            if ( /[\/app_dev.php\/staff]/.test(window.location.pathname) ) {
                this.template = '#menuHomeStaffView';
            }
        }
    });
});