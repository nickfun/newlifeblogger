<html>
<head>
<title>
{username}'s Friends
</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
{#
.brsmt {  border: #000000 solid; border-width: 2px 0px 0px 2px}
.tl { border: #000000 solid; border-width: 0px 2px 2px 0px}
td {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 80%}
.nutrition {  font-size: 280%; font-weight: bold; text-decoration: underline}
a {  color: #003399; text-decoration: none}
.menu {  font-size: 75%; padding-right: 5px; padding-left: 5px}
a:hover {  color: #286FFF; text-decoration: none}
.bl {  border-color: #000000 black; border-style: solid; border-top-width: 2px; border-right-width: 2px; border-bottom-width: 0px; border-left-width: 0px; color: #FFFFFF; font-size: 70%}
#}
-->
</style>
</head>
<body bgcolor="#666699" text="#000000">
<table width="500" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td bgcolor="#000000">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#EEEEEE" align="left">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" align="left">
                  <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50" height="50" bgcolor="#444466" class="tl">&nbsp;
                      </td>
                      <td align="right" valign="top">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td bgcolor="#9898BA" width="25" height="25" class="tl">&nbsp;</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td valign="bottom">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td bgcolor="#9898BA" width="25" height="25" class="tl">&nbsp;</td>
                          </tr>
                        </table>
                      </td>
                      <td valign="bottom">&nbsp; </td>
                    </tr>
                  </table>
                </td>
                <td valign="top" align="right">
                  <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="nutrition" align="right">
                        BLOGS
                      </td>
                    </tr>
                    <tr>
                      <td align="right">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <!-- Menu (HINT: Each item is inside a <td>.)-->
                            <td class="menu"> <a href="{url_home}">Home</a> </td>
                            <td class="menu"> <a href="{url_profile}">Profile</a> </td>
                            <td class="menu"> <a href="{url_friends}">Friends </td>
							<td class="menu"> <a href="{rss_url}">RSS Feed</a> </td>
{set:url_page_prev}         <td class="menu"> <a href="{url_page_prev}">Newer Blogs</a> </td> {/set}
{set:url_page_next}         <td class="menu"> <a href="{url_page_next}">Older Blogs</a> </td> {/set}
                            <!-- Close Menu -->
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td bgcolor="#EEEEEE">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="10">
                    <tr>
                      <td>
{* ======== TEMPLATE BODY BEGINS ======== *}

{mask:blog}
	{set:avatar}<img src="{avatar_url}" align="right">{/set}
	<b>[ {subject}
	{mis:subject}
		<i>No Subject</i>
	{/mis}
	 ]</b> by {author}<br>
	{date}<br>
	{body}<br>
	{set:mood}<b>Mood:</b> {mood}<br>{/set}
	{set:custom_text}<b>{custom_title}:</b> {custom_text}<br>{/set}

	{set:comments}
		<a href="{comments_url}">Comments: {comments_num}</a>
	{/set}
	{mis:comments}
		Comments: <i>Disabled</i>
	{/mis}

	<br><br>
{/mask}

{* ======== TEMPLATE BODY ENDS ======== *}
                      </td>
                    </tr>
                  </table>
                  <table border="0" cellspacing="0" cellpadding="3">
                    <tr>
                      <td class="bl" bgcolor="#777777" nowrap>
                        <a href="%HOME_LINK%"><font color="white"><u>%HOME%</u></font></a>
                      </td>
                    </tr>
                  </table>
                </td>
                <td width="79" align="right" valign="bottom">
                  <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>&nbsp;</td>
                      <td align="right">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td bgcolor="#9898BA" width="25" height="25" class="brsmt">&nbsp;</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td valign="bottom">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td bgcolor="#9898BA" width="25" height="25" class="brsmt">&nbsp;</td>
                          </tr>
                        </table>
                      </td>
                      <td width="50" height="50" bgcolor="#444466" class="brsmt">&nbsp;
                      </td>
                    </tr>
                  </table>
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
	Author: BrAInDeD- [http://www.oswd.org/userinfo.phtml?user=BrAInDeD-]
-->