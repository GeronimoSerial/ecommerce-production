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
                <h1 class="text-white display-5 display-md-4 display-lg-3 fw-bold mb-3">SUPLEMENTOS <span class="text-danger">PREMIUM</span></h1>
                <p class="text-white mb-3 mb-md-4 lead d-none d-sm-block">Descubre nuestra selección de productos de alta calidad</p>
            </div>
        </div>
        <div class="text-center carousel-item">
            <div class="carousel-content position-relative px-2 px-md-4 py-3 py-md-4">
                <h2 class="text-white display-6 display-md-5 display-lg-4 fw-lighter mb-2">Las mejores marcas</h2>
                <h1 class="text-white display-5 display-md-4 display-lg-3 fw-bold mb-3">CALIDAD <span class="text-danger">GARANTIZADA</span></h1>
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
 <!-- productos section -->
<section id="productos" class="collection-section py-5 bg-light">
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
                <a href="<?= base_url('/') ?>" class="text-decoration-none">
                    <div class="category-card position-relative overflow-hidden rounded-4 shadow-lg h-100">
                        <div class="category-img">
                            <img src="<?= base_url('public/images/proteinas.webp')?>" 
                                 class="img-fluid w-100 category-image" alt="Proteínas">
                        </div>
                        <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3 p-md-4">
                            <h3 class="text-white h5 h4-md mb-2">Proteínas</h3>
                            <p class="text-white-50 mb-3 small">Maximiza tu recuperación muscular</p>
                            <div class="btn btn-light btn-sm px-3 px-md-4 py-2 opacity-0 transform-bottom">
                                Explorar <i class="fas fa-arrow-right ms-2"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Creatinas -->
            <div class="col-12 col-sm-6 col-lg-3">
                <a href="<?= base_url('/') ?>" class="text-decoration-none">
                    <div class="category-card position-relative overflow-hidden rounded-4 shadow-lg h-100">
                        <div class="category-img">
                            <img src="<?= base_url('public/images/creatina.png') ?>" 
                                 class="img-fluid w-100 category-image" alt="Creatinas">
                        </div>
                        <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3 p-md-4">
                            <h3 class="text-white h5 h4-md mb-2">Creatinas</h3>
                            <p class="text-white-50 mb-3 small">Potencia tu rendimiento</p>
                            <div class="btn btn-light btn-sm px-3 px-md-4 py-2 opacity-0 transform-bottom">
                                Explorar <i class="fas fa-arrow-right ms-2"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Colágenos -->
            <div class="col-12 col-sm-6 col-lg-3">
                <a href="<?= base_url('/') ?>" class="text-decoration-none">
                    <div class="category-card position-relative overflow-hidden rounded-4 shadow-lg h-100">
                        <div class="category-img">
                            <img src="<?= base_url('public/images/colageno.webp')?>" 
                                 class="img-fluid w-100 category-image" alt="Colágenos">
                        </div>
                        <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3 p-md-4">
                            <h3 class="text-white h5 h4-md mb-2">Colágenos</h3>
                            <p class="text-white-50 mb-3 small">Cuida tu piel y articulaciones</p>
                            <div class="btn btn-light btn-sm px-3 px-md-4 py-2 opacity-0 transform-bottom">
                                Explorar <i class="fas fa-arrow-right ms-2"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Accesorios -->
            <div class="col-12 col-sm-6 col-lg-3">
                <a href="<?= base_url('/') ?>" class="text-decoration-none">
                    <div class="category-card position-relative overflow-hidden rounded-4 shadow-lg h-100">
                        <div class="category-img">
                            <img src="<?= base_url('public/images/accesorios.webp')?>" 
                                 class="img-fluid w-100 category-image" alt="Accesorios">
                        </div>
                        <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3 p-md-4">
                            <h3 class="text-white h5 h4-md mb-2">Accesorios</h3>
                            <p class="text-white-50 mb-3 small">Complementa tu entrenamiento</p>
                            <div class="btn btn-light btn-sm px-3 px-md-4 py-2 opacity-0 transform-bottom">
                                Explorar <i class="fas fa-arrow-right ms-2"></i>
                            </div>
                        </div>
                    </div>
                </a>
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

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="category-section p-3 bg-white rounded-4 shadow-sm h-100">
                    <h3 class="fs-5 mb-4">Top en Proteínas</h3>
                    <div class="vstack gap-3">
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url('public/images/isolated.webp') ?>" alt="Proteína" class="product-img img-fluid me-3">
                            <div>
                                <p class="mb-1 fw-bold">Whey Protein Isolate</p>
                                <span class="text-primary">$ 49.999</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url('public/images/vegan.webp') ?>" alt="Proteína" class="product-img img-fluid me-3">
                            <div>
                                <p class="mb-1 fw-bold">Proteina Vegana</p>
                                <span class="text-primary">$ 39.999</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url('public/images/caseina.webp') ?>" alt="Proteína" class="product-img img-fluid me-3">
                            <div>
                                <p class="mb-1 fw-bold">Casein Protein</p>
                                <span class="text-primary">$ 144.999</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="category-section p-3 bg-white rounded-4 shadow-sm h-100">
                    <h3 class="fs-5 mb-4">Top en Creatina</h3>
                    <div class="vstack gap-3">
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url('public/images/creatina.png') ?>" alt="Creatina" class="product-img img-fluid me-3">
                            <div>
                                <p class="mb-1 fw-bold">Creatina Monohidrato</p>
                                <span class="text-primary">$ 29.999</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url('public/images/hcl.webp') ?>" alt="Creatina" class="product-img img-fluid me-3">
                            <div>
                                <p class="mb-1 fw-bold">Creatina HCL</p>
                                <span class="text-primary">$ 134.999</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url('public/images/micronizada.webp') ?>" alt="Creatina" class="product-img img-fluid me-3">
                            <div>
                                <p class="mb-1 fw-bold">Creatina Micronizada</p>
                                <span class="text-primary">$ 36.999</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="category-section p-3 bg-white rounded-4 shadow-sm h-100">
                    <h3 class="fs-5 mb-4">Top en Pre-entrenos</h3>
                    <div class="vstack gap-3">
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url('public/images/pump.webp') ?>" alt="Pre-entreno" class="product-img img-fluid me-3">
                            <div>
                                <p class="mb-1 fw-bold">PUMP v8</p>
                                <span class="text-primary">$ 39.999</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url('public/images/explosive.webp') ?>" alt="Pre-entreno" class="product-img img-fluid me-3">
                            <div>
                                <p class="mb-1 fw-bold">PRE.NO Explosive</p>
                                <span class="text-primary">$ 44.999</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url('public/images/prewar.webp') ?>" alt="Pre-entreno" class="product-img img-fluid me-3">
                            <div>
                                <p class="mb-1 fw-bold">ENA PRE War</p>
                                <span class="text-primary">$ 34.999</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of popular -->

                                <!-- NOSOTROS SECTION -->
 <!-- about us -->
