</div>
<footer class="footer" data-background-color="black">
      <div class="container">
        <div class="contenair pt-5">
          <nav class="d-flex justify-content-around">
            <ul>
              <li class="px-3 mt-2">
                <i class="fa fa-2x fa-twitter"></i>
              </li>
              <li class="px-3 mt-2">
                <i class="fa fa-2x fa-facebook"></i>
              </li>

              <li class="px-3 mt-2">
                <i class="fa fa-2x fa-codepen"></i>
              </li>
              <li class="px-3 mt-2">
                <i class="fa fa-2x fa-google"></i>
              </li>
            </ul>
          </nav>
          <div class="copyright">
            <ul>
              <li>
                <a href="#"> Board </a>
              </li>
              <li>
                <a href="#"> About Us </a>
              </li>
              <li>
                <a href="#"> Contact </a>
              </li>
            </ul>
            Team Led Zeppelin &copy;
            <script>
              document.write(new Date().getFullYear());
            </script>
            , made with <i class="material-icons">favorite</i> by
            <a href="#" target="_blank">Ali, Caro, Cédric, Jonathan, Rachida </a>
          </div>
        </div>
      </div>
    </footer>
    <!--   Core JS Files   -->


    <script
      src="./assets/js/core/jquery.min.js"
      type="text/javascript"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>

    <script
      src="./assets/js/core/popper.min.js"
      type="text/javascript"
    ></script>
    <script
      src="./assets/js/core/bootstrap-material-design.min.js"
      type="text/javascript"
    ></script>
    <script src="./assets/js/plugins/moment.min.js"></script>
    <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
    <script
      src="./assets/js/plugins/bootstrap-datetimepicker.js"
      type="text/javascript"
    ></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script
      src="./assets/js/plugins/nouislider.min.js"
      type="text/javascript"
    ></script>
    <!--  Google Maps Plugin    -->
    <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
    <script
      src="./assets/js/material-kit.js?v=2.0.7"
      type="text/javascript"
    ></script>
    <script>

      $("#message_text").emojioneArea({
            pickerPosition: "right"
        });

      $(document).ready(function () {
        //init DateTimePickers
        materialKit.initFormExtendedDatetimepickers();

        // Sliders Init
        materialKit.initSliders();
      });

      function scrollToDownload() {
        if ($(".section-download").length != 0) {
          $("html, body").animate(
            {
              scrollTop: $(".section-download").offset().top,
            },
            1000
          );
        }
      }
    </script>
  </body>
</html>

   