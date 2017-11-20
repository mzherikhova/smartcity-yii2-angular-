'use strict';
// Ссылка на серверную часть приложения
var serviceBase = 'http://backend.dev';
// Основной модуль приложения и его компоненты
var yii2AngApp = angular.module('yii2AngApp', [
  'ngRoute',
  'yii2AngApp.site',
  'yii2AngApp.order',
  
]);
// рабочий модуль
var yii2AngApp_site = angular.module('yii2AngApp.site', ['ngRoute','ui.bootstrap']);
var yii2AngApp_order = angular.module('yii2AngApp.order', ['ngRoute']);

 
yii2AngApp.config(['$routeProvider','$httpProvider', function($routeProvider,$httpProvider) {
  // Маршрут по-умолчанию
  $routeProvider.otherwise({redirectTo: '/site/index'});
  $httpProvider.interceptors.push('authInterceptor');
}])
.factory('authInterceptor', function ($q, $window, $location) {
    return {
        request: function (config) {
            if ($window.sessionStorage.access_token) {
                //HttpBearerAuth
                config.headers.Authorization = 'Bearer ' + $window.sessionStorage.access_token;
            }
            
            return config;
        },
        response: function(response) {
            if (response.status === 401) {
                $location.path('/site/login');
                //  Redirect user to login page / signup Page.
            }
            return response || $q.when(response);
        },
        responseError: function (rejection) {
            if (rejection.status === 401) {
                $location.path('/login').replace();
            }
            return $q.reject(rejection);
        }
    };
})
.run(['$rootScope','$window', '$location',function($rootScope,$window,$location) {
  $rootScope.loggedIn = function() {
        return Boolean($window.sessionStorage.access_token);
    };
  $rootScope.logout = function() {
        delete $window.sessionStorage.access_token;
        delete $window.sessionStorage.admin;
        $location.path('/site/login').replace();
    };
    $rootScope.isAdmin = function() {
        return Boolean($window.sessionStorage.admin);
    };  
}]);



