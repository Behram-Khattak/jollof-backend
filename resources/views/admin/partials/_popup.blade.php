@if($popup)

    <div class="modal fade" id="popup"  data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="popup-close">
            <button type="button" class="close closepopup bg-white m-3 py-1 px-2 rounded-circle" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- The slideshow -->
                <div id="demo" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">

                        @foreach($popup->getMedia() as $slide)
                            <div
                                class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <a href="{{ $slide->getCustomProperty('link') }}" target="_blank"><img
                                        class="d-block w-100" src="{{ $slide->getUrl() }}" /></a>
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            $(function () {
                var popupBanner = (function() {
                    return {
                        'createCookieWhenBannerIsShown': false,
                        'createCookieWhenAcceptIsClicked': true,
                        'cookieDuration': 1,            // Number of days before the cookie expires, and the banner reappears
                        'cookieName': 'popup',          // Name of our cookie
                        'cookieValue': 'show',          // Value of cookie

                        '_createCookie': function(name, value, days) {
                            var expires;
                            if (days) {
                                var date = new Date();
                                date.setTime(date.getTime()+(days*24*60*60*1000));
                                expires = "; expires="+date.toGMTString();
                            }
                            else {
                                expires = "";
                            }
                            document.cookie = name+"="+value+expires+"; path=/";
                        },

                        '_checkCookie': function(name) {
                            var nameEQ = name + "=";
                            var ca = document.cookie.split(';');
                            for(var i=0;i < ca.length;i++) {
                                var c = ca[i];
                                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                            }
                            return null;
                        },

                        '_eraseCookie': function(name) {
                            popupBanner._createCookie(name,"",-1);
                        },

                        'createAcceptCookie': function() {
                            popupBanner._createCookie(popupBanner.cookieName, popupBanner.cookieValue, popupBanner.cookieDuration); // Create the cookie
                        },

                        'closeBanner': function() {
                            //var element = document.getElementById('cookie-law');
                            //element.parentNode.removeChild(element);
                            $('#popup').modal('hide');
                        },

                        'accept': function() {
                            popupBanner.createAcceptCookie();
                            popupBanner.closeBanner();
                        },

                        'showUnlessAccepted': function() {

                            if(popupBanner._checkCookie(popupBanner.cookieName) != popupBanner.cookieValue){
                                //CookieBanner._createDiv(html);
                                $('#popup').modal('show');
                            }
                        }

                    }

                })();
                //$('#popup').modal('show');
                popupBanner.showUnlessAccepted();
                $('body').on('click', '.closepopup', function(){
                    popupBanner.createAcceptCookie();
                    $('#popup').modal('hide');
                });
            });
        </script>
    @endpush
@endif
