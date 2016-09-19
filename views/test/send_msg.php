<?php

?>
<html>
<head>
<script type="text/javascript" src="<?=base_url();?>js/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
var controller = {
	sendMsg : function () {
		$.ajax({
		    url: '/feedingmilktobaby/message/',
		    method: 'POST',
		    dataTyle: 'json',
		    data: $("#msg_frm").serialize(),
		    contentType : 'application/json; charset=utf-8',
		    success: function(result) {
		        $("#response").html(result);
		    }
		});
	}
};
</script>
</head>
<body>
	<form id="msg_frm">
	<textarea name="content" id="content"></textarea>
	<input type="hidden" name="user_key" value= "test_user_key"/>
	<input type="hidden" name="type" value= "text"/>
	</form>
	<input type="button" value="send msg" onclick="controller.sendMsg()" />
	<div id="response"></div>
</body>
</html>