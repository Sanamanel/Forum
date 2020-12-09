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
                <a href="home.php"> Board </a>
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
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
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
   
    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="./assets/js/reaction.js"></script>
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

   