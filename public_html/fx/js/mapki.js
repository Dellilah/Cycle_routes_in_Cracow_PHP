(function(){
	
	var city, street, number;
	var mapa, mapa2;
	var geokoder;

	function dodajMarker(lat,lon,opcjeMarkera, choose_map)
    {
        // tworzymy marker z współrzędnymi i opcjami z argumentów funkcji dodajMarker
       opcjeMarkera.position = new google.maps.LatLng(lat,lon);
                 
        opcjeMarkera.map = choose_map; // obiekt mapa jest obiektem globalnym!
       var marker = new google.maps.Marker(opcjeMarkera);

    }           


	var opcjeMapy = 
   	{
        center: new google.maps.LatLng(50.0613, 19.9368),
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    if(	$("#mapka").length != 0){
		mapa = new google.maps.Map(document.getElementById("mapka"), opcjeMapy); 
		// var inf = $('div.point_inf');

		// city = $('div.city').attr('title');
		// street = $('div.street').attr('title');
		// number = $('div.number').attr('title');

		// console.log(street);

		// geokoder = new google.maps.Geocoder();
		// geokoder.geocode({address: city+', '+street+' '+number},obslugaGeokodowania);
	}
 
	function obslugaGeokodowania(wyniki, status)
	{
	    if(status == google.maps.GeocoderStatus.OK)
	    {
	      dodajMarker(wyniki[0].geometry.location.lat(),wyniki[0].geometry.location.lng(),{title: street+' '+number}, mapa); 
	      mapa.setCenter(wyniki[0].geometry.location);
	    }
	}

	var directionsDisplay;
	var directionsService = new google.maps.DirectionsService();
	directionsDisplay = new google.maps.DirectionsRenderer();
	
	var lat_start = $("div.start_lat").attr('title');
	var lng_start = $('div.start_lng').attr('title');
	var latlng_start = new google.maps.LatLng(lat_start, lng_start);
	var lat_stop = $("div.stop_lat").attr('title');
	var lng_stop = $('div.stop_lng').attr('title');
	var latlng_stop = new google.maps.LatLng(lat_stop, lng_stop);
	var points = [];
	var flaga = 0;
	 	 
	//dodawanie "zbiorowe" markerów
	$("div.map_data").each(function(){

		 directionsDisplay.setMap(mapa);

		 // points.push({
   //        location:point1,
   //        stopover:true
   //   	 });

   //   	 points.push({
   //        location:point12,
   //        stopover:true
   //   	 });

   //   	 point12 = new google.maps.LatLng(50.0592095782413, 19.924086329269358);
   //   	 points.push({
   //        location:point12,
   //        stopover:true
   //   	 });
     	 
   //   	 point12 = new google.maps.LatLng(50.0584725709278, 19.91832494430537);
   //   	 points.push({
   //        location:point12,
   //        stopover:true
   //   	 });

   //   	 point12 = new google.maps.LatLng(50.0569847459665, 19.9075424640655);
   //   	 points.push({
   //        location:point12,
   //        stopover:true
   //   	 });

		lat = $('div.lat', this).attr('title');
		lng = $('div.lng', this).attr('title');
		var latlng = new google.maps.LatLng(lat, lng);
		if(flaga == 0){
			flaga = 1;
		}
		else{if( points.length<8){
			points.push({
	          location:latlng,
	          stopover:false
	     	 });
			flaga = 0;
			}
		}
		mapa.setZoom(13);
	    marker = new google.maps.Marker({
	        position: latlng,
	        map: mapa
	    });

	     var request = {
  			   origin:latlng_start,
 			   destination:latlng_stop,
 			   waypoints: points,
 			   travelMode: google.maps.TravelMode.WALKING
 		 };
 		 console.log(request);
  		directionsService.route(request, function(result, status) {
  		   console.log('Ala');
   		 if (status == google.maps.DirectionsStatus.OK) {
   		 	console.log('wchodzi');
    		  directionsDisplay.setDirections(result);


   		 }
		});

	    
	});

	console.log(points);



	//STRONA WSZYSTKICH
	var map_array = new Object();
	$("div.google_map").each(function(){
		
		var id= $(this).attr('name');

		map_array[id] = new google.maps.Map(this, opcjeMapy);

	});

	
	$("div.google_map").each(function(){
		
		var id= $(this).attr('name');

		$("div.map_data_"+id).each(function(){
			
			//console.log($('div.street', this).attr('title'));

			lat = $('div.lat', this).attr('title');
			lng = $('div.lng', this).attr('title');
			var latlng = new google.maps.LatLng(lat, lng);

			/*geokoder = new google.maps.Geocoder();
			geokoder.geocode({address: city+', '+street+' '+number}, function(wyniki, status){
				
				if(status == google.maps.GeocoderStatus.OK)
		  		  {
		   			   dodajMarker(wyniki[0].geometry.location.lat(),wyniki[0].geometry.location.lng(),{title: street+' '+number}, map_array[id]); 
		  			   map_array[id].setCenter(wyniki[0].geometry.location);
		  		  }
			});*/
			map_array[id].setZoom(13);
	          marker = new google.maps.Marker({
	              position: latlng,
	              map: map_array[id]
	          });

		});
	});

	var map_adding = new google.maps.Map(document.getElementById("mapa_add"), opcjeMapy);
		// map_add.addControl(new GLargeMapControl());
		// map_add.addControl(new GMapTypeControl(3));
		// map_add.setCenter( new GLatLng(26.12295, -80.17122), 11,0);

	// google.maps.event.addListener(map_add,'mousemove',function(point)
	// {
	// 	document.getElementById('latspan').innerHTML = point.lat()
	// 	document.getElementById('lngspan').innerHTML = point.lng()	
	// 	document.getElementById('latlong').innerHTML = point.lat() + ', ' + point.lng() 
	// });

	google.maps.event.addListener(map_adding,'click',function(event)
	{

		var kontener = $('div.add_point').last();
		var numer = parseInt(kontener.data('number'));
		numer++;

		var myLatLng = event.latLng;
	    var lat = myLatLng.lat();
	    var lng = myLatLng.lng();
	    var address_code;

 		var geocoder = new google.maps.Geocoder();
	    var latlng = new google.maps.LatLng(lat, lng);
	    geocoder.geocode({'latLng': latlng}, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
	        if (results[0]) {
	          map_adding.setZoom(13);
	          marker = new google.maps.Marker({
	              position: latlng,
	              map: map_adding
	          });
	          address_code = results[0].formatted_address;
	          //console.log(address_code);
	          // infowindow.open(map_adding, marker);
	        }
	      } 
	      else {
	        alert("Geocoder failed due to: " + status);
	      } 
	      console.log(address_code);
	      kontener.after("<div class = 'add_point' data-number='"+ numer + "'>"+ numer + 
											 
											  ". "+ address_code +
											  " <input type='hidden' name='Dlugosc"+ numer +"'" +
											  "id='dlugosc_"+ numer +"' value='"+lat+"'> "
											  + 

											  " <input type='hidden' name='Szerokosc"+ numer +"'" +
											  "id='szerokosc_"+ numer +"' value='"+lng+"'> "
											  + 
											  " <input type='hidden' name='Adres"+ numer +"'" +
											  "id='adres_"+ numer +"' value='"+address_code+"'> "
											  + 
											  "<input type='checkbox' name='Edukacyjnosc" + numer + "'"+
											  "id=edukacyjnosc_'"+ numer 
											  +"'>Edukacyjność<br /><input type='hidden' name='points_count' value='"+numer+"'></div>");

	
	     });
	     //console.log(address_code);

		
	});

})
();
