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
});
