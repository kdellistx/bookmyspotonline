/***************************************************
 * BY: Randy S. Baker
 * ON: 03-APR-2018
 * FILE: main.js
 * NOTE: Core scripts & helpers...
 ***************************************************/

 /**************************************
 * Get the current environment...
 **************************************/
  var strHost = window.location.hostname;
  if (strHost == 'localhost')
  {
    var strURL = 'http://localhost/bookmyspotonline/';
  } else {
    var strURL = 'https://www.bookmyspotonline.com/';
  }

/**************************************
 * Initialize default variables...
 **************************************/
var gmarkers = [];

/**************************************
 * Check if checkbox has been clicked...
 **************************************/
function mapFilterClick(box, category)
{
  if (box.checked)
  {
    show(category);
  } else {
    hide(category);
  }
}

/**************************************
 * Display screen width (debugging)...
 **************************************/
$(document).ready(function () {
  //alert('Screen Width: ' + $(window).width());
});

/**************************************
 * Initialize the sticky sidebar...
 **************************************/
$(document).ready(function(){
   $('.sidebar').theiaStickySidebar({
    additionalMarginTop: 80
  });
});

/**************************************
 * Initialize the owl carousel...
 **************************************/
$(document).ready(function(){
   $('.carousel_in').owlCarousel({
    center: true,
    items: 1,
    loop: true,
    autoplay: true,
    navText: [ '', '' ],
    addClassActive: true,
    margin: 5,
    responsive: {
        600: {
            items: 1
        },
        1000: {
            items: 2,
            nav: true,
        }
    }
  });
});

/**************************************
 * Carousel - Advertisements (Ban)...
 **************************************/
$(document).ready(function () {
  $('#carousel-advertisements').carousel({
    interval: 20000
  })
});

/**************************************
 * Carousel - Advertisements (Sky)...
 **************************************/
$(document).ready(function () {
  $('#carousel-advertisements-skyscraper').carousel({
    interval: 60000
  })
});

/**************************************
 * Carousel - Testimonials...
 **************************************/
$(document).ready(function () {
  $('.carousel_testimonials').owlCarousel({
    items: 1,
    loop: true,
    autoplay: false,
    animateIn: 'flipInX',
    margin: 30,
    stagePadding: 30,
    smartSpeed: 450,
    responsiveClass: true,
    responsive: { 600: { items: 1 }, 1000: { items: 1, nav: false }}
  });
});

/**************************************
 * Update destination listings...
 **************************************/
$(document).ready(function(){
  $('#frmDestination #property_category').change(function(){
    $('#frmDestination').submit();
  });
});

/**************************************
 * Update marketplace listings...
 **************************************/
$(document).ready(function(){
  $('#frmForSale #marketplace_category').change(function(){
    $('#frmForSale').submit();
  });
});

/**************************************
 * Initialize summernote editors...
 **************************************/
$(document).ready(function() {
  $('#property_highlight_summernote').summernote({
    minHeight: 100,
    focus: false,
    toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'insert', [ 'link'] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
  });
  
  $('#property_description_summernote').summernote({
    minHeight: 200,
    focus: false,
    toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'insert', [ 'link'] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
  });

  $('#event_description_summernote').summernote({
    minHeight: 200,
    focus: false,
    toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'insert', [ 'link'] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
  });
});

/**************************************
 * View destinations on map...
 **************************************/
$(document).ready(function () {
  $('.btn-view-result-map').on('click', function (){
    var category_id = $(this).attr('data-category');
    console.log(category_id);
    location.href = strURL + '?property_category=' + category_id;
  });
});

/**************************************
 * View marketplace items on map...
 **************************************/
$(document).ready(function () {
  $('.btn-view-result-map-marketplace').on('click', function (){
    var category_id = $(this).attr('data-category');
    console.log(category_id);
    window.open(strURL + 'marketplace-map/?marketplace_category=' + category_id);
  });
});

/**************************************
 * Save trip data...
 **************************************/
