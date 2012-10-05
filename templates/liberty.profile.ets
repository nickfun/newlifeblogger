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
			{set:url_page_prev}<li><a href="{url_page_prev}">Newer Blogs</a></li>{/}
			{set:url_page_next}<li><a href="{url_page_next}">Older Blogs</a></li>{/}
			<li><a href="{rss_url}">RSS Feed</a></li>
			<li><a href="%HOME_LINK%">%HOME%</a></li>
			
			{avatar}
			
		</ul>	
    </div>

    <div id="content">
			<div class="box">
				<div class="boxtop">{username}'s Profile:</div>
				<div class="boxcontent">
<table border=0 cellspacing=2 cellpadding=0 width=95%>
<tr>
  <td>Avatar:</td>
  <td>{avatar}</td>
</tr>
<tr>
  <td>email: </td>
  <td>{email}</td>
</tr>
<tr>
  <td>Public Blogs: </td>
  <td>{blog_count}</td>
</tr>
<tr>
  <td>Posted Comments: </td>
  <td>{comment_count}</td>
</tr>
<tr>
  <td>Birthday: </td>
  <td>{birthday}</td>
</tr>
<tr>
  <td>Gender: </td>
  <td>{gender}</td>
</tr>
<tr>
  <td>Friends: </td>
  <td>{num_friends}</td>
</tr>
  <td>People who list me as a friend:</td>
  <td>{num_as_friend}</td>
</tr>
<tr>
  <td>Date registered: </td>
  <td>{registered}</td>
</tr>
<tr>
  <td valign="top">Bio: </td>
  <td> {bio} </td>
</tr>
</table>
				</div>
			</div>
    </div>
    
		<div id="footer">
				Copyright &copy; {username}. All rights reserved.
		</div>
</body>

</html>