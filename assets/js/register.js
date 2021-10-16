$(document).ready(function() {
	$("#hideLogIn").click(function() {
		$("#loginform").hide();
		$("#registerform").show();
	});

	$("#hideRegister").click(function() {
		$("#registerform").hide();
		$("#loginform").show();
	});
});