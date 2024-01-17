  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vigenere Cipher</title>
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
    </style>
</head>
<body>
<?php include 'NavBar.php'; ?>
  <?php include 'sidebar.php'; ?>
    	<div class="card" style="margin-left: 225px; margin-right: 200px; border: none; margin-top: 80px;">
        <h1 class="card-header" style="font-weight: 800; background-color: white;"> VIGINERE CIPHER </h1>
        <div class="card-body">

	<p class="card-text">
          The Vigenère cipher is a method of encrypting alphabetic text by using a simple form of polyalphabetic substitution. 
	  It was invented by the 16th-century French diplomat and cryptographer Blaise de Vigenère. The Vigenère cipher is more secure than 
	  simpler substitution ciphers, as it uses a keyword to determine the shift value for each letter in the plaintext. This makes it resistant 
	  to frequency analysis, a common technique used to break classical ciphers.
        </p>

	<h2 class="" style="text-align: center;"> </h2>
        <h2 class="" style="text-align: center; font-weight: 600;"> Encryption </h2>
        <p class="card-text">
	<ol>
	<li>
         Select a keyword that will be used for encryption. The keyword will then be repeated to match the length of the plaintext.
	</li>
	<li>
	 Assign a number to each letter in the plaintext. For example, A=0, B=1, ..., Z=25.
        </li>
	<li>
	Repeat the keyword until it matches the length of the plaintext.
	</li>
	<li>
	For each letter in the plaintext, add the corresponding letter of the keyword to it (mod 26). 
	This will give you the encrypted text.
	</li>
	</ol> 
	</p>

	<p class="card-text">
        <br> Example: </br>
	<br> Let's say we want to encrypt the message "BUTTERFLY" with the keyword "HONEY" </br>
	<br> Plaintext: BUTTERFLY </br>
	<br> Keyword: HONEY </br>
        </p>

        <div className="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; padding-left: 10px;">
          <div className="card-body">
            <span> Now, convert each letter to its numerical equivalent (A=0, ..., Z=25). </span> <br />
            <span> - B -> 1 </span><br />
            <span> - U -> 20 </span><br/>
            <span> - T -> 19 </span><br/>
	    <span> - T -> 19 </span><br/>
            <span> - E -> 4 </span><br/>
            <span> - R -> 17 </span><br/>
	    <span> - F -> 5 </span><br/>
	    <span> - L -> 11 </span><br/>
	    <span> - Y -> 24 </span><br/>
          </div>
        </div>
        </p>

	<div className="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; padding-left: 10px; text-align: center">
          <div className="card-body">
            <span> Now add the corresponding letters of the keyword: </span> <br />
            <span> - B + H = 1 + 7 = 8 -> I </span><br />
            <span> - U + O = 20 + 14 = 8 -> I</span><br/>
            <span> - T + N = 19 + 13 = 6 -> G </span><br/>
	    <span> - T + E = 19 + 4 = 23 -> X </span><br/>
            <span> - E + Y = 4 + 24 = 2 -> C </span><br/>
            <span> - R + H = 17 + 7 = 24 -> </span><br/>
	    <span> - F + O = 5 + 14 = 19 -> T </span><br/>
	    <span> - L + N = 11 + 13 = 24 -> Y </span><br/>
	    <span> - Y + H = 24 + 7 = 1 -> A </span><br/>
          </div>
        </div>
	<p>
	So, the encrypted message is "IIGXCYTYA."
        </p>

	<h2 class="" style="text-align: center;"> </h2>
        <h2 class="" style="text-align: center; font-weight: 600;"> Decryption </h2>
	<p>
	Decryption is similar to encryption, but you subtract the corresponding letters of the keyword from the ciphertext.
	</p>
	
	<p class="card-text">
	<ol>
	<li>
        Keyword is the same as in encryption.
	</li>
	<li>
	The same as encryption, convert the Text to Numbers.
        </li>
	<li>
	Repeat Keyword to match the length of the plaintext.
	</li>
	<li>
	For each letter in the ciphertext, subtract the corresponding letter of the keyword from it (mod 26). 
	This will give you the decrypted text.
	</li>
	</ol> 

	<div className="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; padding-left: 10px; text-align: center">
          <div className="card-body">
            <span> Now add the corresponding letters of the keyword: </span> <br />
            <span>- I - H = 8 - 7 = 1 -> B </span><br />
            <span> - I - O = 8 - 14 = 20 -> U </span><br/>
            <span> - G - N = 6 - 13 = 19 -> T </span><br/>
	    <span> - G - N = 6 - 13 = 19 -> T </span><br/>
            <span> - C - Y = 2 - 24 = 4 -> E </span><br/>
            <span>  - Y - H = 24 - 7 = 17 -> R </span><br/>
	    <span>  - T - O = 19 - 14 = 5 -> F </span><br/>
	    <span>  - Y - N = 24 - 13 = 11 -> L </span><br/>
	    <span> - A - H = 1 - 7 = 20 -> Y </span><br/>
          </div>
        </div>
	
	<p style="text-align: center;"> 
	So, the decrypted message is "BUTTERFLY."
	</p>
	
	<p style="text-align: center;">
	The Vigenère cipher provides a stronger level of security compared to simpler ciphers, but it can still be susceptible 
	to attacks, especially if the key is short or if certain patterns exist in the plaintext.
	</p>

