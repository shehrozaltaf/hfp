@extends('layouts.simple.master')

@section('title', 'Default')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset(config('global.asset_path').'/css/vendors/scrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(config('global.asset_path').'/css/vendors/owlcarousel.css')}}">


    <link rel="stylesheet" type="text/css" href="{{asset('public/css/swiper.min.css')}}">



@endsection

@section('style')
    <style>
        .myheight{
            height: 90%;
        }
        .tales {
            width: 100%;
        }
        .carousel-inner{
            width:100%;
            max-height: 200px !important;
        }


        * {box-sizing: border-box;}
        body {font-family: Verdana, sans-serif;}
        .mySlides {display: none;}
        img {vertical-align: middle;}

        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        /* Caption text */
        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active {
            background-color: #717171;
        }

        /* Fading animation */
        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @keyframes fade {
            from {opacity: .4}
            to {opacity: 1}
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
            .text {font-size: 11px}
        }


    </style>
@endsection

@section('breadcrumb-title')
    <h3>Health Facility Punjab</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">


        <!-- autoplay swiper -->
        {{--  <section id="component-swiper-autoplay">
              <div class="card">
                  <div class="card-header">
                      <h4 class="card-title">Autoplay</h4>
                  </div>
                  <div class="card-body">
                      <div class="swiper-autoplay swiper-container">
                          <div class="swiper-wrapper">
                              <?php for($i=1;$i<=7;$i++){ ?>
                              <div class="swiper-slide">
                                  <img class="img-fluid" src="{{asset('public/slider_imgs/i'.$i.'.jpeg')}}" alt="banner" />
                              </div>
                                  <?php }?>
                              <div class="swiper-slide">
                                  <img class="img-fluid" src="{{asset('public/slider_imgs/images/banner/banner-7.jpg')}}" alt="banner" />
                              </div>
                              <div class="swiper-slide">
                                  <img class="img-fluid" src="{{asset('public/slider_imgs/images/banner/banner-8.jpg')}}" alt="banner" />
                              </div>
                              <div class="swiper-slide">
                                  <img class="img-fluid" src="{{asset('public/slider_imgs/images/banner/banner-9.jpg')}}" alt="banner" />
                              </div>
                              <div class="swiper-slide">
                                  <img class="img-fluid" src="{{asset('public/slider_imgs/images/banner/banner-10.jpg')}}" alt="banner" />
                              </div>
                              <div class="swiper-slide">
                                  <img class="img-fluid" src="{{asset('public/slider_imgs/images/banner/banner-11.jpg')}}" alt="banner" />
                              </div>
                          </div>
                          <div class="swiper-pagination"></div>
                          <div class="swiper-button-next"></div>
                          <div class="swiper-button-prev"></div>
                      </div>
                  </div>
              </div>
          </section>--}}
        <!--/ autoplay swiper -->


        <div class="row">
            <div class="col-sm-12">
                <div class="slideshow-container">
                    <?php for($i=1;$i<=7;$i++){ ?>
                    <div class="mySlides fade">
                        <div class="numbertext"><?=$i?> / 7</div>
                        <img src="{{asset('public/banners/'.$i.'.jpg')}}" style="width:100%">

                    </div>
                    <?php }?>

                </div>
                <br>

                <div style="text-align:center">
                    <?php for($i=1;$i<=7;$i++){ ?>
                    <span class="dot"></span>
                    <?php }?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Responsive Example</h5>
                    </div>
                    <div class="card-body">
                        <div class="owl-carousel owl-theme" id="owl-carousel-2"  >
                            <?php for($i=1;$i<=7;$i++){ ?>
                            <div class="item"><img class="owlCarouselimg img-responsive img-fluid" src="{{asset('public/banners/'.$i.'.jpg')}}"  alt=""></div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var session_layout = '{{ session()->get('layout') }}';
    </script>
@endsection

<script src="{{asset('public/js/swiper.min.js')}}"></script>
{{--<script src="{{asset('public/js/ext-component-swiper.js')}}"></script>--}}
@section('script')
    <script src="{{asset(config('global.asset_path').'/js/owlcarousel/owl.carousel.js')}}"></script>
    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {slideIndex = 1}
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
            setTimeout(showSlides, 2500);
        }



        $(document).ready(function (){

            // autoplay
            var mySwiper10 = new Swiper('.swiper-autoplay', {
                spaceBetween: 30,
                centeredSlides: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                }
            });



            $('#owl-carousel-2').owlCarousel({
                loop:true,
                autoplay:true,
                autoplayTimeout:1000,
                autoplayHoverPause:true,
                margin:10,
                items:1,
                nav:false
            })
        });
    </script>



@endsection

