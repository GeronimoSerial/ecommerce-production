<!-- Hero Section -->
<div class="bg-dark text-white py-5 mt-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-danger text-white px-3 py-2 mb-2">PROTEÍNAS</span>
                <h1 class="display-5 fw-bold mb-3">Suplementos de <span class="text-danger">Proteína</span></h1>
                <p class="lead">Las mejores proteínas para potenciar tu recuperación muscular y alcanzar tus objetivos fitness.</p>
            </div>
            <div class="col-lg-6">
                <img src="<?= base_url('public/images/protein_wallpaper.webp') ?>" alt="Proteínas Banner" class="img-fluid rounded-4">
            </div>
        </div>
    </div>
</div>

<!-- Productos Section -->
<section class="py-5 bg-light">
    <div class="container">
                <!-- Contenedor principal con sidebar y productos -->
        <div class="row g-4">
            <!-- Sidebar con filtros -->
            <div class="col-lg-3">
                <div class="accordion" id="accordionFiltros">
                    <!-- Filtro por Tipo -->
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                                data-bs-target="#filtroTipo">
                                Tipo de Proteína
                            </button>
                        </h2>
                        <div id="filtroTipo" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="tipoWhey" checked>
                                    <label class="form-check-label" for="tipoWhey">
                                        Whey Protein
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="tipoVegana">
                                    <label class="form-check-label" for="tipoVegana">
                                        Proteína Vegana
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="tipoCaseina">
                                    <label class="form-check-label" for="tipoCaseina">
                                        Caseína
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="tipoMass">
                                    <label class="form-check-label" for="tipoMass">
                                        Mass Gainers
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtro por Precio -->
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#filtroPrecio">
                                Rango de Precio
                            </button>
                        </h2>
                        <div id="filtroPrecio" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="range">
                                    <input type="range" class="form-range" min="0" max="100000" id="rangoPrecio">
                                    <div class="d-flex justify-content-between">
                                        <span>$0</span>
                                        <span>$100.000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtro por Sabor -->
                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#filtroSabor">
                                Sabor
                            </button>
                        </h2>
                        <div id="filtroSabor" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="saborChocolate">
                                    <label class="form-check-label" for="saborChocolate">
                                        Chocolate
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="saborVainilla">
                                    <label class="form-check-label" for="saborVainilla">
                                        Vainilla
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="saborFrutilla">
                                    <label class="form-check-label" for="saborFrutilla">
                                        Frutilla
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="saborBanana">
                                    <label class="form-check-label" for="saborBanana">
                                        Banana
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Buscador -->
            <div class="col-lg-9">
                <?= view('components/search_component', ['placeholder' => 'Buscar proteínas...']) ?>
                <div class="row g-3">
            <!-- Grid de Productos -->
                    <!-- Whey Protein Isolate -->
                    <div class="col-md-6 col-lg-4">
                        <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                            <div class="card-img-wrapper mb-3">
                                <img src="<?= base_url('public/images/isolated.webp') ?>" alt="Whey Protein Isolate" class="product-img mx-auto">
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-primary mb-2">Whey Protein</span>
                                <h5 class="fw-semibold mb-2">Whey Protein Isolate</h5>
                                <p class="text-muted small mb-2">Proteína de suero aislada de alta pureza</p>
                                <p class="text-success fw-bold mb-0">$ 49.999</p>
                            </div>
                            <div class="mt-auto">
                                <button class="btn btn-primary w-100 mb-2">Agregar al Carrito</button>
                                <a href="#" class="text-primary text-decoration-none small">Ver Detalles</a>
                            </div>
                        </div>
                    </div>

                    <!-- Mass Gainer -->
                    <div class="col-md-6 col-lg-4">
                        <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                            <div class="card-img-wrapper mb-3">
                                <img src="<?= base_url('public/images/mass_gainer.webp') ?>" alt="Mass Gainer" class="product-img mx-auto">
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-primary mb-2">Mass Gainer</span>
                                <h5 class="fw-semibold mb-2">Mass Gainer Ultra</h5>
                                <p class="text-muted small mb-2">Ganador de masa muscular con extra calorías</p>
                                <p class="text-success fw-bold mb-0">$ 54.999</p>
                            </div>
                            <div class="mt-auto">
                                <button class="btn btn-primary w-100 mb-2">Agregar al Carrito</button>
                                <a href="#" class="text-primary text-decoration-none small">Ver Detalles</a>
                            </div>
                        </div>
                    </div>

                    <!-- Caseína -->
                    <div class="col-md-6 col-lg-4">
                        <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                            <div class="card-img-wrapper mb-3">
                                <img src="<?= base_url('public/images/caseina.webp') ?>" alt="Caseína" class="product-img mx-auto">
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-primary mb-2">Caseína</span>
                                <h5 class="fw-semibold mb-2">Caseína Micelar</h5>
                                <p class="text-muted small mb-2">Proteína de liberación lenta para la noche</p>
                                <p class="text-success fw-bold mb-0">$ 44.999</p>
                            </div>
                            <div class="mt-auto">
                                <button class="btn btn-primary w-100 mb-2">Agregar al Carrito</button>
                                <a href="#" class="text-primary text-decoration-none small">Ver Detalles</a>
                            </div>
                        </div>
                    </div>

                    <!-- Whey Protein Concentrate -->
                    <div class="col-md-6 col-lg-4">
                        <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                            <div class="card-img-wrapper mb-3">
                                <img src="<?= base_url('public/images/micronizada.webp') ?>" alt="Whey Protein Concentrate" class="product-img mx-auto">
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-primary mb-2">Whey Protein</span>
                                <h5 class="fw-semibold mb-2">Whey Protein Concentrate</h5>
                                <p class="text-muted small mb-2">Proteína concentrada de suero</p>
                                <p class="text-success fw-bold mb-0">$ 39.999</p>
                            </div>
                            <div class="mt-auto">
                                <button class="btn btn-primary w-100 mb-2">Agregar al Carrito</button>
                                <a href="#" class="text-primary text-decoration-none small">Ver Detalles</a>
                            </div>
                        </div>
                    </div>

                    <!-- Proteína Vegana -->
                    <div class="col-md-6 col-lg-4">
                        <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                            <div class="card-img-wrapper mb-3">
                                <img src="<?= base_url('public/images/vegan.webp') ?>" alt="Proteína Vegana" class="product-img mx-auto">
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-primary mb-2">Proteína Vegana</span>
                                <h5 class="fw-semibold mb-2">Plant Protein Ultra</h5>
                                <p class="text-muted small mb-2">Blend de proteínas vegetales premium</p>
                                <p class="text-success fw-bold mb-0">$ 45.999</p>
                            </div>
                            <div class="mt-auto">
                                <button class="btn btn-primary w-100 mb-2">Agregar al Carrito</button>
                                <a href="#" class="text-primary text-decoration-none small">Ver Detalles</a>
                            </div>
                        </div>
                    </div>

                    <!-- Mass Gainer Ultra -->
                    <div class="col-md-6 col-lg-4">
                        <div class="p-4 bg-white rounded-4 shadow-sm hover-card text-center h-100 d-flex flex-column">
                            <div class="card-img-wrapper mb-3">
                                <img src="<?= base_url('public/images/mass_gainer.webp') ?>" alt="Mass Gainer Ultra" class="product-img mx-auto">
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-primary mb-2">Mass Gainer</span>
                                <h5 class="fw-semibold mb-2">Mass Gainer Extreme</h5>
                                <p class="text-muted small mb-2">Fórmula avanzada para ganancia de masa</p>
                                <p class="text-success fw-bold mb-0">$ 59.999</p>
                            </div>
                            <div class="mt-auto">
                                <button class="btn btn-primary w-100 mb-2">Agregar al Carrito</button>
                                <a href="#" class="text-primary text-decoration-none small">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paginación -->
                <div class="row mt-5">
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Beneficios Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">¿Por qué elegir nuestras <span class="text-danger">Proteínas</span>?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-shield-check fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Calidad Premium</h5>
                    <p class="text-muted">Productos certificados y de la más alta calidad del mercado</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-trophy fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Resultados Garantizados</h5>
                    <p class="text-muted">Fórmulas probadas científicamente para maximizar tus resultados</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-heart fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Sabor Inigualable</h5>
                    <p class="text-muted">Deliciosos sabores que harán que quieras más</p>
                </div>
            </div>
        </div>
    </div>
</section>
