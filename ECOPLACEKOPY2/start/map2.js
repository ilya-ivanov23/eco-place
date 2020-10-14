function initMap() {
    let centerLat = 53.9;
    let centerLng = 27.6;
    let points = [
        {lat: 53.9638238, lng: 27.5446672},
        {lat: 53.8, lng: 27.5},
        {lat: 53.9, lng: 27.7},
        {lat: 53.78, lng: 27.5},
        
        
    
    
  
    ];

 
    const image = '../imgs/гео.png';
    popupContent = '<p class="content">ул. козловская 67</p>';
    
    const map = new google.maps.Map(document.getElementById('map2'), {
      center: {lat: centerLat, lng: centerLng},
      zoom: 12,
      styles: [
        {
          "featureType": "poi",
          "elementType": "labels.text",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "poi.business",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "road",
          "elementType": "labels.icon",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "transit",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        }
      ],
      disableDefaultUI: true
    });
    
    

    points.forEach(point => {
      const beachMarker = new google.maps.Marker({
          position:{lat: point.lat, lng: point.lng,},
          map: map,
          icon: image
      });
      beachMarker.addListener('click', function() {
        
        // let infowindow = new google.maps.InfoWindow({
        //   content:  fillPopup(place)
        // });
        // infowindow.open(map, this);
        showPlaceDetails(this);
      });
    });
      
  }

  function showPlaceDetails(placeMarker){
      console.log(this);
      //откуда это брать - в душе непредставляю
      let place = {address: 'ул. Козлова 35', name: 'Пункт раздельного приема отходов №34'};
      let container = document.getElementById('place-desciption-container');
      fillPopup(container, place);
      container.classList.remove('hidden');
  }
  
  function fillPopup(container, place){
    container.querySelector('.place-address').textContent = place.address;
    container.querySelector('.place-name').textContent = place.name;
  }

  document.querySelector('#place-desciption-container .close-description-button').addEventListener('click', () => {
    document.getElementById('place-desciption-container').classList.add('hidden');
  });

  initMap();