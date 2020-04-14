


<div class="contactContainer">
<div id="contact-form">
	<div>
		<h4 class="headerForm">Har ni frågor eller funderingar?<br> Fyll i formuläret nedan så hör vi av oss så snart vi kan.</h4> 
	</div>

		   <form method="post" action="mailto:vanessasuthat@outlook.com" enctype="multipart/form-data">
			<div>
		      <label for="name">
		      	<span class="required">Namn: *</span> 
		      	<input type="text" id="name" name="name" value="" placeholder="Ditt namn" required="required" tabindex="1" autofocus="autofocus" minlength="2" maxlength="20" />
		      </label> 
			</div>
			<div>
		      <label for="email">
		      	<span class="required">Email: *</span>
				  <input type="email" 
						   id="email" 
						   name="email" 
						   value="" 
						   placeholder="Din e-postadress" 
						   tabindex="2" required="required"  
						   pattern="(?![^@]{30})[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*"
						   oninvalid="this.setCostomValidity('Ogiltig e-postadress. Får max innehålla 30 tecken. T.ex. dittnamn@epost.se')"
						   oninput ="this.setCustomValidity('')"
						   title="Ogiltig e-postadress. Får max innehålla 30 tecken. T.ex. dittnamn@epost.se" />
		      </label>  
			</div>
		
			<div>		          
		      <label for="message">
		      	<span class="required">Meddelande: *</span> 
		      	<textarea id="message" name="message" placeholder="Ditt meddelande här." tabindex="3" required="required"></textarea> 
		      </label>  
			</div>
			<div>		           
		      <button name="submit" type="submit" id="submit" >SKICKA</button> 
			</div>
		   </form>

    </div>
</div>
    
