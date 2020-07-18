dlight = (function () {
	//METODI E ATTRIBUTI PRIVATI
	var config = {};
	config.commonNames = {
			
		dialogTheme : "themeDefault"
		
	};
	
	//METODI E ATTRIBUTI PUBBLICI
	return {	
	
		getCN : function()
		{
			
			return config.commonNames;	
			
		},
	
		clickHandler: function (that,event)
		{
			
			
			//recupera il tipo di azione
			var action = $(that).attr("data-function");
			//controlla se il link è interno ad un elemento predisposto per le chiamate ajax
			var ajax = $(that).closest('.ajax');
			
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
				dlight.a[action].call(that, event);

			}		
			
		}
	
		
	};
	
}());

$(document).ready(function()
{
 
	//LEGA L'EVENTO DI CLICK AL GESTORE DELLE AZIONI	
	$(document).on("click", "a", function (event) {
		
		dlight.clickHandler(this,event);
	
	});
});