window.addEventListener('DOMContentLoaded', function () {
  console.log('loaded');
  var optionsInput = document.querySelectorAll('.check-options');

  if (optionsInput.length > 0) {
    optionsInput.forEach(function (el, index) {
  
      optionsInput[index].addEventListener('change', function (e) {
        // find next label with options class and register event listener to hide/show it whent check/uncheck
        var label = e.target;
        var input = e.target;
        var option;

        console.log(input);
        while (label.tagName !== 'LABEL') {
          label = label.parentNode;
        }
        console.log(input);
        
        optionLabel = label.nextElementSibling;
        
        if (input.checked)  {
          optionLabel.classList.remove('hidden');
        } else {
          optionLabel.classList.add('hidden');
          optionLabel.querySelector('input').value = null;
        }     
      });
    });
  }
});
