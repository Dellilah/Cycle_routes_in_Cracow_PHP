(function(){
	li = $('ul.icons_choice li');
	var img;

	li.on('mouseenter', function(){

		img = $('img', this);
		img.attr('src', './fx/bitmapy/l_trud_peln.png');
		var prev_li = $(this).prevAll();
		prev_li.each(function() {
    		img = $('img', this);
    		img.attr('src', './fx/bitmapy/l_trud_peln.png');
		});
	});

	li.on('mouseleave', function(){

		if($(this).attr('class') != 'chosen'){
			img = $('img', this);
			img.attr('src', './fx/bitmapy/l_trud_pust.png');
			var prev_li = $(this).prevAll();
			prev_li.each(function() {
	    		img = $('img', this);
	    		img.attr('src', './fx/bitmapy/l_trud_pust.png');
			});
		}	
	});

	li.on('click', function(){

		if($(this).attr('class') != 'chosen'){

			img = $('img', this);
			var parent = $(this).parent().parent();
			var value = $(this).attr('name');
			input = $('input', parent);
			input.attr('value', value);
			img.attr('src', './fx/bitmapy/l_trud_peln.png');
			$(this).attr('class', 'chosen');

			var prev_li = $(this).prevAll();
			prev_li.each(function() {
				$(this).attr('class', 'chosen');
	    		img = $('img', this);
	    		img.attr('src', './fx/bitmapy/l_trud_peln.png');
			});
		}
		else{

			img = $('img', this);
			var parent = $(this).parent().parent();
			input = $('input', parent);
			input.attr('value', '');
			img.attr('src', './fx/bitmapy/l_trud_pust.png');
			$(this).attr('class', '');
			var prev_li = $(this).siblings();
			prev_li.each(function() {
				$(this).attr('class', '');
	    		img = $('img', this);
	    		img.attr('src', './fx/bitmapy/l_trud_pust.png');
			});

		}
	});



})
();