$(document).ready(function(){
  $('#btn-save-trip-data').on('click', function (){
    var trip_begin = $(this).attr('data-start');
    var trip_end = $(this).attr('data-end');
    var trip_action = 'do_trip_planner';
    console.log(trip_begin);
    console.log(trip_end);
    console.log(trip_action);
    $.ajax({
      type: 'POST',
      url: strURL+'includes/ajax.calls.php',
      data: 'action=do_trip_save_data&trip_begin='+trip_begin+'&trip_end='+trip_end+'&trip_action='+trip_action,
      success: function(data){
        //console.log(data);
      }
    });
  });
});

/**************************************
 * Close the map legend...
 **************************************/
$(document).ready(function () {
  $('#btnCloseLegend').on('click', function (){
    $('#legend').css('display','none');
  });
});

/**************************************
 * Map geolocation helpers...
 **************************************/
$(document).ready(function(){
  var myLocation;
  var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 3600000
  };

  function showMyPosition(position){
    console.log('LOCATION: ' + position.coords.latitude + ', ' + position.coords.longitude)
    $('#current-location').html('LOCATION: ' + position.coords.latitude + ', ' + position.coords.longitude);
    //alert('Your position is ' + position.coords.latitude + ', ' + position.coords.longitude);
  }

  function noLocation(error){
    //alert('No location info available. Error code: ' + error.code);
  }

  $('#getPositionButton').on('click', function(){
    $.geolocation.get({win:showMyPosition, fail:noLocation});
  });
});

/**************************************
 * Initialize data tables...
 **************************************/
$(document).ready(function(){
  $('#masterProperties').dataTable({
    'aoColumns': [
      {'bSearchable':true},
      {'bSearchable':false},
      {'bSearchable':false},
      {'bSearchable':true},
      {'bSearchable':false},
    ]});
});

/**************************************
 * Initialize autocomplete (add)...
 **************************************/
$(document).ready(function(){
  function log(message){
    $('#btnResetAddProperty').css('display','inline-block');
  }

  $('#property_name').autocomplete({
    source: function (request, response) {
          $.getJSON(strURL+"property_search.php?term=" + request.term, function (data){
            response($.map(data, function (value, key) {
                return {
                    label: value.property_name,
                    value: value.property_name,
                    id: value.id
                };
            }));
        });
    },
    minLength: 2,
    delay: 100,
    select: function(event, ui){
      $.ajax({
        type: 'GET',
        url: strURL+'includes/ajax.calls.php',
        data: 'action=do_get_property_data&id='+ui.item.id,
        dataType: 'json',
        success: function(data){
          $('#property_id').val(data.id);
          $('#property_address').val(data.property_address);
          $('#property_city').val(data.property_city);
          $('#property_zipcode').val(data.property_zipcode);
          $('#property_phone').val(data.property_phone);
          $('#category_id').val(data.category_id).change();
          $('#property_state').val(data.property_state).change();
          if (data.user_id > 0)
          {
            var is_claimed = 1;
          } else {
            var is_claimed = 0;
          }
          $('#is_claimed').val(is_claimed);
          if ($('#is_claimed').val() == 0)
          {
            $('#btnClaimProperty').attr('href', strURL + 'my-account/?action=claim_property&property_id=' + ui.item.id);
            $('#btnClaimProperty').css('display','inline-block');
          } else {
            $('#btnClaimProperty').css('display','none');
          }
        }
      });
        log(strURL + 'my-account/?action=claim_property&property_id=' + ui.item.id);
      } 
  });
});

/**************************************
 * Claim a property (add property)...
 **************************************/
$(document).ready(function () {
  $('#btnClaimProperty').on('click', function(){
    var property_id = $('#property_id').val();
    $.ajax({
      type: 'POST',
      url: strURL+'includes/ajax.calls.php',
      data: 'action=do_claim_property&property_id='+property_id,
      success: function(data){
        console.log(data);
      }
    });
  });
});

/**************************************
 * Reset add property form...
 **************************************/
