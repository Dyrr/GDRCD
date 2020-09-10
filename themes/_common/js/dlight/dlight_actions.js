dlight.a = (function () {
	//METODI E ATTRIBUTI PRIVATI
	var dialogTheme = dlight.getCN().dialogTheme;
	
	var getUrl = function(url,target,options)
	{

		var options = options == undefined ? {} : options;		

		console.log(options.delay);
		$.get(url, function(data)
		{
			//se non è impostato nessun tempo di attesa
			if(options.delay == 'none') {
				
				//inserisce subito il contenuto della nuova pagina nel div, mantenendo la posizione della scrollbar
				//$(target).html(data);	
			
			//se è impostato un tempo di attesa
			} else {
			
				$(target).html('');
				//inserisce un microritardo prima di inserire nel div il contenuto della pagina nuova per permettere 
				//il reset della scrollbar
				setTimeout(function(){
					$(target).html(data);				
				}, 10);
				
			}

		});
	
	}
	
	function dialog(e,options)
	{
		
		// verifichiamo se nel body non esiste il sorgente per la dialog
		if ($('#dialog-'+ options.name).length == 0) {
		
			// in questo caso lo creiamo:
			$('body').append('\
				<div id="dialog-'+ options.name +'" title="'+ options.title +'" style="padding:0;"><div class="modulo ajax"></div></div>\
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
			  of: "main"
			});				
			$('#dialog-' + options.name + '-icon').hide();
			$('#dialog-' + options.name + '-icon').click(function() {
				$('#dialog-'+ options.name).parent().show();
				//$('#dialog-'+ options.name).dialogExtend("restore");	
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
				$('#dialog-' + options.name + '-icon').remove();
			}
		})
		/*
		.dialogExtend({
			collapsable:true,
			 "collapse" : function(e) {

				 $('#dialog-'+ options.name).parent().hide();
				 $('#dialog-' + options.name + '-icon').show();
				}
		});
		*/
		$('#dialog-'+ options.name).parent().show();
		//$('#dialog-'+ options.name).dialogExtend("restore");
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
	
		ajax_link : function (event)
		{

			event.preventDefault();


			
			var options = {};
			var target = $(this).attr('data-target');
			var url = $(this).attr('href');	
			options.delay = $(this).data('delay') == undefined ? 'yes' : 'none';

			var control = $(this).closest('.ajax');
			if(control.parent().is('main')) {
				
				history.pushState({}, '', url);
			
			}			
			
			if(target === undefined) {
				
				target = $(this).closest(".ajax");
			
			}
			
			getUrl(url,target,options);
		
		},

		main : function (event)
		{

			event.preventDefault();
			
			var options = {};
			var target = 'main .modulo.ajax';
			var url = $(this).attr('href');	
			history.pushState({}, '', url);				
			options.delay = $(this).data('delay') == undefined ? 'yes' : 'none';			
			getUrl(url,target,options);
			
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
		
		dialog : function(event) {
			event.preventDefault();				
			
			var options = {};
			options.width = $(this).data('width') == undefined ? 800 : $(this).data('width');
			options.height = $(this).data('height') == undefined ? 700 : $(this).data('height');
			options.name = $(this).data('name') == undefined ? 'gdrcd' : $(this).data('name');
			options.title = $(this).data('title') == undefined ? 'GDRCD' : $(this).data('title');
			options.css_class = $(this).data('class') == undefined ? 'default' : $(this).data('class');			
			options.url = $(this).attr('href');			
			options.icon = $(this).data('icon') == undefined ? 'far fa-window-maximize' : $(this).data('icon');			
			
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

		none : function (event)
		{			
		
			event.preventDefault();
		
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

$(document).ready(function()
{
 
	//LEGA L'EVENTO DI CLICK AL GESTORE DELLE AZIONI	
	$(document).on("click", "a", function (event) {
		
		//recupera il tipo di azione
		var action = $(this).attr("data-function");
		//controlla se il link è interno ad un elemento predisposto per le chiamate ajax
		var ajax = $(this).closest('.ajax');
		
		//SE IL LINK NON È INTERNO AD UN ELEMENTO PREDISPOSTO DI DEFAULT PER LE CHIAMATE AJAX
		if(ajax.length == 0) {
		
			//se non è stata definita una azione il link viene eseguito come un classico vecchio link altrimenti viene 
			//eseguita l'azione richiesta
			action = (action === undefined) 
				? 'default' 
				: action;

		//ALTRIMENTI SE È INTERNO AD UN ELEMENTO PREDISPOSTO DI DEFAULT PER LE CHIAMATE AJAX		
		} else {
			
			//se è stata definita una azione il link viene caricato tramite ajax altrimenti viene 
			//eseguita l'azione richiesta			
			action = (action === undefined) 
				? 'ajax_link' 
				: action;			
		
		}
		console.log(action);
		//se l'azione esiste
		if( typeof dlight.a[action] === "function" ) {

			//esegue l'azione
			dlight.a[action].call(this, event);

		}
	
	});
});