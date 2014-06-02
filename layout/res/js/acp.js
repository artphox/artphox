function openDialog() {
	var stageh = $('#stage').height();
	var stagew = $('#stage').width();
	var posx = $('#stage').offset().left;
	var posy = $('#stage').offset().top;

	$('#stage-dialog').offset({top: posx - 100 , left: posy + 450});

	$('#stage-dialog').height(stageh/1.5);
	$('#stage-dialog').width(stagew/1.5);


	$('#stage-dialog').fadeIn(400);
}