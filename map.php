<!DOCTYPE html>
<html>
  <head>
    <title>Manhunt map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="./gmaps.css" />
    <?php
    include_once("connection.php");
    array_map("htmlspecialchars", $_POST);
    $stmt = $conn->prepare("SELECT * FROM Players");
    $stmt->execute();
    $test = $stmt->fetchAll();
    $people = json_encode($test);
    ?>
    <script>
    var people = (<?php echo $people;?>);
    </script>
    <script type="module" src="./index.js"></script>
  </head>
  <body>
<!--The div element for the map -->
    <div id="map"></div>
    <script async
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzpVcQynoGYjwPIJi4gAoIPvFBXI30J6w&callback=initMap&v=weekly"
    ></script>
  </body>
</html>