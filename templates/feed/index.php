{% block content %}
<?xml version="1.0" ?>
<rss version="2.0">
	<channel>
		<title>PHPDeveloper.org</title>
		<link>http://www.phpdeveloper.org</link>
		<description>Up-to-the Minute PHP News, views and community</description>
		<language>en-us</language>
		<pubDate>{{ "now"|date('r') }}</pubDate>
		<ttl>30</ttl>
		{% for item in news %}
		<item>
			<title><![CDATA[{{ item.title|raw }}]]></title>
			<guid>http://www.phpdeveloper.org/news/{{ item.id }}</guid>
			<link>http://www.phpdeveloper.org/news/{{ item.id }}</link>
			<description><![CDATA[{{ item.story|raw }}]]></description>
			<pubDate>{{ item.date|date('r') }}</pubDate>
		</item>
		{% endfor %}
	</channel>
</rss>
{% endblock %}