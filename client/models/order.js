'use strict';
yii2AngApp_order.factory("services", ['$http','$location','$route', 
    function($http,$location,$route) {
    var obj = {};
    obj.getOrders = function(){
        return $http.get(serviceBase + '/order');
    }    
    obj.createOrder = function (order) {
        console.log(order)
        return $http({
                method: 'POST',
                url: serviceBase + '/order',
                data: "user_id=" + order.user_id + "&price=" + order.price,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then( successHandler )
            .catch( errorHandler );
        function successHandler( result ) {
            $location.path('/order/index');            
        }
        function errorHandler( result ){
            alert("Error data")
            $location.path('/order/create')
        }
    }; 
    obj.getUsers = function(){
        return $http.get(serviceBase + '/order/getusers');
    }   
    obj.getOrder = function(orderID){
        return $http.get(serviceBase + '/order/' + orderID);
    }
 
    obj.updateOrder = function (order) {
        return $http.put(serviceBase + '/order/update/' + order.id, order )
            .then( successHandler )
            .catch( errorHandler );
        function successHandler( result ) {
            $location.path('/order/index');
        }
        function errorHandler( result ){
            alert("Error data")
            $location.path('/order/update/' + order.id)
        }    
    };    
    obj.deleteOrder = function (orderID) {
        return $http.delete(serviceBase + '/order/' + orderID)
            .then( successHandler )
            .catch( errorHandler );
        function successHandler( result ) {
            $route.reload();
        }
        function errorHandler( result ){
            alert("Error data")
            $route.reload();
        }    
    };    
    return obj;   
}]);