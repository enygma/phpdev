{% block content %}

{% for item in news %}

{% if pending %}
<div class="pending_notice">
	<table cellpadding="0" cellspacing="0" border="0">
	<tr><td><img src="/img/layout/clock.gif"/></td>
	<td>This article is pending and will be posted at <b>{{ item.date }}</b></td></tr></table>
</div><br/>
{% endif %}

<div class="news_item">
	<a href="/news/{{ item.id }}" class="title"><span class="stub">{{ item.title|raw }}</a>
	<div style="color:#B2B2B2;padding:6 0 3 0"><span class="byline">by {{ item.author }}</span>
	<span class="date"> {{ item.date }}</span></div>

	<hr style="background-color:#B1B1B1;height:1px;width:300px;margin:2 0 5 0;border:0px"/>
	<div class="story">
		{{ item.story|raw }}
	</div>
	<span class="tags">
		tagged:
		{% for tagItem in tags %}
		<a class="tagged_with" href="/tag/{{ tagItem.tag }}">{{ tagItem.tag }}</a>
		{% endfor %}
	</span><br/><br/>
	<span class="comment_count">Link: <a href="{{ item.link }}">{{ item.link }}</a></span><br/>
	{% if admin and admin == true %}
	<span class="admin_links">
	<div>
		<b><a href="/admin/news/edit/{{ item.id }}">edit</a> ||
		<a href="/admin/news/delete/{{ item.id }}">delete</a></b>
	</div>
	</span>
	{% endif %}
</div><br/>
{% endfor %}

{% endblock %}