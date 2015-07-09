<script>
function post(data,base) {
		$.ajax({
			"dataType": "Json",
			"type":"post",
		    "data": data,   
		    "url": base+"/Chat/sendMessage.html"
		})
}

function callBack() {
	setTimeout(function(){
		load("<?php echo $rootLang;?>", JSON.stringify(new Object()));
	}, 500);
};



function load(base){
	$.get("<?php echo $rootLang;?>/Chat/loadMessage.html",function(message){
		 $("#display").append($("<div class="main"></div>").append("<div class="id"></div>").append("<div class="date"></div>").append($("<div class="message"></div>").append("message:" + message)))
	});
	$("#display").scrollTop($("#display").height());
	callBack()
};
		
$( document ).ready(function() {

	
	
	$("#envoyer").click(function(){
		if($("#message").val().length >= 1 ){
		    var message = $('#message').val();
		    post({"message":message},"<?php echo $rootLang;?>");
		    $("#display").append("<div></div>").append($('#message').val());
		    $("#message").val('');
		    $('#message').focus();
	    } else {
	        alertify.error("Entrez un message puis cliquez sur Envoyer" );
		}   
	});

	load();
	

	function entree(){
		$('#message').keyup(function(e) {   
	        if(e.keyCode == 13) { 
	          if (e.shiftKey == false){
	              $('#envoyer').click();
	          }
	   		}
	  	});
	};


	

});


</script>

<div class="divcadre">
	<div id="display" class="form-control">	
	</div>
	<div class="boitemessage">
		<div class="form-group">
			<textarea placeholder="<?php echo ENTER_MSG;?>" class="form-control" id= "message" ></textarea>
		</div>
		<div class="bouton">
			<button class="btn-warning btn-lg btn" id="envoyer" type="button"><?php echo SEND;?></button>
		</div>
		<div class="bouton">
			<button class="btn-warning btn-lg btn" type="button"><?php echo DECO;?></button>
		</div>
	</div>
</div>