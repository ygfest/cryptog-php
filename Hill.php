<?php


if (isset($_POST['encrypt'])) {
    $textToEncrypt = $_POST['textToEncrypt'];
    $encryptionMatrix = $_POST['encryptionMatrix'];

    // Validate and sanitize input (crucial step!)
    // ... (add validation and sanitization logic here)

    // Convert the encryption matrix string to a 2D array
    $keyMatrix = array_map('intval', explode(' ', $encryptionMatrix));
    $keyMatrix = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9]
    ];
    
    // Now count should work without issues
    $count = count($keyMatrix);
    // Ensure the matrix is square
    if (count($keyMatrix) !== count($keyMatrix[0])) {
        echo "The encryption matrix must be square.";
        exit;
    }

    $modulus = 26;  // Assuming a modulus of 26 for English letters

    $encryptedText = hillCipherEncrypt($textToEncrypt, $keyMatrix, $modulus);

    echo "<p class='card-text'>Encrypted Text: $encryptedText</p>";
}

if (isset($_POST['decrypt'])) {
    $textToDecrypt = $_POST['textToDecrypt'];
    $decryptionMatrix = $_POST['decryptionMatrix'];
    $keyMatrix = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9]
    ];

    // Validate and sanitize input (crucial step!)
    // ... (add validation and sanitization logic here)

    // Convert the decryption matrix string to a 2D array
    $keyMatrix = array_map('intval', explode(' ', $decryptionMatrix));

    // Now count should work without issues
    $count = count($keyMatrix);
    // Ensure the matrix is square
    if (count($keyMatrix) !== count($keyMatrix)) {
        echo "The decryption matrix must be square.";
        exit;
    }

    $modulus = 26;  // Assuming a modulus of 26 for English letters

    $decryptedText = hillCipherDecrypt($textToDecrypt, $keyMatrix, $modulus);
    echo "<p class='card-text'>Decrypted Text: $decryptedText</p>";
}

function matrixInverse($matrix, $modulus)
{
    $det = determinant($matrix, $modulus);
    $adjugate = adjugate($matrix);
    $inverseDet = modInverse($det, $modulus);

    $result = array();

    foreach ($adjugate as $row) {
        $newRow = array();
        foreach ($row as $element) {
            $newRow[] = ($element * $inverseDet) % $modulus;
        }
        $result[] = $newRow;
    }

    return $result;
}

function determinant($matrix, $modulus)
{
    $n = count($matrix);

    if ($n == 1) {
        return $matrix[0][0];
    } elseif ($n == 2) {
        return ($matrix[0][0] * $matrix[1][1] - $matrix[0][1] * $matrix[1][0] + $modulus) % $modulus;
    } else {
        $det = 0;
        for ($i = 0; $i < $n; $i++) {
            $det = ($det + $matrix[0][$i] * cofactor($matrix, 0, $i, $modulus)) % $modulus;
        }
        return $det;
    }
}

function cofactor($matrix, $row, $col, $modulus)
{
    $subMatrix = array();

    $n = count($matrix);

    for ($i = 0; $i < $n; $i++) {
        if ($i != $row) {
            $currentRow = array();
            for ($j = 0; $j < $n; $j++) {
                if ($j != $col) {
                    $currentRow[] = $matrix[$i][$j];
                }
            }
            $subMatrix[] = $currentRow;
        }
    }

    $sign = ($row + $col) % 2 == 0 ? 1 : -1;

    return ($sign * determinant($subMatrix, $modulus) + $modulus) % $modulus;
}

function adjugate($matrix)
{
    $n = count($matrix);

    $result = array();

    for ($i = 0; $i < $n; $i++) {
        $currentRow = array();
        for ($j = 0; $j < $n; $j++) {
            $currentRow[] = cofactor($matrix, $j, $i, count($matrix));
        }
        $result[] = $currentRow;
    }

    return $result;
}

function modInverse($a, $m)
{
    for ($x = 1; $x < $m; $x++) {
        if ((($a % $m) * ($x % $m)) % $m == 1) {
            return $x;
        }
    }
    return 1;
}

