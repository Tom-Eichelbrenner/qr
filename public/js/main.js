window.addEventListener('DOMContentLoaded', function () {
  console.log('loaded');
  var optionsInput = document.querySelectorAll('label.check-options');

  if (optionsInput.length > 0) {
    optionsInput.forEach(function (el, index) {
  
      optionsInput[index].addEventListener('change', function (e) {
        // find next label with options class and register event listener to hide/show it whent check/uncheck
        var container = e.target;
        var input = e.target;
        var option;

        while (container.tagName !== 'DIV') {
          container = container.parentNode;
        }
        
        optionLabel = container.nextElementSibling.querySelector('label');
        
        if (input.checked)  {
          optionLabel.classList.remove('hidden');
        } else {
          optionLabel.classList.add('hidden');
          optionLabel.querySelector('input').value = null;
        }     
      });
    });
  }

  document.querySelector("#user_hotelUser")
    .addEventListener('change', function (e) {
      var checked = e.target.checked
      var transfertsContainer = document.querySelector("#transferts-container");
      var taxiContainer = document.querySelector("#taxi-container");
      var inputs;

      if (checked === true) {
        transfertsContainer.classList.remove('hidden');
        taxiContainer.classList.add('hidden');
        inputs = taxiContainer.querySelectorAll('input');
        
      } else {
        taxiContainer.classList.remove('hidden');
        transfertsContainer.classList.add('hidden');
        inputs = transfertsContainer.querySelectorAll('input');
      }

      if (inputs.length > 0) {
        console.log(inputs);
        inputs.forEach(function (index, el) {
          if (inputs[el].getAttribute('type') === 'checkbox') {
            inputs[el].checked = false;
          } else {
            inputs[el].value = null;
          }
        });
      }
    });
});
