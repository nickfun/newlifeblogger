<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title>{username}'s Web Log</title>
<style type="text/css">
{#
.bar {
    background-color: #9bc;
	color: #000;
	padding-left: 1em;
	border-top: 1px solid black;
	border-bottom: 1px solid black;
}
p.text { padding-left: 1em; }
div.blog {
	padding: 1em;
	border-left: 1px solid black;
}
div.heading {
	border-left: 1px solid black;
	text-align: center;
	font-family: Verdana, Helvetica, sans-serif;
	font-size: 20px;
	font-weight: bold;
	padding: 1em;
	color: black;
}
body {
    background-color: #369;
	font-color: #fff;
}
a { 
    color: #000; 
	text-decoration: underline; 
}
img { border: 0 }
#}
</style>
</head>
<body>


<center>
<br /><br />
<table border="0" cellpadding="0" cellspacing="0" width="80%">
  <tr>
    <td width="25%" bgcolor="#99bbcc" align="center" valign="top">
	<font face="Arial, sans-serif" size="2" color="#000000">
	<br />    
	<p><a href="{url_home}">Home</a></p>
	<p><a href="{url_profile}">Profile</a></p>
	<p><a href="{url_friends}">Friends</a></p>
	{set:url_page_prev}<p><a href="{url_page_prev}">&lt;-- Newer Blogs</a></p>{/set}
	{mis:url_page_prev}<p>&nbsp;</p>{/mis}
	{set:url_page_next}<p><a href="{url_page_next}">Older Blogs --&gt;</a></p>{/set}
	{mis:url_page_next}<p>&nbsp;</p>{/mis}
	{set:avatar}
		<p><a href="{url_profile}">{avatar}</a></p>
	{/set}
	<p><a href="%HOME_LINK%">%HOME%</a></p>
	<p>{rss_img}</p>
	
	<b>My Friends:</b><br>
	{mask:friend_list}
		<a href="{url_blogs}">{name}</a><br>
	{/mask}
	<br>
	</td>
	<td bgcolor="#ffffff" valign=top>

    	 <!-- heading -->
    	 
     <div class="heading">. [ {username}'s Friends ] .</div>
     
	 <!-- blog -->
	 
	{mask:blog}
		<div class="bar">
			{mis:subject}<i>No Subject</i>{/mis}
			<b>{subject}</b> on {date}</div>

		<div class="blog">
		{set:avatar}
			<img src="{avatar_url}" align="right" />
		{/set}
		<b>{author}</b> Wrote: <br>
		{body}<br />
		{set:mood}<b>Mood:</b> {mood}<br />{/set}
		{set:custom_text}<b>{custom_title}:</b> {custom_text}<br />{/set}
		{set:comments}
			<a href="{comments_url}">Comments: {comments_num}</a>
		{/set}
		{mis:comments}
			Comments: <i>Disabled</i>
		{/mis}
		</div>
	{/mask}
	
    </td>
  </tr>
</table>

<font face="Arial, sans-serif" size=1><i>Copyright &copy; 2003 {username}</i></font>    
</center>

</body>
</html>
<!--
	Template: Blueman
	Source: www.oswd.org
	Author: rdm [http://www.oswd.org/userinfo.phtml?user=rdm]
-->