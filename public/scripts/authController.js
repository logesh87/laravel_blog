(function() {

    'use strict';

    angular
        .module('authApp')
        .controller('AuthController', AuthController);


    function AuthController($auth, $state, $http) {

        var vm = this;
            
        vm.login = function() {

            var credentials = {
                email: vm.email,
                password: vm.password
            }
            
            // Use Satellizer's $auth service to login
            $auth.login(credentials).then(function(data) {

                // If login is successful, redirect to the users state
                $state.go('users', {});
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
                
                if (res.data.token) {                    
                    $auth.login(credentials).then(function(data) {                        
                        $state.go('users', {});
                    });
                }else{
                    console.log(res.data);
                }

            }, function(error) {

                vm.error = error;

            });
        }

    }

})();