<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>{username}'s blogs</title>
	<style>
{#
div.friends-list {
	border: 1px solid black;
	padding: 3px;
	background-color: #ffcc00;
	font-family: verdana, arial, "ms sans serif", sans-serif; 
	font-size: 10px; 
	font-weight: normal;
	line-height: 14px;
	padding: 10px;
	color: #333333;
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
<center>
{*
	BLOGS
*}
{mask:blog}
<table border="0" cellspacing="0" cellpadding="1" bgcolor="#333333" width="99%"><tr><td valign="top">
<table border="0" cellspacing="0" cellpadding="2" bgcolor="#ffcc00" width="100%">
<tr><td bgcolor="#333333"><b><font color="white"> {date}  </font></b></td>
</tr>
</td></tr></table>
</td></tr></table>
<br>
			 
<table border="0" cellspacing="0" cellpadding="1" bgcolor="#333333" width="99%"><tr><td valign="top">
<table border="0" cellspacing="0" cellpadding="2" bgcolor="#ffcc00" width="100%">
<tr>
</tr><tr><td class="small"> 
<b>{subject}
{mis:subject} No Subject {/mis}
</b><br>
{body}<br>
<hr width="15%" align="left" color="#ff9900">
<b>Posted by <a href="{author_url_blogs}">{author}</a></b> <br>
{set:mood}Mood: {mood} <br>{/set}
{set:custom_text}{custom_title}: {custom_text} <br>{/set}
{set:comments}
	<a href="{comments_url}">Comments: {comments_num}</a>
{/set}
{mis:comments}
	Comments are off
{/mis}
</td></tr></table>
</td></tr></table>
<br>
{/mask}
</center> 
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

<div class="friends-list">
{*
	FRIENDS LIST
*}
<b>My Friends:</b>
{mask:friend_list}
<br><a href="{url_blogs}">{name}</a> 
{/}
</div>
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