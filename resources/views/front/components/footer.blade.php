<footer class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="footer-brand">
                    <img src="{{ asset('front/assets/images/logo-with-text.jpg') }}" alt="logo" class="footer-logo">
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="footer-brand">
                    <p>Transform your future with expert-led courses designed for the modern learner.</p>
                    <div class="social-links">
                        <a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ route('front.courses') }}">Courses</a></li>
                    <li><a href="{{ route('front.about.us') }}">About Us</a></li>
                    <li><a href="{{ route('front.faq') }}">FAQ</a></li>
                    <li><a href="{{ route('front.contact') }}">Contact</a></li>
                </ul>
            </div>
            
            <div class="col-md-3 mb-4">
                <h5>Contact Info</h5>
                <div class="contact-info">
                    <ul class="footer-links">
                        <li><i class="fas fa-envelope"></i> <a href="mailto:info@evergfreelance.com" target="_blank">Info@evergfreelance.com</a></li>
                        <li><i class="fas fa-phone"></i> <a href="tel:+639602358974" target="_blank">+63 960 235 8974</a></li>
                        <li><i class="fas fa-map-marker-alt"></i> <a href="https://maps.app.goo.gl/1234567890" target="_blank">123 Learning St, Education City</a></li>
                        <li><i class="fab fa-whatsapp"></i> <a href="https://wa.me/639602358974" target="_blank">+63 960 235 8974</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <hr>
        <div class="row">
            <div class="col-12 text-center">
                <p>&copy; <script>document.write(new Date().getFullYear());</script> EverGreen Freelancing. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>