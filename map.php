<?php
session_start();
if (isset($_SESSION['name'])==false){
  header('Location: login.php');
};
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Manhunt map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="./gmaps.css" />
    <?php
    include_once("connection.php");
    array_map("htmlspecialchars", $_POST);
    $stmt = $conn->prepare("SELECT * FROM players WHERE Username!= :username");
    $stmt->bindParam(':username', $_SESSION['name']);
    $stmt->execute();
    $test = $stmt->fetchAll();
    $people = json_encode($test);
    ?>

    <script>
    const successCallback = (position) => {
        console.log(position);
    var username = '<?php echo $_SESSION['name'];?>';
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    var accuracy = position.coords.accuracy;
    var latest = position.timestamp;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open('GET','uploadlocation.php?latitude='+latitude+'&longitude='+longitude+'&accuracy='+accuracy+'&latest='+latest+'&username='+username, true);
    xmlhttp.send();
    console.log(position);

    var people = (<?php echo $people;?>);
    let map;
    function initMap() {
    // The map, centered at Thames and Kennet
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 6,
      center: {lat: 54.3760767, lng: -2.5588948},
      streetViewControl: false,
    });
    
    for (let j=0; j < people.length; j++) {
      const marker = new google.maps.Marker({
        position: {lat: parseFloat(people[j].Latitude), lng: parseFloat(people[j].Longitude)},
        label: people[j].Username,
        map: map,
      });
      };
    const marker = new google.maps.Marker({
        position: {lat: latitude, lng: longitude},
        label: 'Me',
        map: map,
    });
    }

    window.initMap = initMap;
    };
  
    const errorCallback = (error) => {
    console.log(error);
    };

    const options = {
        enableHighAccuracy: true,
    };

    navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);
    
    </script>


  </head>
  <body>
<!--The div element for the map -->
    <div id="map"></div>
    <script async
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzpVcQynoGYjwPIJi4gAoIPvFBXI30J6w&callback=initMap&v=weekly"
    ></script>
    <br><br>
    <h4>Last coordinates</h4>
    <?php
		include_once("connection.php");
		$stmt = $conn->prepare("SELECT * FROM players");
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $timestamp = $row['Latest'];
			echo ($row["Username"] . ': ' . $timestamp.'<br>');
		}
		?>
  </body>
</html>