(function(){
	
    angular
        .module('blogApp')
        .controller('PostsController', PostsController);  

    function PostsController($http, $state, $rootScope) {
    	

        var vm = this;
        
        vm.posts;
        vm.error;

        vm.getPosts = function() {
            
            $http.get('api/posts').success(function(posts) {
                vm.posts = posts;
            }).error(function(error) {               
                vm.error = error;
                
            });
        }

        vm.getPosts();
    }		
})();