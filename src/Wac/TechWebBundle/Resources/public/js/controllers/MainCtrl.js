angular.module('MainCtrl', [])

.controller('MainController', function ($scope, $interval, Account) {

    // Scope variables initialization
    $scope.ops = {}; $scope.newOps = {}; $scope.value = []; $scope.update = [];
    $scope.datesRanges = [
       {name: 'Le mois dernier', date:moment().subtract(1, 'month')},
       {name: '30 derniers jours', date:moment().subtract(30, 'days')},
       {name: '7 derniers jours', date:moment().subtract(7, 'days')},
       {name: 'Cette année', date:moment().subtract(1, 'year')}
    ];
    $scope.datepickerOptions = {
        format: 'dd-mm-yyyy', autoclose: true, weekStart: 0
    };
    $scope.doneOptions = [
       {name: 'Traitées/Non Traitées', value: '!!'},
       {name: 'traitées', value: 'true'},
       {name: 'non traitées', value: 'false'}
    ];
    $scope.options = [
        {name: 'CREDI/DEBIT', value: '!!'},
        {name: 'CREDIT', value: 'CREDIT'},
        {name: 'DEBIT', value: 'DEBIT'}
    ];
    $scope.date = {startDate: '', endDate: ''};
    $scope.query = {type: ''};
    $scope.montant = {min: '', max: ''};
    $scope.dateAfter = $scope.datesRanges[0];

   // Get current datetime
    $scope.init = $interval(function(){
        $scope.getDatetime = new Date;
    },1000 );

  /**
   * Get value of operation 'done' field
   */
    $scope.isDone = function(done, id){
        done == true ? $scope.value[id] = {done: true} : $scope.value[id] = {done: false};
    };

  /**
   * Remove spaces from date & return date formated in scope
   * @param {string} string the date
   * @param {number} nb     the array index key
   */
    $scope.mySplit = function(string, nb) {
        $scope.array = string.split(' ');
        return $scope.array[nb];
    };

  /**
   * Get all operations by one account in $scope
   * @param {number} account_id   the account
   * @returns {array} $scope.ops  the operations
   */
    $scope.showOps = function(account_id) {
        Account.get(account_id)
          .success(function(data){
              $scope.ops = data;
          })
          .error(function(data){
              console.log(data);
          });
    };

  /**
   * Set 'done' field to true/false
   * @param  {number} id           the operation id
   * @return {Object} $scope.ops   the operations
   */
    $scope.complete = function(id) {
        $scope.update = $scope.value[id];
        Account.update(id, $scope.update)
            .success(function(){
                Account.get(accountId)
                    .success(function(data){
                        $scope.ops = data;
                    })
                    .error(function(data){
                        console.log(data);
                    });
            })
            .error(function(data){
                console.log(data);
            });
    };

});
