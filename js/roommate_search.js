function genderCheck() {
  if (document.getElementById('check_gender').checked) {
    document.getElementById('is_gender').style.display = 'inline';
  }
  else {
    document.getElementById('is_gender').style.display = 'none';
    $('input:radio[name=gender]').prop('checked', false);
  }
}

function occupationCheck() {
  if (document.getElementById('check_occupation').checked) {
    document.getElementById('is_occupation').style.display = 'inline';
  }
  else {
    document.getElementById('is_occupation').style.display = 'none';
    $('input:radio[name=occupation]').prop('checked', false);
  }
}

function tidinessCheck() {
  if (document.getElementById('check_tidy').checked) {
    document.getElementById('is_tidy').style.display = 'inline';
  }
  else {
    document.getElementById('is_tidy').style.display = 'none';
    $('input:radio[name=tidy]').prop('checked', false);
  }
}

function sleepCheck() {
  if (document.getElementById('check_sleep').checked) {
    document.getElementById('is_sleep').style.display = 'inline';
  }
  else {
    document.getElementById('is_sleep').style.display = 'none';
    $('input:radio[name=sleep]').prop('checked', false);
    $('input:radio[name=getup]').prop('checked', false);
  }
}

// $(document).ready(function () {
//   $("#submission").click(function () {
//     $.ajax({
//       url: 'roommate_search.php',
//       type: "POST",
//       data: { gender: $("input[name='gender']:checked").val(), occupation: $("input[name='occupation']:checked").val(), tidy: $("input[name='tidy']:checked").val(), sleep: $("input[name='sleep']:checked").val(), getup: $("input[name='getup']:checked").val() },
//       success: function (data) {
//         $('#search_result').html(data);
//       }
//     });
//   });
// });