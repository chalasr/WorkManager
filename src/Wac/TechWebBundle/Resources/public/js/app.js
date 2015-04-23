var app = angular.module('app', [],
function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

var input, from, to, items, done, dateOperation, currentDate, ops, previousMonth;
var uri = window.location.href.split('/');
var accountId = uri[4];

app.controller('MainController', function ($scope, Project) {

    // Scope variables initialization
    $scope.cards = {}; $scope.lists = {}; $scope.value = []; $scope.update = []; $scope.tasks = {};

  /**
   * Get value of operation 'done' field
   */
    $scope.isDone = function(done, id){
        done == true ? $scope.value[id] = {done: true} : $scope.value[id] = {done: false};
    };


  /**
   * Get all operations by one account in $scope
   * @param {number} account_id   the account
   * @returns {array} $scope.ops  the operations
   */
    $scope.showLists = function(project_id) {
        Project.getLists(project_id)
          .success(function(data){
              $scope.lists = data;
          })
          .error(function(data){
              console.log(data);
          });
    };

  /**
   * Get all operations by one account in $scope
   * @param {number} account_id   the account
   * @returns {array} $scope.ops  the operations
   */
    $scope.showCards = function(list_id) {
        Project.getCards(list_id)
          .success(function(data){
              $scope.cards = data;
          })
          .error(function(data){
              console.log(data);
          });
    };

  /**
   * Get all operations by one account in $scope
   * @param {number} account_id   the account
   * @returns {array} $scope.ops  the operations
   */
    $scope.showTasks = function(card_id) {
        Project.getTasks(card_id)
          .success(function(data){
              $scope.tasks = data;
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
    // $scope.complete = function(id) {
    //     $scope.update = $scope.value[id];
    //     Project.update(id, $scope.update)
    //       .success(function(){
    //           Project.get(accountId)
    //               .success(function(data){
    //                   $scope.ops = data;
    //               })
    //               .error(function(data){
    //                   console.log(data);
    //               });
    //       })
    //       .error(function(data){
    //           console.log(data);
    //       });
    // };

});


app.factory('Project', function($http){
    return {
    		getLists : function(project_id) {
            return $http.get('/api/lists/' + project_id);
    		},
    		getCards : function(list_id) {
            return $http.get('/api/cards/' + list_id);
    		},
    		getTasks : function(card_id) {
            return $http.get('/api/tasks/' + card_id);
    		}
    }
});



app.filter('toArray', function () {
    return function (obj, addKey) {
        if(!obj) return obj;
        if( addKey === false ){
            return Object.keys(obj).map(function(key){
                return obj[key];
            });
        }else{
            return Object.keys(obj).map(function (key){
                return Object.defineProperty(obj[key], '$key', { enumerable: false, value: key});
            });
        }
    };
});
