{mask:main}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>My Blogs</title>
	<style>
<!--
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
.add_comment_block
 {
 background-color: #eeeeee;
 font-family: verdana, arial, sans-serif;
 font-size: 10px;
 color: #333;
 padding: 0px; 
 height: 100px;
 width: 400px;
}
input, textarea, select {
 background-color: #eeeeee;
 font-family: verdana, arial, sans-serif;
 font-size: 10px;
 color: #333;
 padding: 0px; 
} 
input.button {
 background-color: #ccc;
 border-style: outset;
 border-color: #999;
 border-width: 2;
} 
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
			   <span style="font-size: 16px; font-weight: bold">Web Log</span>
			   </td>
			   <td valign="bottom" align="right">
			      
				  <table border="0" cellspacing="0" cellpadding="1" bgcolor="#333333"><tr><td>
				  <table height="20" border="0" cellspacing="0" cellpadding="1" bgcolor="#ffcc00">
				   <tr>
				     <td class="small">&nbsp;&nbsp;&nbsp;[ {link_home} ]
					 [ {link_profile} ]
					 [ {link_friends} ]
					 {set:link_page_prev} [ {link_page_prev} ] {/set}
					 {set:link_page_next} [ {link_page_next} ] {/set} 
					 [ <a href="{rss_url}">RSS Feed</a> ]
					 [ <a href="index.php">NewLife Blogger</a> ] &nbsp;&nbsp;&nbsp;
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
{mask:blog}
<table border="0" cellspacing="0" cellpadding="1" bgcolor="#333333" width="99%"><tr><td valign="top">
<table border="0" cellspacing="0" cellpadding="2" bgcolor="#ffcc00" width="100%">
<tr><td bgcolor="#333333"><b><font color="white"> {date} </font></b></td>
</tr>
</td></tr></table>
</td></tr></table>
<br>
			 
<table border="0" cellspacing="0" cellpadding="1" bgcolor="#333333" width="99%"><tr><td valign="top">
<table border="0" cellspacing="0" cellpadding="2" bgcolor="#ffcc00" width="100%">
<tr>
</tr><tr><td class="small"> 
<b>{subject}</b> <br>
{body}<br>
<hr width="15%" align="left" color="#ff9900">
{set:mood}Mood: {mood} <br>{/set}
{set:custom_text}{custom_title}: {custom_text} <br>{/set}
<a href="{comments_url}">({comments_num}) Comments. </a>
</td></tr></table>
</td></tr></table>
<br>
{/mask}
<a name="#comments"></a>
{set:add_comment_block}
<table border="0" cellspacing="0" cellpadding="1" bgcolor="#333333" width="99%"><tr><td valign="top">
<table border="0" cellspacing="0" cellpadding="2" bgcolor="#ffcc00" width="100%">
<tr><td bgcolor="#333333"><b><font color="white"> Comments: </font></b></td>
</tr>
</td></tr></table>
</td></tr></table>
{mask:comments}<br>
<table border="0" cellspacing="0" cellpadding="1" bgcolor="#333333" width="99%"><tr><td valign="top">
<table border="0" cellspacing="0" cellpadding="2" bgcolor="#ffcc00" width="100%">
<tr>
</tr><tr><td class="small"> 
{set:avatar}<img src="{avatar_url}" align="right">{/set}
<b>{date}</b> -- {author_link_blogs}<br>
{comment}
</td></tr></table>
</td></tr></table>
{/mask}
<br>
<table border="0" cellspacing="0" cellpadding="1" bgcolor="#333333" width="99%"><tr><td valign="top">
<table border="0" cellspacing="0" cellpadding="2" bgcolor="#ffcc00" width="100%">
<tr>
</tr><tr><td class="small"> 
{add_comment_block}
</td></tr></table>
</td></tr></table>
{/set}
</center> 
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
{/mask}


++++++++++++++++++++++++
++  FRIENDS TEMPLATE  ++
++++++++++++++++++++++++

{mask:friends}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title> My Friends</title></head>
<body>

<!-- list friends -->
<div align="center"><div style="width: 80%; padding: 3px; border: 1px solid black; background-color: #d2d2d2; text-align: left;">
<font color="black">
<b>My Friends:</b> {mask:list} <a href="{url_blogs}">{name}</a>{if: !{_last} }, {/if}{/mask}

<!-- nav -->
<br>
<a href="{url_blogs_home}">My Blogs</a> 
{set:url_page_prev}<a href="{url_page_prev}">Previous Page</a>{/set} 
{set:url_page_next}<a href="{url_page_next}">Next Page</a>{/set}
</font></div></div>

<br><br>

<!-- friends blogs -->
{mask:friendsblogs}

<table align="center" border="0" style="width: 80%; padding: 3px; border: 1px solid black; background-color: #d2d2d2;">
<tr><td valign="top">
<!-- avatar -->
{set:avatar}<img src="{avatar_url}" align="right">{/set}

<!-- author, subject & date -->
<div style="width: 80%; padding: 2px; border: 2px solid #ffffff; background-color: #eeeeee;">
<a href="{author_url_blogs}"><font color="blue"><b>{author}</b></font></a>
<font color="black"><b>{subject}</b> {date}</font>
</div>
</td></tr>
<tr>

<!-- the blog -->
<td valign="top">
{body}
</td>
</tr>
<tr><td align="right">

<!-- extra info at bottom -->
<div style="width: 30%; padding: 2px; border: 2px solid #ffffff; background-color: #eeeeee" align="left">
<font color="black">
<a href="{comments_url}">{comments_num} Comments</a> <br>
{set:mood}Mood: {mood} <br>{/set}
{set:custom_text}{custom_title}: {custom_text}{/set}
</font>
</div>
</td></tr></table>
<p>

{/mask}

</body></html>
{/mask}