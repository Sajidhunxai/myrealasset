jQuery(function($){
	$('#st_optimize_database').on('click', function(){
		var load = $(this);
		var st_optimize_meta_key = $('#st_optimize_meta_key').val();
		var st_security_optimize = $('#st_security_optimize').val();
		if(st_optimize_meta_key){
			$.ajax({
				url:st_params.ajax_url,
				method : 'POST',
				dataType: 'json',
				data: {
					action : 'st_optimize_metadata_post',
					security: st_security_optimize,
					st_optimize_meta_key : st_optimize_meta_key,
				},
				beforeSend: function () {
                    load.find('i').show();
                },
                error : function(jqXHR, textStatus, errorThrown) {
                      
                    },
                success : function(res){
                    $('#st_optimize_message').html(res.message);
                    
                },
                complete: function (xhr, status) {
                	load.find('i').hide();
                	$('#st_optimize_message').show();
                }
			});
		}
	});
})