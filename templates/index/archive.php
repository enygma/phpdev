{% extends "layout.main.php" %}

{% block content %}

<table cellpadding="0" cellspacing="0" border="0" id="archive_table">
{% for date,day in news %}
	<tr>
		<td colspan="3" class="archive_day">
			<a href="/archive/20150501" class="archive_day_link">{{ date }}</a></td>
	</tr>
	{% for item in day %}
	<tr>
		<td valign="top" class="link_date">@{{ item.date|date('H:i:s') }}</td>
		<td width="16" valign="top"><img src="/img/layout/gray_arrows.gif"/></td>
		<td align="left"><a class="archive_link" href="/news/{{ item.id }}">{{ item.title }}</a></td>
	</tr>
	{% endfor %}
{% endfor %}
</table>
<br/>

{% endblock %}