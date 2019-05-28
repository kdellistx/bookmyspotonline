/***************************************************
 * BY: Randy S. Baker
 * ON: 15-DEC-2018
 * FILE: wizard-main.js
 * NOTE: Wizard scripts & helpers...
 ***************************************************/

 /**************************************
 * Get the current environment...
 **************************************/
  var strHost = window.location.hostname;
  if (strHost == 'localhost')
  {
    var strURL = 'http://localhost/bookmyspotonline/';
    var strURLWizard = 'http://localhost/bookmyspotonline/wizard/';
  } else {
    var strURL = 'https://www.bookmyspotonline.com/';
    var strURLWizard = 'https://www.bookmyspotonline.com/wizard/';
  }

/**************************************
 * Initialize toTop feature...
 **************************************/
$(document).ready(function(){
  $().UItoTop({easingType:'easeOutQuart'});
});

/**************************************
 * Scroll to the top of the page...
 **************************************/
$(document).ready(function(){
  $('html, body').animate({scrollTop:0}, 0);
});

/**************************************
 * Navigate to login page...
 **************************************/
$(document).ready(function () {
  $('#btn-wizard-ad-login').on('click', function (){
    window.open(strURL + 'login/');
  });
});

/**************************************
 * Navigate to registration page...
 **************************************/
$(document).ready(function () {
  $('#btn-wizard-ad-register').on('click', function (){
    window.open(strURL + 'register/');
  });
});

/**************************************
 * Navigate to add property page...
 **************************************/
$(document).ready(function () {
  $('#btn-wizard-ad-add-property').on('click', function (){
    window.open(strURL + 'add-property/');
  });
});

/**************************************
 * Navigation: Ad Wizard...
 **************************************/
$(document).ready(function (){
  var image_filename = '';
  $('#image_main').change(function(e){
    image_filename = e.target.files[0].name;
    console.log(e.target.files);
  });

  $('#btn-wizard-ad-continue-start').click(function (e){
    e.preventDefault();
    //$('.progress-bar').css('width', '50%');
    //$('.progress-bar').html('Step 2 of 4');
    $('#tab-wizard-ad a[href="#business"]').tab('show');
  });

  $('#btn-wizard-ad-continue-business').click(function (e){
    e.preventDefault();
    //$('.progress-bar').css('width', '75%');
    //$('.progress-bar').html('Step 3 of 4');
    $('#tab-wizard-ad a[href="#images"]').tab('show');
  });

  $('#btn-wizard-ad-continue-images').click(function (e){
    e.preventDefault();
    //$('.progress-bar').css('width', '100%');
    //$('.progress-bar').html('Step 4 of 4');
    $('#tab-wizard-ad a[href="#review"]').tab('show');
  });

  $('#tab-wizard-ad a[href="#review"]').on('shown.bs.tab', function (e){
    var ad_name = $('#ad_name').val();
    var ad_type_val = $('#ad_type').val();
    var ad_type_text = $('#ad_type :selected').text();
    var property_id_val = $('#property_id').val();
    var property_id_text = $('#property_id :selected').text();
    var image_main = $('#image_main').val();
    var content = $('#content').val();
    $('#data-ad-name').html(ad_name);
    $('#data-ad-type').html(ad_type_text);
    $('#data-property-id').html(property_id_text);
    $('#data-image-main').html(image_filename);
    $('#data-content').html(content);
  });
  
  $('#btn-wizard-ad-stop-review').click(function (e){
    e.preventDefault();
    $('#frmAddAdvertisementWizard').submit();
  })
});