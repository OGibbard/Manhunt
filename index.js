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
        map: map,
      });
      };
}

window.initMap = initMap;
