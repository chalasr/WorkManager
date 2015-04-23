var app = angular.module('app', [],
function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

var input, from, to, items, done, listId;
var uri = window.location.href.split('/');
var projectId = uri[4];

app.controller('MainController', function ($scope, Project) {

    // Scope variables initialization
    $scope.cards =  {};
    $scope.lists =  {};
    $scope.tasks =  {};
    $scope.value =  [];
    $scope.update = [];
    $scope.cardData = {};

  /**
   * Get value of task 'done' field
   */
    $scope.isDone = function(done, id){
        done == true ? $scope.value[id] = {done: true} : $scope.value[id] = {done: false};
        return $scope.value[id].done;
    };

    $scope.showLists = function(project_id) {
        Project.getLists(project_id)
          .success(function(data){
              $scope.lists = data;
          })
          .error(function(data){
              console.log(data);
          });
    };

    $scope.newCard = function(listId){
        console.log($scope.cardData.name);
        Project.createCard($scope.cardData, listId)
            .success(function(){
              Project.getLists(projectId)
                .success(function(data){
                    $scope.lists = data;
                })
                .error(function(data){
                    console.log(data);
                });
            })
            .error(function(){
                console.log(data);
            });
    };

    $scope.complete = function(id) {
        $scope.update = $scope.value[id];
        Project.update(id, $scope.update)
            .success(function(){
                Project.getLists(projectId)
                    .success(function(data){
                        $scope.lists = data;
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


app.factory('Project', function($http){
    return {
    		getLists : function(project_id) {
            return $http.get('/api/lists/' + project_id);
    		},
        createCard : function(cardData, listId) {
            return $http({
              method: 'POST',
              url: '/api/card/new/' + listId,
              headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
              data: cardData
            });
        },
        update : function(id, update) {
            return $http.patch('/api/task/' + id, update);
        }
    }
});

app.directive('ngEnter', function() {
        return function(scope, element, attrs) {
            element.bind("keydown keypress", function(event) {
                if(event.which === 13) {
                    scope.$apply(function(){
                        scope.$eval(attrs.ngEnter, {'event': event});
                    });

                    event.preventDefault();
                }
            });
        };
    });
