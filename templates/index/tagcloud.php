<b>Trending Topics:</b>
{% for tag in tags %}
<a class="tag_cloud" href="/tag/{{ tag.tag }}">{{ tag.tag }}</a>
{% endfor %}