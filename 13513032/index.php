<!DOCTYPE html>

<html>
	<head>
		<title>Simple StackExchange</title>
		<link href="style.css" rel="stylesheet" type="text/css"></link>
	</head>

	<body>
		<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$database = "database032";	// Nama database

			// Membuat koneksi
			$connection = mysqli_connect($servername, $username, $password, $database);

			// Mengecek koneksi
			if (!$connection) {
			    die("Connection failed: " . mysqli_connect_error());
			}
		?>

		<h1>Simple StackExchange</h1>
		
		<form class="center">
			<input id="searchBox" type="text"></input>
			<input id="searchButton" type="button" value="Search"></input>
		</form>

		<div class="center" style="margin-top:6px">
			Cannot find what you are looking for? <a href="askQuestion.html" style="color:orange"><b>Ask here</b></a>
		</div>

		<?php
			$query = "	select questionid, questionname, questiontopic, questioncontent, questionvotes, questiondatetime
						from questions
						order by questiondatetime asc";
			$results = mysqli_query($connection, $query);
			
			if (mysqli_num_rows($results) > 0) {	// Database pertanyaan tidak kosong
				echo "<h3>Recently Asked Questions</h3>
				<p class='questionBoundary'></p>";
				
				// Menampilkan setiap pertanyaan dari database
				while ($result = mysqli_fetch_assoc($results)) {
					// Query untuk memperoleh jawaban-jawaban dari pertanyaan yang memiliki id tertentu
					$answerQuery = "select questionid
									from answers
									where questionid = ".$result["questionid"];
					$answerResults = mysqli_query($connection, $answerQuery);

					echo "<questionTopic>".$result["questiontopic"]."</questionTopic>

					<p style='margin-top:0px'>
						<votes>".$result["questionvotes"]." Votes</votes>
						<answers>".mysqli_num_rows($answerResults)." Answers</answers>
						<questionContent>".$result["questioncontent"]."</questionContent>
					</p>

					<p class='askedBy'>
						asked by <b><span style='color:purple'>".$result["questionname"]."</span>|<span style='color:orange'>edit</span>|<span style='color:red'>delete</span></b>
					</p>";
				}
			}
		?>

		<?php
			mysqli_close($connection);
		?>
	</body>
</html>