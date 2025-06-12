<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Mapa de Trilhos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <link rel="stylesheet" href="style.css">


    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        <style>body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 2em;
        }

        .carousel {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 30px;
            scroll-behavior: smooth;
        }

        .slide {
            flex: 0 0 100%;
            scroll-snap-align: start;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #f9f9f9;
        }

        .map-title {
            text-align: center;
            padding: 0.5em;
            font-weight: bold;
            font-size: 18px;
            background: #eee;
        }

        .map-wrap {
            height: 400px;
            width: 100%;
        }

        .map-info {
            padding: 1em;
            background: #fff;
            border-top: 1px solid #ddd;
            font-size: 14px;
            text-align: center;
        }

        .map-info button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .map-info button:hover {
            background-color: #0056b3;
        }

        .gallery {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 1em 0;
        }

        .gallery img {
            width: 30%;
            border-radius: 8px;
            height: 120px;
            object-fit: cover;
            border: 1px solid #ccc;
        }

        .indicators {
            text-align: center;
            margin-bottom: 1em;
        }

        .indicators span {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin: 0 5px;
            background: #ccc;
            border-radius: 50%;
            cursor: pointer;
        }

        .indicators .active {
            background: #007bff;
        }

        #minimap {
            height: 200px;
            margin-top: 40px;
            border-radius: 10px;
            border: 2px solid #ccc;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 2em;
        }

        .carousel {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 30px;
        }

        .slide {
            flex: 0 0 100%;
            scroll-snap-align: start;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #f9f9f9;
        }

        .map-title {
            text-align: center;
            padding: 0.5em;
            font-weight: bold;
            font-size: 18px;
        }

        .map-wrap {
            height: 500px;
            width: 100%;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <a href="../paginas/pagina1.php"><img src="../imagens/rodapedaleira2.png" alt="Logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="../paginas/pagina1.php">🏠 </a></li>
                <li><a href="../paginas/ajuda.php">❓ </a></li>
                <?php if (isset($_SESSION['id_tipos_utilizador']) && $_SESSION['id_tipos_utilizador'] == 0): ?>
                    <li><a href="gestao_trilhos.php" class="admin-button">Gerir Trilhos</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>



    <br>
    <br>
    <div class="container">
        <h2>🗺️ Mapa de Trilhos</h2>
        <br>
        <div style="text-align:center; margin-bottom: 20px;">
            <label for="selector"><strong>Escolhe o trilho:</strong></label>
            <select id="selector" onchange="irParaTrilho()">
                <option value="0">Grand Canyon</option>
                <option value="1">Resmungão Serra de Brasfemes</option>
                <option value="2">Mata Nacional do Choupal</option>
            </select>
        </div>

        <div>
            <button class="botao-trilhos"
                onclick="window.open('http://localhost/PAP/trilhos_app_final/informacao.html', '_blank')">
                 Conhece mais sobre os nossos trilhos 🌍
            </button>
        </div>

        <br>
        <div class="carousel">
            <div class="slide">
                <div class="map-title">Trilho: Grand Canyon</div>
                <div id="map1" class="map-wrap"></div>
                <div class="map-info">
                    <strong>Distância:</strong> 2.0 km<br>
                    <strong>Duração média de bicicleta:</strong> 8 minutos<br>
                    <strong> Coordenadas: </strong> 40°16'28"N 8°24'56"W<br>
                    <strong>Não sabes ir até ao trilho?</strong><br>
                    <button onclick="window.open('https://maps.app.goo.gl/x8nSjN44zkw9hxKn7', '_blank')"> Clica
                        aqui 📍</button>
                </div>
            </div>






            <div class="slide">
                <div class="map-title">Trilho: Resmungão Serra de Brasfemes</div>
                <div id="map2" class="map-wrap"></div>
                <div class="map-info">
                    <strong>Distância:</strong> 3.0 km<br>
                    <strong>Duração média de bicicleta:</strong> 12 minutos<br>
                    <strong> Coordenadas: </strong> 40°16'39"N 8°24'32"W<br>
                    <strong>Não sabes ir até ao trilho?</strong><br>
                    <button onclick="window.open('https://maps.app.goo.gl/bCdSuVZCWfj9AF576', '_blank')">📍 Clica
                        aqui</button>
                </div>
            </div>


            <div class="slide">
                <div class="map-title">Trilho: Mata Nacional do Choupal</div>
                <div id="map3" class="map-wrap"></div>
                <div class="map-info">
                    <strong>Distância:</strong> 5.4 km<br>
                    <strong>Duração média de bicicleta:</strong> 22 minutos<br>
                    <strong> Coordenadas: </strong> 40°13'22"N 8°26'44"W<br>
                    <strong>Não sabes ir até ao trilho?</strong><br>
                    <button onclick="window.open('https://maps.app.goo.gl/umy4ZfkwLWM5Yq2e7', '_blank')">📍 Clica
                        aqui</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Rodapedaleira. Todos os direitos reservados.</p>
    </footer>


    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const mapas = [
            { id: "map1", file: "geojson/grand_canyon.geojson" },
            { id: "map2", file: "geojson/resmungao.geojson" },
            { id: "map3", file: "geojson/choupal.geojson" }
        ];

        mapas.forEach(m => {
            const map = L.map(m.id).setView([40.2056, -8.4196], 13);
            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: '© Esri & contributors'
            }).addTo(map);


            fetch(m.file)
                .then(res => res.json())
                .then(data => {
                    const layer = L.geoJSON(data, {
                        style: {
                            color: "blue",
                            weight: 5,
                            opacity: 0.8
                        }
                    }).addTo(map);
                    map.fitBounds(layer.getBounds());
                });
        });

        function irParaTrilho() {
            const index = document.getElementById("selector").value;
            const carousel = document.querySelector(".carousel");
            const slide = document.querySelectorAll(".slide")[index];
            carousel.scrollTo({
                left: slide.offsetLeft,
                behavior: "smooth"
            });
        }

    </script>

</body>

</html>