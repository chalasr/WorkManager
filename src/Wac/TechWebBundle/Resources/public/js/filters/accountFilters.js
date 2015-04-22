angular.module('accountFilters', [])


.filter('dateBetween', function() {
    return function(items, dateAfter) {
        currentDate = new Date(Date.now());
        var pastMonth = moment().subtract(1, 'month');
        if(dateAfter.name == "Le mois dernier"){
            currentDate = moment().subtract(1, 'month').endOf('month');
            dateAfter.date = beginLastMonth;
        }
        return items.filter(function(item){  // Use ES6 filter method
            return moment(splitDate(item.date.date, 0)).isBetween(dateAfter.date, currentDate);
        })
      }
})

.filter('toArray', function () {
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
})

.filter("byDates", function() {
    return function(items, from, to) {
        var dateFrom = parseDate(from);
        var dateTo = parseDate(to);
        var arrayToReturn = [];
        if(from != '' && to != ''){
            for(var i=0; i<items.length; i++){
                dateOperation = new Date(splitDate(items[i].date.date, 0));
                if(dateOperation > dateFrom && dateOperation < dateTo)
                    arrayToReturn.push(items[i]);
            }
            return arrayToReturn;
        }else{
            return items;
        }
    };
})

.filter('montantBetween', function(){
  return function(items, min, max) {
      var filtered = [];
      if(min != '' && max != ''){
          for(var i=0; i<items.length; i++){
              if(items[i].montant <= max && items[i].montant >= min) {
                  filtered.push(items[i]);
              }
          };
          return filtered;
      }else{
          return items;
      }
  };
});
