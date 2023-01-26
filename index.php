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
	<?php include "dig.php"; ?>

	<div class="flex-container">

		<div class="flex-item item1">


			<form id="form" action="index.php" method="get">

				<?php
				$domain = $_GET["domain"];
				$recType = $_GET["type"];
				?>

				<div class="inner">
					<div class="input-outer">

						<div class="inner-flex">
							<div class="input-flex">
								<input id="input" class="input" type="text" name="domain" placeholder="Enter Domain"
									value="<?php echo $domain ?>" />
								<button class="button" type="submit">Dig</button>
							</div>

							<div class="types">
								<span class="typetext">Type:</span>
								<input type="checkbox" id="Arec" name="type[]" value="A" <?php ischecked($recType, "A") ?> />
								<label for="Arec">A</label>

								<input type="checkbox" id="AAAArec" name="type[]" value="AAAA" <?php ischecked($recType, "AAAA") ?> />
								<label for="AAAArec">AAAA</label>

								<input type="checkbox" id="CNAMErec" name="type[]" value="CNAME" <?php ischecked($recType, "CNAME") ?> />
								<label for="CNAMErec">CNAME</label>

								<input type="checkbox" id="MXrec" name="type[]" value="MX" <?php ischecked($recType, "MX") ?> />
								<label for="MXrec">MX</label>

								<input type="checkbox" id="NSrec" name="type[]" value="NS" <?php ischecked($recType, "NS") ?> />
								<label for="NSrec">NS</label>

								<input type="checkbox" id="TXTrec" name="type[]" value="TXT" <?php ischecked($recType, "TXT") ?> />
								<label for="TXTrec">TXT</label>
							</div>
						</div>

					</div>



					<!-- Will add other settings here -->



				</div>
			</form>
		</div>

		<div class="flex-item item2">
			<div id="answer-section">
				<!-- <hr class="pc-visible"> -->
				<?php
				foreach ($recType as $type) {
					dig($domain, $type);
					// echo $type."<br />";
				}
				?>
			</div>
		</div>

	</div>
	<script>
		var answer = document.getElementsByClassName('answer');
		var answerSection = document.getElementById('answer-section');
		var input = document.getElementById('input');

		//old code for removin answers one by one
		// if (!input.value) {
		// 	Array.prototype.forEach.call(answer, function (element) {
		// 		element.classList.add('hidden');
		// 	});
		// }

		if (!input.value) {
			answerSection.classList.add('hidden');
		}

		Array.prototype.forEach.call(answer, function (element) {
			if (!element.querySelector('span').innerHTML) {
				element.querySelector('span').innerHTML = "No results for " + element.id + " record.";
			}
		});
	</script>
</body>

</html>