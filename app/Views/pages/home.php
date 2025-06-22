<!-- CARROUSEL SECTION-->
<header id="header" class="vh-100 carousel slide" data-bs-ride="carousel">
    <!-- Indicadores del carousel -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#header" data-bs-slide-to="0" class="active" aria-current="true"></button>
        <button type="button" data-bs-target="#header" data-bs-slide-to="1"></button>
    </div>

    <div class="container h-100 d-flex align-items-center carousel-inner">
        <div class="text-center carousel-item active">
            <div class="carousel-content position-relative px-2 px-md-4 py-3 py-md-4">
                <h2 class="text-white display-6 display-md-5 display-lg-4 fw-lighter mb-2">Potencia tu rendimiento</h2>
                <h1 class="text-white display-5 display-md-4 display-lg-3 fw-bold mb-3">SUPLEMENTOS <span
                        class="text-danger">PREMIUM</span></h1>
                <p class="text-white mb-3 mb-md-4 lead d-none d-sm-block">Descubre nuestra selección de productos de
                    alta calidad</p>
            </div>
        </div>
        <div class="text-center carousel-item">
            <div class="carousel-content position-relative px-2 px-md-4 py-3 py-md-4">
                <h2 class="text-white display-6 display-md-5 display-lg-4 fw-lighter mb-2">Las mejores marcas</h2>
                <h1 class="text-white display-5 display-md-4 display-lg-3 fw-bold mb-3">CALIDAD <span
                        class="text-danger">GARANTIZADA</span></h1>
                <p class="text-white mb-3 mb-md-4 lead d-none d-sm-block">Marcas premium seleccionadas para ti</p>
            </div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#header" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#header" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</header>

<!-- PRODUCTOS SECTION -->
<section id="productos" class="collection-section py-5 bg-light" style="min-height: 45vh;">
    <div class="container">
        <div class="text-center mb-4 mb-md-5">
            <span class="badge bg-danger text-white px-3 py-2 mb-2">NUESTRAS CATEGORÍAS</span>
            <h2 class="display-5 display-md-4 fw-bold">Descubrí tu Potencial</h2>
            <div class="border-bottom border-danger border-3 w-50 w-md-25 mx-auto"></div>
        </div>

        <!-- Grid de categorías con hover effects -->
        <div class="row g-3 g-md-4">
            <!-- Proteínas -->
            <div class="col-12 col-sm-6 col-lg-3">
                <a href="<?= base_url('categoria/proteinas') ?>" class="text-decoration-none">
                    <div class="tilt-card h-100">
                        <div class="tilt-card-inner">
                            <div class="tilt-card-content">
                                <div class="card-overlay">
                                    <div class="overlay-content">
                                        <h3 class="overlay-title">Proteínas</h3>
                                        <p class="overlay-text">Maximiza tu recuperación muscular</p>
                                        <div class="overlay-arrow">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <img src="<?= base_url('images/proteinas.webp') ?>" alt="Proteínas"
                                    class="img-fluid rounded-3">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Creatinas -->
            <div class="col-12 col-sm-6 col-lg-3">
                <a href="<?= base_url('categoria/creatinas') ?>" class="text-decoration-none">
                    <div class="tilt-card h-100">
                        <div class="tilt-card-inner">
                            <div class="tilt-card-content">
                                <div class="card-overlay">
                                    <div class="overlay-content">
                                        <h3 class="overlay-title">Creatinas</h3>
                                        <p class="overlay-text">Potencia tu rendimiento físico</p>
                                        <div class="overlay-arrow">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <img src="<?= base_url('images/creatina.webp') ?>" alt="Creatinas"
                                    class="img-fluid rounded-3">
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Colágenos -->
            <div class="col-12 col-sm-6 col-lg-3">
                <a href="<?= base_url('categoria/colagenos') ?>" class="text-decoration-none">
                    <div class="tilt-card h-100">
                        <div class="tilt-card-inner">
                            <div class="tilt-card-content">
                                <div class="card-overlay">
                                    <div class="overlay-content">
                                        <h3 class="overlay-title">Colágenos</h3>
                                        <p class="overlay-text">Cuida tu piel y articulaciones</p>
                                        <div class="overlay-arrow">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <img src="<?= base_url('images/colageno.webp') ?>" alt="Colágenos"
                                    class="img-fluid rounded-3">
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Accesorios -->
            <div class="col-12 col-sm-6 col-lg-3">
                <a href="<?= base_url('categoria/accesorios') ?>" class="text-decoration-none">
                    <div class="tilt-card h-100">
                        <div class="tilt-card-inner">
                            <div class="tilt-card-content">
                                <div class="card-overlay">
                                    <div class="overlay-content">
                                        <h3 class="overlay-title">Accesorios</h3>
                                        <p class="overlay-text">Complementa tu entrenamiento</p>
                                        <div class="overlay-arrow">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <img src="<?= base_url('images/accesorios.webp') ?>" alt="Accesorios"
                                    class="img-fluid rounded-3">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- MAS VENDIDOS SECTION -->
