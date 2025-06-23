<?php
$session = session();
?>

<!-- Hero Section -->
<div class="bg-dark text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Quiénes <span class="text-danger">Somos</span></h1>
                <p class="lead mb-4">En FitSyn, nos dedicamos a proporcionar los mejores suplementos deportivos para
                    ayudarte a alcanzar tus objetivos fitness. Nuestra pasión por la salud y el bienestar nos impulsa a
                    ofrecer productos de la más alta calidad.</p>
            </div>
            <div class="col-lg-6">
                <img src="<?= base_url('images/workoutIconabout.webp') ?>" alt="FitSyn Logo" class="img-fluid big-logo">
            </div>
        </div>
    </div>
</div>

<!-- Nuestra Historia -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold mb-4">Nuestra <span class="text-danger">Historia</span></h2>
                <p class="text-muted mb-4">Fundada en 2025, FitSyn nació con la visión de revolucionar la industria de
                    suplementos deportivos en Argentina. Comenzamos como una pequeña tienda en Corrientes y hemos
                    crecido hasta convertirnos en un referente nacional en la comercialización de suplementos deportivos
                    de alta calidad.</p>
            </div>
        </div>
    </div>
</section>

<!-- Nuestro Equipo -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Nuestro <span class="text-danger">Equipo</span></h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div
                            class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center mb-3 team-icon">
                            <i class="fas fa-person text-white fs-1"></i>
                        </div>
                        <h4 class="fw-bold">Geronimo Serial</h4>
                        <p class="text-danger">CEO y Director de Operaciones</p>
                        <p class="small text-muted">Con más de 10 años de experiencia en la industria fitness, lidera
                            la
                            visión estratégica de FitSyn</p>
                        <a href="https://www.geroserial.com" class="text-danger"> Conocéme</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cards de Enlaces -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <a href="<?= base_url('comercializacion') ?>" class="text-decoration-none">
                    <div class="card hover-card border-0 shadow-sm text-center p-4 hover-shadow transition-all h-100">
                        <div class="card-body">
                            <i class="bi bi-shop fs-1 text-danger mb-3"></i>
                            <h4 class="fw-bold">Comercialización</h4>
                            <p class="text-muted mb-0">Conoce nuestras políticas de venta y distribución</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?= base_url('terminos') ?>" class="text-decoration-none">
                    <div class="card border-0 hover-card shadow-sm text-center p-4 hover-shadow transition-all h-100">
                        <div class="card-body">
                            <i class="bi bi-file-text fs-1 text-danger mb-3"></i>
                            <h4 class="fw-bold">Términos y Condiciones</h4>
                            <p class="text-muted mb-0">Información legal y condiciones de uso</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?= base_url('contacto') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm hover-card text-center p-4 hover-shadow transition-all h-100">
                        <div class="card-body">
                            <i class="bi bi-envelope fs-1 text-danger mb-3"></i>
                            <h4 class="fw-bold">Contacto</h4>
                            <p class="text-muted mb-0">Ponte en contacto con nuestro equipo</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Valores -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Nuestros <span class="text-danger">Valores</span></h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center">
                    <i class="bi bi-shield-check fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Calidad</h5>
                    <p class="text-muted small">Solo los mejores productos certificados</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <i class="bi bi-heart fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Compromiso</h5>
                    <p class="text-muted small">Dedicados a tu éxito fitness</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <i class="bi bi-trophy fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Excelencia</h5>
                    <p class="text-muted small">Mejora continua en todo lo que hacemos</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <i class="bi bi-people fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Comunidad</h5>
                    <p class="text-muted small">Construyendo una comunidad fitness fuerte</p>
                </div>
            </div>
        </div>
    </div>
</section>