@if(!request()->routeIs('myaccount'))
    <footer class="footer">
        <div class="getintouch">
            <h3>Get in Touch</h3>
            <p><a href="{{ route('contact') }}"><span>Send us a message</span></a><br> Or you can call us on <a href="tel:+2347041690452">+2347048258922</a></p>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-8 col-sm-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div>
                                <h6>Quick Links</h6>
                                <div>
                                    <p><a href="{{ route('restaurant.index') }}">Cuisine</a></p>
                                    <p><a href="{{ route('fashion.index') }}">Fashion</a></p>
                                    <p><a href="#" data-toggle="modal" data-target="#comingsoon">Life Style</a></p>
                                    <p><a href="#" data-toggle="modal" data-target="#comingsoon">Scholar</a></p>
                                    <p><a href="#" data-toggle="modal" data-target="#comingsoon">Business</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div>
                                <h6>Information</h6>
                                <div>
                                    <p><a href="{{ route('privacy_policy') }}">Privacy policy</a></p>
                                    <p><a href="{{ route('terms_and_conditions') }}">Terms & condition</a></p>
                                    <p><a href="{{ route('faq') }}">FAQ</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div>
                                <h6>Account</h6>
                                <div>
                                    <p><a href="/merchant/register">Sell on Jollof</a></p>
                                    <p><a href="{{ route('login') }}">Merchant Login</a></p>
                                    <hr>
                                    <p>To advertise on Jollof.com, please send us an email: <a href="mailto:info@jollof.com">info@jollof.com</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-4 col-sm-12 col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <h6>Social</h6>
                                <div>
                                    <p><a href="https://web.facebook.com/jollof.comFB/" target="_blank"><i class="fa fa-facebook"></i> facebook</a></p>
                                    <p><a href="https://www.instagram.com/jollof.comig/" target="_blank"><i class="fa fa-instagram"></i> instagram</a></p>
                                    <p><a href="https://twitter.com/jollofTWEET" target="_blank"><i class="fa fa-twitter"></i> twitter</a></p>
                                    <p><a href="https://www.linkedin.com/showcase/jollof/" target="_blank"><i class="fa fa-linkedin-square"></i> Linkedin</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Mobile App</h6>
                            <div>
                                <div class="p-2">
                                    <a href="https://play.google.com/store/apps/details?id=com.wJollof_15698619" target="_blank">
                                        <img src="{{ asset('images/google-play.png')}}" class="img-fluid" alt="google play icon">
                                    </a>
                                </div>
                                <div class="p-2">
                                    <a href="#" data-toggle="modal" data-target="#comingsoon">
                                        <img src="{{ asset('images/app-store.png') }}" class="img-fluid" alt="app store icon">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <p class="pull-left">{{ date('Y') }} &copy; All Right Reserved, Jollof.com</p>
                <p class="text-right">
                    <a href="{{ route('cancellation.and.refund') }}">Refund & Cancellation Policy</a> | <a href="{{ route('terms_and_conditions') }}">Terms & Conditions</a>
                </p>
            </div>
        </div>
    </footer>
@endif
