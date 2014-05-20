var acp = {};

acp.init = function(pageidentifier) {
	acp.pageidentifier = pageidentifier;
};

acp.send = function(inputs, command, callback) {
	var params = {};
	inputs.each(function(index, element){
		if ($(element).attr("type") == "checkbox") {
			params[element.id] = element.checked;
		} else {
			params[element.id] = element.value;
		}
	});
	$.ajax({
		type: 'POST',
		url: '../system/scripts/adminrequest.php',
		data: {identifier: acp.pageidentifier, command: command, input: params},
		dataType: 'text'
	}).done(function(data, textStatus, jqXHR) {
		callback(data, textStatus, jqXHR);
	});
};