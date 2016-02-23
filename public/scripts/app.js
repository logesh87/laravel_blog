
(function() {

    'use strict';

    angular
        .module('blogApp', ['ui.router', 'satellizer'])
        .config(function($stateProvider, $urlRouterProvider, $authProvider, $httpProvider) {

            
            $authProvider.loginUrl = '/api/login';
            $authProvider.signupUrl = '/api/signup';   
            $authProvider.loginOnSignup = true;         

            
            $urlRouterProvider.otherwise('/home');
            
            $stateProvider
                .state('home', {
                    url: '/home',
                    templateUrl: '../views/home.html'                    
                })
                .state('login', {
                    url: '/login',
                    templateUrl: '../views/login.html',
                    controller: 'AuthController as auth'
                })
                .state('signup', {
                    url: '/signup',
                    templateUrl: '../views/signup.html',
                    controller: 'AuthController as auth'
                })
                .state('logout', {
                    url: '/logout',                    
                    controller: function($auth){
                        $auth.logout();
                    }
                })
                .state('posts', {
                    url: '/posts',
                    templateUrl: '../views/posts.html',
                    controller: 'PostsController as vm'
                })
                .state('users', {
                    url: '/users',
                    templateUrl: '../views/users.html',
                    controller: 'UserController as user'
                });
        })
        .run(function($rootScope, $auth, $state, $window){

            $rootScope.$on('$stateChangeStart', function (e, toState) {

                var isAllowedScreen = ['login', 'signup', 'home'].indexOf(toState.name) !== -1;
                
                if(isAllowedScreen){
                    return; 
                }
                
                if (!$auth.isAuthenticated()) {
                    e.preventDefault();
                    $state.go('login');
                }

            });

            $rootScope.isAuthenticated = function() {
              return $auth.isAuthenticated();
            };            
        })
  

})();