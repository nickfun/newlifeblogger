 {mask:main}

	<p>
		<b>Totals:</b><br>

		{total_public} 		Public Blogs.<br>
		{total_private} 	Priviate Blogs.<br>
		{total_users} 		Valid users.<br>
		{total_comments} 	Comments.
	</p>

	<p>
		<b>In the last 24 hours:</b><br>
		{recent_blogs} 		Blogs.<br>
		{recent_comments} 	Comments.<br>
		{recent_users} 		Users registered
	</p>


	<p>
		<b>Newest:</b><br>
		{set:new_user_username}
			Newest user is <a href="{new_user_url}">{new_user_username}</a>.<br />
		{/set}
		
		{set:new_blog_username}
			Newest Blog is <a href="{new_blog_url}">{new_blog_subject}</a> Posted by
			<a href="{new_blog_user_url}">{new_blog_username}</a>. <br />		
		{/set}
		
		{set:new_comment_username}
			<a href="{new_comment_url}">Newest Comment</a> Was posted by
			<a href="{new_comment_user_url}">{new_comment_username}</a>
		{/set}
	</p>
		
{/mask}