var acp = {
	sidebar: {
		data: {types: {}, elementdata: {}}
	},
	stage: {},
	adaption: {}
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

acp.sidebar.init = function() {
	$('.sidebarli').click(function() {
		var id = $(this).attr('data-elid');
		var data = {command: 'sidebaritemclicked', tabid: acp.sidebar.data.tabid, elid: id};
		acp.sendData(data, function(result) {
			if (result.error != null) {
				alert(result.error);
			}
			if (result.stage != null) {
				acp.stage.setStage(result.stage);
			}
			if (result.dialog != null) {
				//acp.stage.showDialog(result.dialog);
			}
			if (result.slug != null) {
				acp.adaption.setURL(result.slug, {"data": data, "callback": this});
			}
		});
	});
	$('.sidebarbutton').click(function() {
		var id = $(this).attr('data-tabid');
		var data = {command: 'sidebartabchanged', tabid: id};
		acp.sendData(data, function(result) {
			if (result.error != null) {
				alert (result.error);
			}
			if (result.sidebardata != null) {
				var data = $.parseJSON(result.sidebardata);
				acp.sidebar.setData(data);
				acp.sidebar.refresh();
			}
			if (result.slug != null) {
				acp.adaption.setURL(result.slug, {"data": data, "callback": this});
			}
		});
	});
	acp.sidebar.refresh();
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
};

acp.adaption.init = function() {
	$(window).bind('popstate', function(event) {
		event.preventDefault();
		var state = event.originalEvent.state;
		acp.sendData(state.data, state.callback);
	});
};

acp.adaption.setURL = function(slug, data) {
	var base = $("base").attr("href");
	history.pushState(data, null, base+slug);
};

$(document).ready(function() {
	acp.sidebar.init();
	acp.adaption.init();
	
});