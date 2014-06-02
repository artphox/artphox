var acp = {
	sidebar: {
		data: {types: {}, elementdata: {}}
	}
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
			var li = $('<li>' + elementdata[key].text + '</li>');
			if (elementdata[key].type in acp.sidebar.data.types) {
				var type = acp.sidebar.data.types[elementdata[key].type];
				var iconimg = $('<img src="'+type.icon+'" alt="">');
				li.prepend(iconimg);
			}
			if (('elementdata' in elementdata[key]) && elementdata[key].elementdata.length !== 0) {
				var newul = $('<ul></ul>');
				fillUl(newul, elementdata[key].elementdata);
				li.append(newul);
			}
			ul.append(li);
		}
	}

	$('#sidebarul').empty();
	fillUl($("#sidebarul"), acp.sidebar.data.elementdata);
};

$(document).ready(function() {
	acp.sidebar.refresh();
});