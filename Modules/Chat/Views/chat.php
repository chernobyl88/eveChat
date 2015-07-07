<script>
function post(data,base) {
		$.ajax({
			"dataType": "Json",
			"type":"post",
		    "data": data,   
		    "url": base+"/Chat/sendMessage.html"
		})
}
		
$( document ).ready(function() {
	  function send() {
		  $("#envoyer").click(function(){
			if($("#message").val().length >= 5 ){
			    var nom = "moi";
		        var message = $('#message').val();
		       post({"nom": nom, "message":message},"<?php echo $rootLang;?>");
	       } else {
	    	   alertify.error("Si vous le désirez" );
		   }   
	    })
	  }
	function load(base){
		$.get(base+"/Chat/loadMessage.html",function(message){
			alert("message:" + message)
			})
	}


});
</script>

<div class="divcadre">
	<div id="display" class="form-control">
		
	</div>

	<div class="form-group">
		<textarea placeholder="<?php echo ENTER_MSG;?>" class="form-control" id= "message" ></textarea>
	</div>
	
	<div class="bouton">
		<button class="btn-warning btn-lg btn" type="button" id="envoyer"><?php echo SEND;?></button>
	</div>
	<div class="bouton">
		<button class="btn-warning btn-lg btn" type="button"><?php echo DECO;?></button>
	</div>
</div>