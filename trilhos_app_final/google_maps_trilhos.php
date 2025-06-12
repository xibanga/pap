<?php
require '../ligabd.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Trilhos</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
</head>
<body>
    <div class="container">
        <h1>🏞️ Google Maps para Trilhos</h1>
        
        <div class="search-container">
            <input id="searchBox" type="text" placeholder="Pesquise um trilho">
            <button onclick="searchLocation()">🔍 Pesquisar</button>
        </div>
        
        <div id="map" style="width: 100%; height: 600px;"></div>
    </div>

    <script>
        let map;
        let directionsService;
        let directionsRenderer;
        let userMarker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 40.2056, lng: -8.4196 },
                zoom: 12
            });
            
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);
        }
        
        function searchLocation() {
            let input = document.getElementById("searchBox").value;
            let geocoder = new google.maps.Geocoder();
            
            geocoder.geocode({ address: input }, function (results, status) {
                if (status === "OK") {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(15);
                    
                    if (userMarker) userMarker.setMap(null);
                    userMarker = new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map,
                        title: input
                    });
                } else {
                    alert("Local não encontrado: " + status);
                }
            });
        }
        
        function getDirections(lat, lng) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    let userLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    let destination = new google.maps.LatLng(lat, lng);

                    let request = {
                        origin: userLocation,
                        destination: destination,
                        travelMode: google.maps.TravelMode.WALKING
                    };
                    
                    directionsService.route(request, function (result, status) {
                        if (status === google.maps.DirectionsStatus.OK) {
                            directionsRenderer.setDirections(result);
                        } else {
                            alert("Erro ao obter direções: " + status);
                        }
                    });
                }, () => alert("Erro ao obter localização."));
            } else {
                alert("Geolocalização não suportada.");
            }
        }
    </script>
    <script>window.onload = initMap;</script>
</body>
</html>
