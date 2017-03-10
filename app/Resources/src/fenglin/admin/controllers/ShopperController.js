/**
 * Created by korman on 10.03.17.
 */


define(['admin/views/shopper/InactiveReactiveAccountView',
        'admin/views/shopper/NewShopperView'
], function(InactiveReactiveAccountView,
            NewShopperView){

    return {
        inactiveReactiveAccount: function(id){
            var inactiveReactiveAccountView = new InactiveReactiveAccountView();
            inactiveReactiveAccountView.render();
        },
        newShopper: function(){
            var newShopperView = new NewShopperView();
            newShopperView.render();
        }
    };

});
