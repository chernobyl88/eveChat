//function globale

function check(base, data) {
	$.ajax({
		"dataType": "Json",
		"type":"post",
	    "data": data,//$('#details').serialise(),
	    "url": base+"/chat/check.html"
	}).done(function(data) {
		if(data.entity && data.entity.valid == 1)
			$(window).attr("location",base+"/chat/chat.html");
		else
			if(data.entity && data.entity.valid == 0)
				if (data.entity.error && data.entity.error.entity.length > 0) {
					$.each(data.entity.error.entity, function(key, data) {
						alert(data);
					});
				} else 
					callBack();//$(window).attr("location", base+"/chat/check.html");
		
	}).fail(function(xhr,error){
		alert(error);
	});
}


					
<script>
function callBack() {
	setTimeout(function(){
		check("<?php echo $rootLang;?>", JSON.stringify(new Object()));
	}, 1000);
}
</script>

<script src="<?php echo $root;?>/Web/js/check.js"></script>

<script>
$(document).ready(function() {
	callBack();
});
</script>