var acp = {
	sidebar: {
		data: {types: {}, elementdata: {}}
	},
	stage: {}
};

acp.sendData = function(sdata, callback) {
	$.ajax({
		type: 'POST',
		url: '../system/scripts/backend_change.php',
		data: sdata,
		dataType: 'text'
	}).done(function(data, textStatus, jqXHR) {
		try {
			result = $.parseJSON(data);
		} catch (e) {
			alert('Fehler! Data konnte nicht in JSON umgewandelt werden: ' + data);
			return;
		}
		callback(result);
	});
};

/*
Daten sollten nicht einfach 1:1 übernommen werden sondern geprüft werden.
Icon-Daten sollten vorgeladen werden.
*/
acp.sidebar.setData = function(data) {
	acp.sidebar.data = data;
};

acp.sidebar.refresh = function() {
	function fillUl(ul, elementdata) {
		for (var key in elementdata) {
			var li = $('<li class="sidebarli" data-elid="' + elementdata[key].id + '">' + elementdata[key].text + '</li>');
			if (elementdata[key].type in acp.sidebar.data.types) {
				var type = acp.sidebar.data.types[elementdata[key].type];
				var iconimg = $('<img src="'+type.icon+'" alt="">');
				li.prepend(iconimg);
			}
			ul.append(li);
			if (('elementdata' in elementdata[key]) && elementdata[key].elementdata.length !== 0) {
				var newul = $('<ul class="sidebarul"></ul>');
				fillUl(newul, elementdata[key].elementdata);
				ul.append(newul);
			}
		}
	}

	$('.sidebarul').empty();
	fillUl($(".sidebarul"), acp.sidebar.data.elementdata);
};

acp.stage.setStage = function(code) {
	$("#stage").html(code);
}

$(document).ready(function() {
	acp.sidebar.refresh();

	$('.sidebarli').click(function() {
		var id = $(this).attr("data-elid");
		acp.sendData({command: 'sidebaritemclicked', tabid: acp.sidebar.data.tabid, elid: id}, function(result) {
			if (result.error != null) {
				alert(result.error);
			}
			if (result.stage != null) {
				acp.stage.setStage(result.stage);
			}
			if (result.dialog != null) {
				//acp.stage.showDialog(result.dialog);
			}
		});
	});
});