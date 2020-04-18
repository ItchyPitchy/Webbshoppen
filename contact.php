<?php require_once "./header.php"; ?>

<script type = "text/javascript">

function validateForm(){

	const name = document.getElementById('name');
	const form = document.getElementById('form');
	const errorElement = document.getElementById('error');
	messages = []
	

	if(name.value.trim() == null || name.value.trim() == ''){
		console.log('Tom')
		errorElement.innerText = 'Vänligen ange ditt namn.'
		setTimeout(function(){
			errorElement.innerText = ''
		}, 3000);
		return false;
	}
	if(name.value.match(/\d+/g)){
		
		errorElement.innerText = 'Ditt namn får inte innehålla siffror.'
		setTimeout(function(){
			errorElement.innerText = ''
		}, 3000);
		return false;
	}
	if(name.value.length < 2){
		
		errorElement.innerText = 'Ditt namn måste minst vara 2 tecken.'
		setTimeout(function(){
			errorElement.innerText = ''
		}, 3000);
		return false;
	}
	if(name.value.length > 20){
		
		errorElement.innerText = 'Ditt namn får vara max 20 tecken.'
		setTimeout(function(){
			errorElement.innerText = ''
		}, 3000);
		return false;
	}

	return true;

}

</script>



<div class="contactContainer">
<div id="contact-form">
	<div>
		<h4 class="headerForm">Har ni frågor eller funderingar?<br> Fyll i formuläret nedan så hör vi av oss så snart vi kan.</h4> 
	</div>

		   <form id="form" method="POST" action="mail.php"  content-type="text/plain" accect-charset="utf-8"  name="myForm" onsubmit="return validateForm()">
			<div>
	  			
		      <label for="name">
			 
				  <span class="required">Namn: *</span> 
				  <div id="error"></div>
				  <input type="text" id="name" name="name" accect-charset="utf-8" placeholder="Ditt namn" tabindex="1" autofocus="autofocus"  />
				
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
						 
						   title="Ogiltig e-postadress. Får max innehålla 30 tecken. T.ex. dittnamn@epost.se"/>
		      </label>  
			</div>
		
			<div>		          
		      <label for="message">
		      	<span class="required">Meddelande: *</span> 
		      	<textarea id="message" name="message" accect-charset="utf-8"  placeholder="Ditt meddelande här." tabindex="3" required="required"></textarea> 
		      </label>  
			</div>
			<div>		           
		      <button name="submit" type="submit" id="submit" >SKICKA</button> 
			</div>
		   </form>

    </div>
</div>

<?php require_once "./footer.php"; ?>
