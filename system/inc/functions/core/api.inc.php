<?php
	namespace api {

		function requisiti()
		{
			
			\functions\load('core/install');
			
			return \install\requisiti();
			
			
		}
		
	}    
