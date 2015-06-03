
function rollover(id,status){
	if(status=='on'){
		$('#'+id).attr('src','/img/layout/tab-'+id+'_on.gif');
	}else{ $('#'+id).attr('src','/img/layout/tab-'+id+'.gif'); }
}
function submitLogout(){
	$('#logout_form').submit();
	return false;
}
function suggestSpam(id){
	$.ajax({
		type: 'GET',
		url: '/api/comment/'+id+'/reportspam',
		success: function(msg){
			alert('Thank you for your report!');
		}
	});
}
function markAsSpam(id){
	$.ajax({
		type: 'GET',
		url: '/api/comment/'+id+'/isspam',
		success: function(msg){
			$('#comment_'+id).css('display','none');
			alert('Marked as spam!');
		}
	});
}
function side_highlight(id,type){
	(type=='over') ? color='#EEEEEE' : color='#FFFFFF';
	$('#'+id).css('background-color',color);
}