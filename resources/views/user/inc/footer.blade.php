<footer>
    <div class="footer">
        <div class="container">
            <div class="row gap-3">
                <div class="col">
                    <div class="address">
                        <h3>About us</h3>
                        <p class="text-light">
                            <strong>
                                In HealthifyMe We believe that the path to a healthy body and a balanced life should be easy
                                and effective. That’s why we’ve developed a smart platform that helps you achieve your
                                health goals through personalized diet plans, accurate calorie counting, and a comprehensive
                                food database.
                            </strong>
                        </p>
                    </div>
                </div>

                <div class="col">
                    <div class="address">
                        <h3>Contact us </h3>
                        <ul class="loca">
                            <li>
                                <strong><a href="{{ route('contact.create') }}">Contact us from Web</a></strong>
                            </li>
                            <li>
                                <strong>
                                    Email: <a href="mailto:healthifyme@healthifyme.top">healthifyme@healthifyme.top</a>
                                </strong>
                            </li>
                            <li>
                                <strong>
                                    <a href="https://wa.me/201141669674"><i class="fa-brands fa-whatsapp text-success mt-3 fs-2"></i></a>
                                </strong>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col">
                    <div class="address">
                        <h3>Newsletter</h3>
                        <form action="{{ route('newsletter.store') }}" method="post" class="news">
                            @csrf
                            <input type="email"
                                class="form-control mb-3 p-3 fs-5 @error('email') is-invalid @enderror"
                                placeholder="Enter your email" name="email">
                            <button class="submit">Subscribe</button>
                        </form>
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
