{% extends "layout.main.php" %}

{% block content %}

<h3>Submit News</h3>

<p>
<b>Tell us what's happening!</b>
<p>
No one can be everywhere at once, including us, so we rely on our loyal readers to help us out. We try to
grab as much PHP-related goodness each day that we can, but things do fall through the cracks.
</p>
<p>
So, if we've missed something that you're a part of or just want to let us know about - fill in the details
below and send it off! We'll check it out!
</p>

{% if success %}
<div class="alert alert-success">Thanks for the submission. We'll take a look!</div>
{% endif %}

<form class="form form-horizontal" method="POST" action="/news/submit">
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Title:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="title" name="title">
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Contact Name or Email:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="name" name="name">
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Story:</label>
		<div class="col-sm-5">
			<textarea rows="10" id="story" name="story" class="form-control" placeholder="Share your story..."></textarea>
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