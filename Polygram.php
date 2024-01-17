<?php

function polygramEncrypt($plaintext, $key) {
    $plaintext = strtoupper($plaintext);
    $key = strtoupper($key);

    $encryptedText = '';
    $keyLength = strlen($key);
    $plaintextLength = strlen($plaintext);

    for ($i = 0; $i < $plaintextLength; $i++) {
        $char = $plaintext[$i];
        if ($char >= 'A' && $char <= 'Z') {
            $charIndex = ord($char) - ord('A');
            $keyIndex = $i % $keyLength;
            $shift = ord($key[$keyIndex]) - ord('A');
            $newCharIndex = ($charIndex + $shift) % 26;
            $newChar = chr($newCharIndex + ord('A'));
            $encryptedText .= $newChar;
        } else {
            // Non-alphabetic characters remain unchanged
            $encryptedText .= $char;
        }
    }

    return $encryptedText;
}

function polygramDecrypt($ciphertext, $key) {
    $ciphertext = strtoupper($ciphertext);
    $key = strtoupper($key);

    $decryptedText = '';
    $keyLength = strlen($key);
    $ciphertextLength = strlen($ciphertext);

    for ($i = 0; $i < $ciphertextLength; $i++) {
        $char = $ciphertext[$i];
        if ($char >= 'A' && $char <= 'Z') {
            $charIndex = ord($char) - ord('A');
            $keyIndex = $i % $keyLength;
            $shift = ord($key[$keyIndex]) - ord('A');
            $newCharIndex = ($charIndex - $shift + 26) % 26;
            $newChar = chr($newCharIndex + ord('A'));
            $decryptedText .= $newChar;
        } else {
            // Non-alphabetic characters remain unchanged
            $decryptedText .= $char;
        }
    }

    return $decryptedText;
}

// Initialize variables
$plaintext = '';
$key = '';
$ciphertext = '';
$decryptedText = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $plaintext = isset($_POST['plaintext']) ? $_POST['plaintext'] : '';
    $key = isset($_POST['key']) ? $_POST['key'] : '';

    // Encrypt the input
    $ciphertext = polygramEncrypt($plaintext, $key);

    // Decrypt the input
    $decryptedText = polygramDecrypt($ciphertext, $key);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polygram Cipher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }

        form {
            display: inline-block;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 300px;
            padding: 8px;
            margin-bottom: 16px;
        }

        button {
            padding: 10px;
        }

        .result {
            margin-top: 20px;
        }

	ul {
            list-style-type: disc; /* Use disc for a bullet point */
        }

        li {
            text-align: left; /* Align text to the left within list items */
        }
        .custom-btn-success {
      background: linear-gradient(to right, #28a745, #218838); /* Adjust the colors as needed */
      border: none;
      color: white;
    }
    </style>
</head>
<body>
<?php include 'NavBar.php'; ?>
  <?php include 'sidebar.php'; ?>
	

	<div class="card" style="margin-left: 225px; margin-right: 200px; border: none; margin-top: 80px;">
        <h1 class="card-header" style="font-weight: 800; background-color: white;"> POLYGRAM CIPHER </h1>
        <div class="card-body">
        
	<p class="card-text">
          The Polygram Substitution Cipher is a type of substitution cipher in cryptography where groups of consecutive letters, 
	  called polygrams, are replaced with corresponding groups of letters based on a predefined key. It is an extension of the simple 
	  substitution cipher, where individual letters are replaced, allowing for more complex and varied transformations.
        </p>

	<h2 class="" style="text-align: center;"> </h2>
        <h2 class="" style="text-align: center; font-weight: 600;">Key Setup</h2>
        <p class="card-text">
	<ul>
	<li>
         A key is created to define the substitutions for various polygrams.
	</li>
	<li>
	 The key consists of mappings between specific polygrams in the plaintext and their corresponding replacements in the ciphertext.
        </li>
	</ul> 
	</p>

	<h2 class="" style="text-align: center;"> </h2>
        <h2 class="" style="text-align: center; font-weight: 600;">Polygrams</h2>
        <p class="card-text">
	<ul>
	<li>
         In the Polygram Substitution Cipher, a polygram is a sequence of consecutive letters in the plaintext.
	</li>
	<li>
	 The length of the polygram can vary, and it depends on the specific design of the cipher.
        </li>
	</ul> 
	</p>

        
	<h2 class="" style="text-align: center;"> </h2>
        <h2 class="" style="text-align: center; font-weight: 600;">Encryption</h2>
        <p class="card-text">
	<ul>
	<li>
         The plaintext is divided into non-overlapping polygrams.
	</li>
	<li>
	 Each polygram is replaced with the corresponding polygram from the key.
        </li>
	</ul> 
	</p>

	<h2 class="" style="text-align: center;"> </h2>
        <h2 class="" style="text-align: center; font-weight: 600;">Decryption</h2>
        <p class="card-text">
	<ul>
	<li>
         The ciphertext is divided into non-overlapping polygrams.
	</li>
	<li>
	 Each polygram is replaced with the inverse substitution from the key to retrieve the original plaintext.
        </li>
	</ul> 
	</p>

    <h6 class=""style="text-align: center; font-weight: 600;">Try it yourself</h6>
        <div class="card" style=" width: 32rem; border: none; margin: auto;">
    <form method="post">
        <label for="plaintext">Enter Text:</label><br/>
        <input type="text" name="plaintext" id="plaintext" value="<?= htmlspecialchars($plaintext) ?>" required><br/>

        <label for="key">Enter Key:</label><br/>
        <input type="text" name="key" id="key" value="<?= htmlspecialchars($key) ?>" required><br/>

        <br>
        <button type="submit" class="btn btn-success custom-btn-success">Encrypt / Decrypt</button>
    </form>
    <div class="result">
        <p><strong>Encrypted Text:</strong> <?= htmlspecialchars($ciphertext) ?></p>
        <p><strong>Decrypted Text:</strong> <?= htmlspecialchars($decryptedText) ?></p>
    </div>
        </div>
    
	
	  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
