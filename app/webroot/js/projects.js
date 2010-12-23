$(document).ready(function() {
	
		var project_id = $("#ProjectProjectid").text();

			$("#ProjectUsers").fcbkcomplete({json_url: "/issuetracker/users/ajaxFind"});

});
			
