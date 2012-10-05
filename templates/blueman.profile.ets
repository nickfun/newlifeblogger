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
	 {set:avatar}<p>{avatar}</p>{/set}
	 <p><a href="%HOME_LINK%">%HOME%</a></p>
	 <p>{rss_img}</p>
    </td>
    <td bgcolor="#ffffff" valign=top>
		<!-- heading -->
		<div class="heading">. [ {username} ] .</div>

		<div class="bar">{username}'s Profile</div>

		<div class="blog">
		
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
		
		</div>
      
    <!-- end body -->
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