<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>{username}'s Friends</title>
<style type="text/css">
<!--
{#

a:link { color: #000000; }
a:hover { color: #333333; }
a:visited { color: #000000; }
a:active { color: #666666; }

a:link.nav { color: #FFFFFF; }
a:hover.nav { color: #FFFFFF; }
a:visited.nav { color: #FFFFFF; }
a:active.nav { color: #FFFFFF; }

div.heading {
	font-face: Arial;
	font-size: 30px;
	font-color: black;
	font-weight: bold;
}

#}
-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000">

<div class="heading" align="center">{username}'s Friends</div>


<table border="0" width="500" cellpadding="0" cellspacing="0" align="center">
 <tr>
  <td width="350" valign="bottom">
   <table border="0" cellspacing="0" cellpadding="2" bgcolor="#000000">
    <tr>
     <td>
      <font face="Arial, Helvetica" size="2" color="#FFFFFF">
       <a href="{url_home}" class="nav">Home</a>
       <a href="{url_profile}" class="nav">Profile</a>
       <a href="{url_friends}" class="nav">Friends</a>
       {set:url_page_prev}<a href="{url_page_prev}" class="nav">Newer Blogs</a>{/set}
       {set:url_page_next}<a href="{url_page_next}" class="nav">Older Blogs</a>{/set}
      </font>
     </td>
    </tr>
   </table>
  </td>
  <td align="right" valign="bottom">
   <a href="%HOME_LINK%"><font face="Arial" size="3" color="#000000"><b>%HOME%</b></font></a>
  </td>
 </tr>
 <tr colspan="2" bgcolor="#000000">
  <td bgcolor="#000000" colspan="2">
   <table width="100%" border="0" cellspacing="2" cellpadding="0" bgcolor="#000000"><tr><td>
   <table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF">
    <tr>
     <td bgcolor="ffcc33">
     
{mask:blog}

	<font face="Arial, Helvetica" size="2">
	<u><b>{subject}</b>
	{mis:subject}<i>No Subject</i>{/mis}
	 @ {date}</u><br>
	{set:avatar}<img src="{avatar_url}" align="right">{/set}
	{body} <br>
	{set:comments}
		<a href="{comments_url}">Comments: {comments_num}</a>
	{/set}
	{mis:comments}
		Comments: <i>Disabled</i>
	{/mis} <br>
	{set:mood}Mood: {mood}<br>{/set}
	{set:custom_text}{custom_title}: {custom_text}<br>{/set}
	<center>- {author}</center>
	<center><hr width="85%" color="#000000" align="center"></center>
{/mask}


<p>{rss_img}</p>
      </font>
     </td>
    </tr>
   </table>
   </td></tr></table>
  </td>
 </tr>
 <tr colspan="2">
  <td align="center" colspan="2">
   <font face="Arial, Helvetica" size="1">
    Copyright &copy; 2003 {username}	
   </font>
  </td>
 </tr>
</table>
</body>
</html>
<!--
	Template: I Hate Salem
	Source: www.oswd.org
	Author: BrAInDeD- [http://www.oswd.org/userinfo.phtml?user=BrAInDeD-]
-->