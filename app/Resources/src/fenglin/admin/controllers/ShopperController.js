/**
 * Created by korman on 10.03.17.
 */


define(['admin/views/shopper/InactiveReactiveAccountView',
        'admin/views/shopper/NewShopperView',
        'consumer/models/ShopperModel',
        'consumer/views/shopper/ShopperSearchResultView',
        'admin/views/shopper/InactiveReactiveCompositeView',
        'admin/collections/InactiveReactiveCollection',
        'consumer/views/core/LoadingToastView',
        'consumer/views/core/ErrorToastView'
], function(InactiveReactiveAccountView,
            NewShopperView,
            ShopperModel,
            ShopperSearchResultView,
            InactiveReactiveCompositeView,
            InactiveReactiveCollection,
            LoadingToastView,
            ErrorToastView
){

    var loadToast  = new LoadingToastView();
    var errorToast = new ErrorToastView();

    return {
        inactiveReactiveAccount: function(id){
            loadToast.render();
            errorToast.render();

            var inactiveReactiveAccountView = new InactiveReactiveAccountView();
            inactiveReactiveAccountView.render();
        },
        newShopper: function(){
            var newShopperView = new NewShopperView();
            newShopperView.render();
        },
        search: function(name){
            console.log(name);
            loadToast.show();
            var inactiveReactiveCollection = new InactiveReactiveCollection();
            //inactiveReactiveCollection.set('name', name);

            inactiveReactiveCollection.fetch({
                data: {
                    name: name
                },
                success: function (collection) {
                    // var shopperSearchResultView = new ShopperSearchResultView({
                    //     model: model
                    // });
                    console.log(collection.toJSON());
                    //shopperSearchResultView.render();
                    var inactiveReactiveCompositeView = new InactiveReactiveCompositeView({
                        collection: collection
                    });
                    inactiveReactiveCompositeView.render();
                    loadToast.hide();
                },
                error: function () {
                    loadToast.hide();
                    errorToast.show();
                    setTimeout(function(){
                        errorToast.hide();
                    }, 3000);
                }
            });

            // var shopperModel = new ShopperModel();
            // shopperModel.set('name', name);
            // shopperModel.fetchByName(function(model, response){
            //     console.log(model.toJSON());
            //     var shopperSearchResultView = new ShopperSearchResultView({
            //         model: model
            //     });
            //     shopperSearchResultView.render();
            //     loadToast.hide();
            // }, function(model, response){
            //     loadToast.hide();
            //     errorToast.show();
            //     setTimeout(function(){
            //         errorToast.hide();
            //     }, 3000);
            // });
        }
    };

});
