'use strict';
yii2AngApp_order.config(['$routeProvider','$httpProvider', function($routeProvider,$httpProvider) {
  $routeProvider
    .when('/order/index', {
        templateUrl: 'views/order/index.html',
        controller: 'index'
    })
    .when('/order/create', {
        templateUrl: 'views/order/create.html',
        controller: 'create',
        
    })
    .when('/order/update/:orderId', {
        templateUrl: 'views/order/update.html',
        controller: 'update',        
    })
    .when('/order/delete/:orderId', {
        templateUrl: 'views/order/index.html',
        controller: 'delete',
    })
    .otherwise({
        redirectTo: '/order/index'
    });    
   
    
}])


yii2AngApp_order.controller('index', ['$scope', '$http', 'services','$location', 
    function($scope,$http,services,$location) {
    $scope.message = 'Table of orders.';
    $scope.changeSelect= function(dt){
        $scope.changeDate= moment(dt).format("MM-DD-YYYY");
    }      
    $scope.today = function() {
        $scope.dt = new Date();
    };
    

    $scope.clear = function () {
        $scope.dt = null;
    };

    $scope.open = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.opened = true;
    };

    $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
    };

    $scope.formats = ['MM-dd-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];

    services.getOrders().then(function(data){
        $scope.orders = data.data;
    },function(error) {
        $location.path('/site/login')
    });    
    $scope.deleteOrder = function(orderID) {
        if(confirm("Are you sure to delete order: " + orderID)==true && orderID>0){
            services.deleteOrder(orderID);    
            $route.reload();
        }
    };
}])
.controller('create', ['$scope', '$http', 'services','$location', 
    function($scope,$http,services,$location) {
        $scope.message = 'Create order.';
        services.getUsers().then(function(data){            
            $scope.users = data.data.users;
        },function(error) {
            console.log(error)
        })
        $scope.createOrder = function(order) {
            var results = services.createOrder(order);
    }  
}])
.controller('update', ['$scope', '$http', '$routeParams', 'services','$location', 
    function($scope,$http,$routeParams,services,$location) {
        $scope.message = 'Update order.';
        var original = angular.fromJson(services.getOrder($routeParams.orderId));
        $scope.order = angular.copy(original);
        services.getUsers().then(function(data){            
            $scope.users = data.data.users;
        },function(error) {
            console.log(error)
        })
        $scope.isClean = function() {
            return angular.equals(original, $scope.order);
        }
        $scope.updateOrder = function(order) {    
            var results = services.updateOrder(order);
        } 
}]);