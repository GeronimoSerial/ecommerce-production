<!-- Hero Section -->
<div class="bg-dark text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-3">Términos y <span class="text-danger">Condiciones</span></h1>
                <p class="lead">Información legal y políticas de uso de <b>FitSyn</b></p>
            </div>
            <div class="col-lg-6">
                <img src="<?= base_url('images/workoutIconabout.webp') ?>" alt="FitSyn Logo" class="img-fluid"
                    style="max-height: 300px;">
            </div>
        </div>
    </div>
</div>


<!-- Términos y Condiciones -->
<div class="container-fluid py-5 bg-hero">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Navegación de pestañas -->
                <ul class="nav nav-tabs mb-4" id="termsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-black" id="general-tab" data-bs-toggle="tab"
                            data-bs-target="#general" type="button" role="tab" aria-selected="true">General</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-black" id="privacy-tab" data-bs-toggle="tab"
                            data-bs-target="#privacy" type="button" role="tab" aria-selected="false">Privacidad</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-black" id="sales-tab" data-bs-toggle="tab" data-bs-target="#sales"
                            type="button" role="tab" aria-selected="false">Ventas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-black" id="warranty-tab" data-bs-toggle="tab"
                            data-bs-target="#warranty" type="button" role="tab" aria-selected="false">Garantías</button>
                    </li>
                </ul>

                <!-- Contenido de las pestañas -->
                <div class="tab-content" id="termsTabContent">
                    <!-- Términos Generales -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="card-title fw-bold mb-4">Términos Generales</h2>

                                <h4 class="fs-5 fw-bold mb-3">1. Aceptación de los Términos</h4>
                                <p class="text-muted mb-4">Al acceder y utilizar este sitio web, usted acepta estos
                                    términos y condiciones en su totalidad. Si no está de acuerdo con estos términos y
                                    condiciones o alguna parte de estos, no debe utilizar este sitio web.</p>

                                <h4 class="fs-5 fw-bold mb-3">2. Uso del Sitio</h4>
                                <p class="text-muted mb-4">Este sitio web está destinado únicamente a personas mayores
                                    de 18 años. Al utilizar este sitio web, usted garantiza que tiene al menos 18 años
                                    de edad.</p>

                                <h4 class="fs-5 fw-bold mb-3">3. Propiedad Intelectual</h4>
                                <p class="text-muted mb-4">Todo el contenido de este sitio web, incluyendo textos,
                                    gráficos, logos, imágenes y software, está protegido por derechos de autor y es
                                    propiedad de FitSyn o de sus proveedores de contenido.</p>

                                <h4 class="fs-5 fw-bold mb-3">4. Modificaciones</h4>
                                <p class="text-muted">Nos reservamos el derecho de modificar estos términos y
                                    condiciones en cualquier momento. Los cambios entrarán en vigor inmediatamente
                                    después de su publicación en el sitio web.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Política de Privacidad -->
                    <div class="tab-pane fade" id="privacy" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="card-title fw-bold mb-4">Política de Privacidad</h2>

                                <h4 class="fs-5 fw-bold mb-3">1. Recopilación de Información</h4>
                                <p class="text-muted mb-4">Recopilamos información personal cuando usted:</p>
                                <ul class="text-muted mb-4">
                                    <li>Se registra en nuestro sitio</li>
                                    <li>Realiza una compra</li>
                                    <li>Se suscribe a nuestro boletín</li>
                                    <li>Contacta con nuestro servicio al cliente</li>
                                </ul>

                                <h4 class="fs-5 fw-bold mb-3">2. Uso de la Información</h4>
                                <p class="text-muted mb-4">La información recopilada se utiliza para:</p>
                                <ul class="text-muted mb-4">
                                    <li>Procesar sus pedidos</li>
                                    <li>Mejorar nuestros servicios</li>
                                    <li>Comunicarnos con usted sobre su cuenta</li>
                                    <li>Enviar información promocional (si lo ha autorizado)</li>
                                </ul>

                                <h4 class="fs-5 fw-bold mb-3">3. Protección de Datos</h4>
                                <p class="text-muted">Implementamos medidas de seguridad para proteger su información
                                    personal contra acceso, modificación, divulgación o destrucción no autorizada.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Términos de Venta -->
                    <div class="tab-pane fade" id="sales" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="card-title fw-bold mb-4">Términos de Venta</h2>

                                <h4 class="fs-5 fw-bold mb-3">1. Proceso de Compra</h4>
                                <p class="text-muted mb-4">Al realizar una compra en nuestro sitio web, usted confirma
                                    que:</p>
                                <ul class="text-muted mb-4">
                                    <li>Los productos serán utilizados de acuerdo con las instrucciones del fabricante
                                    </li>
                                    <li>La información proporcionada durante la compra es precisa y completa</li>
                                    <li>Tiene la capacidad legal para realizar la compra</li>
                                </ul>

                                <h4 class="fs-5 fw-bold mb-3">2. Precios y Pagos</h4>
                                <p class="text-muted mb-4">
                                    Todos los precios están en pesos argentinos e incluyen IVA. Nos reservamos el
                                    derecho de modificar los precios en cualquier momento.
                                    Los pagos se procesan de forma segura a través de nuestros proveedores de servicios
                                    de pago autorizados.
                                </p>

                                <h4 class="fs-5 fw-bold mb-3">3. Envíos y Entregas</h4>
                                <p class="text-muted mb-4">
                                    Los tiempos de entrega son estimados y pueden variar según la ubicación y el método
                                    de envío seleccionado.
                                    No nos hacemos responsables por retrasos causados por eventos fuera de nuestro
                                    control.
                                </p>

                                <h4 class="fs-5 fw-bold mb-3">4. Cancelaciones</h4>
                                <p class="text-muted">Las cancelaciones son posibles dentro de las 24 horas posteriores
                                    a la realización del pedido, siempre que el producto no haya sido enviado.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Garantías y Soporte -->
                    <div class="tab-pane fade" id="warranty" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="card-title fw-bold mb-4">Garantías y Soporte Post-venta</h2>

                                <h4 class="fs-5 fw-bold mb-3">1. Garantía de Productos</h4>
                                <p class="text-muted mb-4">
                                    Todos nuestros productos cuentan con garantía del fabricante.
                                    Los suplementos tienen garantía de calidad y autenticidad.
                                    Si el producto presenta algún defecto de fabricación, será reemplazado sin costo
                                    adicional.
                                </p>

                                <h4 class="fs-5 fw-bold mb-3">2. Política de Devoluciones</h4>
                                <ul class="text-muted mb-4">
                                    <li>30 días para devoluciones</li>
                                    <li>El producto debe estar sin abrir y en su empaque original</li>
                                    <li>Debe presentar el comprobante de compra</li>
                                    <li>Los costos de envío de devolución corren por cuenta del cliente</li>
                                </ul>

                                <h4 class="fs-5 fw-bold mb-3">3. Soporte Post-venta</h4>
                                <p class="text-muted mb-4">Ofrecemos:</p>
                                <ul class="text-muted mb-4">
                                    <li>Asesoramiento sobre el uso de productos</li>
                                    <li>Seguimiento de pedidos</li>
                                    <li>Resolución de problemas</li>
                                    <li>Atención al cliente personalizada</li>
                                </ul>

                                <h4 class="fs-5 fw-bold mb-3">4. Contacto</h4>
                                <p class="text-muted">Para cualquier consulta sobre garantías o soporte post-venta,
                                    puede contactarnos a través de:</p>
                                <ul class="text-muted mb-0">
                                    <li>Email: soporte@fitsyn.com</li>
                                    <li>Teléfono: +54 123 456 789</li>
                                    <li>WhatsApp: +54 123 456 789</li>
                                    <li>Horario de atención: Lunes a Viernes de 9:00 a 18:00 hs</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Última actualización -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <p class="text-muted small">Última actualización: Abril 2025</p>
            </div>
        </div>
    </div>
</div>