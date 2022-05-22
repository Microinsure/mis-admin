<!--
=========================================================
* Soft UI Dashboard - v1.0.5
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{config('app.url')}}/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{config('app.url')}}/assets/img/favicon.png">
  <title>
    Admin | {{$title}}
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{config('app.url')}}/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="{{config('app.url')}}/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{config('app.url')}}/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{config('app.url')}}/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"
  integrity="sha512-8bHTC73gkZ7rZ7vpqUQThUDhqcNFyYi2xgDgPDHc+GXVGHXq+xPjynxIopALmOPqzo9JZj0k6OqqewdGO3EsrQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
  integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"
  integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid pe-0">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="../pages/dashboard.html">
              {{-- MicroInsurance Services Company --}}
        <img src="{{config('app.url')}}/logo.png" class="navbar-brand-img w-30 h-50" alt="main_logo">

            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto ms-xl-auto me-xl-7">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="../pages/dashboard.html">
                    <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                    Help
                  </a>
                </li>

              </ul>

            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <div class="row">
                    <div class="col-12">
                      @if ($errors->first('email') != null && !empty($errors->first('email')))
     <div class="ui negative message">
         <i class="close icon"></i>
         <div class="header">
             Access Denied!
         </div>
         <p>{{ $errors->first('email') }}</p>
     </div>
 @endif
 @if ($errors->first('password') != null && !empty($errors->first('password')))
     <div class="ui negative message">
         <i class="close icon"></i>
         <div class="header">
             Access Denied!
         </div>
         <p>{{ $errors->first('password') }}</p>
     </div>
 @endif
 @if ($errors->first('access_denied') != null && !empty($errors->first('access_denied')))
     <div class="ui negative message">
         <i class="close icon"></i>
         <div class="header">
             Access Denied!
         </div>
         <p>{{ $errors->first('access_denied') }}</p>
     </div>
 @endif

                    </div>
                  </div>
                  <h3 class="font-weight-bolder text-info text-gradient">Administrator Login</h3>
                  <p class="mb-0">Enter your email and password to Login</p>
                </div>
                <div class="card-body">
                  <form role="form" method="POST" class="ui form" id="loginForm" action="{{route('users.login')}}">
                      @csrf
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="email" class="form-control" placeholder="Email"
                       name="email" aria-label="Email" aria-describedby="email-addon" required>
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" placeholder="Password"
                      name="password" aria-label="Password" aria-describedby="password-addon" required>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>

                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="javascript:;" class="text-info text-gradient font-weight-bold">Sign up</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('{{config('app.url')}}/assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer py-5">
    <div class="container">
      {{-- <div class="row">
        <div class="col-lg-8 mb-4 mx-auto text-center">
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            Company
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            About Us
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            Team
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            Products
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            Blog
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            Pricing
          </a>
        </div>
        <div class="col-lg-8 mx-auto text-center mb-4 mt-2">
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-dribbble"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-twitter"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-instagram"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-pinterest"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-github"></span>
          </a>
        </div>
      </div> --}}
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> CloudFare Software Solutions
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->

  <script src="{{config('app.url')}}/assets/js/core/popper.min.js"></script>
  <script src="{{config('app.url')}}/assets/js/core/bootstrap.min.js"></script>
  <script src="{{config('app.url')}}/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{config('app.url')}}/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{config('app.url')}}/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
  <script>
      $(()=>{
          $('#loginForm').submit(()=>{
              $('#loginForm').addClass('loading');
          })

          $('.message .close').on('click', function() {
            $(this).closest('.message').transition('fade');
          });
      })
  </script>
</body>

</html>
