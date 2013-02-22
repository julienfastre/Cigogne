function basket2formBinderService() {

    var fon;
    
    this.addItem = function(item) {
        fon(item);
    } ;
    
    this.register = function(fona) {
        fon = fona;
    }
    
    this.gogo = function(test){
        console.log(test);
    }
}


angular.module('listingView', [], function($provide) {
   $provide.factory('basket2formBinderService', function() {
       return new basket2formBinderService();
   }) 
});





function basketController($scope, binder) {
    $scope.moneyGifts = [];
    // an object moneyGift should be :
    // {title: 'the title', amount: 50 }
    
    binder.gogo('from basketController');
        
    $scope.getTotalMoneyGifts = function() {
        var total = 0;
        angular.forEach($scope.moneyGifts, function(moneyGift) {
            total += moneyGift.amount;
        });
        
        return total;
    };
    
    this.addItem = function (item) {
        console.log('additem');
        console.log(item);
        $scope.moneyGifts.push(item);
    };
    
    binder.register(this.addItem);
    
}
basketController.$inject = ['$scope', 'basket2formBinderService'];


function moneyGiftController($scope, $element, binder) {
    
    binder.gogo('from moneyGift');

    
    $scope.addMoneyGift = function() {
        console.log("addMoneyGift");
        el = angular.element($element);
        console.log(el.text());
        a = el.find('.amount').val();
        t = el.find('.title').val();
        ob = {form: el, amount: a, title: t};
        
        binder.addItem(ob);

        //$scope.moneyGifts.push({title: $scope.title, amount: $scope.amount});
    };
    
    
}

moneyGiftController.$inject = ['$scope', '$element', 'basket2formBinderService'];
