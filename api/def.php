<!DOCTYPE html>
<html>
<head>
	<title>Sveriges Radio API</title>
</head>
<body>

	<h1>Sveriges Radio API</h1>
	
	<p>
		<table cellpadding="5">
			<tr>
				<th align="left" width="200">Method</th>
				<th align="left">What to expect</th>
			</tr>
			
			<tr>
				<td valign="top">/api/v1/hello</td>
				<td valign="top">Handshake. Returns current date.</td>
			</tr>
			
			<tr>
				<td valign="top">/api/v1/artist?s=%s</td>
				<td valign="top">Search for artist and return a list of plays</td>
			</tr>
			
			<tr>
				<td valign="top">/api/v1/song?s=%s</td>
				<td valign="top">Search song and get plays</td>
			</tr>
			
			<tr>
				<td valign="top">/api/v1/toplist?start=%d&end=%d</td>
				<td valign="top">Get a toplist of most played songs</td>
			</tr>
		</table>
	</p>

</body>
</html>
