dlight.f = (function () {
	//METODI E ATTRIBUTI PRIVATI
	var dialogTheme = dlight.getCN().dialogTheme;
	
	//posticipa il caricamento della pagina se
	var getUrl = function(url,target,data)
	{

		$.post(url,data, function(data)
		{
			
			//svuota il div target
			$(target).html('');
			//imposta un microritardo nel popolare i dati nel div per fare in modo che in caso di scrollbar queste
			//ritornino in alto
			setTimeout(function(){
				
				//riempie il div con il contenuto
				$(target).html(data);				
			
			}, 10);

		})
		.fail(function() {
			alert( "error" );
		});
	
	}
	
	//METODI E ATTRIBUTI PUBBLICI
	return {	
	
		test : function (event)
		{
		
			console.log('TEST');
			
		},
		
		ajax_form : function (event)
		{

			event.preventDefault();

			var target = $(this).attr('data-target');
			var url = $(this).attr('action');

			//RILEVA IL VALORE DEL SUBMIT (UTILE NEL CASO DI PULSANTI MULTIPLI DI SUBMIT)
			var btn = $(this).find("input[type=submit]:focus");
			
			if(btn.attr('name') == undefined) {
			
				var btn = $(this).find("button:focus");			
			
			}
			
			var act = $(this).find("button:focus").attr('formaction');
			
			if(act != undefined) {
				url = act;
			}
			
			var act = $(this).find("input[type=submit]:focus").attr('formaction');
			
			if(act != undefined) {
				url = act;
			}			
			
			console.log(url);
			
			if(btn.attr('name') != undefined) {
				
				$(this).append('<input type ="hidden" name="' + btn.attr('name') + '" value="' + btn.val() + '" />');
				console.log(btn.attr('name') + ' / ' + btn.val());

			}
			
			if(target === undefined) {
				
				target = $(this).closest(".ajax");
			
			}
			var data = $(this).serialize();			
			console.log("TARGET:" + target);
			getUrl(url,target,data);
		
		},
	
		dialog : function(event) {
			event.preventDefault();				
			
			var width = $(this).data('width') == undefined ? 800 : $(this).data('width');
			var height = $(this).data('height') == undefined ? 700 : $(this).data('height');
			var name = $(this).data('name');
			var title = $(this).data('title');
			var css_class = $(this).data('class');
			var url = $(this).attr('action');			
			var icon = $(this).data('icon') == undefined ? 'far fa-window-maximize' : $(this).data('icon');
			
			// verifichiamo se nel body non esiste il sorgente per la dialog
			if ($('#dialog-'+name).length == 0) {
			
				// in questo caso lo creiamo:
				$('body').append('\
					<div id="dialog-'+name+'" title="'+title+'" style="padding:0;">\
					<div class="ajax"></div>\
					</div>\
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
			var data = $(this).serialize();	
			$('#dialog-' + name + ' .ajax').html('');
			// Ok, adesso siamo pronti per lanciare la modale!
				setTimeout(function(){
		
					getUrl(url,'#dialog-' + name + ' .ajax',data);					
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
		
		
		scroll_to : function (event)
		{			
		
			event.preventDefault();
			var position = $(this).attr('href');
			$(this).closest(".mCustomScrollbar").mCustomScrollbar("scrollTo",position);
		
		},

		scroll_top : function (event)
		{			
		
			if(event != null) {
				
				event.preventDefault();
			
			}
			
			$(this).closest(".mCustomScrollbar").mCustomScrollbar("scrollTo",'top');
		
		},		
		
		none : function (event)
		{			
		
			event.preventDefault();
		
		},
		
		default : function (event)
		{			
		
		
		},		
		
	};
	
}());

$(document).ready(function() {
	
	//LEGA L'EVENTO DI SUBMIT DI UN FORM AL GESTORE DELLE AZIONI	
	$( document ).on( "submit", "form", function(event){
		//recupera il tipo di azione
		var action = $(this).attr("data-function");
		//controlla se il form è interno ad un elemento predisposto per le chiamate ajax		
		var ajax = $(this).closest('.ajax');
		console.log("XHR: " + ajax);
		//SE IL FORM NON È INTERNO AD UN ELEMENTO PREDISPOSTO DI DEFAULT PER LE CHIAMATE AJAX		
		if(ajax.length == 0) {
		
			//se non è stata definita una azione il form viene inviato nel modo classico altrimenti viene 
			//eseguita l'azione richiesta			
			action = (action === undefined) 
				? 'ajax_form' 
				: action;

		//ALTRIMENTI SE È INTERNO AD UN ELEMENTO PREDISPOSTO DI DEFAULT PER LE CHIAMATE AJAX		
		} else {
			
			//se non è stata definita una azione il form viene inviato tramite ajax altrimenti viene 
			//eseguita l'azione richiesta				
			action = (action === undefined) 
				? 'ajax_form' 
				: action;			
		
		}
		
		//se l'azione esiste
		if( typeof dlight.f[action] === "function" ) {

			dlight.f[action].call(this, event);

		}
	
	});	
	
	
});