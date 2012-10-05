<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>{username}: Blogs</TITLE>
<META content="text/html; charset=windows-1252" http-equiv=Content-Type>
<style type="text/css">
<!--
img { border: 0; }
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
        
{* PROFILE TAGS *}
	<table width="90%" align="center">
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