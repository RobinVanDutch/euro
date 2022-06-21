
let polls_radio_buttons = document.querySelectorAll(
  ".poll input[type=radio]"
);
let polls_radio_buttons_groups = [];
polls_radio_buttons.forEach((button) => {
  if (polls_radio_buttons_groups[button.getAttribute('data')] === undefined)
    polls_radio_buttons_groups[button.getAttribute('data')] = [];
  polls_radio_buttons_groups[button.getAttribute('data')].push(button);
  
});
// console.log(polls_radio_buttons_groups);

let checkRadioOnChange = function () {
  polls_radio_buttons_groups.forEach((group) => {
    polls_radio_buttons_groups[0] = [];
    
    let checkedButtonId = -1;
    for (let i = 0; i < group.length; i++) {
      if (group[i].checked) {
        checkedButtonId = i;
        group.forEach((button) => {
          button.setAttribute("disabled", "");
        });
      }
    }
    if (checkedButtonId < 0) {
      group.forEach((button) => {
        button.removeAttribute("disabled");
      });
    } else {
      group[checkedButtonId].removeAttribute("disabled");
      checkedButtonId = -1;
    }
  });
};
polls_radio_buttons.forEach((onchange = checkRadioOnChange));



