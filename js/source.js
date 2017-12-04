// FUTURE: add javascript to its own page if time
var numberOfDays = 2;

/**
 * Adds a date selector to the date-time div
 * @author Gary
 */
function addDate() {
  if (numberOfDays <= 7) {
    var o = document.getElementById('date-time');
    var childList = o.childNodes;
    o.insertBefore(makeDate(numberOfDays++), childList[childList.length - 1]);
  }
}

/**
 * Makes a date
 * @author Gary
 * @param   {int}     number of date selectors on page
 * @returns {element} of new date input selectors
 */
function makeDate(number) {
  var row = document.createElement('div');
  var child1 = document.createElement('div');
  var child2 = document.createElement('div');
  var child3 = document.createElement('div');
  var child4 = document.createElement('div');
  var input1 = document.createElement('input');
  var input2 = document.createElement('input');
  var input3 = document.createElement('input');
  var input4 = document.createElement('button');
  row.className = 'row';
  child1.className = 'col-xs-12 col-sm-4 form-group';
  child2.className = 'col-xs-12 col-sm-3 form-group';
  child3.className = 'col-xs-12 col-sm-3 form-group';
  child4.className = 'col-xs-12 col-sm-2 form-group';
  input1.className = 'form-control';
  input2.className = 'form-control';
  input3.className = 'form-control';
  input4.className = 'btn btn-danger form-control';
  input1.type = 'text';
  input2.type = 'time';
  input3.type = 'time';
  input4.type = 'button';
  input1.name = 'date[]';
  input2.name = 'startTime[]';
  input3.name = 'endTime[]';
  input4.name = 'button[]';
  row.id = 'row' + number;
  input1.placeholder = "mm/dd/yyyy";
  input1.id = 'date' + number;
  input2.id = 'startTime' + number;
  input3.id = 'endTime' + number;
  input4.id = 'button' + number;
  input4.innerHTML = 'Delete <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>';
  input4.onclick = function() {
    document.getElementById('date-time').removeChild(row);
    numberOfDays--;
  };
  row.appendChild(child1);
  row.appendChild(child2);
  row.appendChild(child3);
  row.appendChild(child4);
  child1.appendChild(input1);
  child2.appendChild(input2);
  child3.appendChild(input3);
  child4.appendChild(input4);
  return row;
}


function removeDate(input) {
  var row = document.getElementById(input.id).parentElement.parentElement;
  document.getElementById('date-time').removeChild(row);
  numberOfDays--;
}

//-----------------------------------Google maps autocomplete---------------------//
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var autocomplete;

function initAutocomplete() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  autocomplete = new google.maps.places.Autocomplete(
    /** @type {!HTMLInputElement} */
    (document.getElementById('location')), {
      types: ['geocode']
    });
}

var lastLength = 0;
function formatPhone() {
  var el = document.getElementById('phone');
  var phoneNumber = el.value;
  phoneNumber = phoneNumber.replace(/\D+/g, '');
  if (lastLength >= phoneNumber.length) {
    lastLength = phoneNumber.length;
  } else {
    if (phoneNumber.length > 0) {
      phoneNumber = '(' + phoneNumber;
    }
    if (phoneNumber.length >= 4) {
      phoneNumber = phoneNumber.substr(0,4) + ')-' + phoneNumber.substring(4, phoneNumber.length);
    }
    if (phoneNumber.length >= 9) {
      phoneNumber = phoneNumber.substr(0,9) + '-' + phoneNumber.substring(9, phoneNumber.length);
    }
    if (phoneNumber.length >= 15 && phoneNumber.length < 16) {
      phoneNumber = phoneNumber.replace(/\D+/g, '');
      phoneNumber = phoneNumber.charAt(0) + "(" + phoneNumber.substring(1, 4) + ")-" + phoneNumber.substring(4, 7) + "-" + phoneNumber.substring(7);
    }
    if (phoneNumber.length >= 16) {
      phoneNumber = phoneNumber.replace(/\D+/g, '');
      phoneNumber = phoneNumber.substring(0, 2) + "(" + phoneNumber.substring(2, 5) + ")-" + phoneNumber.substring(5, 8) + "-" + phoneNumber.substring(8);
    }
    el.value = phoneNumber;
    lastLength = phoneNumber.length;
  }

}
