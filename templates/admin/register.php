{% extends "layout.main.php" %}

{% block content %}

<h2>Register</h2>

<form action="/admin/register" class="form-horizontal" method="POST">
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Username:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="username" name="username">
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Password:</label>
		<div class="col-sm-5">
			<input type="password" class="form-control" id="password" name="password">
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Email:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="email" name="email">
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">First Name:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="fname" name="fname">
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Last Name:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="lname" name="lname">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-2">&nbsp;</div>
		<div class="col-sm-8"><input type="submit" class="btn" name="sub" value="Submit"/></div>
	</div>
</form>

{% endblock %}