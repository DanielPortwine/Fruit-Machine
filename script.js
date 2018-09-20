$(document).ready(function(){
	// login and sign up form swapping
	var loginState = 'Login';
	$("#loginStateButton").click(function(){
		$("#loginStateButton").text(loginState);
		if (loginState == 'Login'){
			$("#loginForm").hide();
			$("#signUpForm").show();
			loginState = 'Sign Up';
		} else if (loginState == 'Sign Up'){
			$("#loginForm").show();
			$("#signUpForm").hide();
			loginState = 'Login';
		}
		$("#loginStateTitle").text(loginState);
	});
	// displays alerts
	$('.alert').alert();
	// logout
	$("#logoutButton").click(function(){
		window.location = 'logout.php';
	});
	// random items
	var items = ['pineapple','strawberry','peach'];
	var canSpin = true;
	function changeItem(itemNo,item){
		itemNo = "#item" + itemNo;
		$(itemNo).attr("src","images/"+item+".png");	
	}
	function resetSpin(){
		canSpin = true;
		$("#spinButton").attr("disabled",false);
	}
	function spin(){
		if (canSpin == true){
			canSpin = false;
			$("#spinButton").attr("disabled",true);
			for (i=1;i<=5;i++){
				var itemNo = "#item" + i;
				$(itemNo).attr("src","images/spinning.gif");
				var item = items[Math.floor(Math.random()*items.length)];
				setTimeout(changeItem,i*2000,i,item);
			}
			setTimeout(resetSpin,10000);
		}
	}
	// user spins
	$("#spinButton").click(spin);
});