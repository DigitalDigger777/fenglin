/**
 * Created by korman on 10.03.17.
 */


define(['admin/views/admin/LoginView'], function(LoginView){

    return {
        login: function(){
            var loginView = new LoginView();
            loginView.render();
        }
    };

});
