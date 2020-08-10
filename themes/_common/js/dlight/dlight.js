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
	
	};
	
}());

