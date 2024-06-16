<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/styles/navbarWeb.css">
    <link rel="stylesheet" href="public/styles/index.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'templates/navbarWeb.php'; ?>

    <div class="container mt-4 pt-5">
        <section id="bienvenido" class="mt-5 text-center">
            <div class="welcome-content">
                <h1 class="welcome-heading">Bienvenido a Mi Blog</h1>
                <p>Explora lo último en noticias, citas y más. Descubre, aprende y conecta.</p>
                <div class="icon-container">
                    <i class="fas fa-briefcase"></i>
                    <i class="fas fa-newspaper"></i>
                    <i class="fas fa-users"></i>
                </div>
                <blockquote class="blockquote">
                    <p class="mb-0">"El éxito es la suma de pequeños esfuerzos repetidos día tras día."</p>
                    <footer class="blockquote-footer">Robert Collier</footer>
                </blockquote>
                <a href="#about" class="btn btn-primary mt-3 cta-button">Conoce más sobre nosotros</a>
            </div>
        </section>

        

        <section id="noticias" class="mt-5">
            <h2 class="section-title">Últimas Noticias</h2>
            <div class="row">
                <?php                
                require_once 'app/config/config.php';
                require_once 'app/models/noticiaModel.php';

                $noticiasModel = new Noticia($pdo);
                $noticias = $noticiasModel->getAllNoticias();

                foreach ($noticias as $noticia):
                    $imagePath = "app/public/uploads" . htmlspecialchars($noticia['imagen']);
                    if (file_exists($imagePath)):
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= $imagePath ?>" class="card-img-top" alt="<?= htmlspecialchars($noticia['titulo']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($noticia['titulo']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($noticia['texto']) ?></p>
                                <a href="app/views/admin/noticias/show.php?id=<?= htmlspecialchars($noticia['idNoticia']) ?>" class="btn btn-primary">Leer más</a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($noticia['titulo']) ?></h5>
                                <p class="card-text">Imagen no disponible.</p>
                                <p class="card-text"><?= htmlspecialchars($noticia['texto']) ?></p>
                                <a href="noticias/show.php?id=<?= htmlspecialchars($noticia['idNoticia']) ?>" class="btn btn-primary">Leer más</a>
                            </div>
                        </div>
                    </div>
                <?php endif; endforeach; ?>
            </div>
        </section>

        <section id="about" class="mt-5">
            <h2 class="section-title">Sobre Nosotros</h2>
            <div class="row">
                <div class="col-md-6">
                    <p>Nuestra misión es proporcionar contenido de calidad que inspire, eduque y conecte a las personas. Nos dedicamos a ofrecer las últimas noticias, información útil y recursos valiosos para nuestros lectores.</p>
                    <p>Visión: Ser el blog de referencia donde los profesionales y entusiastas puedan encontrar contenido relevante y actualizado.</p>
                    <p>Valores: Compromiso con la calidad, integridad en la información, y pasión por la innovación.</p>
                    <p>Únete a más de 10,000 profesionales que mejoran sus habilidades con nosotros cada mes.</p>
                </div>
                <div class="col-md-6">
                    <div id="aboutCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="app/public/imagesWeb/img.jpg" class="d-block w-100" alt="Descripción de imagen 1">
                            </div>
                            <div class="carousel-item">
                                <img src="app/public/imagesWeb/img2.jpg" class="d-block w-100" alt="Descripción de imagen 2">
                            </div>
                            <div class="carousel-item">
                                <img src="app/public/imagesWeb/img3.jpg" class="d-block w-100" alt="Descripción de imagen 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>
            </div>
            <p>Para más información, visita nuestra <a href="about.php">página sobre nosotros</a>.</p>
        </section>
    <section id="testimonials" class="mt-5">
        <h2 id="titleTestimonials" class="section-title text-center">Testimonios</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial p-4">
                    <img src="app/public/imagesWeb/user1.jpg" class="rounded-circle mb-3" alt="Testimonio 1">
                    <p class="testimonial-text">"Este blog ha cambiado mi vida. Las noticias y recursos son de alta calidad y siempre están actualizados."</p>
                    <p class="testimonial-author">- María López</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial p-4">
                    <img src="app/public/imagesWeb/user2.jpg" class="rounded-circle mb-3" alt="Testimonio 2">
                    <p class="testimonial-text">"He aprendido tanto desde que comencé a seguir este blog. Las citas y noticias me mantienen informado y motivado."</p>
                    <p class="testimonial-author">- Juan Pérez</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial p-4">
                    <img src="app/public/imagesWeb/user3.jpg" class="rounded-circle mb-3" alt="Testimonio 3">
                    <p class="testimonial-text">"El mejor lugar para estar al día con las últimas noticias y obtener información valiosa. ¡Recomendado!"</p>
                    <p class="testimonial-author">- Carlos Gómez</p>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="mt-5">
        <h2 class="section-title">Contacto</h2>
        <div class="contact-form">
            <form action="submit_form.php" method="post" id="contactForm">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Asunto</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <span id="buttonText">Enviar</span>
                    <i id="planeIcon" class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </section>
    </div>
    <footer>
        <p>&copy; 2024 Mi Portafolio. Todos los derechos reservados.</p>
        <p><a href="privacy.php">Política de Privacidad</a> | <a href="terms.php">Términos de Servicio</a></p>
    </footer>

    <script src="public/js/navbarWeb.js"></script> 
    <script src="public/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
