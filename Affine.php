<?php
$textToEncrypt = "";
$textToDecrypt = "";
$encryptedText = "";
$decryptedText = "";

function egcd($a, $b) {
    $x = 0;
    $y = 1;
    $u = 1;
    $v = 0;

    while ($a != 0) {
        $q = (int)($b / $a);
        $r = $b % $a;
        $m = $x - $u * $q;
        $n = $y - $v * $q;
        $b = $a;
        $a = $r;
        $x = $u;
        $y = $v;
        $u = $m;
        $v = $n;
    }

    $gcd = $b;
    return array($gcd, $x, $y);
}

function modinv($a, $m) {
    list($gcd, $x, $y) = egcd($a, $m);
    if ($gcd != 1) {
        return null; 
    } else {
        return ($x % $m + $m) % $m;
    }
}

function affineEncrypt($text, $key) {
    $a = $key[0];
    $b = $key[1];
    $result = "";

    for ($i = 0; $i < strlen($text); $i++) {
        $ch = $text[$i];
        if (ctype_alpha($ch)) {
            $offset = ctype_upper($ch) ? ord('A') : ord('a');
            $result .= chr((($a * (ord($ch) - $offset) + $b) % 26) + $offset);
        } else {
            $result .= $ch;
        }
    }

    return $result;
}

function affineDecrypt($cipher, $key) {
    $a = $key[0];
    $b = $key[1];
    $modInv = modinv($a, 26);
    $result = "";

    for ($i = 0; $i < strlen($cipher); $i++) {
        $ch = $cipher[$i];
        if (ctype_alpha($ch)) {
            $offset = ctype_upper($ch) ? ord('A') : ord('a');
            $result .= chr((($modInv * (ord($ch) - $offset - $b + 26)) % 26) + $offset);
        } else {
            $result .= $ch;
        }
    }

    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["encrypt"])) {
        $textToEncrypt = $_POST["textToEncrypt"];
        $key = [17, 20];

        $encryptedText = affineEncrypt($textToEncrypt, $key);
    } elseif (isset($_POST["decrypt"])) {
        $textToDecrypt = $_POST["textToDecrypt"];
        $key = [17, 20]; 
        $decryptedText = affineDecrypt($textToDecrypt, $key);
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
  <link rel="stylesheet" href="./styles/NavBar.css">
  <title>Affine Cipher</title>
</head>
<body>
  <?php include 'NavBar.php'; ?>
  <?php include 'sidebar.php'; ?>
  <div class="card" style="margin-left: 225px; margin-right: 200px; border: none; margin-top: 80px;">
  <h2 class="card-header" style="font-weight: 800; background-color: white;">AFFINE CIPHER</h2>
      <div class="card-body">
        <h5 class="card-title">Affine Cipher</h5>
        <p class="card-text">
          The Affine cipher is a type of monoalphabetic substitution cipher, wherein each letter in an alphabet is mapped to its numeric equivalent, encrypted using a simple mathematical function, and converted back to a letter. The formula used means that each letter encrypts to one other letter, and back again, meaning the cipher is essentially a standard substitution cipher with a rule governing which letter goes to which. <br/>
          The whole process relies on working modulo m (the length of the alphabet used). In the affine cipher, the letters of an alphabet of size m are first mapped to the integers in the range 0 … m-1. <br/>
          The ‘key’ for the Affine cipher consists of 2 numbers, we’ll call them a and b. The following discussion assumes the use of a 26 character alphabet (m = 26). a should be chosen to be relatively prime to m (i.e. a should have no factors in common with m).
        </p>
        <img class="card-img-top" src="./assets/encryption.svg">
        <h6  style="text-align: center; font-weight: 600;">Encryption</h6>
        <p class="card-text">
          It uses modular arithmetic to transform the integer that each plaintext letter corresponds to into another integer that corresponds to a ciphertext letter. The encryption function for a single letter is<br />
        </p>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span style="font-weight: 600;">E(x) = (ax + b) mod m</span><br />
            <span>Modulus m: size of the alphabet</span><br />
            <span>a and b: key of the cipher.</span><br />
            <span>a must be chosen such that a and m are coprime.</span>
          </div>
        </div>
        <br/>
        <h6 class="" style="text-align: center; font-weight: 600;">Decryption</h6>
        <p class="card-text">
          In deciphering the ciphertext, we must perform the opposite (or inverse) functions on the ciphertext to retrieve the plaintext. Once again, the first step is to convert each of the ciphertext letters into their integer values. The decryption function is  <br />
        </p>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span style="font-weight: 600;">D ( x ) = a^-1 ( x - b ) mod m</span><br />
            <span>a^-1 : modular multiplicative inverse of a modulo m. i.e., it satisfies the equation 1 = a a^-1 mod m .</span><br />
          </div>
        </div>
        <p class="card-text">
          <span>We need to find a number x such that: </span><br/> 
          <span>
            If we find the number x such that the equation is true, then x is the inverse of a, and we call it a^-1. The easiest way to solve this equation is to search each of the numbers 1 to 25, and see which one satisfies the equation.   
          </span>
        </p>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span style="font-weight: 600;">[g,x,d] = gcd(a,m);  % we can ignore g and d, we dont need them</span><br />
            <span>x = mod(x,m);</span><br />
          </div>
        </div>
        <p class="card-text">
          If you now multiply x and a and reduce the result (mod 26), you will get the answer 1. Remember, this is just the definition of an inverse i.e. if a*x = 1 (mod 26), then x is an inverse of a (and a is an inverse of x) <br />
        </p>
        <h6 class=""style="text-align: center; font-weight: 600;">Example:</h6>
        <div style="display: flex; justify-content: center; align-items: center;">
        <img class="card-img-top" style="width: 70%; margin: 0;" src="./assets/affine-cipher.svg" alt="Affine Image">
      </div>
        <h6 class=""style="text-align: center; font-weight: 600;">Try it yourself</h6>
        <div class="card" style=" width: 32rem; border: none; margin: auto;">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="card" style="width: 32rem; border: none; margin: auto;">
        <textarea class="" name="textToEncrypt" placeholder="Enter text to encrypt"><?php echo $textToEncrypt; ?></textarea>
        <br>
        <button type="submit" class="btn btn-success" name="encrypt">Encrypt</button>
        <p class="card-text">Encrypted Text: <?php echo $encryptedText; ?></p>
        <textarea class="" name="textToDecrypt" placeholder="Enter text to decrypt"><?php echo $textToDecrypt; ?></textarea>
        <br>
        <button type="submit" class="btn btn-danger" name="decrypt" style="background-color: rgb(42, 42, 44)">Decrypt</button>
        <p class="card-text">Decrypted Text: <?php echo $decryptedText; ?></p>
    </div>
</form>

        </div><br/><br/>
        <?php include 'Footer.php'; ?>
</div>
       
</body>
</html>