function hillCipherEncrypt($plaintext, $keyMatrix, $modulus)
{
    $n = count($keyMatrix);

    // Pad the plaintext with 'X' if its length is not a multiple of $n
    while (strlen($plaintext) % $n != 0) {
        $plaintext .= 'X';
    }

    $ciphertext = '';

    for ($i = 0; $i < strlen($plaintext); $i += $n) {
        $block = substr($plaintext, $i, $n);
        $blockVector = array();

        for ($j = 0; $j < $n; $j++) {
            $blockVector[] = ord($block[$j]) - ord('A');
        }

        $resultVector = matrixMultiply($keyMatrix, $blockVector, $modulus);

        foreach ($resultVector as $element) {
            $ciphertext .= chr($element + ord('A'));
        }
    }

    return $ciphertext;
}
function hillCipherDecrypt($ciphertext, $keyMatrix, $modulus)
{
    // Implementation of hillCipherDecrypt function
    $inverseMatrix = matrixInverse($keyMatrix, $modulus);

    if (!$inverseMatrix) {
        echo "The decryption matrix is not invertible.";
        exit;
    }

    return hillCipherEncrypt($ciphertext, $inverseMatrix, $modulus);
}

function matrixMultiply($matrix, $vector, $modulus)
{
    $result = array();
    $n = count($matrix);

    for ($i = 0; $i < $n; $i++) {
        $sum = 0;
        for ($j = 0; $j < $n; $j++) {
            $sum += $matrix[$i][$j] * $vector[$j];
        }
        $result[] = $sum % $modulus;
    }

    return $result;
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
  <title>Hill Cipher</title>
</head>
<body>
  <?php include 'NavBar.php'; ?>
  <?php include 'sidebar.php'; ?>
  <div class="card" style="margin-left: 225px; margin-right: 200px; border: none; margin-top: 80px;">
  <h2 class="card-header" style="font-weight: 800; background-color: white;">HILL CIPHER</h2>
      <div class="card-body">
        <h5 class="card-title">Hill Cipher</h5>
        <p class="card-text">
        Hill Cipher is a polyalphabetic cipher created by extending the Affine cipher, using linear algebra and modular arithmetic via a numeric matrix that serves as an encryption and decryption key. </span>
        </p>
        <h6 class="" style="text-align: center; font-weight: 600;">Encryption</h6>
        <p class="card-text">
        How to encrypt using Hill cipher? <br/>
      Hill cipher encryption uses an alphabet and a square matrix M of size n made up of integers numbers and called encryption matrix.<br/>
      
        </p>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span>Example: Encrypt the plain text DCODEZ with the latin alphabet ABCDEFGHIJKLMNOPQRSTUVWXYZ and the matrix M(size n=2):<br><br>
            The encrypted message is now “MDLNFN”.<br/>
            <img src= "/assets/m.png" ></span>
            
          </div>
        </div>
        <br/>
        <h6 class="" style="text-align: center; font-weight: 600;">Decryption</h6>
        <p class="card-text">
        Hill cipher decryption needs the matrix and the alphabet used. <br/>
        Decryption involves matrix computations such as matrix inversion, and arithmetic calculations such as modular inverse. <br />
        
        </p>
        <p class="card-text">
        To decrypt hill ciphertext, 
        compute the matrix inverse modulo 26 (where 26 is the alphabet length), requiring the matrix to be invertible.<br></p>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span>
        Example: Using the example matrix, compute the inverse matrix modulo 26<br>
            <img src= "/assets/n.jpg">  </span><br />
    </div>
        </div>
        <br>
        
        <h6 class="" style="text-align: center; font-weight: 600;">Example:</h6>
<h6 class="" style="text-align: center;">Image here</h6>
<h6 class=""style="text-align: center; font-weight: 600;">Try it yourself</h6>

<div class="card" style="width: 32rem; border: none; margin: auto;">
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="card" style="width: 32rem; border: none; margin: auto;">
        <textarea class="" name="textToEncrypt" placeholder="Enter text to encrypt"><?php echo isset($textToEncrypt) ? $textToEncrypt : ''; ?></textarea>
        <br>
        <label for="encryptionMatrix">Enter Encryption Matrix (e.g., 2 4 5 9 2 1 3 17 7): </label>
        <input type="text" name="encryptionMatrix" placeholder="Enter encryption matrix">
        <br>
        <button type="submit" class="btn btn-success" name="encrypt">Encrypt</button>
        <p class="card-text">Encrypted Text: <?php echo isset($encryptedText) ? $encryptedText : ''; ?></p>

        
        <p class="card-text">Decrypted Text: <?php echo isset($textToEncrypt) ? $textToEncrypt : ''; ?></p>
        </div>
</form>


        </div><hr/>
</body>
</html>
