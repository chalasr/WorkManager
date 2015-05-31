var app = angular.module('app', [],
function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

var input, from, to, items, done, listId, key, value;
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
    $scope.taskData = {};

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
        Project.createCard($scope.cardData[listId], listId)
            .success(function(){
              Project.getLists(projectId)
                .success(function(data){
                    $scope.lists = data;
                    $scope.cardData = {};
                })
                .error(function(data){
                    console.log(data);
                });
            })
            .error(function(data){
                console.log(data);
            });
    };

    $scope.newTask = function(cardId){
        Project.createTask($scope.taskData, cardId)
            .success(function(){
              Project.getLists(projectId)
                .success(function(data){
                    $scope.lists = data;
                    $scope.taskData = {};
                })
                .error(function(data){
                    console.log(data);
                });
            })
            .error(function(data){
                console.log(data);
            });
    };

    $scope.removeCard = function(id){
        Project.deleteCard(id)
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

    $scope.removeTask = function(id){
        $('.' + id).fadeOut();
        Project.deleteTask(id)
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
        createTask : function(taskData, cardId) {
          // return $http.post('/api/task/new' + cardId, taskData);
            return $http({
              method: 'POST',
              url: '/api/task/new/' + cardId,
              headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
              data: taskData
            });
        },
        deleteCard : function(id) {
  				  return $http.delete('/api/card/' + id + '/delete');
  			},
        deleteTask : function(id) {
  				  return $http.delete('/api/task/' + id + '/delete');
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
