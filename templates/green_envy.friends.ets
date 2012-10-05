<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>{username}: Blogs</TITLE>
<META content="text/html; charset=windows-1252" http-equiv=Content-Type>
<style type="text/css">
<!--
img { border: 0; }
textarea.nlb_add_comment {
	width: 300px;
	height: 150px;
}
-->
</style>
</HEAD>

<BODY bgColor=#ffffff link=#000080 text=#000000 vLink=#000080><FONT face="Verdana, Arial" size=2>
<TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">

<TR>
<TD bgColor=#000000>
<TABLE border=0 cellPadding=4 cellSpacing=1 width="100%" height="472">
      
<TR bgColor=#b0bb9d>
<TD height="32" valign="top"><FONT face="Verdana, Arial" size=2>
<CENTER><B>=({username})=</B></CENTER></FONT>
</TD></TR>

<TR bgColor=#fffff>
<TD height="392" valign="top">
<table border="0" width="100%">
<tr>
<td align="left" valign="top">
<FONT face="Verdana, Arial" size=2>
{* BLOGS *}            
	{mask:blog}
	<a href="{author_url_blogs}"><b>{author}</b></a> Posted: <br>
	<U><FONT COLOR=green>
		{subject}
		{mis:subject}<i>No Subject</i>{/}
	</FONT></U> {date}<BR>
	{body}<br>
	{set:mood}<b>Mood:</b> {mood}<br>{/set}
	{set:custom_text}<b>{custom_title}:</b> {custom_text}<br>{/set}

	{set:comments}
		<a href="{comments_url}">Comments: {comments_num}</a>
	{/set}
	{mis:comments}
		Comments: <i>Disabled</i>
	{/mis}            	
	<BR><BR>
{/mask}
	</font>

{* COMMENTS *}

{set:view_comments}
{mask:list_comments}
	<table width="100%"><tr><td align="left" valign="top">
	<FONT face="Verdana, Arial" size=2>
	{set:avatar}<a href="{author_url_profile}"><img src="{avatar_url}" align="left"></a>{/}
	{set:guest}
		<b>{author}</b>:
	{/set}
	{mis:guest}
		<a href="{author_url_blog}"><b>{author}</b></a>:
	{/mis}
	{body}
	</td></tr></table>
{/mask}
	<FONT face="Verdana, Arial" size=2>
	<center><b>Add Comment:</b>
	{add_comment}<br>{link_bbcode} {link_smiles} </center>

{/set}
	</td>            
<td width="10%" valign="top">
<div align="right">
<TABLE Width=120 CelLSpacing=0 Border=0 align=top bgcolor="#000000">
<TR>
<TD BGCOLOR="#b0bb9d" align="justify" bordercolor="#B0BB9D"> 
<B>  <Font Face="Verdana,Arial" Size=2 Color=black>
<CENTER>-(Navigate)-</CENTER></font></b>
</TD>
</TR>

<TR>
<TD BGCOLOR="#88aa88" bordercolor="#B0BB9D" align="left"> <Font Face="Verdana,Arial" Size=2>

{* NAVIGATION *}

<TABLE>
  	<TR><TD> <font size=2 face="Verdana"> <a href="{url_home}">Home</a> </font></TD></TR>
<TR><TD> <font size=2 face="Verdana"> <a href="{url_profile}">Profile</a> </font></TD></TR>
<TR><TD> <font size=2 face="Verdana"> <a href="{url_friends}">Friends</a> </font></TD></TR>

{set:url_page_prev}
<TR><TD> <font size=2 face="Verdana"> <a href="{url_page_prev}">Back a page</a> </font></TD></TR>
{/}

{set:url_page_next}
<TR><TD> <font size=2 face="Verdana"> <a href="{url_page_next}">Next Page</a> </font></TD></TR>
{/}

<TR><TD> <font size=2 face="Verdana"> <a href="%HOME_LINK%">%HOME%</a> </font></TD></TR>
<tr><td> {rss_img} </TD></TR>
	  
</TABLE>

<TABLE Width=120 CelLSpacing=0 Border=0 align=top bgcolor="#000000">
<TR>
<TD BGCOLOR="#b0bb9d" align="justify" bordercolor="#B0BB9D"> 
<B>  <Font Face="Verdana,Arial" Size=2 Color=black>
<CENTER>-(My Friends)-</CENTER></font></b>
</TD>
</TR>
{* FRIENDS LIST *}
<TABLE>
{mask:friend_list}
<TR><TD> <font size=2 face="Verdana"> <a href="{url_blogs}">{name}</a> </font></TD></TR>
{/mask}
</table>
			

    			</font>
    			</td>
    			</tr>
			  </TABLE>
   
   			  </font>
   		     </div>
   		     </TD>
   		     </TR>
      </TABLE>
   
      <TR bgColor=#b0bb9d>
      <TD height="18" valign="top"><FONT face="Verdana, Arial" size=2>
      <CENTER><B>=(&copy; 2004 {username})=
      </B></CENTER></FONT>
      </TD></TR>
   </TABLE>

  </TD></TR>
</TABLE>

<CENTER></CENTER>
</BODY>
<!--
	Template: Green Envy
	Source: www.oswd.org
	Author: Mystic [http://www.oswd.org/userinfo.phtml?user=Mystic]
-->