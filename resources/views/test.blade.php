<!DOCTYPE html>
<html>

<head>
<link href=
"https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"
	rel="stylesheet"/>
<script src=
"https://code.jquery.com/jquery-3.1.1.min.js">
</script>
<script src=
"https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js">
</script>
</head>

<body>

<div class="ui container center aligned">
	<h2 class="ui header green"> GeeksforGeeks </h2>
	
	<h3> Semantic-UI Form Multiple Select Content </h3>
</div>

<div class="ui form">
	<div class="field">
	<label>
		Skills
	</label>

	<select multiple="" class="ui search selection dropdown">
		<option value="">
		Select Multiple skills:
		</option>

		<option value="cpp">
		C++
		</option>

		<option value="css">
		CSS
		</option>

		<option value="dart">
		Dart
		</option>

		<option value="firebase">
		Firebase
		</option>

		<option value="flutter">
		Flutter
		</option>

		<option value="java">
		Java
		</option>

		<option value="Javascript">
		Javascript
		</option>

		<option value="python">
		Python
		</option>

		<option value="web-dev">
		Web Development
		</option>
	</select>
	</div>
</div>
<script>
	$('.ui.dropdown').dropdown();
</script>
</body>
</html>
