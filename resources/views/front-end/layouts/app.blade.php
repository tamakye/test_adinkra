<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> @yield('title') - {{ config('app.name') }} </title>
  <meta name="description" content="@yield('meta_description', 'Adinkra')">
  <meta  name="keywords" content="@yield('meta_keywords', 'Welcome to Adinkra')">
  <meta  name="author" content="INCRE Ghana">
  <link rel="canonical" href="{{url()->current()}}"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <x-favicon />

  <link rel="stylesheet" href="{{ asset('/fontawesome-free/css/6-all.min.css') }}">
  <link href="{{ asset('/plugins/bootstrap@5/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset("/plugins/swiper/swiper-bundle.min.css") }}" rel="stylesheet">
  <link href="{{ asset("/plugins/select2/css/select2.min.css") }}" rel="stylesheet">
  <link href="{{ asset("/plugins/select2-bootstrap4-theme/select2-bootstrap4.css") }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/plugins/datetimepicker/jquery.datetimepicker.min.css') }}">
  <link href="{{ asset("/plugins/toastr/toastr.css") }}" rel="stylesheet">
  @livewireStyles 
  <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
  @yield('styles')
</head>

<body>

  <header id="header">
    <div class="top-bar">
      <div class="container p-0">
        <div id="topCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item text-center active">
              <span class="text-uppercase">{{ !empty($page) ? $page->top_slider_one : 'Welcome To 3DINKRA, A Poetic Gasp Of African Art' }}</span>
            </div>
            <div class="carousel-item text-center">
              <span class="text-uppercase">{{ !empty($page) ? $page->top_slider_two : 'Subscribe to our Newsletters so you don’t miss our new collections' }} </span>
            </div>
            <div class="carousel-item text-center">
             <span class="text-uppercase">{{ !empty($page) ? $page->top_slider_three : 'New Collection Coming Soon' }} </span>
           </div>
         </div>
         <button class="carousel-control-prev" type="button" data-bs-target="#topCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#topCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>

  <div class="container-fluid navbar-container">
    <a href="/" class="logo-wrapper">
      <img src="{{ asset('/images/logo.png') }}" class="img-fluid" alt="Logo" width="250px">
    </a>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light bg-transparent mt-2 ">
      <div class="container">
        <a class="navbar-brand logo-wrapper-sm" href="/">
          <img src="{{ asset('/images/logo.png') }}" class="img-fluid" alt="Logo" width="250px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav navbar-left mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link @yield('adinkra-jewelry-status')" aria-current="page" href="{{ route('products.listing', 'adinkra-jewelry') }}">ADINKRA JEWELRY</a>
            </li>

            <li class="nav-item">
              <a class="nav-link @yield('legacy-jewelry-status')" href="{{ route('products.listing', 'legacy-jewelry') }}">LEGACY JEWELRY</a>
            </li>

            <li class="nav-item">
              <a class="nav-link @yield('custom-jewelry-status')" href="{{ route('custom-jewelry') }}">CUSTOM JEWELRY</a>
            </li>

            <li class="nav-item">
              <a class="nav-link @yield('art-pieces-status')" href="{{ route('products.listing', 'art-pieces') }}">ART PIECES</a>
            </li>

            <li class="nav-item">
              <a class="nav-link @yield('digital-collections-status')" href="{{ route('products.listing', 'digital-collections') }}">DIGITAL COLLECTIBLES</a>
            </li>

            <li class="nav-item">
              <a class="nav-link @yield('house-of-adinkra-status')" href="{{ route('house-of-adinkra') }}">HOUSE OF 3DINKRA</a>
            </li>

            <li class="nav-item nav-search position-relative">
              <a href="javascript:void(0)" class="nav-link search-on-large" data-bs-toggle="offcanvas" data-bs-target="#searchOffcanvas" aria-controls="searchOffcanvas">
                <i class="fa-solid fa-magnifying-glass"></i>
                {{-- <livewire:search-product /> --}}
              </a>

              <a href="#!" class="btn btn-primary bg-gray btn-block search-on-small text-white border-0 border-radius-0"  data-bs-toggle="offcanvas" data-bs-target="#searchOffcanvas" aria-controls="searchOffcanvas">  <i class="fa-solid fa-magnifying-glass"></i></a>
            </li>
          </ul>
          <ul class="navbar-nav d-flex flex-row me-1">
           <li class="nav-item me-3 me-lg-0">
            <a class="nav-link  icons" href="{{ route('newsletter') }}">
              <i class="fa-solid fa-envelope"></i>
            </a>
          </li>
          @auth
          <li class="nav-item me-3 me-lg-0 dropdown">
            {{-- <a class="nav-link  icons" href="#"><i class="fa-solid fa-user"></i></a> --}}
            <div class="dropdown">
              <a class="dropdown-toggle nav-link  icons" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user"></i>
              </a>

              <ul class="dropdown-menu  dropdown-menu-end">
               @admin
               <li>
                <a class="dropdown-item" href="{{ route('dashboard') }}">Admin Dashboard</a>
              </li>
              @endadmin
              <li><a class="dropdown-item text-start" href="{{ route('profile') }}">Profile</a></li>
              <li><a class="dropdown-item text-start" href="{{ route('my-orders') }}">My Orders</a></li>
              {{-- <li><a class="dropdown-item text-start" href="#">Addresses</a></li> --}}
              {{-- <li><a class="dropdown-item text-start" href="#">Tickets</a></li> --}}
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();"> <i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
                <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </li>
        @else
        <li class="nav-item me-3 me-lg-0">
          <a class="nav-link  icons" href="{{ route('login') }}">
            <i class="fa-regular fa-user"></i>
          </a>
        </li>
        @endauth


        <li class="nav-item me-3 me-lg-0  position-relative">
          <a class="nav-link  icons" href="{{ route('my-wishlist') }}">
            <i class="fa-regular fa-heart"></i>
          </a>
          <div class="refresh-wishlist">
            @if(userHasWishlist())
            <span class="wishlist-tems"><i class="fas fa-circle"></i></span>
            @endif
          </div>
        </li>

        <li class="nav-item me-3 me-lg-0  position-relative">
          <a  href="{{ route('cart') }}" class="nav-link  icons">
            <i class="fas fa-shopping-cart"></i>
            <div class=" refresh-cart">
              @if(!Cart::session(get_cart_id())->isEmpty())
              <span class="cart-tems"><i class="fas fa-circle"></i></span>
              @endif
            </div>
            {{-- <span class="cart-tems">{{ Cart::session(get_cart_id())->getTotalQuantity() }}</span> --}}
          </a>

        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Navbar -->
