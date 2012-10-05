 {mask:main}
<html>
	<head>
		<title>Insert...</title>
		<LINK HREF="{script_path}skin/style.css" TYPE="text/css" REL="stylesheet"> 
	</head>
	<body>
	
		{* MUST have this tag! *}
		{java_script}
			
		<table width="100%">
			<tr>
				<td width="50%">
					<font size="+1">
						<center>Icon</center>
					</font>
				</td>
				<td>
					<font size="+1">Description</font>
				</td>
			</tr>
			{mask:items}
			<tr>
				<td>
					<center>
					<a href="javascript:insertItem('{code}');"><img src="{img}" border="0"></a>
					</center>
				</td>
				<td>{desc}</td>
			</tr>
			{/mask}
		</table>
	<p>
	<center>
	<b>Powered by NewLife Blogger 3.0</b>
	</center>
	</p>
	</body>
</html>

{/mask}	