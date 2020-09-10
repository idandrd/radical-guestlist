'use strict';

// Register `phoneList` component, along with its associated controller and template
angular.
  module('phoneList').
  component('phoneList', {
    templateUrl: 'phone-list/phone-list.template.html',
    controller: ['$http', function PhoneListController($http) {
      var self = this;
      self.orderProp = 'first_name';
      self.phones = [];
      self.query = "";
      self.chosen = "";
      
      self.checkIn = function checkIn(guest) {
		$http.get('scripts/?cmd=ticket&id='+guest.id).then(function(response) {
		  if (response.data.success == true) {
            guest.checked = '1';
          }
        });
      };
      
      self.reload = function reload() {
        $http.get('scripts/?cmd=fetch').then(function(response) {
          self.phones = response.data.data;
        });
      };
	  
	  self.clear = function clear() {
		  self.query = "";
	  };
    
    self.choose = function choose(id) {
      self.chosen = id;
    };
      
      self.intervalID = setInterval(function(){self.reload();}, 30*1000);
      self.reload();

    }]
  });
