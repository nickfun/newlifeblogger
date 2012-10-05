{mask:main}

	<p>
	{set:url_page_prev}
		<a href="{url_page_prev}">Back a page</a>
	{/set}

	{set:url_page_next}
		<a href="{url_page_next}">Next Page</a>
	{/set}
	</p>
	<center>
		<table width="95%" class="nlb_table">
			<tr>
				<th>Subject</th>
				<th>Date</th>
				<th>Options</th>
			</tr>
		{mask:list}
			<tr>
				<td> <a href="{url_view}" onMouseOver="return overlib('View Item');" onMouseOut="nd();">{subject}</a> </td>
				<td> {date} </td>
				<td> 
					<a href="{url_edit}" onMouseOver="return overlib('Edit Item');" onMouseOut="nd();">Edit</a>
					<a href="{url_delete}" onMouseOver="return overlib('Delete Item');" onMouseOut="nd();">Delete</a> 
				</td>
			</tr>
		{/mask}
		</table>
	</center>
	<p>
	{set:url_page_prev}
		<a href="{url_page_prev}">Back a page</a>
	{/set}

	{set:url_page_next}
		<a href="{url_page_next}">Next Page</a>
	{/set}
	</p>
{/mask}