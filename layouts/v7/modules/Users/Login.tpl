{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Users/views/Login.php *}

{strip}
<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="test/VTT/LoginTheme/2/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="test/VTT/LoginTheme/2/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="test/VTT/LoginTheme/2/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="test/VTT/LoginTheme/2/vendor/animate/animate.css">

	<link rel="stylesheet" type="text/css" href="test/VTT/LoginTheme/2/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="test/VTT/LoginTheme/2/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="test/VTT/LoginTheme/2/vendor/select2/select2.min.css">

	<link rel="stylesheet" type="text/css" href="test/VTT/LoginTheme/2/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="test/VTT/LoginTheme/2/css/util.css">
	<link rel="stylesheet" type="text/css" href="test/VTT/LoginTheme/2/css/main.css">

	<style>
.user-logo {
	margin: 0 auto;
	padding-bottom: 20px;
		}
.wrap-login100 .forgotPassword-form {
  display: none;
}
.wrap-login100 .login-form {
  /*display: none;*/
}
.reset-password-button{
	background: #78fc25; !important
	/*background: #fcc425 !important;*/
}
#page {
    min-height: 100%;
    padding-top: 0px !important;
}


</style>


<body>
 
<div class="limiter">
		<div class="container-login100">
			<!-- <div class="wrap-login100 p-b-160 p-t-50"> -->
			<div class="wrap-login100 p-b-160 p-t-50">
			<div class="text-center">
			<img class="img-responsive user-logo" style="width:50%;" src="layouts/v7/resources/Images/vtiger.png">
				<span class="login100-form-title p-b-43">
						Ready To Buy
					</span>
    <span class="{if !$ERROR}hide{/if} login100-form-title bg-danger m-b-6" id="validationMessage">{$MESSAGE}</span>
    <span class="{if !$MAIL_STATUS}hide{/if} login100-form-title bg-success m-b-6">{$MESSAGE}</span>
</div>
				<form action="index.php" id="LoginForm" method="POST" class="login-form login100-form validate-login-form">
					<input type="hidden" name="module" value="Users" />
    <input type="hidden" name="action" value="Login" />					
					<div class="wrap-input100 rs1 validate-input" data-validate="Username is required">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="label-input100">Username</span>
					</div>
					
					
					<div class="wrap-input100 rs2 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="label-input100">Password</span>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn" form="LoginForm">
							Sign in
						</button>
					</div>
					
					<div class="forget_p text-center w-full p-t-23">
						<a href="#" class="text-white">
							Forgot password?
						</a>
					</div>
				</form>

				<form class="forgotPassword-form login100-form validate-reset-form" action="forgotPassword.php" method="POST">
					<div class="wrap-input100 rs1 validate-input" data-validate = "Username is required">
						<!-- <input class="input100" type="text" name="username"> -->
						<input class="input100" id="fusername" type="text" name="username" placeholder="Username">
						<span class="label-input100">Username</span>
					</div>
					
					
					<div class="wrap-input100 rs2 validate-input" data-validate="Email is required">
						<!-- <input class="input100" type="password" name="pass"> -->
						<input class="input100" id="email" type="email" name="emailId" placeholder="Email">
						<span class="label-input100">Email</span>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="reset-password-button login100-form-btn">
							Reset Password
						</button>
					</div>
					
					<div class="login-page text-center w-full p-t-23">
					<span class="text-white">Please enter details and submit </span>
						<a href="#" class="text-warning">
							Back to login page
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

 
{literal}	
	<!-- <script src="test/VTT/LoginTheme/2/js/main.js"></script> -->

	<script type="text/javascript">
	var loginForm = jQuery('.login-form');
	var forgetPassword = jQuery('.forgotPassword-form');
	$('.forget_p a').click(function(){
		// $(".forgotPassword-form").slideToggle("slow");
		// forgetPassword.fadeIn();
		forgetPassword.toggleClass('forgotPassword-form');
		loginForm.toggleClass('forgotPassword-form');
	// $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});

	$('.login-page a').click(function(){
		// $(".forgotPassword-form").slideToggle("slow");
		forgetPassword.toggleClass('forgotPassword-form');
		loginForm.toggleClass('forgotPassword-form');
		loginForm.fadeIn();
});

/**********************************************************************/
(function ($) {
    "use strict";

    /*==================================================================
    [ Focus Contact2 ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })    
    })
  
  
    /*==================================================================
    [ Validate ]*/
    // var input = $('.validate-input .input100');
var loginInput = $('.validate-reset-form .validate-input .input100');

    $('.validate-reset-form').on('submit',function(){
        var check = true;

        for(var i=0; i<loginInput.length; i++) {
            if(validate(loginInput[i]) == false){
                showValidate(loginInput[i]);
                check=false;
            }
        }

        return check;
    });

var resetInput = $('.validate-login-form .validate-input .input100');

    $('.validate-login-form').on('submit',function(){
        var check = true;

        for(var i=0; i<resetInput.length; i++) {
            if(validate(resetInput[i]) == false){
                showValidate(resetInput[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    

})(jQuery);

</script>
{/literal}		



{/strip}