<section id="popular" class="py-4 py-md-5">
    <div class="container">
        <div class="title text-center pt-3 pb-4 pb-md-5">
            <h2 class="fw-bold position-relative d-inline-block ms-0 ms-md-4">Los Más Vendidos</h2>
        </div>

        <div class="row g-5">
            <!-- PROTEINAS -->
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fs-4 text-primary mb-0">Top en Proteínas</h3>
                    <a href="<?= base_url('categoria/proteinas') ?>" class="btn btn-outline-primary btn-sm">Ver todos
                        <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
                <div class="row g-4 mt-3">
                    <?php if (!empty($topProteinas)): ?>
                        <?php foreach ($topProteinas as $producto): ?>
                            <div class="col-md-4">
                                <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                                    <div class="card-img-wrapper mb-3">
                                        <img src="<?= base_url('images/' . ($producto['url_imagen'] ?? 'default-product.jpg')) ?>"
                                            alt="<?= esc($producto['nombre']) ?>" class="product-img mx-auto">
                                    </div>
                                    <h5 class="fw-semibold mb-2"><?= esc($producto['nombre']) ?></h5>
                                    <p class="text-success fw-bold mb-3">$
                                        <?= number_format($producto['precio'], 0, ',', '.') ?></p>
                                    <a href="<?= base_url('producto/' . $producto['id_producto']) ?>"
                                        class="btn btn-primary mt-auto">Comprar</a>
                                    <a href="<?= base_url('producto/' . $producto['id_producto']) ?>"
                                        class="text-primary text-decoration-none mt-1">Detalles</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-muted">No hay productos destacados en esta categoría.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- CREATINAS -->
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fs-4 text-primary mb-0">Top en Creatinas</h3>
                    <a href="<?= base_url('categoria/creatinas') ?>" class="btn btn-outline-primary btn-sm">Ver todos
                        <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
                <div class="row g-4 mt-3">
                    <?php if (!empty($topCreatinas)): ?>
                        <?php foreach ($topCreatinas as $producto): ?>
                            <div class="col-md-4">
                                <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                                    <div class="card-img-wrapper mb-3">
                                        <img src="<?= base_url('images/' . ($producto['url_imagen'] ?? 'default-product.jpg')) ?>"
                                            alt="<?= esc($producto['nombre']) ?>" class="product-img mx-auto">
                                    </div>
                                    <h5 class="fw-semibold mb-2"><?= esc($producto['nombre']) ?></h5>
                                    <p class="text-success fw-bold mb-3">$
                                        <?= number_format($producto['precio'], 0, ',', '.') ?></p>
                                    <a href="<?= base_url('producto/' . $producto['id_producto']) ?>"
                                        class="btn btn-primary mt-auto">Comprar</a>
                                    <a href="<?= base_url('producto/' . $producto['id_producto']) ?>"
                                        class="text-primary text-decoration-none mt-1">Detalles</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-muted">No hay productos destacados en esta categoría.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- COLÁGENOS -->
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fs-4 text-primary mb-0">Top en Colágenos</h3>
                    <a href="<?= base_url('categoria/colagenos') ?>" class="btn btn-outline-primary btn-sm">Ver todos
                        <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
                <div class="row g-4 mt-3">
                    <?php if (!empty($topColagenos)): ?>
                        <?php foreach ($topColagenos as $producto): ?>
                            <div class="col-md-4">
                                <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                                    <div class="card-img-wrapper mb-3">
                                        <img src="<?= base_url('images/' . ($producto['url_imagen'] ?? 'default-product.jpg')) ?>"
                                            alt="<?= esc($producto['nombre']) ?>" class="product-img mx-auto">
                                    </div>
                                    <h5 class="fw-semibold mb-2"><?= esc($producto['nombre']) ?></h5>
                                    <p class="text-success fw-bold mb-3">$
                                        <?= number_format($producto['precio'], 0, ',', '.') ?></p>
                                    <a href="<?= base_url('producto/' . $producto['id_producto']) ?>"
                                        class="btn btn-primary mt-auto">Comprar</a>
                                    <a href="<?= base_url('producto/' . $producto['id_producto']) ?>"
                                        class="text-primary text-decoration-none mt-1">Detalles</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-muted">No hay productos destacados en esta categoría.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ACCESORIOS -->
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fs-4 text-primary mb-0">Top en Accesorios</h3>
                    <a href="<?= base_url('categoria/accesorios') ?>" class="btn btn-outline-primary btn-sm">Ver todos
                        <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
                <div class="row g-4 mt-3">
                    <?php if (!empty($topAccesorios)): ?>
                        <?php foreach ($topAccesorios as $producto): ?>
                            <div class="col-md-4">
                                <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                                    <div class="card-img-wrapper mb-3">
                                        <img src="<?= base_url('images/' . ($producto['url_imagen'] ?? 'default-product.jpg')) ?>"
                                            alt="<?= esc($producto['nombre']) ?>" class="product-img mx-auto">
                                    </div>
                                    <h5 class="fw-semibold mb-2"><?= esc($producto['nombre']) ?></h5>
                                    <p class="text-success fw-bold mb-3">$
                                        <?= number_format($producto['precio'], 0, ',', '.') ?></p>
                                    <a href="<?= base_url('producto/' . $producto['id_producto']) ?>"
                                        class="btn btn-primary mt-auto">Comprar</a>
                                    <a href="<?= base_url('producto/' . $producto['id_producto']) ?>"
                                        class="text-primary text-decoration-none mt-1">Detalles</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-muted">No hay productos destacados en esta categoría.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- end of MAS VENDIDOS section-->

