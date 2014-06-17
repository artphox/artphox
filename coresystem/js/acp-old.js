//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

/*
ACP.JS VOR 17.06. Inklusive Adaption
*/

//--------------------------------------------------------------ACP-Variable definieren----------------------------------------------------------------------------

var acp = {
	sidebar: {
		data: {types: {}, elementdata: {}}
	},
	stage: {},
	adaption: {},
	server: {}
};

//--------------------------------------------------------------Unterobjekte & Funktionen----------------------------------------------------------------------------

/*
acp.server 
bietet alle Funktionen zur Kommunikation mim Server
*/
/*
acp.server.sendData sendet Daten an backend_change.php
sdata: Zu sendende Daten
noadaption: True, wenn kein neuer History-Eintrag erzeugt werden soll
*/
acp.server.sendData = function(sdata, noadaption) {
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
		if (noadaption === true) {
			acp.server.react(result, null);
		}
		else {
			acp.server.react(result, sdata);
		}
	});
};

/*
acp.server.react reagiert auf Ergebnisse vom Server und wertet sie aus.
Neue Reaktionen gehören in diese Methode. Die Funktion basiert auf der Annahme,
dass die Antworten von allen Anfragen von der gleichen Funktion behandelt werden können.
result: Vom Server gesendetes JSON-Objekt
adaptiondata: Soll ein neuer History-Eintrag erzeugt werden, die Daten, die an den Server geschickt wurden. Ansonsten null
*/
acp.server.react = function(result, adaptiondata) {
	if (result.error != null) {
		alert(result.error);
	}
	if (result.stage != null) {
		acp.stage.setStage(result.stage);
	}
	if (result.dialog != null) {
		//acp.stage.showDialog(result.dialog);
	}
	if (result.sidebardata != null) {
		var data = $.parseJSON(result.sidebardata);
		acp.sidebar.setData(data);
		acp.sidebar.refresh();
	}
	if (adaptiondata !== null && result.slug != null) {
		acp.adaption.setURL(result.slug, adaptiondata);
	}
};

/*
acp.adaption
Funktionen für die ACP-seitige Adaption
*/

/*
acp.adaption.init
Init-Funktion. Setzt Popstate-Eventhandler
*/
acp.adaption.init = function() {
	$(window).bind('popstate', function(event) {
		event.preventDefault();
		var state = event.originalEvent.state;
		acp.server.sendData(state, true);
	});
};

/*
acp.adaption.setURL
Erzeugt einen neuen History-Eintrag und passt die URL an, ohne die Seite zu laden.
slug: Neuer Slug, der an fixe Base-URL angehängt wird
data: An den Server zu sendende Data, falls der Zurück-Button gedrückt wird.
*/
acp.adaption.setURL = function(slug, data) {
	var base = $("base").attr("href");
	history.pushState(data, null, base+slug);
};

/*
acp.sidebar
Alles was mim Sidebar zu tun hat
*/

/*
acp.sidebar.setData
Wird zu Beginn in index.tpl aufgerufen.
data: JSON-Daten, die den Inhalt des Sidebars beschreiben
TODO: Icon-Daten vorladen!
*/
acp.sidebar.setData = function(data) {
	acp.sidebar.data = data;
};

/*
acp.sidebar.init
Init-Funktion des Sidebars. Setzt Eventhandler und ruft refresh auf, um den Tree aufzubauen
*/
acp.sidebar.init = function() {
	$('#sidebar').delegate('.sidebarli', 'click', function() {
		var id = $(this).attr('data-elid');
		var data = {command: 'sidebaritemclicked', tabid: acp.sidebar.data.tabid, elid: id};
		acp.server.sendData(data);
	});
	$('#sidebar').delegate('.sidebarbutton', 'click', function() {
		var id = $(this).attr('data-tabid');
		var data = {command: 'sidebartabchanged', tabid: id};
		acp.server.sendData(data);
	});

	acp.sidebar.refresh();

};

/*
acp.sidebar.refresh
Baut Sidebar-Tree neu auf
*/
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

/*
acp.stage
Alles was mit der Stage allgemein zu tun hat
*/
acp.stage.setStage = function(code) {
	$("#stage").html(code);
};

/*
document.ready
Ruft diverse Init-Funktionen auf
*/
$(document).ready(function() {
	acp.sidebar.init();
	acp.adaption.init();
	
});