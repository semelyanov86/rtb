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
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:400,300'>
<link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
<link rel="stylesheet" href="test/VTT/LoginTheme/3/style.css">
<style type="text/css">
    .bg-image {
        position: absolute;
        background-image: url("test/VTT/LoginTheme/3/nyc.jpg");
        /*background-image: url("https://images.unsplash.com/photo-1519501025264-65ba15a82390?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjF9&w=1000&q=80");*/
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        /* Full height */
        height: 100%;
        width: 100%;
        
		  -webkit-filter: blur(5px);
		  -moz-filter: blur(5px);
		  -o-filter: blur(5px);
		  -ms-filter: blur(5px);
		  filter: blur(5px);
		
    }
    input{
    	font-size: 1.5em;
    }
    #page {
        min-height: 100%;
        padding-top: 0px !important;
    }
    .cont_ba_opcitiy {
    background: none;
    position: relative;
    width: 80%;
    border-radius: 3px;
    margin-top: 60px;
    padding: 15px 0px;
}
.error_message{
	background: rgba(255, 255, 0, 0.75);
    font-weight: 400;
    color: #000;
    border-radius: 5px;
    position: relative;
    width: 40%;
    border-radius: 3px;
    margin-top: 60px;
    padding: 15px 0px;
}
.cont_ba_opcitiy > h2 {
    background: #ffff00;
    font-weight: 400;
    color: #000;
    border-radius: 5px;
    padding: 5px;
}
.cont_ba_opcitiy > p {
    font-weight: 400;
    margin-top: 15px;
    color: #000000;
    font-size: 14px;
}
</style>

<div class="bg-image"></div>
<!-- partial:index.partial.html -->
<div class="cotn_principal">
    <div class="cont_centrar">
        <div class="text-center">
            <img class="img-responsive user-logo" style="width:25%; padding: 8% 0 0 0" src="layouts/v7/resources/Images/vtiger.png">
            <!-- <span class="login100-form-title p-b-43">VTiger Company Name</span> -->
            <h2 class="{if !$ERROR}hide{/if} cont_ba_opcitiy error_message" id="validationMessage">{$MESSAGE}</h2>
            <h2 class="{if !$MAIL_STATUS}hide{/if} cont_ba_opcitiy error_message">{$MESSAGE}</h2>
        </div>
        <div class="cont_login">
            <div class="cont_info_log_sign_up">
                <div class="col_md_login">
                    <div class="cont_ba_opcitiy">

                        <h2>Login</h2>
                        <p>if you want to login so use this form to Login to your account.</p>
                        <br>
                        <button class="btn_login" onclick="cambiar_login()">Login</button>
                    </div>
                </div>
                <div class="col_md_sign_up">
                    <div class="cont_ba_opcitiy">
                        <h2>Reset Password</h2>

                        <p>if you forgot or lost your password and can't access to your account, use this form.</p>

                        <button class="btn_sign_up" onclick="cambiar_sign_up()">Reset Password</button>
                    </div>
                </div>
            </div>

            <div class="cont_back_info">
                <div class="cont_img_back_grey">
                    <img src="test/VTT/LoginTheme/3/nyc.jpg" alt="" />
                </div>

            </div>
            <div class="cont_forms">
                <div class="cont_img_back_">
                    <img src="test/VTT/LoginTheme/3/nyc.jpg" alt="" />
                </div>
                <form action="index.php" id="LoginForm" method="POST" class="login-form login100-form validate-login-form">
                    <div class="cont_form_login">
                        <a href="#" onclick="ocultar_login_sign_up()"><i class="material-icons">&#xE5C4;</i></a>
                        <h2>Login</h2>
                        <input type="hidden" name="module" value="Users" />
                        <input type="hidden" name="action" value="Login" />
                        <input id="username" type="text" name="username" placeholder="Username">
                        <input id="password" type="password" name="password" placeholder="Password">
                        <button class="btn_login" type="submit">Login</button>

                    </div>
                </form>

                <form class="forgotPassword-form login100-form validate-reset-form" action="forgotPassword.php" method="POST">
                    <div class="cont_form_sign_up">
                        <a href="#" onclick="ocultar_login_sign_up()"><i class="material-icons">&#xE5C4;</i></a>
                        <h2>Reset Password</h2>

                        <input id="fusername" type="text" name="username" placeholder="Username">
                        <input id="email" type="email" name="emailId" placeholder="Email">
                        <button class="btn_sign_up" type="submit">Reset Password</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- partial -->
 
{literal}	

<script src="test/VTT/LoginTheme/3/script.js"></script>

{/literal}		



{/strip}