//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

/*
Titel:          js/adaption.js
Autor:          Simon Fraiss
Version:        Adaption-1.3
Release-Date:   05.03.2014
Beschreibung:   JavaScript-Datei für Änderungen an der Struktur und Eigenschaften der Webseite, inklusive Ajax-Navigation und URL-Anpassung
*/

//ERWEITERT DURCH MAINPAGE-TITEL-SPEICHERUNG UND URLLINK-KLASSE
//ERWEITERT DURCH WEITERE PARAMETER UND GRÖSSERE TITELVIELFALT

//--------------------------------------------------------------Adaption-Variable definieren----------------------------------------------------------------------------

//AdaptionData-Objekt erzeugen
var adaption = {};
/*
Adaption-Variablen (werden in init gesetzt):
initstate:          Gibt an, ob die Seite noch im anfänglichen Zustand ist, oder bereits eine Anpassung über loadPage vorgenommen wurde
errortitle:         Standard-Seitentitel bei Ajax-Fehlern.
fadeDuration:       Dauer des Aus- bzw. Ein-Fadens. Sollte aus DB abgefragt werden.
fadeEasing:         Easing des Fadens (swing/linear). Sollte aus DB abgefragt werden.
defaultContainer:   Standard-Container, in den Seiten hineingeladen werden
working:            Gibt an, ob die URL-Anpassung überhaupt vom Browser unterstützt wird. Standard-Wert false, wird weiter unten auf true gesetzt.
titlePatternNormal: Muster für Seitentitel. Möglicher Platzhalter: %page% (%site% wird im Konstruktor bereits ersetzt)
*/



//--------------------------------------------------------------Adaption-Funktionen definieren---------------------------------------------------------------------------

//----------------------------------------------------------adaption.init----------------------------------------------------------
/*
Funktion adaption.init
Beschreibung:	Initialisiert die Adpation. Sollte immer gleich am Start beim Laden aufgerufen werden.
				Initialisiert die Adaption-Variablen und setzt die nötigen Event-Handler.
Parameter:
	state:              StateName mit dem die Seite geladen wird. Notwendig um das Navigieren durch die History zu ermöglichen.
	sitetitle:          Site-Titel
	titlePatternNormal: Muster für kompletten Seitentitel. Verwendbare Variablen: %site% und %page%
	titlePatternError:  Muster für Error-Seitentitel. Verwendbare Variable: %site%
	fadeDuration:       Seitenübergangsdauer
	fadeEasing:         Seitenübergangsart
*/
//----------------------------------------------------------------------------------------------------------------------------------
adaption.init = function(state, siteTitle, titlePatternNormal, titlePatternError, fadeDuration, fadeEasing) {

	//-----------------------------------Adaption-Variablen setzen-----------------------------------

	adaption.initstate = true;
	adaption.fadeDuration = parseInt(fadeDuration, 10);
	adaption.fadeEasing = fadeEasing;
	adaption.defaultContainer = '#content';
	adaption.working = false;
	adaption.titlePatternNormal = titlePatternNormal.replace('%site%', siteTitle);
	adaption.errorTitle = titlePatternError.replace('%site%', siteTitle);
	//Prüfung ob History-API unterstützt wird
	if (!(history.pushState) || !(history.replaceState)) {
		return;
	}
	adaption.working = true;


	//-----------------------------------Ready-Funktion setzen---------------------------------------

	$(document).ready(function() {

		//---------------------------State-Replacement---------------------------
		//State wird replaced. State ist zwar der gleiche, aber es wird ein Data-Objekt übergeben, welches für die Zurück-Funktion wichtig ist!
		//-----------------------------------------------------------------------
		history.replaceState({ url: state }, document.title, location.href);
		


		//---------------------------Click-Eventhandler--------------------------
		//Klick-Event für alle A-Tags der Klasse Ajaxlink.
		//-----------------------------------------------------------------------

		$('a.ajaxlink').click(function(event) {
		
			//Falls die mittlere Maustaste gedrückt wurde, muss die Adaption nicht zur Tat schreiten
			if (event.which == 2) return;

			event.preventDefault();
			var attrhref = $(event.target).attr('href');	//Angegeben State abfragen
			var parts = attrhref.split('?');
			var stateurl = parts[0];
			var params = '';
			if (parts.length > 1) {
				params = parts[1];
			}
			var href = event.target.href;

			//Inhalt und URL anpassen
			adaption.loadPage(stateurl, href, params);

		});

		//---------------------------Click-Eventhandler--------------------------
		//Klick-Event für alle A-Tags der Klasse URLlink.
		//-----------------------------------------------------------------------
		$('a.urllink').click(function(event) {

			//Falls die mittlere Maustaste gedrückt wurde, muss die Adaption nicht zur Tat schreiten
			if (event.which == 2) return;

			event.preventDefault();
			var href = event.target.href;

			adaption.justSetUrl(null, href, null);

		});


		//---------------------------Popstate-Eventhandler-----------------------
		//Popstate wird aufgerufen, wenn der State durch Klicken des Zurück-Buttons geändert wird
		//Bei manchen Browsern (zB Chrome) wird das Event auch beim ersten Laden ausgelöst
		//-----------------------------------------------------------------------

		$(window).bind('popstate', function(event) {

			//Verhindern von erstmaligem Aktivieren!
			//if (event.originalEvent.state == null) {
			if (adaption.initstate) {
				return;
			}

			//State aus übergebenem Data-Objekt abfragen
			var state = event.originalEvent.state;
			var stateurl = state.url;

			//Get-Parameter herausfinden
			var parts = location.href.split('?');
			var params = '';
			if (parts.length > 1) {
				params = parts[1];
			}

			//Inhalt anpassen, ohne URL zu ändern, da diese bereits geändert wurde
			adaption.loadPage(stateurl, null, params);

		});

		//-----------------------------------------------------------------------	
		
	});
};

