<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>{username}'s blogs</title>
	<style>
{#
table.profile_body {
	border: 1px solid black;
	background-color: #ffcc00;
}
p { 
 font-family: verdana, arial, "ms sans serif", sans-serif; 
 font-size: 10px; 
 font-weight: normal;
 color: #333333;
 }
.small
 { 
 font-family: verdana, arial, "ms sans serif", sans-serif; 
 font-size: 10px; 
 font-weight: normal;
 line-height: 14px;
 padding-left: 10px;
 color: #333333;
 }
.big
 { 
 font-family: verdana, arial, "ms sans serif", sans-serif; 
 font-size: 14px; 
 line-height: 14px;
 padding-left: 10px;
 color: #333333;
 }
td { 
 font-family: verdana, arial, "ms sans serif", sans-serif; 
 font-size: 12px;
 color: #333333;
 }
a:link {
 color: #333333;
 font-weight: none; 
 text-decoration: underline;
 }
a:visited {
 color: #333333;
 font-weight: none;
 text-decoration: underline;
 }
a:active {
 color: #333333;
 font-weight: none;
 text-decoration: underline;
 }
a:hover {
 color:#666666;
 font-weight: none;
 text-decoration: underline;
 }
#}
-->
</style>
</head>
<body bgcolor="#eeeeee">
<center>

<table cellspacing="20" >
<tr><td>
<table cellspacing="0" cellpadding="1" border="0" bgcolor="333333" ><tr><td>
	<table cellspacing="0" cellpadding="1" border="0" bgcolor="cccccc"><tr><td>
		<table cellspacing="0" cellpadding="3" border="0" bgcolor="white"><tr><td>
			<table cellspacing="0" cellpadding="1" border="0" bgcolor="333333"><tr><td>
			 <table cellspacing="0" cellpadding="5" border="0" bgcolor="#ff9900" width="610">
			  <tr>
			   <td valign="center">
			   <span style="font-size: 16px; font-weight: bold">{username}'s Friends</span>
			   </td>
			   <td valign="bottom" align="right">
			      
				  <table border="0" cellspacing="0" cellpadding="1" bgcolor="#333333"><tr><td>
				  <table height="20" border="0" cellspacing="0" cellpadding="1" bgcolor="#ffcc00">
				   <tr>
				     <td class="small">&nbsp;&nbsp;&nbsp;
				     [ <a href="{url_home}">Home</a> ]
					 [ <a href="{url_profile}">Profile</a> ]
					 [ <a href="{url_friends}">Friends</a> ]
					 {set:link_page_prev} [ <a href="{url_page_prev}">Newer Blogs</a> ] {/set}
					 {set:link_page_next} [ <a href="{url_page_next}">Older Blogs</a> ] {/set} 
					 [ <a href="{rss_url}">RSS Feed</a> ]
					 [ <a href="%HOME_LINK%">%HOME%</a> ] &nbsp;&nbsp;&nbsp;
					 </td>
				   </tr>
				  </table>
				  </td></tr></table>
				 
			   </td>
			  </tr>  
			 </table>
			</td></tr></table>
		</td></tr></table>
	</td></tr></table>
</td></tr></table>
</td></tr></table>

<table cellspacing="20" >
<tr><td>
<table cellspacing="0" cellpadding="1" border="0" bgcolor="333333" ><tr><td>
	<table cellspacing="0" cellpadding="1" border="0" bgcolor="cccccc"><tr><td>
		<table cellspacing="0" cellpadding="3" border="0" bgcolor="white"><tr><td>
			<table cellspacing="0" cellpadding="1" border="0" bgcolor="333333"><tr><td>
			 <table cellspacing="0" cellpadding="5" border="0" bgcolor="#ff9900" width="610">
			  <tr>
			   <td>


<table width="90%" align="center" class="profile_body">
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

			   </td>
			  </tr>  
			 </table>
			</td></tr></table>
		</td></tr></table>
	</td></tr></table>
</td></tr></table>
</td></tr></table>


</center>
</body>
</html>
<!--
	Template: Citrus
	Source: www.oswd.org
	Author: Whompy [http://www.oswd.org/userinfo.phtml?user=whompy]
-->