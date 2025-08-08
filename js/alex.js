// For disabling form submissions if there are invalid fields

/*---------------------------------------*/
/*	NAVIGATION AND NAVIGATION VISIBLE ON SCROLL
/*---------------------------------------*/
$( window ).on( "load", function() {
   mainNav();
   $(window).scroll(function() {
       mainNav();
   });
   function mainNav() {
       var top = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
       if (top > 40) $('.appear').stop().animate({
           "opacity": '1',
           "top": '0'
       });
       else $('.appear').stop().animate({
           "top": '-70',
           "opacity": '0'
       });

 }
    });

(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        $('#space').html('<br>');
        if (form.checkValidity() === false) {
          $('#messages').removeClass().addClass('alert alert-danger alert-dismissible').slideDown().show();
          $('#messages_content').html('<h5>Some fields have not been filled.</h5>');
          event.stopPropagation();
          event.preventDefault();
        } else {
          $('#messages').removeClass().addClass('hide')
          $('#messages_content').html('');
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

$('input[name="radioOptions1"]').on('change', function() {
  $('input[name="new"]').prop("checked", true);
});
$('input[name="radioOptions2"]').on('change', function() {
  $('input[name="child"]').prop("checked", true);
});

$('#pharmacy').addClass('hide').hide();
$('#address').addClass('hide').hide();
$('input[name="radioOptions3"]').on('change', function() {
  if ($("input[name='radioOptions3']:checked").val()=="Delivery within 24 hours") {
    $('#pharmacy').addClass('hide').slideUp();
    $('#address').removeClass('hide').slideDown().show();
    document.getElementById("inputAddress1").required = true;
    document.getElementById("inputPhone2").required = false;
    document.getElementById("inputPharmacy").required = false;
    document.getElementById("inputAddress").required = false;
  } else if ($("input[name='radioOptions3']:checked").val()=="Forwarded to preferred pharmacy") {
    $('#address').addClass('hide').slideUp();
    $('#pharmacy').removeClass('hide').slideDown().show();
    document.getElementById("inputAddress1").required = false;
    document.getElementById("inputPhone2").required = true;
    document.getElementById("inputPharmacy").required = true;
    document.getElementById("inputAddress").required = true;
  }
});

weekday();
function weekday() {
    var d = new Date();
    if (d.getDay() == 0 || d.getDay() == 6) {
      var st = '10:00:00';
      var et = '18:00:00';
    } else {
      var st = '09:00:00';
      var et = '21:00:00';
    }
    sd = new Date(d.getTime());
    sd.setHours(st.split(":")[0]);
    sd.setMinutes(st.split(":")[1]);
    sd.setSeconds(st.split(":")[2]);
    ed = new Date(d.getTime());
    ed.setHours(et.split(":")[0]);
    ed.setMinutes(et.split(":")[1]);
    ed.setSeconds(et.split(":")[2]);

    var day = '';
    var hours = '';

    if (d.getDay() == 0) {
      day = 'Sunday';
    } else if (d.getDay() == 1) {
      day = 'Monday';
    } else if (d.getDay() == 2) {
      day = 'Tuesday';
    } else if (d.getDay() == 3) {
      day = 'Wednesday';
    } else if (d.getDay() == 4) {
      day = 'Thursday';
    } else if (d.getDay() == 5) {
      day = 'Friday';
    } else if (d.getDay() == 6) {
      day = 'Saturday';
    }

    document.getElementById(day).classList.add('today');
    if (sd < d && ed > d) {
      hours = 'Open';
    } else {
      hours = 'Closed';
    }

    $('#' + day + ' .open').html('<img src="assets/Hours/' + hours + '.png">');
}

$(window).scroll(function() {

  var scrollPosition = $(window).scrollTop();

  var aboutTop = $('#about').offset().top;
  var doctorsTop = $('#doctors').offset().top;

  if (scrollPosition >= doctorsTop) {
    $('#about_link').removeClass('active1')
    $('#doctors_link').addClass('active1')
  }
  else if (scrollPosition >= aboutTop) {
    $('#doctors_link').removeClass('active1')
    $('#about_link').addClass('active1')
  }
  else {
    $('#doctors_link').removeClass('active1')
    $('#about_link').removeClass('active1')
  }
});
