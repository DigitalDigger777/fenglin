/**
 * Created by korman on 28.01.17.
 */

define([
    'shopper/views/consumer/ConsumerSearchView'
], function(ConsumerSearchView){
    var urlRoot = requirejs.s.contexts._.config.urlRoot;

    return {
        search: function(){
            console.log('consumer search page');
            var consumerSearchView = new ConsumerSearchView();
            consumerSearchView.render();
        }
    };
});
