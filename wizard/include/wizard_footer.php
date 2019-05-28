<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 15-DEC-2018
 * ---------------------------------------------------
 * Wizard Public HTML Footer (wizard_footer.php)
 *****************************************************/
?>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-2">
        <img src="<?php echo BASE_URL_RSB?>img/logo.png" width="141px" height="40px" alt="footer logo" id="logo_footer" data-retina="true" />
        <ul id="contact_details_footer">
          <li>Book My Spot Online<br />PO Box 338<br />McKinney, TX 75070<br /><a href="tel://2146999132">(214) 699-9132</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <h3>Popular Categories</h3>
        <ul>
          <li><a href="<?php echo BASE_URL_RSB?>destinations/">Antique Stores</a></li>
          <li><a href="<?php echo BASE_URL_RSB?>destinations/">Art Galleries</a></li>
          <li><a href="<?php echo BASE_URL_RSB?>destinations/">Attractions</a></li>
          <li><a href="<?php echo BASE_URL_RSB?>destinations/">Bars - Landmarks</a></li>
          <li><a href="<?php echo BASE_URL_RSB?>destinations/">Bed &amp; Breakfast</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <h3><a href="<?php echo BASE_URL_RSB?>about/" style="color:#FF9680; font-weight:500 !important;">About Us</a></h3>
        <ul>
          <li><a href="<?php echo BASE_URL_RSB?>">Home</a></li>
          <li><a href="<?php echo BASE_URL_RSB?>destinations/">Destinations</a></li>
          <li><a href="<?php echo BASE_URL_RSB?>advertise/">Advertise</a></li>
          <li><a href="<?php echo BASE_URL_RSB?>pricing/">Pricing</a></li>
          <li><a href="<?php echo BASE_URL_RSB?>contact/">Contact Us</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <h3>Newest Locations</h3>
        <ul>
          <li><a href="#">Wimberley, TX</a></li>
          <li><a href="#">Dripping Springs, TX</a></li>
          <li><a href="#">Austin, TX</a></li>
          <li><a href="#">San Antonio, TX</a></li>
          <li><a href="#">Dallas, TX</a></li>
        </ul>
      </div>
      <div class="col-md-3" id="newsletter">
        <h3>Newsletter</h3>
        <p>Join our newsletter to stay informed about special offers and news.</p>
        <div id="message-newsletter_2"></div>
          <form id="frmNewsletter" name="frmNewsletter" method="post" action="<?php echo BASE_URL_RSB?>" role="form">
            <input type="hidden" id="action" name="action" value="do_newsletter_signup" />
            <div class="form-group">
              <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" />
            </div>
            <input type="submit" id="btnSubmit" name="btnSubmit" class="btn_1 white" value="Subscribe" />
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div id="social_footer">
            <ul>
              <li><a href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a href="https://www.instagram.com/bookmyspotonline/" target="_blank"><i class="fa fa-instagram"></i></a></li>
              <li><a href="#"><i class="fa fa-youtube"></i></a></li>
            </ul>
            <p>Copyright &copy; <?php echo date('Y')?> <a target="_blank" href="<?php echo BASE_URL_RSB?>">Book My Spot Online</a>  |  All Right Reserved</p>
          </div>
        </div>
      </div>
    </div>
    </footer>
    <a href="#" id="toTop"><span id="toTopHover"> </span></a>
    <script src="<?php echo BASE_URL_RSB?>plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="<?php echo BASE_URL_RSB?>plugins/owl-carousel-2.0.0/dist/owl.carousel.js"></script>
    <script src="<?php echo BASE_URL_RSB?>plugins/bootstrap-4.1.3/js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL_RSB?>js/common_scripts.js"></script>
    <script src="<?php echo BASE_URL_RSB?>js/validate.js"></script>
    <script src="<?php echo BASE_URL_RSB?>js/functions.js"></script>
    <script src="<?php echo BASE_URL_RSB?>js/bootstrap-datepicker.js"></script>
    <script src="<?php echo BASE_URL_RSB?>js/bootsrap_datepicker_func.js"></script>
    <script src="<?php echo BASE_URL_RSB?>plugins/summernote/summernote.js"></script>
    <script src="<?php echo BASE_URL_RSB?>plugins/fancybox/jquery.fancybox.js"></script>
    <script src="<?php echo BASE_URL_RSB?>js/datatables.min.js"></script>
    <script src="<?php echo BASE_URL_RSB?>js/easing.js"></script>
    <script src="<?php echo BASE_URL_RSB?>js/move-top.js"></script>
    <script src="<?php echo BASE_URL_RSB_WIZARD?>assets/js/wizard-main.js"></script>
  </body>
</html>