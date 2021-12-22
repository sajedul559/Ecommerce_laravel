@extends('frontend.layouts.master')
@section('main_content')
<main id="main">
    <div class="container">

        <!--MAIN SLIDE-->
        @include('frontend.homepage.main_slide')

        <!--BANNER-->
        @include('frontend.homepage.banner')

        <!--On Sale-->
        @include('frontend.homepage.onsale_product')

        <!--Latest Products-->
        @include('frontend.homepage.latest')

        <!--Product Categories-->
        @include('frontend.homepage.product_category')		

    </div>

</main>
@endsection()