<div class="container py-4">

	<h2>Nous contacter</h2>

	<form id="contact">
		<div class="mb-3" id="email">
			<label for="email" class="form-label">Votre adresse email</label>
			<input type="email" class="form-control" id="email" aria-describedby="emailHelp">
			<div id="emailHelp" class="form-text">Nous pourrons vous recontacter avec votre email</div>
		</div>

		<div class="mb-3" id="sujet">
			<label for="sujet" class="form-label">Sujet</label>
			<input type="text" class="form-control" id="sujet">
		</div>

		<div class="mb-3" id="message">
			<label for="sujet" class="form-label">Message</label>
			<textarea class="form-control" placeholder="Exprimez-vous" id="floatingTextarea2" style="height: 100px"></textarea>
		</div>

		<p id="error" class="text-danger"></p>
		<p id="success" class="text-success"></p>

		<button type="submit" id="submit" class="btn btn-primary">Envoyer</button>
	</form>

</div>

<script src="lib/js/contact.js"></script>