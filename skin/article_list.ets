{mask:main}

<table class="nlb_table" width="97%">
	<tr>
		<th width="50%">
			Subject
		</th>
		<th>
			Author
		</th>
		<th>
			Date Published
		</th>
	</tr>
{mask:articles}
	<tr>
		<td>
			<a href="{url_article}">{subject}</a>
		</td>
		<td>
			<a href="{author_url_profile}">{author}</a>
		</td>
		<td>
			{date}
		</td>
	</tr>
{/mask}

</table>

{/mask}