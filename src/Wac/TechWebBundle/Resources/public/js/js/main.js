var app = angular.module('app', [
    'MainCtrl', 'accountService', 'accountFilters', 'ng-bootstrap-datepicker'
],function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

var input, from, to, items, done, dateOperation, currentDate, ops, previousMonth, min, max;
var uri = window.location.href.split('/');
var accountId = uri[4];
var currday = new Date().getDate();
var lastMonth = moment().subtract(1, 'month');
var endLastMonth = lastMonth.endOf('month');
var beginLastMonth = moment().subtract(1, 'month').subtract(currday-1, 'days');

/**
* Parse a date from string to string
* @param {string} string     date
* @param {number} nb         array index number
* @param {date}   newdate         array index number
*/
function splitDate(string, nb) {
    var newDate = string.split(' ');
    return newDate[nb];
};
function parseDate(input){
    var parts = input.split('-');
    return new Date(parts[2], parts[1]-1, parts[0]);
};

function objToArray(obj, addKey) {
    if (!obj)
        return obj;
    if ( addKey === false ) {
        return Object.keys(obj).map(function(key) {
            return obj[key];
        });
    }else{
        return Object.keys(obj).map(function (key) {
            return Object.defineProperty(obj[key], '$key', {enumerable: false, value: key});
        });
    }
};
