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
    
    $scope.serviceGifts = [];
    
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
    
    
    
    var public = {
        addItem : function (item) {
            console.log('additem');
            console.log(item);

            switch (item.type) {
                case 'money':
                    $scope.moneyGifts.push(item);
                    break;
                case 'nature':
                    $scope.natureGifts.push(item);
                    break;
                case 'service':
                    $scope.serviceGifts.push(item);
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
                case 'service':
                    processService(item);
                    break;
                default:
                    console.log(item.type + 'not exist');
            }

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
                a = countItems('money') + countItems('nature') + countItems('service');
                return a;
                break;
            case 'nature':
                return $scope.natureGifts.length;
                break;
            case 'service':
                return $scope.serviceGifts.length;
                break;
            default:
                console.log('not implemented');
                return 0;
        }
        
    };
    
    processMoney = function () {
        
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
    
    processNature = function(item) {
        if (countItems('nature') > 0 ) {
            h = $('#basket_nature_title');
            if (h.hasClass('invisible')) {
                h.removeClass('invisible');
            }
            
            p = $('#basket_nature_total');
            if (p.hasClass('invisible')) {
                p.removeClass('invisible');
            }
                        
        } else {
            h = $('#basket_nature_title');
            
                h.addClass('invisible');
                        
            p = $('#basket_nature_total');
            
                p.addClass('invisible');
            
        }
    };
    
    processService = function(item) {
        if (countItems('service') > 0 ) {
            h = $('#basket_service_title');
            if (h.hasClass('invisible')) {
                h.removeClass('invisible');
            }
            
            p = $('#basket_service_total');
            if (p.hasClass('invisible')) {
                p.removeClass('invisible');
            }
                        
        } else {
            h = $('#basket_service_title');
            
                h.addClass('invisible');
                        
            p = $('#basket_service_total');
            
                p.addClass('invisible');
            
        }
    };
    
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
        
        //delete in serviceGift
        if (found === false) {
            for (i = 0; i < $scope.serviceGifts.length; i++) {
                if ($scope.serviceGifts[i].uuid === uuid) {
                    foundId = $scope.serviceGifts[i].id;
                    $scope.serviceGifts.splice(i, 1);
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
        
        //enable the form corresponding to uuid
        forms = $('form');
        console.log('found ' + forms.length + 'forms ');
        for(i=0; i < forms.length; i++) {
            formE = $(forms[i]);
            inputUuid = formE.find('input[name=uuid]');
            console.log(inputUuid.length);
            if (inputUuid.length === 1) {

                if ($(inputUuid[0]).val() === uuid) {
                    inputs = formE.find(':input');
                    inputs.each(function(){
                        $(this).prop('disabled', false);
                    });
                    
                    uuidInput = formE.find('input[name=uuid]');
                    uuidInput.remove();
                    
                }
            }
        }
        
        processVisibleMessage();
        processMoney();
        processNature();
        processService();
        
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
        
        //within serviceGifts
        if (found === false) {
            for (i=0; i < $scope.serviceGifts.length; i++) {
                if ($scope.serviceGifts[i].uuid === r.uuid) {
                    $scope.serviceGifts[i].id = r.id;
                    found = true;
                }
            }
        } 
        
        if (found === false) {
            alert('erreur du serveur');
        }
    };
    
    
    //bind some function to the binder, to let them accessible to other controllers:
    binder.registerAddItem(public.addItem);
    binder.registerBindItem(this.bindItem);
    
    //add the gift already in the basket
    for(i = 0; i < itemsInBasket.length; i++) {
        public.addItem(itemsInBasket[i]);
        
        //disable the form corresponding to the item
        forms = $('form');
        console.log('we are searching for ' + itemsInBasket[i].itemId);
        console.log('within ' +forms.length);
        for (j = 0; j < forms.length; j++) {
            formE = $(forms[j]);
            inputsId = formE.find('input[name*="item"]');
            console.log(inputsId);
            //if the form has an item...
            if(inputsId.length > 0) {
                console.log('i found something');
                //if the item correspond to the itemId...
                console.log('found item ' + $(inputsId[0]).val() 
                        +' in ' + $(inputsId[0]).attr('name'));
                if($(inputsId[0]).val().toString() === itemsInBasket[i].itemId.toString()) {
                    console.log('i found the correct form !');
                    elements = formE.find(':input');
                    
                    elements.each(function(){
                        $(this).prop('disabled', true);
                    });
                    
                    uuidInput = $('<input>', {
                        type: 'hidden',
                        value: itemsInBasket[i].uuid,
                        name:'uuid'

                    });
        
                    formE.append(uuidInput);
                    
                }
            }
        }
        
    }
    
    return public;
    
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
        iid = el.find('input[name*="item"]').val();
        uuuid = uuidProvider.createGuid();
        
        
        ob = {form: el, amount: aamount_corrected, title: ttitle, type: ttype, uuid: uuuid, itemId : iid};
        
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
        qquantity = el.find('input[name*="quantity"]').val();
        iid = el.find('input[name*="item"]').val();
        
        
        ob = {message: mmessage, uuid : uuuid, title: ttitle, type: ttype, quantity: qquantity, itemId: iid};
        
        binder.addItem(ob);
        
        formService.sendForm($element, ob);

    };
    
    
}

natureGiftController.$inject = ['$scope', '$element', 'basket2formBinderService', 'sendFormService', 'uuidProvider'];


function serviceGiftController($scope, $element, binder, formService, uuidProvider) {
    
    binder.gogo('from serviceGiftController');
    
    angular.element($element).submit(function(event) {
        event.preventDefault();
    });

    
    $scope.addServiceGift = function() {
        console.log("addServiceGift");
        el = angular.element($element);
        
        mmessage = el.find('[name*="message"]').val();
        
        ttitle = el.find('input[name=title]').val();
        ttype =  el.find('input[name=type]').val();
        uuuid = uuidProvider.createGuid();
        qquantity = el.find('input[name*="quantity"]').val();
        iid = el.find('input[name*="item"]').val();
        
            
        ob = {message: mmessage, uuid : uuuid, title: ttitle, type: ttype, quantity: qquantity, itemId: iid};
        
        binder.addItem(ob);
        
        formService.sendForm($element, ob);

    };
    
    
}

serviceGiftController.$inject = ['$scope', '$element', 'basket2formBinderService', 'sendFormService', 'uuidProvider'];



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
        
        elements = form.find(':input');
        for(i=0; i < elements.length; i++) {
            $(elements[i]).prop('disabled', true);

        }
        
    };
    
}