
<!DOCTYPE html>
<html lang="en">
<head>
	<title>PHPDeveloper: PHP News, Views and Community</title>
	<link href='http://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/css/site.css" type="text/css" />
	<link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" />
	<script src="/js/jquery.js" type="text/javascript"></script>
	<script src="/js/site.js" type="text/javascript"></script>
	<script src="/js/bootstrap.min.js" type="text/javascript"></script>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="/feed" />
</head>

<body>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-3" style="background: #FFFFFF url('/img/layout/logo-bg3.gif') repeat-x top left;"><a href="/"><img src="/img/layout/logo3.gif" border="0"/></a></div>
		<div class="col-md-9" style="background: #FFFFFF url('/img/layout/logo-bg3.gif') repeat-x top left;height:145px"></div>
	</div>
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-9">
			<a href="/news/submit"><img src="/img/layout/tab-submit_news.gif" id="submit_news" border="0"/></a>
			<a href="/archive"><img src="/img/layout/tab-archive.gif" id="archive" onMouseOver="rollover('archive','on')" onMouseOut="rollover('archive','off')" border="0"/></a>
			<a href="/contact"><img src="/img/layout/tab-contact.gif" id="contact" onMouseOver="rollover('contact','on')" onMouseOut="rollover('contact','off')" border="0"/></a>
			<a href="http://blog.phpdeveloper.org"><img src="/img/layout/tab-blog.gif" id="blog" onMouseOver="rollover('blog','on')" onMouseOut="rollover('blog','off')" border="0"/></a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3" style="padding-right:20px">
					{% if username %}
					<div>
						logged in as <b>{{ username }}</b>
						not you? <a href="/admin/logout">logoff</a><br/>
						[<a href="/admin">administration</a>]
					</div><br/>
					{% endif %}
					<a href="/feed"><img src="/img/layout/feed_icon-small.gif" border="0"></a> <b>Subscribe</b>
					<div style="margin-top:5px">
						<a href="http://twitter.com/phpdeveloper"><img height="24" src="/img/layout/twitter-icon-black.png" border="0"> @phpdeveloper.org</a>
					</div>

					<br/><br/>
					<span class="sidetitle">News Archive</span>
					{% for item in archive %}
					<div style="margin-bottom:5px">
					<img src="/img/layout/gray_arrows.gif"/>
					<a class="sidelink" href="/news/22661">{{ item.title }}</a>
					</div>
					{% endfor %}
				</div>
				<div class="col-md-9">
					<br/>
					<div style="border:1px solid #CCCCCC;background-color:#EEEEEE;color:#000000;width:500px;font-size:10px;padding:5px">
						Looking for more information on how to do PHP the right way? Check out <a style="color:#000000" href="http://phptherightway.com">PHP: The Right Way</a>
					</div>
					<br/>

					{% block content %}{% endblock %}
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<br/>
		<div class="col-md-12" style="text-align:center">{{ tagcloud|raw }}</div>
	</div>
</div>
<footer style="background-color:#920017;color:#FFFFFF;font-size:10px;padding:5px;text-align:center">
	All content copyright, <?php echo date('Y'); ?> PHPDeveloper.org ::
	<a href="mailto:info@phpdeveloper.org" style="font-weight:bold;color:#FFFFFF">info@phpdeveloper.org</a>
</footer>

</body>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"> </script>
<script type="text/javascript"> _uacct = "UA-246789-1"; urchinTracker(); </script>

</html>
