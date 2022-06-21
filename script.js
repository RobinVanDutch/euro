"use strict";

var EIT = {};
window.EIT = EIT;

window.onload = function() {

    // popup

    // end popup

    // menu

    // endmenu

    // modal

    // modal end

    // === scroll to section plugin


  // === / scroll to section plugin

    // mask

    // end mask

    // === form ===
  var Form = function() {
    var _this = this;

    this.$formList = document.querySelectorAll('form');

    Array.from(this.$formList).forEach(function($form) {

      $form.onsubmit = function(e) {
        e.preventDefault();
        _this.sendHandler($form);
      };
    });

    return this;
  }

  Form.prototype.sendHandler = function($form) {
    var _this = this;
    if (!$form.checkValidity()) {
      $form.classList.add('checked');
      return false;
    }

    var $btn = $form.querySelector('button[type="submit"]');
    $btn.disabled = true;
    $btn.style.width = $btn.offsetWidth + "px";
    $btn.style.height = $btn.offsetHeight + "px";
    $btn.style.textAlign = 'center';
    $btn.innerHTML = '<span class="loader"></span>';
    
    var formData = new FormData($form);
    this.post('../ajax.php', formData, function(result) {
      console.log(result);
      $btn.style.width = $btn.style.height = $btn.style.textAlign = '';
      $btn.innerHTML = 'gg не будет';
      $btn.disabled = false;
      $form.classList.remove('checked');


      Array
        .from($form.querySelectorAll('input[type="text"]'))
        .forEach(function($item) { $item.value = ''; });
    });
  }

  Form.prototype.post = function(url, sendData, success) {
    var xhr = new XMLHttpRequest();

    xhr.open('POST', url);
    
    xhr.onload = function() {
      success(xhr.response);
    };

    xhr.send(sendData);
  }

//   const $counts = document.querySelectorAll('input');

// test start 



  var $counts = Array.from(document.querySelectorAll('input'));
 console.log($counts[1].value);
 var gg = [];
 for (var len = $counts.length , i = len; --i >= 0;) {
     gg[i] = $counts[i].value;
 }
 console.log(gg);
 
//  for (var len = $counts.length, i = len; --i >= 0;) {
//     if ($counts[$counts[i]]) {
//       $counts[$counts[i]] += 1;
//       $counts.splice(i, 1);
//     } else {
//       $counts[$counts[i]] = 1;
//     }
//   }
//   $counts.sort(function(a, b) {
//     return $counts[b] - $counts[a];
//   });

// console.log($counts);



//  test end

  EIT.Form = Form;
  // === / form ===

    // init()
    new Form();

};
