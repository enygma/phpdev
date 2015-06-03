{% extends "layout.main.php" %}

{% block content %}

{% if message %}
	{% if success == false %}{% set alertType = 'danger' %}{% else %}{% set alertType = 'success' %}{% endif %}
	<div class="alert alert-{{ alertType }}">{{ message|raw }}</div>
{% endif %}
<br/>

Are you sure you want to delete <b>{{ item.title }}?</b><br/>

<p>
	This action cannot be revered and will remove the news item and related tags.
	<br/>
	<form action="" method="POST">
		<a href="/news/{{ item.id }}" class="btn btn-danger">Go back</a>
		<input type="submit" class="btn btn-success" value="Do it!"/>
	</form>
</p>

{% endblock %}