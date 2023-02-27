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
    var username = '<?php echo $_SESSION['name'];?>';
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    var accuracy = position.coords.accuracy;
    var latest = position.timestamp;

    var a = new Date(latest);
    var year = a.getFullYear();
    var month = a.getMonth();
    var date = a.getDate();
    var hour = a.getHours();
    var min = a.getMinutes();
    var sec = a.getSeconds();
    var fulldate = date + '/' + month + '/' + year
    var time = hour + ':' + min + ':' + sec

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open('GET','uploadlocation.php?latitude='+latitude+'&longitude='+longitude+'&accuracy='+accuracy+'&latest='+latest+'&username='+username, true);
    xmlhttp.send();

    var people = (<?php echo $people;?>);
    let map;
    function initMap() {
    // The map, centered at Thames and Kennet
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 13,
      center: {lat: 52.481149, lng: -0.485304},
      streetViewControl: false,
    });
    
    for (let j=0; j < people.length; j++) {
      const infowindow = new google.maps.InfoWindow({
        content: ('<a>Date: '+fulldate+'</a><br><a>Time: '+time+'</a><br><a>Accuracy: '+accuracy+'</a>'),
      });
      const marker = new google.maps.Marker({
        position: {lat: parseFloat(people[j].Latitude), lng: parseFloat(people[j].Longitude)},
        label: people[j].Username,
        map: map,
      });
      marker.addListener("click", () => {
        infowindow.open({
          anchor: marker,
          map,
          shouldFocus: false,
        });
      });
      };
    const infowindow = new google.maps.InfoWindow({
      content: ('<a>Date: '+fulldate+'</a><br><a>Time: '+time+'</a><br><a>Accuracy: '+accuracy+'</a>'),
    });
    const marker = new google.maps.Marker({
        position: {lat: latitude, lng: longitude},
        label: 'Me',
        map: map,
    });
    marker.addListener("click", () => {
        infowindow.open({
          anchor: marker,
          map,
          shouldFocus: false,
        });
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
    <?php
		#include_once("connection.php");
		#$stmt = $conn->prepare("SELECT * FROM players");
		#$stmt->execute();
		#while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    #        $timestamp = date('Y-m-d h:i:s',($row['Latest']-3600000)/1000);
		#	echo ($row["Username"] . ': ' . $timestamp.'    Accuracy: '.$row['Accuracy'].'<br>');
		#}
		?>
  </body>
</html>