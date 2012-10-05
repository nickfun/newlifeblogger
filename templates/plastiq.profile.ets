<html>
<head>
<title>{username}'s blogs</title>
<style type="text/css">
textarea.nlb_add_comment {
	width: 400px;
	height: 150px;
}
a { color: #000000; }
a:visited { color: #3b3b3b; }
a:hover { color: #000000; }
</style>
</head>

<body bgcolor=#f3f3f3 marginheight=2 topmargin=0 leftmargin=0 marginwidth=2>
<font face=lucida size=+4 color=#3b3b3b><center>{username}</center></font>
<table border=0 width=90% cellspacing=3 cellpadding=0 align=center>
  <tr>
	<!-- cell that contains the title -->
	<td width=100%>
	  <!-- table for the title -->
	  <table border=0 cellspacing=2 cellpadding=0 width=100%>
		<tr>
		  <td bgcolor=#000000>
			<table border=0 cellspacing=1 cellpadding=2 align=center width=100%>
			  <tr>
				<td bgcolor=#a1bfc6 width=10%>&nbsp;</td>
				<td bgcolor=#cfcfcf align=center>
					<a href="{url_home}">Home</a> ::
					<a href="{url_profile}">Profile</a> ::
					<a href="{url_friends}">Friends</a> ::
					{set:link_page_prev} <a href="{url_page_prev}">Newer Blogs</a> :: {/set}
					{set:link_page_next} <a href="{url_page_next}">Older Blogs</a> :: {/set} 
					<a href="{rss_url}">RSS Feed</a> ::
					<a href="%HOME_LINK%">%HOME%</a>
				</td>
				<td bgcolor=#a1bfc6 width=10%>&nbsp;</td>
			  </tr>
			</table>
		   </td>
	  </table>
	  <!-- title end --> 
	</td>

  </tr>

  <tr>

	<!-- This cell is where the content goes -->
	<td width=100%>
	
	<table border=0 cellspacing=2 cellpadding=0 width=100%>
	  <tr>
		<td bgcolor=#000000>
		  <table border=0 cellspacing=1 cellpadding=5 width=100%>
			<tr>
			<!-- Here's the cell where everything else is under -->
			<td bgcolor=#cfcfcf>
			
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
			
			
			  	{mask:blog}
				<!-- blog table -->
				<table border=0 cellspacing=2 cellpadding=0 width=95%>
				  <tr>
					<td>
					  <!-- title table -->
					  <table border=0 cellspacing=2 cellpadding=0 width=50%>
						<tr>
						  <td bgcolor=#000000 width=100%>
						  <table border=0 cellspacing=1 cellpadding=3 width=100%>
							  <tr>
								<td bgcolor=#a1bfc6>{date}</td>
								<td bgcolor=#cfcfcf width="70%">
									{subject}
									{mis:subject}<i>No Subject</i>{/}
								</td>
							  </tr>
							</table>
						  </td>
						</tr>
					  </table>
					  <!-- table for date/title ends -->
					  {body}
					  <hr width="20%" color="#a1bfc6" align="left">
					  <b>Posted by <a href="{author_url_blog}">{author}</a></b><br>
					  {set:mood}Mood: {mood} <br>{/}
					  {set:custom_text}{custom_title}: {custom_text} <br> {/}
					  {set:comments} <a href="{comments_url}">Comments: {comments_num}</a> {/set}
					  {mis:comments} Comments: Off {/mis}
					  
					</td>
				  </tr>
				</table>
				
				{/mask}
				
			  </td>
			</tr>
		  </table>
		</td>
	  </tr>
	</table>
	</td>
  </tr>
</table>
</body>
</html>
<!--
	Template: Nutrition
	Source: www.oswd.org
	Author: Antipop [http://www.oswd.org/userinfo.phtml?user=antipop]
-->