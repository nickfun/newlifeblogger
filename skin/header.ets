 
{mask:main}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>

<!--
	layout based on ArtisticO by iamthebest2
	Free template from oswd.org
-->

<HEAD>
<TITLE>{main_title}</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<META NAME="DESCRIPTION" 	CONTENT="Free Multi-User web log software">
<META NAME="KEYWORDS" 		CONTENT="Free, Blog, web log, NewLife, NewLife Blogger, NLB, Sevengraff, GPL, Multi-User">
<META NAME="AUTHOR" 		CONTENT="Sevengraff">
<LINK HREF="{script_path}skin/style.css" TYPE="text/css" REL="stylesheet"> 
</HEAD>

<BODY>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<script language="JavaScript" src="{script_path}skin/overlib.js"></script>
<!-- 
	ToolTips by OverLib
	http://www.bosrup.com/web/overlib/
	overLIB (c) Erik Bosrup 
-->
<script language="JavaScript" type="text/javascript">
var ol_offsetx 		= 15;
var ol_fgcolor 		= "#D3DEE4";
var ol_bgcolor 		= "#000000";
var ol_capcolor 	= "#ffffff";
var ol_closecolor 	= "#ffffff";
var ol_width 		= "250";
</script>

<TABLE WIDTH="97%" BORDER="0" CELLSPACING="1" CELLPADDING="0" BGCOLOR="#000000" ALIGN="center">
	<TR>
		<TH COLSPAN="3"> 
			<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
				<TR>
					<TD CLASS="bg" HEIGHT="31" ALIGN="left">&nbsp;<FONT SIZE=4><B>NewLife Blogger v3.0</B></FONT></TD>
					<TD CLASS="bg" WIDTH="224" HEIGHT="31" ALIGN="right">
						<a href="http://www.sevengraff.com"><FONT color="black" SIZE=2>sevengraff.com</FONT></a>
						&nbsp;&nbsp;
					</TD>
				</TR>
			 </TABLE>
		</TH>
	</TR>

	<TR>
		<TD VALIGN="top" width="15%" BGCOLOR="#ffffff"><BR>
			<TABLE CELLSPACING="0" CELLPADDING="0" WIDTH="100%" BORDER="0">
				<TR>
					<TD CLASS="mltop">Options</TD>
				</TR>
				<TR>
					<TD CLASS="ml">
					{mask:sitenav}
						» <A CLASS="menubar" HREF="{link}">{text}</A><BR> {/mask}
					</TD>
				</TR>
			</TABLE><BR>
		{set:usernav}
			<TABLE CELLSPACING="0" CELLPADDING="0" WIDTH="100%" BORDER="0">
				<TR>
					<TD CLASS="mltop">{navtype}</TD>
				</TR>
				<TR>
					<TD CLASS="ml">
					{mask:usernav}
						» <A CLASS="menubar" HREF="{link}">{text}</A><BR> {/mask}
					</TD>
				</TR>
		 	</TABLE><BR>
		{/set}
		<!-- Buttons and credits -->
			<TABLE CELLSPACING="0" CELLPADDING="0" WIDTH="100%" BORDER="0">
				<TR>
					<TD CLASS="mltop">Credits</TD>
				</TR>
				<TR>
					<TD CLASS="ml">
						<A CLASS="menubar" HREF="http://www.php.net" target="_blank" onMouseOver="return overlib('PHP: Hypertext Preprocessor')" onMouseOut="nd();"><img src="{script_path}skin/powered_php.png"></A><BR>
						<A CLASS="menubar" HREF="http://www.mysql.org" target="_blank" onMouseOver="return overlib('MySQL Database');" onMouseOut="nd();"><img src="{script_path}skin/powered_mysql.png"></a><br>
						<A CLASS="menubar" HREF="http://www.sevengraff.com" target="_blank" onMouseOver="return overlib('Sevengraff Unlimited Media')" onMouseOut="nd();"><img src="{script_path}skin/powered_sum.gif"></A><BR>
						<A CLASS="menubar" HREF="http://ets.sf.net" target="_blank" onMouseOver="return overlib('ETS: Easy Template System')" onMouseOut="nd();"><img src="{script_path}skin/powered_ets.gif"></A><BR><BR>
					</TD>
				</TR>
			</TABLE><BR>
		</TD>
		<TD CLASS="content" VALIGN="top" align="left"><BR>
			<div class="title">{page_title}</div>
<!-- Begin Content -->

{/mask}