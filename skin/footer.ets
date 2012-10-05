
{mask:main}

<!-- End of Content -->
<br>
		</TD>
		<TD VALIGN="top" width="15%" BGCOLOR="#ffffff">
			<br>
			<!-- User Welcome Table -->
			<TABLE CELLSPACING="0" CELLPADDING="0" WIDTH="98%" BORDER="0">
				<tr>
					<td class="mltop">Welcome</td>
				</tr>
				<tr>
					<TD CLASS="ml">
					{mask:welcome}
						{set:username}
							Hello {username}!
							<li><a class="menubar" href="{url_cp}">Post Blog</a>
							<li><a class="menubar" href="{url_blogs}">View Blogs</a>
							<li><a class="menubar" href="{url_friends}">Friends Page</a>
							<li><a class="menubar" href="{url_logout}">Logout</a>
						{/}
						{mis:username}
							Hi guest, please
							<a class="menubar" href="{url_login}">Login</a>
							or <a class="menubar" href="{url_register}">Register</a>	
						{/}
					{/mask}
					</td>
				</tr>
			</TABLE><BR>
			<!-- end user welcome table -->
						
			<!-- Recen Blogs Table -->
			<TABLE CELLSPACING="0" CELLPADDING="0" WIDTH="100%" BORDER="0">
				<TR>
					<TD CLASS="mltop">Recent Blogs</TD>
				</TR>
				{mis:recent_blogs}<tr><TD CLASS="ml">No new Blogs</td></td>{/mis}
				{mask:recent_blogs}
				<tr>
					<TD CLASS="ml">
						<A CLASS="menubar" 
							HREF="{url_blog}" 
							onMouseOver="return overlib('Posted by {author}<br>At: {date}<br>Comments: {const:c}', LEFT);" 
							onMouseOut="nd();">
						{const:s}</A>
					</td>
				</tr>
				{/mask}
			</TABLE><BR>
			<!-- end recent blogs table -->
		</TD>
	</TR>
</TABLE>

<TABLE WIDTH="97%" BORDER="0" CELLSPACING="1" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD ALIGN="center" class="copyright">
			Powered by <a href="http://www.sevengraff.com" target="_blank" onMouseOver="return overlib('NewLife Blogging System v 3.0<br>&copy Copyright 2004 Sevengraff', ABOVE, CENTER);" onMouseOut="nd();"><b>NewLife Blogger</b></a>
			<br>
			Generated in {gen_time} seconds using {query_count} queries.
		</TD>
	</TR>
</TABLE>
<br>
</BODY>
</HTML>
<!--
	layout based on ArtisticO by iamthebest2
	Free template from oswd.org
-->
{/mask}

{mask:s}{subject}{mis:subject}<i>No Subject</i>{/mis}{/mask}
{mask:c}{comments}{mis:comments}<i>disabled</i>{/mis}{/mask}