<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>DigTool</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
</head>

<body>

	<div class="form">

		<form id="form" action="index.php" method="get">

			<?php
			$domain = $_GET["domain"];
			$recType = $_GET["type"];

			function ischecked($recType, $value)
			{
				foreach ($recType as $type) {
					if ($type == $value) {
						echo "checked='checked'";
					}
				}
			}
			?>

			<div class="inner">
				<div class="input-outer">
					<input id="input" class="input" type="text" name="domain" placeholder="Enter Domain"
						value="<?php echo $domain ?>">
					<!-- <button class="button" type="submit">Dig</button> -->

					<div class="types">
						<input type="checkbox" id="Arec" name="type[]" value="A" <?php ischecked($recType, "A") ?>
							onchange="document.getElementById('form').submit()">
						<label for="Arec">A</label>

						<input type="checkbox" id="CNAMErec" name="type[]" value="CNAME" <?php ischecked($recType, "CNAME") ?> onchange="document.getElementById('form').submit()">
						<label for="CNAMErec">CNAME</label>

						<input type="checkbox" id="MXrec" name="type[]" value="MX" <?php ischecked($recType, "MX") ?>
							onchange="document.getElementById('form').submit()">
						<label for="MXrec">MX</label>

						<input type="checkbox" id="NSrec" name="type[]" value="NS" <?php ischecked($recType, "NS") ?>
							onchange="document.getElementById('form').submit()">
						<label for="NSrec">NS</label>

						<input type="checkbox" id="TXTrec" name="type[]" value="TXT" <?php ischecked($recType, "TXT") ?>
							onchange="document.getElementById('form').submit()">
						<label for="TXTrec">TXT</label>
					</div>
				</div>

				<div id="answer-section">
					<hr>
					<!-- <div id="answer"> -->
					<?php

					function dig($domain, $type)
					{

						if (isset($domain)) {

							$resolver = "8.8.8.8";

							$command = 'dig ' . $domain . " " . $type . " " . ' +short @' . $resolver;

							$escaped_command = escapeshellcmd($command);

							$output = shell_exec($escaped_command);

							echo "<div class='answer' id='". $type ."'>";
							echo "<span>";

							if (preg_match("/[a-z]/i", $output) && $type == "A") {
								$arr = explode("\n", $output);
								echo "CNAME: ";
								if(!empty($output)){
									
									for ($i = 0; $i <= 3; $i++) {
										echo $arr[$i];
										echo "<br>";
									}
								}else{
									$output = "No results.";
								}
								
							} else {
								if(empty($output)){
									$output = "No results.";
								}
								echo $type . ": ";

								if(strlen($output) > 25 && $type != "TXT"){
									$arr = explode("\n", $output);
									for ($i = 0; $i <= 3; $i++) {
										echo $arr[$i];
										echo "<br>";
									}
								}else{
									echo $output;
								}
							}

							echo "</span>";
							echo "</div>";
						}

					}

					foreach ($recType as $type) {
						dig($domain, $type);
						// echo $type."<br />";
					}
					?>
					<!-- </div> -->
				</div>

				<script>
					var answer = document.getElementsByClassName('answer');
					var answerSection = document.getElementById('answer-section');
					var input = document.getElementById('input');
					if (!input.value) {
						Array.prototype.forEach.call(answer, function (element) {
							element.classList.add('hidden');
						});

					}

					Array.prototype.forEach.call(answer, function (element) {
							if(!element.querySelector('span').innerHTML){
								element.querySelector('span').innerHTML = "No results for " + element.id + " record.";
							}
						});
				</script>
			</div>
		</form>
	</div>


</body>

</html>