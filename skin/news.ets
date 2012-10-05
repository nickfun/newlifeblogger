 {mask:main}

	{mask:news}

		<div style="padding: 3px; margin: 3px;">
		<span class="news_subject">{subject}</span> <br>
		{body}
		{set:comments}
			<br /><a href="{comments_url}">Comments: {comments_num}</a>
		{/set}
		{mis:comments}
			<br />Comments: <i>Disabled</i>
		{/mis}
		<br />
		<span class="news_extra">Posted by <b>{author}</b> on {date}</span>
		
		</div>
		
	{/mask}
	
	{set:view_comments}
	{*
		These only show up when we are viewing comments
	*}
		
		<div class="title">Comments:</div>
				
		{mask:list_comments}
			<div class="comment">
				<fieldset class="comment">
					<legend class="comment">
						<b>
						{mis:guest}<a href="{author_url_profile}">{author}</a>{/mis}
						{set:guest}{author}{/set}
						</b> Posted on {date}
					</legend>
					{body}
				</fieldset>
			</div>
		{/mask}
		
		<fieldset class="comment">
			<legend>Add Comment</legend>
			<center>
				{add_comment}<br>{link_bbcode} {link_smiles}
			</center>
		</fieldset>
	
	{/set}

{/mask}