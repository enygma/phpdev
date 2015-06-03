{% extends "layout.main.php" %}

{% block content %}

{% if message %}
	{% if success == false %}{% set alertType = 'danger' %}{% else %}{% set alertType = 'success' %}{% endif %}
	<div class="alert alert-{{ alertType }}">{{ message|raw }}</div>
{% endif %}

<form action="{% if action == 'add' %}/admin/news/add
	{% else %}/admin/news/edit/{{ item.id }}{% endif %}" method="POST" class="form-horizontal">
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Title:</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="title" name="title" value="{{ item.title }}">
		</div>
	</div>
	<div class="form-group">
		<label for="Story" class="col-sm-2 control-label">Story:</label>
		<div class="col-sm-8">
			<textarea name="story" cols="70" rows="20" id="story">{{ item.story }}</textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="tags" class="col-sm-2 control-label">Tags:</label>
		<div class="col-sm-8">
			<input type="tags" class="form-control" name="tags" id="tags" value="{{ item.delTags }}">
		</div>
	</div>
	<div class="form-group">
		<label for="tags" class="col-sm-2 control-label">Post Date:</label>
		<div class="col-sm-8">
			<select name="month" id="month">
				{% for num, month in months %}<option value="{{ num }}"
				{% if num == item.date|date('m') %} selected {% endif %}
				>{{ month }}</option>
				{% endfor %}
			</select>
			<select name="day" id="day">
				{% for day in days %}<option value="{{ day }}"
				{% if day == item.date|date('d') %} selected {% endif %}
				>{{ day }}</option>
				{% endfor %}
			</select>
			<select name="year" id="year">
				{% for year in years %}<option value="{{ year }}"
				{% if year == item.year|date('Y') %} selected {% endif %}
				>{{ year }}</option>
				{% endfor %}
			</select>
			@
			<select name="hour" id="hour">
				{% for hour in hours %}<option value="{{ hour }}"
				{% if hour == item.date|date('H') %} selected {% endif %}
				>{{ hour }}</option>
				{% endfor %}
			</select>
			<select name="minute" id="minute">
				{% for minute in minutes %}<option value="{{ minute }}"
				{% if minute == item.date|date('i') %} selected {% endif %}
				>{{ minute }}</option>
				{% endfor %}
			</select>
			<select name="second" id="second">
				{% for second in seconds %}<option value="{{ second }}"
				{% if second == item.date|date('s') %} selected {% endif %}
				>{{ second }}</option>
				{% endfor %}
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="link" class="col-sm-2 control-label">Link:</label>
		<div class="col-sm-8">
			<input type="link" class="form-control" name="link" id="link" value="{{ item.link }}">
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-2"></div>
		<div class="col-md-3">
			<input type="submit" value="Submit News" name="sub"/>
		</div>
	</div>
</form>

{% endblock %}