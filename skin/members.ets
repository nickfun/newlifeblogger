{mask:main}

<table class="nlb_table" width="100%">
	<tr>
		<td><b>Sort Options:</b></td>
		{mask:sort}
			<td>{item} 
			<a onMouseOver="return overlib('{asc}');" onMouseOut="nd();" href="{url_asc}">Up</a> / 
			<a onMouseOver="return overlib('{desc}');" onMouseOut="nd();" href="{url_desc}">Down</a></td>
		{/mask}
	</tr>
</table>

<p>
{set:url_page_prev}
	<a href="{url_page_prev}">Previous Page</a>
{/set}
{set:url_page_next}
	<a href="{url_page_next}">Next Page</a>
{/set}
</p>

<table class="nlb_table" width="100%">
	<tr>
		<th>Username</th>
		<th>Blogs</th>
		<th>Profile</th>
		<th>Join Date</th>
	</tr>
	{mask:members}
	<tr>
		<td>{username}</td>
		<td><a href="{url_blogs}" onMouseOver="return overlib('Public Blogs: {blog_count}');" onMouseOut="nd();">View Blogs</a></td>
		<td><a href="{url_profile}">View Profile</a></td>
		<td>{registered}</td>
	</tr>
	{/mask}
</table>

{set:url_page_prev}
	<a href="{url_page_prev}">Previous Page</a>
{/set}
{set:url_page_next}
	<a href="{url_page_next}">Next Page</a>
{/set}


{/mask}