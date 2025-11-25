<?php include("includes/navbar.php"); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Visita Quibdó</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

    <style>
        /* Banner grande */
        .hero {
            background-image: url("https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1500&q=80");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 15px;
            padding: 120px 40px;
            margin-top: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.25);
            position: relative;
            overflow: hidden;
        }

        /* Filtro suave elegante */
        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.25);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 700px;
            color: white;
        }

        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
        }

        .hero-text {
            font-size: 1.15rem;
            line-height: 1.6;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- Banner principal -->
    <div class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Bienvenido a Visita Quibdó</h1>
            <p class="hero-text">
                Descubre los mejores lugares turísticos, apoya los emprendimientos locales
                y explora lo más hermoso de nuestro municipio.
            </p>
        </div>
    </div>

    <!-- SECCIÓN INFORMATIVA (la que pediste) -->
    <div class="row text-center mb-5 mt-5">

        <div class="col-md-4 mb-4">
            <h4 class="text-primary fw-bold">🌿 Lugares Turísticos</h4>
            <p>Explora cascadas, ríos, cultura afro, selva y naturaleza única en Quibdó.</p>
        </div>

        <div class="col-md-4 mb-4">
            <h4 class="text-primary fw-bold">🛍️ Emprendimientos Locales</h4>
            <p>Apoya negocios locales en gastronomía, artesanías, tecnología y más.</p>
        </div>

        <div class="col-md-4 mb-4">
            <h4 class="text-primary fw-bold">📞 Conexión Fácil</h4>
            <p>Contacta directamente a los emprendedores vía WhatsApp.</p>
        </div>

    </div>

</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