</div>

@hasSection('carousel')
@yield('carousel')
@endif
</header><!-- /header -->


<main class="main">
  @yield('content')
</main>


<div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="searchOffcanvas" aria-labelledby="searchOffcanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-gray text-uppercase" id="searchOffcanvasLabel">Search products</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <livewire:search-product />
  </div>
</div>

<footer class="footer p-100 pb-4 border-top">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h5 class="title text-uppercase mb-4">Customer care</h5>
        <ul class="list-unstyled text-decoration-none">
          <li><a href="#!">Order information</a></li>
          <li><a href="#!">Care instructions</a></li>
          <li><a href="#!">After sales service</a></li>
          <li><a href="#!">Digital warranties</a></li>
          <li><a href="{{ route('contact') }}">Book an appointment</a></li>
          <li><a href="#!">Return and exchange</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5 class="title text-uppercase mb-4">OUR COMPANY</h5>
        <ul class="list-unstyled text-decoration-none">
          <li><a href="#!">Corporate social responsibility </a></li>
          <li><a href="#!">People and careers</a></li>
          <li><a href="#!">Brand protection</a></li>
          <li><a href="#!">Hotels & resorts</a></li>
          <li><a href="#!">The maison </a></li>
          <li><a href="#!">Our collections</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5 class="title text-uppercase mb-4">LEGAL AREA</h5>
        <ul class="list-unstyled text-decoration-none">
          <li><a href="#!"> Cookies Settings</a></li>
          <li><a href="#!"> Cookie policy </a></li>
          <li><a href="#!"> Candidate privacy notice </a></li>
          <li><a href="#!"> Book an appointment</a></li>
          <li><a href="#!"> Terms of condition</a></li>
          <li><a href="#!"> Terms of use</a></li>
        </ul>
      </div>
      <div class="col-md-3 d-flex flex-column">
        <h5 class="title text-uppercase mb-4">CONTACT US</h5>
        <ul class="list-unstyled text-decoration-none">
          <li><a href="#!"><i class="fa-solid fa-circle me-2 f-20 mt-0"></i>  <span class="">Order information</span></a></li>
          <li><a href="#!"><i class="fa-solid fa-circle me-2 f-20 mt-0"></i> <span class="">Care instructions</span></a></li>
          <li><a href="#!"><i class="fa-solid fa-circle me-2 f-20 mt-0"></i> <span class="">After sales service</span></a></li>
        </ul>
        <div class="footer-social-icons">
         <i class="fa-brands fa-facebook facebook icon me-2"></i>
         <i class="fa-brands fa-twitter twitter icon me-2"></i>
         <i class="fa-brands fa-instagram instagram icon me-2"></i>
         <i class="fa-brands fa-linkedin linkedin icon me-2"></i>
       </div>
     </div>
   </div>
 </div>
</footer>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('/plugins/bootstrap@5/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset("/plugins/swiper/swiper-bundle.min.js") }}"></script>
<script src="{{ asset("/plugins/select2/js/select2.min.js") }}"></script>
<script src="{{ asset("/plugins/toastr/toastr.min.js") }}"></script>
{{-- <script src="{{ asset('plugins/slick/slick.min.js') }}" type="text/javascript" ></script> --}}
<script src="{{ asset('/plugins/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('js/cart.js') }}" type="text/javascript" ></script>
<script src="{{ asset('js/script.js') }}" type="text/javascript" ></script>

@yield('scripts')

@livewireScripts


<script>
  $(function(){

    // alerts
    @if(session()->has('success'))
    toastr.success('{{session()->get('success')}}');
    @endif
    @if(session()->has('info'))
    toastr.info('{{session()->get('info')}}');
    @endif
    @if(session()->has('warning'))
    toastr.warning('{{session()->get('warning')}}');
    @endif
    @if(session()->has('error'))
    toastr.error('{{session()->get('error')}}');
    @endif
    

    new Swiper('.rings-swiper', {
      speed: 600,
      loop: false,
      // spaceBetween: 120,
      // effect: "coverflow",
      // autoplay: {
      //   delay: 5000,
      //   disableOnInteraction: true
      // },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      slidesPerView: 4,
      // direction: "vertical",
      // pagination: {
      //   el: ".swiper-pagination",
      //   clickable: true,
      // },
      
      breakpoints: {
        320: {
          slidesPerView: 1,
        },

        1200: {
          slidesPerView: 3,
        },

        1500: {
          slidesPerView: 4,
        }
      }
    });
   // })

  })
</script>
</body>
</html>