//----------------------------------------------------------adaption.justSetUrl------------------------------------------------------
/*
Funktion adaption.justSetUrl
Beschreibung:     Passt nur die URL auf die angegebene Adresse an, ohne eine Seite zu laden. Es kann auch ein StateName angegeben werden,
				wird keiner angegeben, wird der aktuelle State replaced, anstatt ein neuer gepusht. Die Änderung des States wird weiters
				bei zukünftigem Drücken des Zurück-Buttons insofern nicht beachtet, dass einfach die vorherige SubPage geladen wird. 
				D.h. es kommt wirklich nur zu einer reinen URL-Änderung, ohne weiteres Trara.
Parameter:
	state:      Neuer StateName (optional). 
	href:       Neue URL. Sollte Basis-URL (aus Base-Tag) + State entsprechen
	title:      Neuer Titel (falls null: Keine Änderung)
*/
//---------------------------------------------------------------------------------------------------------------------------------
adaption.justSetUrl = function (state, href, title) {
	if (title == null) {
		title = document.title;
	}
	if (state == null) {
		history.replaceState(history.state, title, href);
	} else {
		history.pushState({url: state}, title, href);
	}
};

//----------------------------------------------------------adaption.loadPage------------------------------------------------------
/*
Funktion adaption.loadPage
Beschreibung:   Ladet eine bestimmte SubPage (nicht einfach irgendeine beliebige Seite!!!) in den angegeben Container und passt die URL an.
Parameter:
	state:      StateName der SubPage, wie er in der DB steht. Entspricht dem State der URL.
	href:       Neue URL. Sollte Basis-URL (aus Base-Tag) + State entsprechen.
                Kann leer gelassen werden, wenn URL und Titel nicht angepasst werden sollen.
	getparams:  Get-Parameter als String, aus der URL herausgenommen. z.B. "id=123&c=lol". Optional.
	container:  Selector-String des Containers, in den der Inhalt bzw. die Fehlermeldung geladen werden soll.
                Kann leer gelassen werden, wenn es in den defaultContainer geladen werden soll.
Rückgabewert:   Gibt false zurück, fals die URL-Anpassung vom Browser nicht unterstützt wird oder kein State angegeben wurde. Ansonsten true.
*/
//---------------------------------------------------------------------------------------------------------------------------------
adaption.loadPage = function (state, href, getparams, container) {
	//Bedingungen prüfen
	if (adaption.working == false || state == null) {
		return false;
	}
	if (container == null) {
		container = adaption.defaultContainer;
	}
	var aimurl = 'system/scripts/frontend_change.php';
	if (getparams != null) {
		aimurl += '?' + getparams;
	}
	//Container ausblenden
	$(container).fadeTo(
		adaption.fadeDuration, 0, adaption.fadeEasing,
		function(animation, jumpedToEnd) {
			//frontend_change.php aufrufen
			$.ajax({
				type: 'POST',
				url: aimurl,
				data: {state: state, type: 'json'},
				dataType: "text"
			}).done(function(data, textStatus, jqXHR) {
				try {
					result = $.parseJSON(data);
				} catch (e) {
					var errorspan = $('<span style="color: red;"></span>');
					errorspan.html(data);
					console.log('Apx-JS-Error: ' + e.message + '\r\n' + data);
					$(container).html(errorspan);
					if (href != null) {
						history.pushState({url: state}, adaption.errorTitle, href);
						document.title = adaption.errorTitle;
					}
					return;

				}
				//Fehler vorhanden? -> Fehler anzeigen
				if (result.error != null) {
					$(container).html('<span style="color: red;">' + result.error + '</span>');
					//URL und Titel anpassen
					if (href != null) {
						history.pushState({url: state}, adaption.errorTitle, href);
						document.title = adaption.errorTitle;
					}
					return;
				}
				//Notwendige Daten nicht erhalten? -> Fehler anzeigen
				if (result.code == null || result.title == null) {
					$(container).html('<span style="color: red;">No data received!</span>');
					//URl und Titel anpassen
					if (href != null) {
						history.pushState({url: state}, adaption.errorTitle, href);
						document.title = adaption.errorTitle;
					}
					return;
				}
				//Alles ok? -> Inhalt anzeigen
				$(container).html(result.code);
				//URL und Titel anpassen
				if (href != null) {
					var title = adaption.createTitle(result.title);
					history.pushState({url: state}, title, href);
					document.title = title;
				}
			}).fail(function(jqXHR, textStatus, errorThrown) {
				$(container).html('<span style="color: red;">Ajax-Error: ' +  textStatus + ': ' + errorThrown + '</span>');
				if (href != null) {
					history.pushState({url: state}, adaption.errorTitle, href);
					document.title = adaption.errorTitle;
				}
			}).always(function(v1, v2, v3) {
				adaption.initstate = false;
				//Container wieder anzeigen
				$(container).fadeTo(adaption.fadeDuration, 1, adaption.fadeEasing);
			});
		}
	);
	return true;
	
};

adaption.createTitle = function(pagetitle) {
	return adaption.titlePatternNormal.replace('%page%', pagetitle);
};