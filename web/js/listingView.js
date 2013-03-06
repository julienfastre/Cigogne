function basket2formBinderService() {

    var fon;
    
    this.addItem = function(item) {
        fon(item);
    } ;
    
    this.register = function(fona) {
        fon = fona;
    };
    
    this.gogo = function(test){
        console.log(test);
    };
    

}


angular.module('listingView', [], function($provide) {
   $provide.factory('basket2formBinderService', function() {
       return new basket2formBinderService();
   });
   
   $provide.factory('sendFormService', function() {
       return new sendFormService();
   });
   
   $provide.factory('uuidFactory', function(){
       return new uuidFactory(); 
   });
});




function basketController($scope, binder, formServiceInstance) {
    $scope.moneyGifts = [];
    // an object moneyGift should be :
    // {title: 'the title', amount: 50 }
    
    binder.gogo('from basketController');
    /**
     * the form service
     */
    formService = formServiceInstance ;
        
    $scope.getTotalMoneyGifts = function() {
        var total = 0;
        angular.forEach($scope.moneyGifts, function(moneyGift) {
            total = moneyGift.amount + total;
        });
        
        return total;
    };
    
    this.addItem = function (item) {
        console.log('additem');
        console.log(item);
        $scope.moneyGifts.push(item);
        
        if (countItems('all') > 0) {
            if (! $('#basket_all_empty_message').hasClass('invisible') )
                {
                    $('#basket_all_empty_message').addClass('invisible');
                }
        }
            
          
        
        switch(item.type) 
        {
            case 'money' :
                processMoney(item);
                break;
            default:
                console.log(item.type + 'not exist');
        }
        
    };
    
    countItems = function(type) {
        switch (type) {
            case 'money' :
                return $scope.moneyGifts.length;
                break;
            case 'all':
                a = countItems('money') + countItems('gifts');
                return a;
                break;
            default:
                console.log('not implemented');
                return 0;
        }
        
    };
    
    processMoney = function (item) {
        console.log('process money');
        
        if (countItems('money') > 0 ) {
            h = $('#basket_money_title');
            if (h.hasClass('invisible')) {
                h.removeClass('invisible');
            }
            
            p = $('#basket_money_total');
            if (p.hasClass('invisible')) {
                p.removeClass('invisible');
            }
                        
        }
            
    };
    
    
    
    
    binder.register(this.addItem);
    
}
basketController.$inject = ['$scope', 'basket2formBinderService'];


function moneyGiftController($scope, $element, binder, formService, uuidFactory) {
    
    binder.gogo('from moneyGift');
    
    angular.element($element).submit(function(event) {
        event.preventDefault();
    });

    
    $scope.addMoneyGift = function() {
        console.log("addMoneyGift");
        el = angular.element($element);
        aamount = el.find('.amount').val();
        pattern = new RegExp(el.find('.amount').attr('pattern'));
        console.log(pattern);
        
        if (!pattern.test(aamount))
            {
                amountInput = el.find('.amount').get(0);
                amountInput.setCustomValidity("Indiquez un nombre avec un point ou une virgule");
            } 
            
        //correct amount
        aamount_corrected = parseFloat(aamount.replace(",", "."));
        
        ttitle = el.find('input[name=title]').val();
        ttype =  el.find('input[name=type]').val();
        uuuid = uuidFactory.guid();
        ob = {form: el, amount: aamount_corrected, title: ttitle, type: ttype, uuid: uuuid};
        
        binder.addItem(ob);
        
        formService.sendForm($element, ob);

    };
    
    
}

moneyGiftController.$inject = ['$scope', '$element', 'basket2formBinderService', 'sendFormService', 'uuidFactory'];


function sendFormService() {
    
    this.sendForm = function(formElement, item) {
        console.log('sendform active');
        form = angular.element(formElement);
        
        //add the uuid input
        uuidInput = $('<input>', {
            type: 'hidden',
            value: item.uuid,
            name: 'uuid'
        });
        
        form.append(uuidInput);

        $.ajax({
            type: form.attr('method'),
            data: form.serialize(),
            url: form.attr('action'),
            error: function(xhr, text, error) {
                    alert(text);
                    console.log(xhr);
                    console.log(error);
                }
            
        })
    };
    
}

function uuidFactory() {
    s4 = function() {
        return Math.floor((1 + Math.random()) * 0x10000)
                   .toString(16)
                   .substring(1);
    };

    this.guid = function() {
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
               s4() + '-' + s4() + s4() + s4();
    }
}