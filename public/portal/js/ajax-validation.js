$(document).ready(function(){
	$('.ajax-form').submit(function(e){
	    e.preventDefault();
		let url = $(this).attr('action');
		let method = $(this).attr('method');
		let form = $(this);
		let form_data = new FormData(this);
		$(form).find('button').prop('disabled', true)
		$.ajax({
			type: method,
			url: url,
			data: form_data,
			contentType: false,
			processData: false,
			success: function(response){
				if(response.message){
					swal({
					  title: response.message,
					  text: response.message_body,
					  timer: 4000,
					  icon: response.type
					}).then((result) => {
						if(response.url)
							window.location.href = response.url;
						
					});
				}
				$(form).find('button').prop('disabled', false)
			},
			error: function(xhr, status, error) {
		        if (xhr.status == 422) {
		            form.find('div.text-danger').remove();
		            var errorObj = JSON.parse(xhr.responseText).errors;
		            $.map(errorObj, function(value, index) {
		                var appendIn = form.find('[name="' + index + '"]').closest('.col-12');
		                if (!appendIn.length) {
		                    swal({
							  title: 'Error!',
							  text: value[0],
							  timer: 4000,
							  icon: 'error'
							});
		                } else {
		                    $(appendIn).append('<div class="text-danger my-2">' + value[0] + '</div>')
		                }
		            });
		        } else {
		            swal({
					  	title: 'Server Error!',
					  	text: 'Contact with support, Thank you!',
					  	timer: 4000,
					  	icon: 'error'
					});
		        }
		        $(form).find('button').prop('disabled', false)
            }
		})
	});
})