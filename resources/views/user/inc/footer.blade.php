<footer>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
                    <div class="row">
                        <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 ">
                            <div class="address">
                                <h3>Address </h3>
                                <ul class="loca">
                                    <li>
                                        <a href="#"></a>It is a long established fact
                                        <br>that a reader will be
                                    </li>
                                    <li>
                                        <a href="#"></a>(+71 1234567890)
                                    </li>
                                    <li>
                                        <a href="#"></a>demo@gmail.com
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="address">
                                <h3>Social Link</h3>
                                <ul class="Menu_footer">
                                    <li class="active"> <a href="#">Twitter</a> </li>
                                    <li><a href="#">Facebook</a> </li>
                                    <li><a href="#">Instagram</a> </li>
                                    <li><a href="#">Linkdin</a> </li>
                                </ul>
                            </div>
                        </div> --}}

                        <div class="col-lg-6 col-md-6 col-sm-6 ">
                            <div class="address">
                                <h3>Newsletter</h3>
                                <form class="news">
                                    <input class="newslatter" placeholder="Enter your email" type="text"
                                        name=" Enter your email">
                                    <button class="submit">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="copyright">
            <div class="container">
                <p>Copyright © 2025 Design by <a href="#"><strong>HealthifyMe</strong></a></p>
            </div>
        </div>
    </div>
</footer>

{{-- Js --}}
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/fontawesome.min.js') }}"></script>
<script src="{{ asset('admin/js/Featherlight.js') }}"></script>
@yield('script')

</body>

</html>
