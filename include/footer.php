<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 03-APR-2018
 * ---------------------------------------------------
 * Public HTML Footer (footer.php)
 *****************************************************/
?>
  <!-- BEGIN: More Information Modal -->
    <div class="modal fade" id="modalSendPageInfo" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <form id="frmSendPageInfo" name="frmSendPageInfo" method="post" action="<?php echo BASE_URL_RSB?>" role="form">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times-rectangle red"></i></span></button>
            <h4 class="modal-title">Send This Page To Family &amp; Friends</h4>
          </div>
          <div class="modal-body">
            <p>Complete the following form to send this page to your family and friends.</p>
              <input type="hidden" id="action" name="action" value="do_send_page" />
              <input type="hidden" id="page_url" name="page_url" value="" />
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="form-group">
                    <label>Your Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Your Name" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="form-group">
                    <label>Your Email</label>
                    <input type="email" id="from_email" name="from_email" class="form-control" placeholder="Your Email" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="form-group">
                    <label>To Email</label>
                    <input type="email" id="to_email" name="to_email" class="form-control" placeholder="To Email" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Message</label>
                    <textarea id="comments" name="comments" class="form-control" placeholder="Enter your message..." style="height:100px;"></textarea>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
            <button type="submit" id="btnSendPage" name="btnSendPage" class="btn btn-success"><i class="fa fa-envelope"></i> Send</button>
          </div>
        </div>
        </form>
      </div>
    </div>
    <!-- END: More Information Modal -->
    <!-- BEGIN: Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-2 col-sm-4">
            <img src="<?php echo BASE_URL_RSB?>img/logo.png" width="141px" height="40px" alt="footer logo" id="logo_footer" data-retina="true" />
            <ul id="contact_details_footer">
              <li>Book My Spot Online<br />PO Box 338<br />McKinney, TX 75070<br /><a href="tel://2146999132">(214) 699-9132</a></li>
            </ul>
          </div>
          <div class="col-md-2 col-sm-4">
            <h3>Popular Categories</h3>
            <ul>
              <li><a href="<?php echo BASE_URL_RSB?>destinations/">Antique Stores</a></li>
              <li><a href="<?php echo BASE_URL_RSB?>destinations/">Art Galleries</a></li>
              <li><a href="<?php echo BASE_URL_RSB?>destinations/">Attractions</a></li>
              <li><a href="<?php echo BASE_URL_RSB?>destinations/">Bars - Landmarks</a></li>
              <li><a href="<?php echo BASE_URL_RSB?>destinations/">Bed &amp; Breakfast</a></li>
            </ul>
          </div>
          <div class="col-md-2 col-sm-4">
            <h3><a href="<?php echo BASE_URL_RSB?>about/" style="color:#FF9680;">About Us</a></h3>
            <ul>
              <li><a href="<?php echo BASE_URL_RSB?>">Home</a></li>
              <li><a href="<?php echo BASE_URL_RSB?>destinations/">Destinations</a></li>
              <li><a href="<?php echo BASE_URL_RSB?>advertise/">Advertise</a></li>
              <li><a href="<?php echo BASE_URL_RSB?>pricing/">Pricing</a></li>
              <li><a href="<?php echo BASE_URL_RSB?>contact/">Contact Us</a></li>
            </ul>
          </div>
          <div class="col-md-2 col-sm-4">
            <h3>Newest Locations</h3>
            <ul>
              <li><a href="#">Wimberley, TX</a></li>
              <li><a href="#">Dripping Springs, TX</a></li>
              <li><a href="#">Austin, TX</a></li>
              <li><a href="#">San Antonio, TX</a></li>
              <li><a href="#">Dallas, TX</a></li>
            </ul>
          </div>
          <div class="col-md-3 col-sm-4" id="newsletter">
            <h3>Newsletter</h3>
            <p>Join our newsletter to stay informed about special offers and news.</p>
            <div id="message-newsletter_2"></div>
              <form id="frmNewsletter" name="frmNewsletter" method="post" action="<?php echo BASE_URL_RSB?>" role="form" >
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
                <p>Copyright &copy; <?php echo date('Y')?> <a target="_blank" href="<?php echo BASE_URL_RSB?>">Book My Spot Online</a>  |  All Rights Reserved</p>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <div id="toTop"></div>
      <div class="sharethis-inline-share-buttons"></div>
      <script src="<?php echo BASE_URL_RSB?>js/bootstrap.min.js"></script>
      <script src="<?php echo BASE_URL_RSB?>plugins/owl-carousel-2.0.0/dist/owl.carousel.js"></script>
      <script src="<?php echo BASE_URL_RSB?>plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
      <script src="<?php echo BASE_URL_RSB?>js/common_scripts.js"></script>
      <script src="<?php echo BASE_URL_RSB?>js/validate.js"></script>
      <script src="<?php echo BASE_URL_RSB?>js/functions.js"></script>
      <script src="<?php echo BASE_URL_RSB?>js/bootstrap-datepicker.js"></script>
      <script src="<?php echo BASE_URL_RSB?>js/bootsrap_datepicker_func.js"></script>
      <script src="<?php echo BASE_URL_RSB?>plugins/theia-sticky-sidebar-1.7.0/theia-sticky-sidebar.js"></script>
      <script src="<?php echo BASE_URL_RSB?>plugins/summernote/summernote.js"></script>
      <script src="<?php echo BASE_URL_RSB?>plugins/fancybox/jquery.fancybox.js"></script>
      <script src="<?php echo BASE_URL_RSB?>js/datatables.min.js"></script>
      <script src="<?php echo BASE_URL_RSB?>js/jquery-sidebar.js"></script>
      <script src="<?php echo BASE_URL_RSB?>js/easing.js"></script>
      <script src="<?php echo BASE_URL_RSB?>js/move-top.js"></script>
      <script src="<?php echo BASE_URL_RSB?>js/main.js"></script>
      <?php
      if ($strPageName == 'home' || $strPageName == 'trip_planner' || $strPageName == 'marketplace_map' || $strPageName == 'marketplace_item_details' || $strPageName == 'property_details' || $strPageName == 'reservation_property_details' || $strPageName == 'map_all_properties')
      {
        ?>
        <script async defer src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=<?php echo GOOGLE_API_KEY?>&callback=initialize"></script>
        <?php
      }
      ?>
  </body>
</html>