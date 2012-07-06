(function(){
		var ul = $('.user_panel ul');
		var nav = $('div.user_panel');
		ul.hide();
		nav.on('mouseenter', function(){
			//$('.nav_main_background p').hide();
			ul.slideToggle(250);
			// ul.show();
			
		})
		nav.on('mouseleave', function(){
			ul.slideToggle(250);
			// ul.hide();
			//ul.removeClass('border');
			//$('.nav_main_background p').removeClass('hide');
		})

		$('span.subt').addClass('hide');

		var menu_divs = $('.nav_main_background div');

		menu_divs.on('mouseenter', function(){
			var check = $(this).attr('class');
			$('.' + check +' span.subt').show();

		})

		menu_divs.on('mouseleave', function(){
			var check = $(this).attr('class');
			$('.' + check +' span.subt').hide();

		})

		$('#add_field_point').on('click', function(){
		
			var kontener = $('div.add_point').last();
			var numer = parseInt(kontener.data('number'));
			numer++;
			// var add_html = "{assign var=count value="+ numer +"}";

			kontener.after("<div class = 'add_point' data-number='"+ numer + "'>"+ numer + 
											 
											  ". <input type='text' name='Nazwa"+ numer +"'" +
											  "id='nazwa_"+ numer +"' size='30'> "
											  + 

											  "<input type='text' name='Miasto"+ numer +"'" +
											  "id='miasto_"+ numer +"' value='Kraków' size='30'> "
											  + 
											  											 
											  "<input type='text' name='Ulica"+ numer +"'" +
											  "id=ulica_'"+ numer +"' size='30'> " 
											  +

											  "<input type='text' name='Numer"+ numer +"'" +
											  "id=numer_'"+ numer +"' size='10'> " 
											  +
											  
											  "<input type='checkbox' name='Edukacyjnosc" + numer + "'"+
											  "id=edukacyjnosc_'"+ numer 
											  +"'>Edukacyjność<br /><input type='hidden' name='points_count' value='"+numer+"'></div>");

			

		});
		
		$('#remove_field_point').on('click', function(){

			// $(this).parent().remove();
			console.log('Klikniete');

		});

		$('#add_field_picture').on('click', function(){

			var kontener = $('div.add_picture').last();
			var numer = parseInt(kontener.data('number'));
			numer++;
			console.log($(numer));

			kontener.after("<div class = 'add_picture' data-number='"+ numer + "'>" +
												numer+". <input name='img_"+numer+"' type='file'></div> ");

		});

		$('.show_details').hide();

		$('.points li img').on('click', function(){

			var details = $(this).siblings();
			
				details.slideToggle(250);
		
			
			console.log($(this).siblings());
		});

	})
	();
