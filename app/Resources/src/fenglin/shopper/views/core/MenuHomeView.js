/**
 * Created by korman on 27.01.17.
 */

define(['marionette'], function(Marionette){
    return Marionette.View.extend({
        el: '#menuContainer',
        onRender: function(){

        },
        initialize: function () {

            // console.log(/[\/shopper]/.test(window.location.pathname));
            if ( /\/shopper/.test(window.location.pathname) ) {
                this.template = '#menuHomeView';
            }

            // console.log(/[\/staff]/.test(window.location.pathname));
            if ( /\/staff/.test(window.location.pathname) ) {
                this.template = '#menuHomeStaffView';
            }
        }
    });
});