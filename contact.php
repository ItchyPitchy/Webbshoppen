<?php

require_once "header.php";
 require_once "style_contact.css";
?>


<div class="container">
<div id="contact-form">
	<div>
		<h4>Have a question or just want to get in touch?<br> Fyll out this form and let us know.</h4> 
	</div>

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
		      	<input type="email" id="email" name="email" value="" placeholder="Your Email" tabindex="2" required="required"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
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
</div>
    
<?php
require_once "footer.php";
?>