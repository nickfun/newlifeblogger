{mask:form}

	<h3>Search the blogs</h3>
	
	{set:noresults}No blogs were found matching your query{/set}
	
	<p>
	<form method="post" action="{url_search}">
		Search for this text: <input type="text" name="q" size="60" />
		<br /><label><input type="checkbox" name="subject"> In the subject</label>
		<br /><label><input type="checkbox" name="body" checked="checked"> In the body</label>
		<br />Posted by author: <input type="text" name="author">
		<br /><input type="submit" value="Search!">
	</form>
	</p>
{/mask}
		

{mask:results}

	<strong>There were {matches} entries found:</strong>

	<div>
	{set:url_prev}<a href="{url_prev}">Back</a>{/set}
	{set:url_next}<a href="{url_next}">Next</a>{/set}
	</div>
	
	<ul>
	{mask:entries}
		<li>
			{author} @ {date}: <br />
			<a href="{url}">{subject}</a> 
			<p>{body} ({comments} Comment{mis:comments:1}s{/})</p>
		</li>
	{/mask}
	</ul>
	
{/}

{mask:redirect}

	Your results are being procesed and will be shown here: <a href="{url}">Click if you are not redirected</a>
	
	<script language="javascript" type="text/javascript">window.location="{url}";</script>
	
{/}