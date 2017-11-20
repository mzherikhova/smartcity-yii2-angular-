'use strict';
yii2AngApp_site.config(['$routeProvider','$httpProvider', function($routeProvider,$httpProvider) {
  $routeProvider
    .when('/site/index', {
        templateUrl: 'views/site/index.html',
        controller: 'index'
    })
    .when('/site/login', {
        templateUrl: 'views/site/login.html',
        controller: 'login'
    })    
    .otherwise({
        redirectTo: '/site/index'
    });    
}])

.controller('index', ['$scope', '$http', function($scope,$http) {
    // Сообщение для отображения представлением
    $scope.message = 'Вы читаете главную страницу приложения. ';
}])
.controller('login', ['$scope', '$http','$window','$location', function($scope,$http,$window,$location) {
    // Сообщение для отображения представлением
    $scope.message = 'Это страница с информацией о приложении.';
    $scope.login = function () {            
            $scope.submitted = true;
            $scope.error = {};       
            $http({
                method: 'POST',
                url: serviceBase + '/user/login',
                data: "username=" + $scope.userModel.username + "&password=" + $scope.userModel.password,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result){                    
                    $window.sessionStorage.access_token = result.data.access_token;
                    if (result.data.admin) {
                        $window.sessionStorage.admin = result.data.admin;
                    }                    
                    $location.path('/order/index');

               },function (error){
                    console.log(error);
               });
         
        };
}]);
