<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 20-JUL-2018
 * ---------------------------------------------------
 * GEO Test Page (geo.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'geo';
$strPageTitle = 'GEO Test';

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>GEO Test</h1>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                Test...
                <p><button id="getPositionButton">Click</button></p>
                <div id="current-location">0</div>
                <script>



                    /*
                    var getPosition = function (options){
                        return new Promise(function (resolve, reject){
                            navigator.geolocation.getCurrentPosition(resolve, reject, options);
                        });
                    }

                    getPosition().then((position) => {
                        console.log(position);
                        myLocation = position;
                    })
                    .catch((err) => {
                        console.error(err.message);
                    });

                    console.log('LOC: ' + myLocation);
                    */
                    /*
                    function getCurrentWeather(coordinates){
                        console.log('Clicked...');
                        return new Promise(function(resolve, reject){
                            new Request.JSON({
                                url: '/echo/json/',
                                data: {
                                    json: JSON.encode({temperature:'Too hot!'}),
                                    delay: 1
                                },
                                onSuccess: function(response){
                                    resolve(response);
                                }
                                }).send();
                            });
                        }

                    function showCurrentWeather(data){
                        var temp = document.getElementById('current-temperature');
                        temp.textContent = data.temperature;
                    }

                    function getPreciseLocation(){
                        var geo = navigator.geolocation;
                        return new Promise(function(resolve, reject){
                            geo.getCurrentPosition(function(position){
                                resolve([position.coords.latitude, position.coords.longitude]);
                            });
                        });
                    }

                    function getWeatherWrapper(){
                        getPreciseLocation()
                        .then(getCurrentWeather)
                        .then(showCurrentWeather);
                    }

                    var prompt = document.getElementById('precise-location-prompt');
                    prompt.addEventListener('click', getWeatherWrapper);
                    */
                </script>
            </div>
        </div>
    </div>
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>