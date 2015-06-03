{% extends "layout.main.php" %}

{% block content %}

<h2>Login</h2>

{% if message %}
	{% if success == false %}{% set alertType = 'danger' %}{% else %}{% set alertType = 'success' %}{% endif %}
	<div class="alert alert-{{ alertType }}">{{ message|raw }}</div>
{% endif %}
<form action="/admin/login" class="form-horizontal" method="POST">
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
		<label for="title" class="col-sm-2 control-label">Remember Me?</label>
		<div class="col-sm-8">
			<input type="checkbox" class="form-control" id="rememberme" name="rememberme" value="on">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-2">&nbsp;</div>
		<div class="col-sm-8"><input type="submit" class="btn" name="sub" value="Submit"/></div>
	</div>
</form>
<a href="/admin/register">Click here</a> to register

{% endblock %}