<!-- NOSOTROS SECTION -->
<section id="nosotros" class="py-5 py-md-6 bg-light"
    style="min-height: 80vh; display: flex; justify-content: center; align-items: center;">
    <div class="container">
        <div class="row gy-4 gy-lg-0 align-items-center">
            <!-- Texto y Botones -->
            <div class="col-12 col-lg-6 order-lg-1 text-center text-lg-start">
                <div class="title pt-3 pb-4 pb-md-5">
                    <h2 class="fw-bold position-relative d-inline-block ms-0 ms-md-4 text-primary">Sobre FitSyn</h2>
                </div>
                <p class="lead text-muted mb-3">Tu Socio en el Camino hacia tus Objetivos Fitness</p>
                <p class="mb-4 px-2 px-lg-0">En FitSyn, nos dedicamos a proporcionar los mejores suplementos deportivos
                    del mercado, respaldados por la ciencia y la calidad. Nuestra misión es ayudarte a alcanzar tus
                    metas fitness con productos premium y asesoramiento experto.</p>

                <!-- Botón "Ver más" -->
                <div class="text-center text-lg-start mb-4">
                    <a href="<?= base_url('/nosotros') ?>"
                        class="btn btn-outline-primary rounded-pill px-5 py-2 btn-hover-shadow">
                        Ver más
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>

                <!-- Características -->
                <div class="border-top mt-4 pt-4">
                    <div class="row g-4">
                        <div class="col-6 col-md-3">
                            <h6 class="fw-semibold mb-2">PRODUCTOS CERTIFICADOS</h6>
                            <p class="mb-0 small text-muted">Garantía de calidad en cada producto</p>
                        </div>
                        <div class="col-6 col-md-3">
                            <h6 class="fw-semibold mb-2">ASESORÍA EXPERTA</h6>
                            <p class="mb-0 small text-muted">Equipo de profesionales del fitness</p>
                        </div>
                        <div class="col-6 col-md-3">
                            <h6 class="fw-semibold mb-2">ENVÍOS RÁPIDOS</h6>
                            <p class="mb-0 small text-muted">Entrega en 24-48 horas</p>
                        </div>
                        <div class="col-6 col-md-3">
                            <h6 class="fw-semibold mb-2">SATISFACCIÓN GARANTIZADA</h6>
                            <p class="mb-0 small text-muted">30 días de garantía de devolución</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Imagen -->
            <div class="col-12 col-lg-6 order-lg-0">
                <div class="px-4 px-lg-0">
                    <img src="<?= base_url('images/nosotros.png') ?>" alt="Sobre nosotros"
                        class="img-fluid rounded-4 shadow-lg transform-hover">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- end of about us -->