<?php

?>
<html>
<head>
<script type="text/javascript" src="<?=base_url();?>js/jquery-3.1.0.min.js" />
<script type="text/javascript">
function sendMsg() {
	$.ajax({
	    url: '/feedingmilktobaby/message/',
	    type: 'POST',
	    dataTyle: 'json',
	    data: {
		    user_key : 'test_user_key',
		    type: 'text',
		    content: $("#msg").val();
	    }
	    success: function(result) {
	        $("#response").val(result);
	    }
	});
}
</script>
</head>
<body>
	<textarea id="msg">
	</textarea>
	<input type="button" value="send msg" onclick="sendMsg()" />
	<textarea id="response">
	</textarea>
</body>
</html>