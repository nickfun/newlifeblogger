<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<title>{username}'s blog</title>    
	<link rel="stylesheet" type="text/css" href="./templates/liberty.css" />
</head>
<body>
	<div id="header">
		<span class="title">{username}'s blog</span>
	</div>
    <div class="side">
      <ul>
				<li><a href="{url_home}">Home</a></li>
				<li><a href="{url_profile}">My Profile</a></li>
				<li><a href="{url_friends}">My Friends</a></li>
				{set:url_page_prev}<li><a href="{url_page_prev}">Newer Blogs</a></li>{/set}
				{set:url_page_next}<li><a href="{url_page_next}">Older Blogs</a></li>{/set}
				<li><a href="{rss_url}">RSS Feed</a></li>
				<li><a href="%HOME_LINK%">%HOME%</a></li>
				{avatar}
			</ul>	
    </div>
    <div id="content">
    	{mask:blog}
			<div class="box">
				{set:subject}<div class="boxtop"><strong>{subject}</strong> posted {date}</div>{/}
				<div class="boxcontent"><p>{body}</p></div>
				<div class="boxbottom">
					{set:comments}
						<a href="{comments_url}">{comments_num} Comment{mis:comments_num:1}s{/}</a>
					{/}
					{mis:comments}
						Comments turned off
					{/}
				</div>
				{set:mood}<div class="boxbottom"><strong>Mood:</strong> {mood}</div>{/}
				{set:custom_text}<div class="boxbottom"><strong>{custom_title}:</strong> {custom_text}</div>{/}
			</div>
		{/}

		{* COMMENTS *}
		{set:view_comments}
	
			<div class="box">
				<div class="boxtop">Comments</div>
				<div class="boxcontent">
					<dl>
					{mask:list_comments}
						<dt>{date}
						{set:guest}Anonymous comment{/set}
						{mis:guest}<a href="{author_url_blog}">{author}</a>{/mis}
						</dt>
						<dd>{body}</dd>
					{/mask}
					</dl>
			
					<div align="center"><b>Add Comment:</b>
					{add_comment}<br>{link_bbcode} {link_smiles}
					</div>
				</div>
			</div>
		{/set}
		
    </div>
		<div id="footer">
				Copyright &copy; {username}. All rights reserved.
		</div>
</body>
</html>