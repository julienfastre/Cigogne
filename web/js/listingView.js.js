function basketController($scope) {
    $scope.moneyGifts = [];
    // an object moneyGift should be :
    // {title: 'the title', amount: 50 }
    
    $scope.addMoneyGift = function() {
        console.log("addMoneyGift");
        console.log($scope.title);
        $scope.moneyGifts.push({title: $scope.title, amount: $scope.amount});
    };
    
    $scope.getTotalMoneyGifts = function() {
        var total = 0;
        angular.forEach($scope.moneyGifts, function(moneyGift) {
            total += moneyGift.amount;
        });
        
        return total;
    };
    
}

