$(document).ready(function() {
	
	var project_id = $("#ajax-project-id").text();

	$("#IssueUsers").fcbkcomplete({json_url: "/issuetracker/projects/" + project_id + "/users"});

});
