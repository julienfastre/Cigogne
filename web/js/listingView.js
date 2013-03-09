function basket2formBinderService() {

    var addItemFunction;
    var bindItemFunction;
    
    this.addItem = function(item) {
        addItemFunction(item);
    } ;
    
    this.bind = function(r) {
        bindItemFunction(r);
    };
    
    this.registerAddItem = function(fona) {
        addItemFunction = fona;
    };
    
    this.registerBindItem = function(fona) {
        bindItemFunction = fona;
    };
    
    this.gogo = function(test){
        console.log(test);
    };
}

function uuidProvider() {
    s4 = function() {
        return Math.floor((1 + Math.random()) * 0x10000)
                   .toString(16)
                   .substring(1);
    };

    this.createGuid = function() {
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
               s4() + '-' + s4() + s4() + s4();
    };
}


angular.module('listingView', [], function($provide) {
   $provide.factory('basket2formBinderService', function() {
       return new basket2formBinderService();
   });
   
   $provide.factory('sendFormService', function(basket2formBinderService) {
       return new sendFormService(basket2formBinderService);
   });
   
   $provide.factory('uuidProvider', function() {
       return new uuidProvider();
   });
});




function basketController($scope, binder, formServiceInstance) {
    $scope.moneyGifts = [];
    // an object moneyGift should be :
    // {title: 'the title', amount: 50, uuid: 'uuidstring' }
    
    $scope.natureGifts = [];
    //should be:
    //{title: 'the title', message:'the message', uuid: 'uuidstring' }
    
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
        
        switch (item.type) {
            case 'money':
                $scope.moneyGifts.push(item);
                break;
            case 'nature':
                $scope.natureGifts.push(item);
                break;
        }
        
        
        processVisibleMessage();
             
        switch(item.type) 
        {
            case 'money' :
                processMoney(item);
                break;
            case 'nature':
                processNature(item);
                break;
            default:
                console.log(item.type + 'not exist');
        }
        
    };
    
    processVisibleMessage = function() {
        if (countItems('all') > 0) {
            if (! $('#basket_all_empty_message').hasClass('invisible') )
                {
                    $('#basket_all_empty_message').addClass('invisible');
                }
        } else {
            if ( $('#basket_all_empty_message').hasClass('invisible') )
                {
                    $('#basket_all_empty_message').removeClass('invisible');
                }
        }
    }
    
    countItems = function(type) {
        switch (type) {
            case 'money' :
                return $scope.moneyGifts.length;
                break;
            case 'all':
                a = countItems('money') + countItems('nature');
                return a;
                break;
            case 'nature':
                return $scope.natureGifts.length;
            default:
                console.log('not implemented');
                return 0;
        }
        
    };
    
    processMoney = function () {
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
                        
        } else {
            h = $('#basket_money_title');
            
                h.addClass('invisible');
                        
            p = $('#basket_money_total');
            
                p.addClass('invisible');
            
        }
            
    };
    
    processNature = function (item) {
        
    }
    
    $scope.deleteItem = function(uuid) {
        
        found = false;
        foundId = null;
        
        //delete in moneyGift 
        for (i = 0; i < $scope.moneyGifts.length; i++) {
            if ($scope.moneyGifts[i].uuid === uuid) {
                foundId = $scope.moneyGifts[i].id;
                $scope.moneyGifts.splice(i, 1);
                found = true;
            }
        }
            
        //delete in natureGift
        if (found === false) {
            for (i = 0; i < $scope.natureGifts.length; i++) {
                if ($scope.natureGifts[i].uuid === uuid) {
                    foundId = $scope.natureGifts[i].id;
                    $scope.natureGifts.splice(i, 1);
                    found = true;
                }            
            } 
        }
        
        
        if (found === true) {
            token = deleteToken;
            
            console.log('token est '+token);
            
            params = {token: token, id: foundId};
            
            $.ajax({
                url: urlDeleteGift,
                method: 'POST',
                data: $.param(params),
                error: function(xhr, text, error) {
                    alert(text);
                    console.log(xhr);
                    console.log(error);
                }
            });
  
        } else {
            alert(uuid+' not found ! ');
        } 
        
        processVisibleMessage();
        processMoney();
        
    };
    
    
    this.bindItem = function(r) {
        found = false;
        
        //within moneyGifts:
        for (i=0; i < $scope.moneyGifts.length; i++) {
            if ($scope.moneyGifts[i].uuid === r.uuid) {
                $scope.moneyGifts[i].id = r.id;
                found = true;
            }
        }
        
        //within natureGifts
        if (found === false) {
            for (i=0; i < $scope.natureGifts.length; i++) {
                if ($scope.natureGifts[i].uuid === r.uuid) {
                    $scope.natureGifts[i].id = r.id;
                    found = true;
                }
            }
        }
        
        if (found === false) {
            alert('erreur du serveur');
        }
    };
    
    
    //bind some function to the binder, to let them accessible to other controllers:
    binder.registerAddItem(this.addItem);
    binder.registerBindItem(this.bindItem);
    
}
basketController.$inject = ['$scope', 'basket2formBinderService'];


function moneyGiftController($scope, $element, binder, formService, uuidProvider) {
    
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
        uuuid = uuidProvider.createGuid();
        
        
        ob = {form: el, amount: aamount_corrected, title: ttitle, type: ttype, uuid: uuuid};
        
        binder.addItem(ob);
        
        formService.sendForm($element, ob);

    };
    
    
}

moneyGiftController.$inject = ['$scope', '$element', 'basket2formBinderService', 'sendFormService', 'uuidProvider'];


function natureGiftController($scope, $element, binder, formService, uuidProvider) {
    
    binder.gogo('from natureGiftController');
    
    angular.element($element).submit(function(event) {
        event.preventDefault();
    });

    
    $scope.addNatureGift = function() {
        console.log("addNatureGift");
        el = angular.element($element);
        
        mmessage = el.find('[name*="message"]').val();
        
        ttitle = el.find('input[name=title]').val();
        ttype =  el.find('input[name=type]').val();
        uuuid = uuidProvider.createGuid();
        
        
        ob = {message: mmessage, uuid : uuuid, title: ttitle, type: ttype};
        
        binder.addItem(ob);
        
        formService.sendForm($element, ob);

    };
    
    
}

natureGiftController.$inject = ['$scope', '$element', 'basket2formBinderService', 'sendFormService', 'uuidProvider'];



function sendFormService(bindService) {
    
    bindService.gogo('from sendFormService');
    
    this.sendForm = function(formElement, item) {
        console.log('sendform active');
        form = angular.element(formElement);
        
        uuidInput = $('<input>', {
            type: 'hidden',
            value: item.uuid,
            name:'uuid'
            
        });
        
        form.append(uuidInput);

        $.ajax({
            type: form.attr('method'),
            data: form.serialize(),
            url: form.attr('action'),
            dataType: "json",
            error: function(xhr, text, error) {
                    alert(text);
                    console.log(xhr);
                    console.log(error);
                },
            complete: function(xhr) {
                    r = $.parseJSON(xhr.responseText);
                    console.log(r);
                    bindService.bind(r);
            }
            
        });
    };
    
}