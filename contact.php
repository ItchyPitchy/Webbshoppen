<?php

?>

<!-- test -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style_contact.css">
    <title>Document</title>
</head>
<body>
    
<!-- test -->

<div id="contact-form">
	<div>
		<h4>Have a question or just want to get in touch?<br> Fyll out this form and let us know.</h4> 
	</div>
		<!-- <p id="failure">Oopsie...message not sent.</p>  
		<p id="success">Thank you! We will get back to you shortly.</p> -->

		   <form method="post" action="#">
			<div>
		      <label for="name">
		      	<span class="required">Name: *</span> 
		      	<input type="text" id="name" name="name" value="" placeholder="Your Name" required="required" tabindex="1" autofocus="autofocus" minlength="2" maxlength="20" />
		      </label> 
			</div>
			<div>
		      <label for="email">
		      	<span class="required">Email: *</span>
		      	<input type="email" id="email" name="email" value="" placeholder="Your Email" tabindex="2" required="required" />
		      </label>  
			</div>
		
			<div>		          
		      <label for="message">
		      	<span class="required">Message: *</span> 
		      	<textarea id="message" name="message" placeholder="Please write your message here." tabindex="3" required="required"></textarea> 
		      </label>  
			</div>
			<div>		           
		      <button name="submit" type="submit" id="submit" >SEND</button> 
			</div>
		   </form>

    </div>
    
<!-- test -->
    </body>
</html>