<section id="nosotros" class="py-4 py-md-5">
    <div class="container">
        <div class="row gy-4 gy-lg-0 align-items-center">
            <div class="col-12 col-lg-6 order-lg-1 text-center text-lg-start">
                <div class="title pt-2 pt-md-3 pb-3 pb-md-4">
                    <h2 class="fw-bold position-relative d-inline-block ms-0 ms-md-4">Sobre FitSyn</h2>
                </div>
                <p class="lead text-muted mb-3">Tu Socio en el Camino hacia tus Objetivos Fitness</p>
                <p class="mb-4 px-2 px-lg-0">En FitSyn, nos dedicamos a proporcionar los mejores suplementos deportivos del mercado, respaldados por la ciencia y la calidad. Nuestra misión es ayudarte a alcanzar tus metas fitness con productos premium y asesoramiento experto.</p>
                <div class="text-center text-lg-start mb-4">
                    <a href="<?= base_url('/nosotros') ?>" class="btn btn-outline-primary rounded-pill px-4 btn-ver-mas">
                        Ver más
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                
                <div class="border-top mt-4 pt-4">
                    <div class="row g-3 g-md-4">
                        <div class="col-6">
                            <h6 class="mb-2">PRODUCTOS CERTIFICADOS</h6>
                            <p class="mb-0 small">Garantía de calidad en cada producto</p>
                        </div>
                        <div class="col-6">
                            <h6 class="mb-2">ASESORÍA EXPERTA</h6>
                            <p class="mb-0 small">Equipo de profesionales del fitness</p>
                        </div>
                        <div class="col-6">
                            <h6 class="Mb-2">ENVÍOS RAPIDOS</h6>
                            <p class="mb-0 small">Entrega en 24-48 horas</p>
                        </div>
                        <div class="col-6">
                            <h6 class="mb-2">SATISFACCIÓN GARANTIZADA</h6>
                            <p class="mb-0 small">30 días de garantía de devolución</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 order-lg-0">
                <div class="px-4 px-lg-0">
                    <img src="<?= base_url('public/images/nosotros.png')?>" alt="Sobre nosotros" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of about us -->