<?php
    function vigenereEncrypt($plaintext, $key) {
        $keyLength = strlen($key);
        $encryptedText = '';

        for ($i = 0; $i < strlen($plaintext); $i++) {
            if ($plaintext[$i] == ' ') {
               
                $encryptedText .= ' ';
                continue;
            }

            $char = $plaintext[$i];
            $keyChar = $key[$i % $keyLength];

            $encryptedChar = chr(((ord($char) + ord($keyChar)) % 26) + ord('A'));

            $encryptedText .= $encryptedChar;
        }

        return $encryptedText;
    }

    function vigenereDecrypt($encryptedText, $key) {
        $keyLength = strlen($key);
        $decryptedText = '';

        for ($i = 0; $i < strlen($encryptedText); $i++) {
            if ($encryptedText[$i] == ' ') {
              
                $decryptedText .= ' ';
                continue;
            }

            $char = $encryptedText[$i];
            $keyChar = $key[$i % $keyLength];

            $decryptedChar = chr(((ord($char) - ord($keyChar) + 26) % 26) + ord('A'));

            $decryptedText .= $decryptedChar;
        }

        return $decryptedText;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $plaintext = strtoupper($_POST['plaintext']);
        $key = strtoupper($_POST['key']);

        if (isset($_POST['encrypt'])) {
            $resultText = vigenereEncrypt($plaintext, $key);
            $resultType = 'Encrypted';
        } elseif (isset($_POST['decrypt'])) {
            $resultText = vigenereDecrypt($plaintext, $key);
            $resultType = 'Decrypted';
        }

        echo "<p>Plaintext: $plaintext</p>";
        echo "<p>Key: $key</p>";
        echo "<p>$resultType Text: $resultText</p>";
    }
    ?>
  
  <h6 class=""style="text-align: center; font-weight: 600;">Try it yourself</h6>
    <div class="card" style=" width: 32rem; border: none; margin: auto; text-align: center;">
    <form method="post" action="">
        <label for="plaintext">Enter Text:</label><br/>
        <input type="text" id="plaintext" name="plaintext" required> <br/>
        <label for="key">Enter Key:</label><br/>
        <input type="text" id="key" name="key" required><br/>
        <button type="submit" name="encrypt" class="btn btn-success">Encrypt</button>
        <button type="submit" name="decrypt" class="btn btn-primary" style="background-color: rgb(42, 42, 44)">Decrypt</button>
    </form>
    </div>


	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
 	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
