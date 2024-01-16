
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="C:\xampp\htdocs\cryptog\bootstrap\js\bootstrap.min.js"></script>
  <title>Autokey Cipher</title>
</head>
<body>
  <?php include 'NavBar.php'; ?>
  <?php include 'sidebar.php'; ?>
  <div class="card" style="margin-left: 225px; margin-right: 200px; border: none; margin-top: 80px;">
  <h2 class="card-header" style="font-weight: 800; background-color: white;">AUTOKEY CIPHER</h2>
      <div class="card-body">
        <h5 class="card-title">Autokey Cipher</h5>
        <p class="card-text">
          Autokey Cipher is a polyalphabetic substitution cipher. It is closely related to the Vigenere cipher but uses a different method of generating the key. It was invented by Blaise de Vigenère in 1586. <br/>
          Instead of a set key phrase, it uses earlier letters in the message as part of the code, making it harder to crack. Think of it like a lock key that changes as you insert it deeper, making it trickier to pick. <br/>
          This "self-keying" feature makes it more secure than simple substitution ciphers, but still vulnerable to clever codebreakers.
        </p>
        <img class="card-img-top mx-auto d-block" style="width: 30%; margin: 0;" src="/assets/Tabula Recta.jpg" alt="Tabula Recta">
        <h6 class="" style="text-align: center;">Tabula Recta</h6>
        <h6 class="" style="text-align: center; font-weight: 600;">Encryption</h6>
        <p class="card-text">
          Encryption using the Autokey Cipher is very similar to the Vigenère Cipher, except in the creation of the keystream.<br />
          The keystream is made by starting with the keyword or keyphrase, and then appending to the end of this the plaintext itself.<br />
          We then use a Tabula Recta to find the keystream letter across the top, and the plaintext letter down the left, and use the crossover letter as the ciphertext letter.
        </p>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span style="font-weight: 600;">Ci=(Pi + Ki) mod 26</span><br />
            <span style="font-weight: 600;">Plaintext: APPLE</span><br />
            <span>Autokey: M</span><br />
            <span style="font-weight: 600;">Encryption: </span><br />
            <span>-------------------------------- </span><br />
            <span style="font-weight: 600;">The Encrypted text is: MBBXQ</span><br />
          </div>
        </div>
        <br/>
        <h6 class="" style="text-align: center; font-weight: 600;">Decryption</h6>
        <p class="card-text">
          To decrypt a ciphertext using the Autokey Cipher, we start just as we did for the Vigenère Cipher, and find the first letter of the key across the top, find the ciphertext letter down that column, and take the plaintext letter at the far left of this row. <br />
          As well as being the plaintext letter, we now need to add this letter to the end of the keystream as we shall need it later.
          Continuing to decode each letter, we add them to the end of the keystream each time. The decryption function is: 
        </p>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span style="font-weight: 600;">Pi = (Ci - Ki) mod 26</span><br />
            <span>Encrypted text(C): MBBXQ</span><br />
            <span>Key(K): M</span><br />
            <span>-----------------------------------</span><br />
            <span>Decrypted Text: A P P L E</span><br />
          </div>
        </div>
        </br />
        </br />
        <?php
function encrypt($text, $key) {
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $keyLength = strlen($key);
    $encryptedText = '';

    for ($i = 0; $i < strlen($text); $i++) {
        $index = (strpos($alphabet, $text[$i]) + strpos($alphabet, $key[$i % $keyLength])) % 26;
        $encryptedText .= $alphabet[$index];

        // Append the plaintext letter to the key
        $key .= $text[$i];
    }

    return $encryptedText;
}

function decrypt($text, $key) {
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $keyLength = strlen($key);
    $decryptedText = '';

    for ($i = 0; $i < strlen($text); $i++) {
        $index = (strpos($alphabet, $text[$i]) - strpos($alphabet, $key[$i % $keyLength]) + 26) % 26;
        $decryptedText .= $alphabet[$index];

        // Append the decrypted letter to the key
        $key .= $decryptedText[$i];
    }

    return $decryptedText;
}


if (isset($_POST['encrypt'])) {
    $text = $_POST['text'];
    $key = $_POST['key'];
    $encryptedText = encrypt($text, $key);
    echo "<div class='text-center'><p class='card-text'>Encrypted Text: $encryptedText</p></div>";
} elseif (isset($_POST['decrypt'])) {
    $text = $_POST['text'];
    $key = $_POST['key'];
    $decryptedText = decrypt($text, $key);
    echo "<div class='text-center'><p class='card-text'>Decrypted Text: $decryptedText</p></div>";
}

?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-group" style="width: 32rem; border: none; margin: auto;">
        <label for="text">Text</label>
        <input type="text" class="form-control" id="text" name="text" required>
    </div>
    <div class="form-group" style="width: 32rem; border: none; margin: auto;">
        <label for="key">Key</label>
        <input type="text" class="form-control" id="key" name="key" required>
    </div>
    <br />
    <br /> 
    <div class="text-center">
        <h6>Try it yourself</h6>
        <button type="submit" name="encrypt" class="btn btn-success">Encrypt</button>
        <button type="submit" name="decrypt" class="btn btn-primary" style="background-color: rgb(42, 42, 44)">Decrypt</button>
    </div>
</form>


  </div>
  <?php include 'Footer.php' ;?>
</div>

 </div>
 
</body>
</html>