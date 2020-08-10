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
				? 'default' 
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