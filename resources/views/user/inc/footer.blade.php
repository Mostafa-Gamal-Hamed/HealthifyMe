<footer class="bg-dark text-white pt-5">
    <div class="container">
        <div class="row g-4">
            <!-- About Us Section -->
            <div class="col-lg-4 col-md-6">
                <div class="pe-lg-4">
                    <h3 class="h4 mb-4">
                        <i class="fas fa-heartbeat me-2 text-primary"></i> About HealthifyMe
                    </h3>
                    <p class="mb-4">
                        We believe that the path to a healthy body and balanced life should be accessible and effective.
                        Our smart platform helps you achieve your health goals through personalized diet plans,
                        accurate calorie tracking, and a comprehensive nutrition database.
                    </p>
                    <div class="social-icons">
                        <a href="#" class="text-white me-3" aria-label="Facebook">
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                        <a href="#" class="text-white me-3" aria-label="Twitter">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="text-white me-3" aria-label="Instagram">
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                        <a href="#" class="text-white" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links Section -->
            <div class="col-lg-2 col-md-6">
                <h3 class="h4 mb-4">
                    <i class="fas fa-link me-2 text-primary"></i> Quick Links
                </h3>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-white text-decoration-none">Home</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('diet.diets') }}" class="text-white text-decoration-none">Diet Plans</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('contact.create') }}" class="text-white text-decoration-none">Contact Us</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('PrivacyPolicy') }}" class="text-white text-decoration-none">Privacy Policy</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('TermsOfService') }}" class="text-white text-decoration-none">Terms of
                            Service</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div class="col-lg-3 col-md-6">
                <h3 class="h4 mb-4">
                    <i class="fas fa-envelope me-2 text-primary"></i> Contact Us
                </h3>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-envelope mt-1 me-2 text-primary"></i>
                        <a href="mailto:healthifyme@healthifyme.top" class="text-white text-decoration-none" target="_blank">
                            healthifyme@healthifyme.top
                        </a>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fab fa-whatsapp mt-1 me-2 text-success"></i>
                        <a href="https://wa.me/201141669674" class="text-white text-decoration-none" target="_blank">
                            Chat on WhatsApp
                        </a>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="fas fa-map-marker-alt mt-1 me-2 text-primary"></i>
                        <span>10 Talaat Harb Square, Cairo City</span>
                    </li>
                </ul>
            </div>

            <!-- Newsletter Section -->
            <div class="col-lg-3 col-md-6">
                <h3 class="h4 mb-4">
                    <i class="fas fa-newspaper me-2 text-primary"></i> Newsletter
                </h3>
                <p class="mb-3">Subscribe to get health tips and updates</p>
                <form action="{{ route('newsletter.store') }}" method="post" class="needs-validation" novalidate>
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control py-2 @error('email') is-invalid @enderror" placeholder="Your email" name="email" required
                            aria-label="Email for newsletter subscription">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                    <div class="form-text text-white-50">
                        We'll never share your email with anyone else.
                    </div>
                </form>
            </div>
        </div>

        <hr class="my-4 bg-secondary">

        <!-- Copyright Section -->
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-0">
                    &copy; 2025 <a href="{{ url('home') }}"
                        class="text-white text-decoration-none">HealthifyMe</a>.
                    All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">
                    Made with <i class="fas fa-heart text-danger"></i> for a healthier world
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts Section -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
<script src="{{ asset('js/fontawesome.min.js') }}" defer></script>
<script src="{{ asset('admin/js/Featherlight.js') }}" defer></script>
@yield('script')
</body>
</html>
