{% extends "layout.main.php" %}

{% block content %}

<table cellpadding="0" cellspacing="0" border="0" id="stats_table">
	<tr>
		{% for item in pending %}
		<td class="bars pending" align="center">
			<img src="/img/layout/red_dot.gif" width="12" height="{{ item.views }}"/>
			<br/><span class="id">{{ item.id }}</span><br/>{{ item.views }}
		</td>
		{% endfor %}
		{% for item in active %}
		<td class="bars" align="center">
			<img src="/img/layout/red_dot.gif" width="12" height="{{ item.views }}"/>
			<br/><span class="id">{{ item.id }}</span><br/>{{ item.views }}
		</td>
		{% endfor %}
	</tr>
</table>
<br/>
<ul class="stats_list">
	{% for item in active %}
	<li>[A] [<a href="/news/{{ item.id }}">{{ item.id }}</a>] {{ item.title }}
	{% endfor %}
</ul>
<br/>
<b>Pending articles:</b><br/>
<ul class="stats_list">
	{% for item in pending %}
	<li>{{ item.date|date('m.d.Y H:i:s') }} [P] [<a href="/news/{{ item.id }}">{{ item.id }}</a>] {{ item.title }}
	{% endfor %}
</ul>

{% endblock %}