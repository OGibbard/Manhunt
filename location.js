const successCallback = (position) => {
    console.log(position);
    console.log(position.coords);
    console.log(position.coords.latitude);
  };
  
  const errorCallback = (error) => {
    console.log(error);
  };
navigator.geolocation.getCurrentPosition(successCallback, errorCallback);