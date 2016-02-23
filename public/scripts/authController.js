(function() {

    'use strict';

    angular
        .module('blogApp')
        .controller('AuthController', AuthController);


    function AuthController($auth, $state, $http, $window) {

        var vm = this;
            
        vm.login = function() {

            var credentials = {
                email: vm.email,
                password: vm.password
            }
                        
            $auth.login(credentials).then(function(data) {                
                $state.go('posts', {});
            });
        }

        vm.signup = function() {

            var credentials = {
                name:vm.name,
                email: vm.email,
                password: vm.password,
                password_confirmation: vm.password_confirmation
            };

            $auth.signup(credentials).then(function(res) {                            
                $state.go('posts', {});
            });
        }


        vm.logout = function(){
            $auth.logout();
        }

    }

})();