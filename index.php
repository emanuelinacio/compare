<!DOCTYPE html>
<html>
<head>
	<title>Compare Database</title>
</head>
<body>
	<div>
		<h2>IMPORTAÇÂO</h2>
		<form method="POST" action="upload/upload.php" enctype="multipart/form-data">
			<select name="database">			
				<option value="mongodb">Mongodb</option>
				<option value="mysql">Mysql</option>			
			</select>
			<br>
			<input name="userfile" type="file" />
			<input type="submit" value="Send File" />
		</form>
	</div>
	<hr>
	<div>
		<h2>Buscas</h2>
		<form method="GET" action="queries/queries.php">
			<select name="database">			
				<option value="mongodb">Mongodb</option>
				<option value="mysql">Mysql</option>			
			</select>
			<br>
			<select name="query">
				<option value="client">Clients</option>
			</select>			
			<input type="submit" value="Search" />
		</form>
	</div>	
</body>
</html>