$(document).ready(function () {
  $('#btnResetAddProperty').on('click', function(){
    $('#frmAddProperty').trigger('reset');
    $('#btnResetAddProperty').css('display','none');
    $('#btnClaimProperty').css('display','none');
  });
});

/**************************************
 * Submit Trip Planner form...
 **************************************/
$(document).ready(function () {
  $('#btnSubmitTripPlanner').on('click', function(){
    var selected_places = $('#frmDirectionMapOptions').serialize();
    $('#frmTripPlanner #selected_categories').val(selected_places);
    $('#frmTripPlanner').submit();
  });
});

/**************************************
 * Initialize autocomplete (home)...
 **************************************/
$(document).ready(function(){
  function handleRedirect(message){
    location.href = message;
  }

  $('#property_name_search').autocomplete({
    source: function (request, response) {
          $.getJSON(strURL+"property_search.php?term=" + request.term, function (data){
            response($.map(data, function (value, key) {
                return {
                    label: value.property_name,
                    value: value.property_name,
                    id: value.id
                };
            }));
        });
    },
    minLength: 2,
    delay: 100,
    select: function(event, ui){
      $.ajax({
        type: 'GET',
        url: strURL+'includes/ajax.calls.php',
        data: 'action=do_get_property_data&id='+ui.item.id,
        dataType: 'json',
        success: function(data){
          console.log('PROPERTY NAME: ' + data.property_name);
        }
      });
        handleRedirect(strURL + 'details/' + ui.item.id + '/' + encodeURIComponent(ui.item.value) + '/');
      } 
  });
});

/**************************************
 * Autocomplete (Home: Campgrounds)...
 **************************************/
$(document).ready(function(){
  function handleRedirect2(message){
    location.href = message;
  }
  $('#campground_name_search').autocomplete({
    source: function (request, response) {
          $.getJSON(strURL+"property_search_rv_park.php?term=" + request.term, function (data){
            response($.map(data, function (value, key) {
                return {
                    label: value.property_name,
                    value: value.property_name,
                    id: value.id
                };
            }));
        });
    },
    minLength: 2,
    delay: 100,
    select: function(event, ui){
      $.ajax({
        type: 'GET',
        url: strURL+'includes/ajax.calls.php',
        data: 'action=do_get_property_data&id='+ui.item.id,
        dataType: 'json',
        success: function(data){
          console.log('CAMPGROUND NAME: ' + data.property_name);
        }
      });
        handleRedirect2(strURL + 'property-details/' + ui.item.id + '/' + encodeURIComponent(ui.item.value) + '/');
      } 
  });
});

/**************************************
 * Initialize province drop-downs...
 **************************************/
$(document).ready(function(){
  $('#frmAddProperty #property_country').change(function(){
    var country_id = $(this).val();
    console.log('COUNTRY ID: '+ country_id);
     $.ajax({
        type: 'POST',
        url: strURL+'includes/ajax.calls.php',
        data: 'action=do_get_country_provinces&id='+country_id,
        dataType: 'json',
        success: function(data){
          $('#frmAddProperty #property_state').empty();
          $('#frmAddProperty #property_state').append('<option selected="true"> --Select-- </option>');
          $('#frmAddProperty #property_state').prop('selectedIndex', 0);
          $.each(data, function (key, entry) {
            $('#frmAddProperty #property_state').append($('<option></option>').attr('value', key).text(entry));
          })
        }
      });
  });
});

/**************************************
 * Send page information (modal)...
 **************************************/
$(document).ready(function(){
  $('#modalSendPageInfo').on('show.bs.modal', function (event){
    var button = $(event.relatedTarget);
    var page_url = button.data('page-url');
    var modal = $(this);
    modal.find('#page_url').val(page_url);
    $('#frmSendPageInfo').attr('action', page_url);
  })
});

/**************************************
 * Initialize the toTop feature...
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
 * Trigger parallax refresh...
 **************************************/
$(document).ready(function(){
  function trigger_parallax_resize()
  {
    $(window).trigger('resize.px.parallax');
  }
  window.setTimeout(trigger_parallax_resize, 6000);
});