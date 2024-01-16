<?php

class HomophonicCipher
{
    private $key;

    public function HomophonicCipher($key)
    {
        $this->key = $key;
    }

    public function encrypt($plaintext)
    {
        $encryptedText = '';
        $plaintext = strtoupper($plaintext);

        for ($i = 0; $i < strlen($plaintext); $i++) {
            $char = $plaintext[$i];

            if ($char >= 'A' && $char <= 'Z') {
                $index = ord($char) - ord('A');
                if (isset($this->key[$index])) {
                    $randomSubstitution = $this->key[$index][array_rand($this->key[$index])];
                    $encryptedText .= $randomSubstitution . ' ';
                }
            } else {
                $encryptedText .= $char;
            }
        }

        return trim($encryptedText);
    }

    public function decrypt($ciphertext)
    {
        $decryptedText = '';
        $ciphertext = strtoupper($ciphertext);
        $substitutions = array_flip($this->key);

        $words = explode(' ', $ciphertext);

        foreach ($words as $word) {
            $found = false;

            foreach ($this->key as $index => $substitutionArray) {
                if (in_array($word, $substitutionArray)) {
                    $decryptedText .= chr($index + ord('A'));
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $decryptedText .= $word;
            }
        }

        return $decryptedText;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $key = [
        0 => ['A', 'B', 'C'],
        1 => ['D', 'E'],
        2 => ['F', 'G', 'H'],
		3 => ['I', 'J', 'K'],
		4 => ['L', 'M', 'N'],
		5 => ['O', 'P', 'Q'],
		6 => ['R', 'S', 'T']
        // ... add more substitutions as needed
    ];

    $cipher = new HomophonicCipher($key);

    if (isset($_POST["encrypt"])) {
        $plaintext = $_POST["plaintext"];
        $ciphertext = $cipher->encrypt($plaintext);
    }

    if (isset($_POST["decrypt"])) {
        $ciphertext = $_POST["ciphertext"];
        $decryptedText = $cipher->decrypt($ciphertext);
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
  <title>Homophonic Cipher</title>
    </head>
    <body>
     <?php include 'NavBar.php'; ?>
     <?php include 'sidebar.php'; ?>
     <div class="card" style="margin-left: 225px; margin-right: 200px; border: none; margin-top: 80px;">
     <h2 class="card-header" style="font-weight: 800; background-color: white;">HOMOPHONIC CIPHER</h2>
<body>

<body>
    <h1>Homophonic Cipher</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="plaintext">Plaintext:</label>
        <input type="text" id="plaintext" name="plaintext" value="<?php echo isset($plaintext) ? htmlspecialchars($plaintext) : ''; ?>" required>
        <button type="submit" name="encrypt">Encrypt</button>
        <br><br>
        <label for="ciphertext">Ciphertext:</label>
        <input type="text" id="ciphertext" name="ciphertext" value="<?php echo isset($ciphertext) ? htmlspecialchars($ciphertext) : ''; ?>" required>
        <button type="submit" name="decrypt">Decrypt</button>
        <br><br>
        <label for="decryptedText">Decrypted Text:</label>
        <input type="text" id="decryptedText" name="decryptedText" value="<?php echo isset($decryptedText) ? htmlspecialchars($decryptedText) : ''; ?>" readonly>
    </form>
</body>


</html>