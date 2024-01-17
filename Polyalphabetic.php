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

        $encryptedChar = chr(((ord($char) - ord('A') + ord($keyChar) - ord('A')) % 26) + ord('A'));

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

        $decryptedChar = chr(((ord($char) - ord('A') - (ord($keyChar) - ord('A')) + 26) % 26) + ord('A'));

        $decryptedText .= $decryptedChar;
    }

    return $decryptedText;
}

function displayResult($plaintext, $key, $resultType, $resultText) {
    echo "<p>Plaintext: $plaintext</p>";
    echo "<p>Key: $key</p>";
    echo "<p>$resultType Text: $resultText</p>";
}

// Initialize variables
$resultType = '';
$resultText = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize user input
    $plaintext = isset($_POST['plaintext']) ? strtoupper($_POST['plaintext']) : '';
    $key = isset($_POST['key']) ? strtoupper($_POST['key']) : '';

    if (!empty($plaintext) && !empty($key)) {
        if (isset($_POST['encrypt'])) {
            $resultText = vigenereEncrypt($plaintext, $key);
            $resultType = 'Encrypted';
        } elseif (isset($_POST['decrypt'])) {
            $resultText = vigenereDecrypt($plaintext, $key);
            $resultType = 'Decrypted';
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="C:\xampp\htdocs\cryptog\bootstrap\js\bootstrap.min.js"></script>
  <title>polyalphabetic Cipher</title>
</head>
<body>
  <?php include 'NavBar.php'; ?>
  <?php include 'sidebar.php'; ?>
  <div class="card" style="margin-left: 225px; margin-right: 200px; border: none; margin-top: 80px;">
  <h2 class="card-header" style="font-weight: 800; background-color: white;">POLYALPHABETIC CIPHER</h2>
      <div class="card-body">
        <h5 class="card-title">Polyalphabetic Cipher</h5>
        <p class="card-text">
        A polyalphabetic cipher is a substitution, using multiple substitution alphabets.
        The Vigenère cipher is probably the best-known example of a polyalphabetic cipher,
        though it is a simplified special case. The Enigma machine is more complex but is 
        still fundamental. Polyalphabetic Substitution Ciphers was the cryptographers answer
        to Frequency Analysis. The first known polyalphabetic cipher was the Alberti Cipher
        invented by Leon Battista Alberti in around 1467. He used a mixed alphabet to encrypt
        the plaintext, but at random points he would change to a different mixed alphabet,
        indicating the change with an uppercase letter in the ciphertext.<br>
        </p>
        
        <h6 class="" style="text-align: center;"> <img src= "/assets/p.png"> </h6>
        <h6 class="" style="text-align: center; font-weight: 600;">Encryption</h6>
        <p class="card-text">
        The first letter of the plaintext, G is paired with A, the first letter of the key.
        So use row G and column A of the Vigenère square, namely G. Similarly, for the second letter of the plaintext, 
        the second letter of the key is used, the letter at row E, and column Y is C. 
        The rest of the plaintext is enciphered in a similar fashion.
        As an example we shall encrypt the plaintext "leon battista alberti".
        To keep with the convention of writing ciphertext in uppercase, we shall invert Alberti's own rule,
        and use lowercase letters to signify the change.
         </p>
         
         <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span style="font-weight: 600;"> case is "a" is encrypted as "V", so we start the ciphertext with a lowercase "v".</span><br />
            <span>The "v" starting position of the disc, and the "g" indicates that we need to change the position so that "G" is beneath "a". </span><br />
            <span>final ciphertext "vGZJIWVOgZOYZGGmXNQDFU"</span> <img src= "/assets/o.png"><br>
          </div>
          </div>
        </div>
        <br/>
        <div class="card-body">
        <h6 class="" style="text-align: center; font-weight: 600;">Decryption</h6>
        <p class="card-text">
        
        Decryption is performed by going to the row in the table corresponding to the key, 
        finding the position of the ciphertext letter in this row, and then using the column’s label as the plaintext.
        For example, in row A (from AYUSH), the ciphertext G appears in column G, which is the first plaintext letter. 
        Next, we go to row Y (from AYUSH), locate the ciphertext C which is found in column E, thus E is the second plaintext letter.
        A more easy implementation could be to visualize Vigenère algebraically by converting [A-Z] into numbers [0–25]. 
        </p>
        </div>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span style="font-weight: 600;"> Encryption<br>
        The plaintext(P) and key(K) are added modulo 26.<br>
        Ei = (Pi + Ki) mod 26<br>

        Decryption<br>
        Di = (Ei - Ki) mod 26<br>
          </div>
        </div>
        <br/>
        <h6 class=""style="text-align: center; font-weight: 600;">Try it yourself</h6>
        <div class="card" style="width: 32rem; border: none; margin: auto; text-align: center;">
    <form method="post" action="">
        <label for="plaintext">Enter Text:</label>
        <input type="text" id="plaintext" name="plaintext" required>
        <br>
        <label for="key">Enter Key:</label>
        <input type="text" id="key" name="key" required>
        <br>
        <button type="submit" name="encrypt" class="btn btn-success">Encrypt</button>
        <button type="submit" name="decrypt" class="btn btn-primary" style="background-color: rgb(42, 42, 44);">Decrypt</button>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            displayResult($plaintext, $key, $resultType, $resultText);
        }
        ?>
    </form>
</div><hr/>
</body>
</html>