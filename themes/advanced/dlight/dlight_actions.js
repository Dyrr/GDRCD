dlight.a = (function () {
	//METODI E ATTRIBUTI PRIVATI
	var dialogTheme = dlight.getCN().dialogTheme;
	
	var getUrl = function(url,target,options)
	{

		var options = options == undefined ? {} : options;		


		$.get(url, function(data)
		{
			
			

			console.log(options.delay);
			//se non è impostato nessun tempo di attesa
			if(options.delay == 'none') {
				
				//inserisce subito il contenuto della nuova pagina nel div, mantenendo la posizione della scrollbar
				$(target).html(data);	
			
			//se è impostato un tempo di attesa
			} else {
			
				$(target).html('');
				//inserisce un microritardo prima di inserire nel div il contenuto della pagina nuova per permettere 
				//il reset della scrollbar
				setTimeout(function(){
					$(target).html(data);				
				}, 50);
				
			}
				



		});

	
	
	}
	
	function dialog(e,options)
	{
		
			// verifichiamo se nel body non esiste il sorgente per la dialog
			if ($('#dialog-'+ options.name).length == 0) {
			
				// in questo caso lo creiamo:
				$('body').append('\
					<div id="dialog-'+ options.name +'" title="'+ options.title +'" style="padding:0;"><div class="ajax"></div></div>\
				');
				
				$('body').append('\
					<div id="dialog-'+ options.name +'-icon" title="'+ options.title +'" data-tooltip="true" class="dialog_icon">\
					<i class="' + options.icon + '"></i>\
					</div>\
				');
				$('#dialog-' + options.name + '-icon').draggable({containment: "parent"});  
				$('#dialog-' + options.name + '-icon').position({
				  my: "left top",
				  at: "left top",
				  of: ".output"
				});				
				$('#dialog-' + options.name + '-icon').hide();
				$('#dialog-' + options.name + '-icon').click(function() {
					$('#dialog-'+ options.name).parent().show();
					$('#dialog-'+ options.name).dialogExtend("restore");	
					$('#dialog-' + options.name + '-icon').hide();
					
				});
			}
			$('#dialog-' + options.name + ' .ajax').html('');
			// Ok, adesso siamo pronti per lanciare la modale!
				setTimeout(function(){
					$('#dialog-' + options.name + ' .ajax').load(options.url);				
				}, 50);			

			
			
			$('#dialog-'+ options.name).dialog({
				width: options.width,
				height: options.height,
				dialogClass: options.css_class,
				close: function(e, ui){
					$(this).dialog('destroy').remove();
				}
			}).dialogExtend({
				collapsable:true,
				 "collapse" : function(e) {

					 $('#dialog-'+ options.name).parent().hide();
					 $('#dialog-' + options.name + '-icon').show();
					}
			});
			$('#dialog-'+ options.name).parent().show();
			$('#dialog-'+ options.name).dialogExtend("restore");
			$('#dialog-' + options.name + '-icon').hide();		
	
	}
	
	function query(url)
	{
		var queryString1 = {};
		url.replace(
			new RegExp("([^?=&]+)(=([^&]*))?", "g"),
			function($0, $1, $2, $3) { queryString1[$1] = $3; }
		);	
		return queryString1;
		
	}	
	
	//METODI E ATTRIBUTI PUBBLICI
	return {	
	
		media_control : function (event)
		{

			event.preventDefault();
			var frame = "player_" + $(this).data('target');
			
			var media_state = $(this).data('media_state');

			if(media_state == 'pauseVideo') {
				
				if( $('audio#' + frame).length)
				{
					
					document.getElementById(frame).pause();
					
				} else {
				
					document.getElementById(frame).contentWindow.postMessage('{"event":"command","func": "pauseVideo","args":""}', '*');
					
				}

				var new_state = 'playVideo';				
				$('#player_control_' + $(this).data('target')).removeClass('fa-pause');
				$('#player_control_' + $(this).data('target')).addClass('fa-play');				
				
				
			} else {
				
				if( $('audio#' + frame).length)
				{
					
					document.getElementById(frame).play();
					
				} else {				
				
					document.getElementById(frame).contentWindow.postMessage('{"event":"command","func": "playVideo","args":""}', '*');
					
				}
				
				var new_state = 'pauseVideo';				
				$('#player_control_' + $(this).data('target')).addClass('fa-pause');
				$('#player_control_' + $(this).data('target')).removeClass('fa-play');			
			
			}
			
			$(this).data('media_state',new_state);
		
		},
		
		ajax_link : function (event)
		{

			event.preventDefault();

			var options = {};
			var target = $(this).attr('data-target');
			var url = $(this).attr('href');	
			options.delay = $(this).data('delay') == undefined ? 'yes' : 'none';

			if(target === undefined) {
				
				target = $(this).closest(".ajax");
			
			}
			
			
			getUrl(url,target,options);
			

		
		},

		main : function (event)
		{

			event.preventDefault();

			var target = '.output';
			var url = $(this).attr('href');	
				
			getUrl(url,target);
			
		},		
		
		scheda : function(event) {
			event.preventDefault();				
			
			var options = {};
			
			options.width = 864;
			options.height = 615;
			options.name = 'scheda';
			options.title = 'Scheda';
			options.css_class = 'wscheda';			
			options.url = $(this).attr('href');			
			options.icon = 'far fa-user';

			dialog(event,options);
		},
		
		msg : function(event) {
			event.preventDefault();				
			
			var options = {};
			
			options.width = 400;
			options.height = 700;
			options.name = 'msg';
			options.title = 'Messaggi';
			options.css_class = 'smartphone';			
			options.url = $(this).attr('href');			
			options.icon = 'fas fa-mobile-alt';

			dialog(event,options);
		},		
		

		dialog : function(event) {
			event.preventDefault();				
			
			var width = $(this).data('width') == undefined ? 800 : $(this).data('width');
			var height = $(this).data('height') == undefined ? 700 : $(this).data('height');
			var name = $(this).data('name');
			var title = $(this).data('title');
			var css_class = $(this).data('class') == undefined ? 'default' : $(this).data('class');			
			var url = $(this).attr('href');			
			var icon = $(this).data('icon') == undefined ? 'far fa-window-maximize' : $(this).data('icon');

			// verifichiamo se nel body non esiste il sorgente per la dialog
			if ($('#dialog-'+name).length == 0) {
			
				// in questo caso lo creiamo:
				$('body').append('\
					<div id="dialog-'+name+'" title="'+title+'" style="padding:0;"><div class="ajax"></div></div>\
				');
				
				$('body').append('\
					<div id="dialog-'+name+'-icon" title="'+title+'" data-tooltip="true" class="dialog_icon">\
					<i class="' + icon + '"></i>\
					</div>\
				');
				$('#dialog-' + name + '-icon').draggable({containment: "parent"});  
				$('#dialog-' + name + '-icon').position({
				  my: "left top",
				  at: "left top",
				  of: ".output"
				});				
				$('#dialog-' + name + '-icon').hide();
				$('#dialog-' + name + '-icon').click(function() {
					$('#dialog-'+name).parent().show();
					$('#dialog-'+name).dialogExtend("restore");	
					$('#dialog-' + name + '-icon').hide();
					
				});
			}
			$('#dialog-' + name + ' .ajax').html('');
			// Ok, adesso siamo pronti per lanciare la modale!
				setTimeout(function(){
					$('#dialog-' + name + ' .ajax').load(url);				
				}, 50);			
			
			
			
			$('#dialog-'+name).dialog({
				width: width,
				height: height,
				dialogClass: css_class,
				close: function(event, ui){
					$(this).dialog('destroy').remove();
				}
			}).dialogExtend({
				collapsable:true,
				 "collapse" : function(evt) {

					 $('#dialog-'+name).parent().hide();
					 $('#dialog-' + name + '-icon').show();
					}
			});
			$('#dialog-'+name).parent().show();
			$('#dialog-'+name).dialogExtend("restore");
			$('#dialog-' + name + '-icon').hide();
		},
		
		
		none : function (event)
		{			
		
			event.preventDefault();
		
		},
		
		show_all : function(event)
		{
			
			event.preventDefault();		
			$(this).closest('.indice').find('li>ul').show();
			$(this).closest('.indice').find('li>ol').show();
			$(this).closest('.indice').find('.fa-plus').addClass('fa-minus').removeClass('fa-plus');
		
		},
		
		hide_all : function(event)
		{
			
			event.preventDefault();		
			$(this).closest('.indice').find('li>ul').hide();
			$(this).closest('.indice').find('li>ol').hide();
			$(this).closest('.indice').find('.fa-minus').addClass('fa-plus').removeClass('fa-minus');
		
		},		
		
		internal_window : function (event)
		{			
		
			event.preventDefault();				
			var target = $(this).attr('href');
			$('.internal_window').hide();
			$('#' + target).show();
		
		},
		
		internal_close : function (event)
		{			
		
			event.preventDefault();				
			var target = $(this).attr('href');			
			$(this).closest('.menu_item').remove();
			$('#' + target).remove();
			$('.internal_window').hide();			
			$('.internal_window').first().show();			
		
		},		

		mobile_menu : function(event)
		{
			
			event.preventDefault();				
			$('#window_list').toggle();
			
		},
		
		notepad : function (event)
		{			
			event.preventDefault();
				
			var target = $(this).data('target');
			var content = $('#notepad_text').val();
			$('#' + target).val(content);
		
		},

		speech : function (event)
		{
			var target = $(this).data('target');			
			event.preventDefault();
			
			if (window.hasOwnProperty('webkitSpeechRecognition')) {

				var recognition = new webkitSpeechRecognition();

				recognition.continuous = false;
				recognition.interimResults = false;

				recognition.lang = "it-IT";
				recognition.start();

				recognition.onresult = function(e) {

					var value = $('#' + target).val();
					var new_value = e.results[0][0].transcript;
					$('#' + target).val(value + ' ' +new_value);

					recognition.stop();

				};

				recognition.onerror = function(e) {
					
					recognition.stop();
				
				}

			}			
			
		},
		
		item_toggle : function(event)
		{
			
			event.preventDefault();

			var target = $(this).data('target');
			
			$(this).children().first().toggleClass("fa-plus-square fa-minus-square");

			
			
			$(target).toggle("blind",250,
				function() {
					
					$(target)[0].scrollIntoView({ behavior: 'smooth', block: 'center' });					
				
				}
			);
			
			
		},		
		
		scroll_to : function(event)
		{
			
			event.preventDefault();

			var target = $(this).data('target');
				
			$(target)[0].scrollIntoView({ behavior: 'smooth', block: 'start' });					
				

			
			
		},		
		
		toggle_table: function(event){
			$(this).closest('table').find('tbody').toggle();
			$(this).toggleClass('fa-minus-square-o fa-plus-square-o');
		},
		
		toggle: function(event){
			event.preventDefault();			
			var target = $(this).data('target');
			$('#' + target).toggle();
		},

		storia_pubblica: function(event){
			event.preventDefault();			
			$(this).closest('.scheda_content.varie').find('.storia_pubblica').show();
			$(this).closest('.scheda_content.varie').find('.storia_privata').hide();

		},		
		
		storia_privata: function(event){
			event.preventDefault();			
			$(this).closest('.scheda_content.varie').find('.storia_pubblica').hide();
			$(this).closest('.scheda_content.varie').find('.storia_privata').show();
		},			
		
		chat_tab : function(event) {
			
			event.preventDefault();
			var target = $(this).data('target');
			$('.pagina_frame_chat .chat_box').hide();
			$('.pagina_frame_chat #' + target).show();
			
			$('.pagina_frame_chat .chat_tab').removeClass('active');
			$('.pagina_frame_chat .chat_tab').addClass('passive');
			$(this).parent().addClass('active');
			$(this).parent().removeClass('passive');
			$(this).children('span').html('');			
			
			var finestra_chat = (target == 'pagina_chat') ? 0 : 1;
			
			$('#finestra_chat').val(finestra_chat);
		
		},
		
		chat_ajax : function(event) {
			
			event.preventDefault();
			var target = $(this).data('target');
			var url = $(this).attr('href');
			$('.pagina_frame_chat .chat_box').hide();
			$('.pagina_frame_chat #' + target).show();
			
			$('.pagina_frame_chat .chat_tab').removeClass('active');
			$('.pagina_frame_chat .chat_tab').addClass('passive');
			$(this).parent().addClass('active');
			$(this).parent().removeClass('passive');
			
			$('#' + target + ' .mCSB_container').load(url);
			//getUrl(event,this,url,'#' + target + ' .mCSB_container');		

		},		
		
		tab : function(event) {
			
			event.preventDefault();
			var target = $(this).data('target');
			var url = $(this).attr('href');


			$(this).parent().find('a').removeClass('selected');
			$(this).addClass('selected'); 
			$(target).load(url);
	

		},				
		
		
		img_show : function(event)
		{
			event.preventDefault();				
			var target = $(this).attr('href');
			var html ='\
				<div style="position:absolute;top:10px;bottom:10px;left:10px;right:10px;">\
					<a href="#" data-function="img_hide">\
						<img id="img_preview" src="' + target + '" style="width:100%;height:100%;object-fit:contain;">\
					</a>\
				</div>';			
			
			$('body').append('<div class="full img_shadow" style="background-color:rgba(0,0,0,0.75);z-index:30000000;"></div>');
			$('body .img_shadow').html(html);

			
		},
		
		img_hide : function(event)
		{
			event.preventDefault();				

			$('body .img_shadow').html('');
			$('body .img_shadow').remove();		
			
		},			
		
		default : function (event)
		{			
		
		
		},		
		
	};
	
}());