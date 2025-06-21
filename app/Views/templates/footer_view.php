<!-- footer -->
<footer class="bg-dark py-4 py-md-5">
    <div class="container">
        <div class="row text-white g-4">
            <div class="col-12 col-md-6 col-lg-3">
                <a class="text-decoration-none brand text-white d-block mb-3" href="<?= base_url('/') ?>">
                    <img src="<?= base_url('public/images/workoutIcon.png') ?>" alt="FitSyn Logo" class="img-fluid me-2"
                        style="max-height: 30px;">
                    <span class="align-middle">FITSYN</span>
                </a>
                <p class="text-white-50 fs-6">Tu tienda de confianza para todos los suplementos deportivos. Calidad
                    premium y resultados garantizados para alcanzar tus objetivos fitness.</p>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="fw-light mb-3">Enlaces</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= base_url('/') ?>" class="text-white-50 text-decoration-none hover-link">
                            <i class="bi bi-chevron-right me-2 small"></i>Inicio
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('#productos') ?>" class="text-white-50 text-decoration-none hover-link">
                            <i class="bi bi-chevron-right me-2 small"></i>Productos
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('contacto') ?>" class="text-white-50 text-decoration-none hover-link">
                            <i class="bi bi-chevron-right me-2 small"></i>Contacto
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('#nosotros') ?>" class="text-white-50 text-decoration-none hover-link">
                            <i class="bi bi-chevron-right me-2 small"></i>Sobre Nosotros
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="fw-light mb-3">Contáctanos</h5>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-start text-white-50">
                        <i class="bi bi-geo-alt mt-1 me-3"></i>
                        <span class="fw-light">Calle Ejercicio 99, Corrientes, Argentina</span>
                    </div>
                    <div class="d-flex align-items-start text-white-50">
                        <i class="bi bi-telephone mt-1 me-3"></i>
                        <span class="fw-light">+54 123 456 789</span>
                    </div>
                    <div class="d-flex align-items-start text-white-50">
                        <i class="bi bi-envelope mt-1 me-3"></i>
                        <span class="fw-light">info@fitsyn.com</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="fw-light mb-3">Síguenos</h5>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white fs-5 hover-link"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white fs-5 hover-link"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white fs-5 hover-link"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white fs-5 hover-link"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
        </div>

        <div class="border-top border-secondary mt-4 pt-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="text-white-50 mb-0">&copy; 2025 FitSyn. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="<?= base_url('/terminos') ?>" class="text-white-50 text-decoration-none me-3">Términos y
                        Condiciones</a>
                    <a href="<?= base_url('/comercializacion') ?>"
                        class="text-white-50 text-decoration-none">Comercialización</a>
                </div>
            </div>
        </div>
    </div>
</footer>