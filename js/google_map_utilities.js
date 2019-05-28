/***************************************************
 * BY: Randy S. Baker
 * ON: 16-AUG-2018
 * FILE: google_map_utilitiesjs
 * NOTE: Google maps helpers...
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
var map = null;
//var ib = new InfoBox();
var ib = new google.maps.InfoWindow;

/**************************************
 * Create a maker and infobox...
 **************************************/
function createMarker(latlng, name, html, category)
{
  var boxText = document.createElement('div');
  boxText.style.cssText = "margin-top:42px; background:rgba(68,53,134,0.6); padding:10px; border-radius:10px; color:#FFFFFF;";
  var fullContent = name;
  boxText.innerHTML = name;

  var myOptions = {
    content: boxText,
    disableAutoPan: false,
    maxWidth: 0,
    pixelOffset: new google.maps.Size(-100, 0),
    zIndex: null,
    boxStyle: { 
      background: "url('http://www.eyestagedit.com/wtda/assets/map/tip.png') no-repeat",
      width: '250px',
    },
    closeBoxURL: '',
    infoBoxClearance: new google.maps.Size(1, 1),
    isHidden: false,
    pane: 'floatPane',
    enableEventPropagation: false
  };

  var marker = new google.maps.Marker({
    position: latlng,
    icon: category + '.png',
    map: map,
    title: name,
    zIndex: Math.round(latlng.lat() * -100000)<<5
  });

  // Store the category and name info as a marker properties...
  marker.mycategory = category;                                 
  marker.myname = name;
  gmarkers.push(marker);
  google.maps.event.addListener(marker, 'click', function(){
    ib.setOptions(myOptions)
    ib.open(map, this);
  });
}

/**************************************
 * Display markers on map...
 **************************************/
function show(category)
{
  for (var i=0; i < gmarkers.length; i++)
  {
    if (gmarkers[i].mycategory == category)
    {
      gmarkers[i].setVisible(true);
    }
  }
  document.getElementById(category+'box').checked = true;
}

/**************************************
 * Hide markers on map...
 **************************************/
function hide(category)
{
  for (var i=0; i < gmarkers.length; i++)
  {
    if (gmarkers[i].mycategory == category)
    {
      gmarkers[i].setVisible(false);
    }
  }
  document.getElementById(category+'box').checked = false;
  ib.close();
}

/**************************************
 * Check if checkbox has been clicked...
 **************************************/
function boxclick(box, category)
{
  if (box.checked)
  {
    show(category);
  } else {
    hide(category);
  }
}

/**************************************
 * Trigger the click event...
 **************************************/
function myclick(i)
{
  google.maps.event.trigger(gmarkers[i], 'click');
}

/**************************************
 * Initialize the map and data...
 **************************************/
function initialize()
{
  var myOptions = {
    zoom: 14,
    center: new google.maps.LatLng(35.54655,-77.05217),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  
  map = new google.maps.Map(document.getElementById('map'), myOptions);
  google.maps.event.addListener(map, 'click', function(){
    ib.close();
  });

  $(document).ready(function(){
    $.getJSON('data.json', function(data) {
      for (var i = 0; i < data.length; i++)
      {
        var item = data[i];
        var point = new google.maps.LatLng(item.ltt, item.lgt);
        var name = item.name;
        var html = "<b>"+item.name+"<\/b><br \/>"+item.address+"<br \/><a href='"+ item.url +"' title='"+ item.name +"'>View details<\/a>";
        var category = item.cat;
        var marker = createMarker(point,name,html,category);
      }

      show('eat');
      hide('stay');
      hide('shop');
      hide('play');
      hide('community');
    });
  });
}