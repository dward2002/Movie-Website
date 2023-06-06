<h2><?= esc($title) ?></h2>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<p id="ajaxArticle"></p>

<form id = "myform" action="<?=base_url()?>/signup" method="post">
    <?= csrf_field() ?>

	<div class="mb-3">
		<label for="username" class="form-label">Username</label>
		<input class="form-control" type="input" id = "username" name="username" value="<?= set_value('username') ?>">
		<br>
	</div>
	<div class="mb-3">
		<label for="password" class="form-label">Password</label>
		<input class="form-control" type="password" name="password" value="<?= set_value('password') ?>">
		<br>
	</div>
	
    <input onClick ="getData()" class="btn btn-primary" id = "Btnsubmit" name="Btnsubmit" value="Create account">
</form>

<script>
	//if enter is pressed submit button is clicked
	document.getElementById("myform")
		.addEventListener("keyup", function(event) {
		event.preventDefault();
		if (event.keyCode === 13) {
			document.getElementById("Btnsubmit").click();
		}
	});

	function getData() {
		if (document.getElementById("username").value == ""){
			var username = "1";
		}
		else{
			var username = document.getElementById("username").value;
		}
		// Fetch data
		fetch('https://mi-linux.wlv.ac.uk/~2008458/ci4-demo3/public/ajax/user/' + username)
			
		  // Convert response string to json object
		  .then(response => response.json())
		  .then(response => {
			  
		  if(response == null){
			  document.getElementById('myform').submit();
		  }
		  else{
			 // Copy one element of response to our HTML paragraph
			document.getElementById("username").style.borderColor = "red";
			document.getElementById("ajaxArticle").innerHTML = "Username is already taken";
			//it viabrates on some devices
			window.navigator.vibrate(100);
			
			
		  }
		  })
		  .catch(err => {
			
			// Display errors in console
			console.log(err);
		});
	}
</script>