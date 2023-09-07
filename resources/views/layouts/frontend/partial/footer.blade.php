<footer>

    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-6">
                <div class="footer-section">

                    <a class="logo" href="#"><img src="{{ asset('frontend') }}/images/logo.png" alt="Logo Image"></a>
                    <p class="copyright">Bona @ 2017. All rights reserved.</p>
                    <p class="copyright">Designed by <a href="https://colorlib.com" target="_blank">Colorlib</a>.Downloaded from <a href="https://themeslab.org/" target="_blank">Themeslab</a></p>
                    <ul class="icons">
                        <li><a href="#"><i class="ion-social-facebook-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-twitter-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-vimeo-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-pinterest-outline"></i></a></li>
                    </ul>

                </div><!-- footer-section -->
            </div><!-- col-lg-4 col-md-6 -->

            <div class="col-lg-4 col-md-6">

                <div class="footer-section">
                    <h4 class="title"><b>CATAGORIES</b></h4>
                    @foreach($footer_categories_cunk as $footer_categories)
                    <ul>
                        @foreach($footer_categories as $footer_category)
                        <li>
                            @if(!empty($footer_category['subcategories']))
                                <a href="{{ route('subcategory',[$footer_category['id'], $footer_category['slug']]) }}">{{ $footer_category['name'] }}</a>
                            @else
                                <a href="{{ route('videos',[$footer_category['id'], $footer_category['slug']]) }}">{{ $footer_category['name'] }}</a>
                            @endif

                        </li>
                        @endforeach
                    </ul>
                    @endforeach
                </div><!-- footer-section -->
            </div><!-- col-lg-4 col-md-6 -->

            <div class="col-lg-4 col-md-6">
                <div class="footer-section">

                    <h4 class="title"><b>Pages</b></h4>
                    <ul>
                        @foreach($cms_pages as $page)
                            <li>
                                <a href="{{ route('cms', $page->slug) }}">{{ $page->title }}</a>
                            </li>
                        @endforeach
                    </ul>

                </div><!-- footer-section -->
            </div><!-- col-lg-4 col-md-6 -->

        </div><!-- row -->
    </div><!-- container -->
</footer>
