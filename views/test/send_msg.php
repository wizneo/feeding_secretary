<?php

?>
<html>
<head>
<script type="text/javascript" src="<?=base_url();?>js/jquery-3.1.0.min.js" />
<script type="text/javascript">
var aaaaa = "er";
var controller = {
	sendMsg : function () {
		$.ajax({
		    url: '/feedingmilktobaby/message/',
		    method: 'POST',
		    dataTyle: 'json',
		    data: {
			    user_key : 'test_user_key',
			    type: 'text',
			    content: $("#msg").val()
		    },
		    contentType : 'application/json; charset=utf-8',
		    success: function(result) {
		        $("#response").val(result);
		    }
		});
	}
};
</script>
</head>
<body>
	<textarea id="msg"></textarea>
	<input type="button" value="send msg" onclick="controller.sendMsg()" />
	<textarea id="response"></textarea>
</body>
</html>