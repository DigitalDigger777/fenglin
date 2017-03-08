/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette',
    'consumer/views/shopper/ShopperCompositeView',
    'consumer/collections/ShopperCollections',
    'consumer/views/core/LoadingToastView',
    'consumer/views/core/ErrorToastView'
], function(Marionette,
            ShopperCompositeView,
            ShopperCollections,
            LoadingToastView,
            ErrorToastView){


    var loadToast  = new LoadingToastView();
    loadToast.render();

    var errorToast = new ErrorToastView();
    errorToast.render();

    return Marionette.View.extend({
        el:'#searchBarContainer',
        template: '#searchBarView',
        ui: {
            search: '#searchShoppersButton'
        },
        events: {
            'click @ui.search': function(){
                var search = $('#searchInput').val();
                console.log(search);

                var shopperCollection  = new ShopperCollections();
                shopperCollection.fetch({
                    data:{
                        search: search
                    },
                    success: function(){

                        var shopperList = new ShopperCompositeView({
                            collection: shopperCollection
                        });
                        shopperList.render();
                        loadToast.hide();
                    },
                    error: function(){
                        errorToast.show();
                    }
                });

            }
        },
        onRender: function(){
            var $searchBar = $('#searchBar'),
                $searchResult = $('#searchResult'),
                $searchText = $('#searchText'),
                $searchInput = $('#searchInput'),
                $searchClear = $('#searchClear'),
                $searchCancel = $('#searchCancel');

            function hideSearchResult(){
                $searchResult.hide();
                $searchInput.val('');
            }
            function cancelSearch(){
                hideSearchResult();
                $searchBar.removeClass('weui-search-bar_focusing');
                $searchText.show();
            }

            $searchText.on('click', function(){
                $searchBar.addClass('weui-search-bar_focusing');
                $searchInput.focus();
            });
            $searchInput
                .on('blur', function () {
                    if(!this.value.length) cancelSearch();
                })
                .on('input', function(){
                    if(this.value.length) {
                        $searchResult.show();
                    } else {
                        $searchResult.hide();
                    }
                })
            ;
            $searchClear.on('click', function(){
                hideSearchResult();
                $searchInput.focus();
            });
            $searchCancel.on('click', function(){
                cancelSearch();
                $searchInput.blur();
            });
        }
    });
});