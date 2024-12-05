<?php
session_start();
require '../conf/db.php';

// Check if the admin is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch admin details from the database
$email_id = $_SESSION['user']; // Assuming admin ID is stored in the session
$admin_query = "SELECT full_name, email_id, phone_number FROM users WHERE email_id = ?";
$stmt = $conn->prepare($admin_query);
$stmt->bindParam(1, $email_id, PDO::PARAM_INT);
$stmt->execute();
$admin_details = $stmt->fetch(PDO::FETCH_OBJ);

// Check if admin details were found
if ($admin_details) {
    $full_name = $admin_details->full_name;
    $email_id = $admin_details->email_id;
    $phone_number = $admin_details->phone_number;
} else {
    echo "Admin details not found.";
    exit();
}

$product_color = $_GET['product_color'];
$product_name = $_GET['product_name'];
$size = $_GET['size'];
$category = $_GET['category'];

?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    
    <title>shoes</title>

    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="assets/css/material-dashboard.min.css?v=3.0.6" rel="stylesheet" />

    <style>
      .async-hide {
        opacity: 0 !important
      }
    </style>

    <script>
      (function(a, s, y, n, c, h, i, d, e) {
        s.className += ' ' + y;
        h.start = 1 * new Date;
        h.end = i = function() {
          s.className = s.className.replace(RegExp(' ?' + y), '')
        };
        (a[n] = a[n] || []).hide = h;
        setTimeout(function() {
          i();
          h.end = null
        }, c);
        h.timeout = c;
      })(window, document.documentElement, 'async-hide', 'dataLayer', 4000, {
        'GTM-K9BGS8K': true
      });
    </script>

    <script>
      (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
          (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
          m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
      })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
      ga('create', 'UA-46172202-22', 'auto', {
        allowLinker: true
      });
      ga('set', 'anonymizeIp', true);
      ga('require', 'GTM-K9BGS8K');
      ga('require', 'displayfeatures');
      ga('require', 'linker');
      ga('linker:autoLink', ["2checkout.com", "avangate.com"]);
    </script>
  </head>

  <body class="g-sidenav-show  bg-gray-200">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

      <div class="container-fluid py-4" style="margin-top: 5%;">

        <div class="row">
          <div class="col-12">
            <div class="multisteps-form mb-9">
              
              <div class="row">
                <div class="col-12 col-lg-8 m-auto">
                  <div class="card">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="multisteps-form__progress">
                          <button class="multisteps-form__progress-btn js-active" type="button" title="User Info">
                            <span>User Info</span>
                          </button>
                          <button class="multisteps-form__progress-btn" type="button" title="Address">Address</button>
                          <!--button class="multisteps-form__progress-btn" type="button" title="Socials">Socials</button>
                          <button class="multisteps-form__progress-btn" type="button" title="Profile">Profile</button-->
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <form class="multisteps-form__form" method="POST" action="process_address.php">

                        <div class="multisteps-form__panel border-radius-xl bg-white js-active" data-animation="FadeIn">
                          <h5 class="font-weight-bolder mb-0">About me</h5>
                          <!--p class="mb-0 text-sm">Mandatory informations</p-->
                          <div class="multisteps-form__content">
                            <div class="row mt-3">
                              <div class="col-12 col-sm-6">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label" style="color:#e91e63;"><b>Full Name</b></label>
                                  <input value="<?php echo $full_name ?>" readonly class="multisteps-form__input form-control" type="text" />
                                </div>
                              </div>
                              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label" style="color:#e91e63;"><b>Email Address</b></label>
                                  <input value="<?php echo $email_id ?>" readonly class="multisteps-form__input form-control" type="text" />
                                </div>
                              </div>
                            </div>
                            <div class="row mt-3">
                              <div class="col-12 col-sm-6">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label" style="color:#e91e63;"><b>Phone Number</b></label>
                                  <input value="<?php echo $phone_number ?>" readonly class="multisteps-form__input form-control" type="text" />
                                </div>
                              </div>
                              <!--div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Company</label>
                                  <input class="multisteps-form__input form-control" type="email" />
                                </div>
                              </div>
                            </div>
                            <div class="row mt-3">
                              <div class="col-12 col-sm-6">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Password</label>
                                  <input class="multisteps-form__input form-control" type="password" />
                                </div>
                              </div>
                              <A>Rutu</A> 
                              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Repeat Password</label>
                                  <input class="multisteps-form__input form-control" type="password" />
                                </div>
                              </div-->
                            </div>
                            <div class="button-row d-flex mt-4">
                              
                              <a href="../show_men_shoes.php?product_color=<?php echo $product_color; ?>&product_name=<?php echo $product_name; ?>&category=<?php echo $category; ?>">
                                <button class="btn bg-gradient-light mb-0" type="button" title="Back">
                                  Back
                                </button>
                              </a>

                              <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">Next</button>
                            </div>
                          </div>
                        </div>


                        <div class="multisteps-form__panel border-radius-xl bg-white" data-animation="FadeIn">
                          <h5 class="font-weight-bold mb-0">Address</h5>
                          <p class="mb-0 text-sm" style="color:#e91e63;"><b>Tell us where are you living</b></p>
                          <div class="multisteps-form__content">
                            <div class="row mt-3">
                              <div class="col">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label"><b>Address</b></label>
                                  <input name="address" class="multisteps-form__input form-control" type="text" required/>
                                </div>
                              </div>
                            </div>
                            <!--div class="row mt-3">
                              <div class="col">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Address 2</label>
                                  <input class="multisteps-form__input form-control" type="text" />
                                </div>
                              </div>
                            </div-->
                            <div class="row mt-3">
                              <div class="col-12 col-sm-6">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label"><b>City</b></label>
                                  <input name="city" class="multisteps-form__input form-control" type="text" required/>
                                </div>
                              </div>
                              <div class="col-6 col-sm-4 mt-3 mt-sm-0">
                                <!--select class="form-control" name="choices-state" id="choices-state">
                                  <option value="Asia" selected>Asia</option>
                                  <option value="America">America</option>
                                </select-->
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label"><b>Country</b></label>
                                  <input name="country" class="multisteps-form__input form-control" type="text" required/>
                                </div>
                              </div>
                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label"><b>Zip</b></label>
                                  <input name="zip" class="multisteps-form__input form-control" type="text" required/>
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic"> 
                                  <input name="product_color" value="<?php echo $product_color ?>" class="multisteps-form__input form-control" type="hidden" />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic"> 
                                  <input name="product_name" value="<?php echo $product_name ?>" class="multisteps-form__input form-control" type="hidden" />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic"> 
                                  <input name="size" value="<?php echo $size ?>" class="multisteps-form__input form-control" type="hidden" />
                                </div>
                              </div>

                              <div class="col-6 col-sm-2 mt-3 mt-sm-0">
                                <div class="input-group input-group-dynamic"> 
                                  <input name="category" value="<?php echo $category ?>" class="multisteps-form__input form-control" type="hidden" />
                                </div>
                              </div>

                            </div>
                            <div class="button-row d-flex mt-4">
                              <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                              <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit" title="Next">Go To Payment</button>
                            </div>
                          </div>
                        </div>

                        <!--div class="multisteps-form__panel border-radius-xl bg-white" data-animation="FadeIn">
                          <h5 class="font-weight-bolder mb-0">Socials</h5>
                          <p class="mb-0 text-sm">Please provide at least one social link</p>
                          <div class="multisteps-form__content">
                            <div class="row mt-3">
                              <div class="col-12">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Twitter Handle</label>
                                  <input class="multisteps-form__input form-control" type="text" />
                                </div>
                              </div>
                              <div class="col-12 mt-3">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Facebook Account</label>
                                  <input class="multisteps-form__input form-control" type="text" />
                                </div>
                              </div>
                              <div class="col-12 mt-3">
                                <div class="input-group input-group-dynamic">
                                  <label class="form-label">Instagram Account</label>
                                  <input class="multisteps-form__input form-control" type="text" />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="button-row d-flex mt-4 col-12">
                                <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">Next</button>
                              </div>
                            </div>
                          </div>
                        </div-->

                        <!--div class="multisteps-form__panel border-radius-xl bg-white h-100" data-animation="FadeIn">
                          <h5 class="font-weight-bolder mb-0">Profile</h5>
                          <p class="mb-0 text-sm">Optional informations</p>
                          <div class="multisteps-form__content mt-3">
                            <div class="row">
                              <div class="col-12 mt-3">
                                <div class="input-group input-group-dynamic">
                                  <textarea class="multisteps-form__textarea form-control" rows="5" placeholder="Say a few words about who you are or what you're working on."></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="button-row d-flex mt-4">
                              <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                              <button class="btn bg-gradient-dark ms-auto mb-0" type="button" title="Send">Send</button>
                            </div>
                          </div>
                        </div-->
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="assets/js/plugins/choices.min.js"></script>
    <script src="assets/js/plugins/multistep-form.js"></script>
    <script>
        if (document.getElementById('choices-state')) {
          var element = document.getElementById('choices-state');
          const example = new Choices(element, {
            searchEnabled: false
          });
        };
      </script>

    <script src="assets/js/plugins/dragula/dragula.min.js"></script>
    <script src="assets/js/plugins/jkanban/jkanban.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
          var options = {
            damping: '0.5'
          }
          Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
      </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="assets/js/material-dashboard.min.js?v=3.0.6"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8b722938298e3d36","serverTiming":{"name":{"cfL4":true}},"version":"2024.8.0","token":"1b7cbb72744b40c580f8633c6b62637e"}' crossorigin="anonymous"></script>

  </body>

</html>