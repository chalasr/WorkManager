angular.module('accountService', [])

.factory('Account', function($http){
    return {
    		get : function(account_id) {
            return $http.get('/api/operations/' + account_id);
    		},
        update : function(id, update) {
            return $http.patch('/api/operation/' + id, update);
			  }
    }
});
