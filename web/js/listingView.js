function basketController($scope) {
    $scope.moneyGifts = [];
    // an object moneyGift should be :
    // {title: 'the title', amount: 50 }
        
    $scope.getTotalMoneyGifts = function() {
        var total = 0;
        angular.forEach($scope.moneyGifts, function(moneyGift) {
            total += moneyGift.amount;
        });
        
        return total;
    };
    
}

function moneyGiftController($scope, $element, $http) {
    
    $scope.addMoneyGift = function() {
        console.log("addMoneyGift");
        form = angular.element($element);
        console.log(el);
        seria = el.serialize();
        console.log(seria);

        //$scope.moneyGifts.push({title: $scope.title, amount: $scope.amount});
    };
}