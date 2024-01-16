<?php
$encryptedText = "";
$decryptedText = "";

function caesarEncrypt($text, $shift) {
    $result = "";
    for ($i = 0; $i < strlen($text); $i++) {
        if (ctype_upper($text[$i]))
            $result .= chr((ord($text[$i]) + $shift - 65) % 26 + 65);
        else
            $result .= chr((ord($text[$i]) + $shift - 97) % 26 + 97);
    }
    return $result;
}

function caesarDecrypt($text, $shift) {
    $result = "";
    for ($i = 0; $i < strlen($text); $i++) {
        if (ctype_upper($text[$i]))
            $result .= chr((ord($text[$i]) - $shift - 65 + 26) % 26 + 65);
        else
            $result .= chr((ord($text[$i]) - $shift - 97 + 26) % 26 + 97);
    }
    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['encrypt'])) {
        $plainText = $_POST["encryptPlainText"];
        $caesarShift = $_POST["encryptCaesarShift"];
        $encryptedText = caesarEncrypt(strtoupper($plainText), $caesarShift);
    } elseif (isset($_POST['decrypt'])) {
        $encryptedText = $_POST["decryptEncryptedText"];
        $caesarShift = $_POST["decryptCaesarShift"];
        $decryptedText = caesarDecrypt(strtoupper($encryptedText), $caesarShift);
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
  <title>Caesar Cipher</title>
</head>
<body>
<?php include 'NavBar.php'; ?>
<?php include 'Sidebar.php'; ?>
<div class="card" style="margin-left: 225px; margin-right: 200px; border: none; margin-top: 80px;">
<h2 class="card-header" style="font-weight: 800; background-color: white;">CAESAR CIPHER</h2>

  <p class="card-text">  
    <div class="card-body">
    <h5 class="card-title">Caesar Cipher</h5>
    <ul>
    <li>
      <span>The Caesar cipher is a simple encryption technique that was used by Julius Caesar to send secret messages to his allies. It works by shifting the letters in the plaintext message by a certain number of positions, known as the “shift” or “key”.</span>
    </li>
    <li>
      <span>The Caesar Cipher technique is one of the earliest and simplest methods of encryption technique. It’s simply a type of substitution cipher, i.e., each letter of a given text is replaced by a letter with a fixed number of positions down the alphabet. For example with a shift of 1, A would be replaced by B, B would become C, and so on. The method is apparently named after Julius Caesar, who apparently used it to communicate with his officials.</span>
    </li>
    <li>
      <span>Thus to cipher a given text we need an integer value, known as a shift which indicates the number of positions each letter of the text has been moved down.</span>
    </li>
    <li>
      <span>The encryption can be represented using modular arithmetic by first transforming the letters into numbers, according to the scheme, A = 0, B = 1,…, Z = 25. Encryption of a letter by a shift n can be described mathematically as.</span>
    </li>
    <li>
      <span>For example, if the shift is 3, then the letter A would be replaced by the letter D, B would become E, C would become F, and so on. The alphabet is wrapped around so that after Z, it starts back at A.</span>
    </li>
    <li>
      <span>Here is an example of how to use the Caesar cipher to encrypt the message “HELLO” with a shift of 3: <br/>
       1. Write down the plaintext message: HELLO<br/>
       2. Choose a shift value. In this case, we will use a shift of 3.<br/>
       3. Replace each letter in the plaintext message with the letter that is three positions to the right in the alphabet.<br/>
       </span>
    </li>
  </ul>
  <h6 style="text-align: center;">
            H becomes K (shift 3 from H)<br/><br/>

            E becomes H (shift 3 from E)<br/><br/>

            L becomes O (shift 3 from L)<br/><br/>

            L becomes O (shift 3 from L)<br/><br/>

            O becomes R (shift 3 from O)<br/><br/>
          </h6>
          <div class='card=text'>
            4. The encrypted message is now “KHOOR”.
          </div>
          <ul>
            <li>
              <span>
                To decrypt the message, you simply need to shift each letter back by the same number of positions. In this case, you would shift each letter in “KHOOR” back by 3 positions to get the original message, “HELLO”.
              </span>
            </li>
          </ul>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span style="font-weight: 600;">En(x) = (x+n)mod 26</span><br />
            <span>(Encryption Phase with shift n)</span><br /><br/>
            <span style="font-weight: 600">Dn(x)=(x-n)mod 26</span><br />
            <span>(Decryption Phase with shift n)</span><br />
          </div>
        </div>
        <div style="display: flex; justify-content: center; align-items: center;">
        <img class="card-img-top" style="width: 50%; margin: 0;" src="./assets/caesar.svg" alt="Caesar Image">
      </div>
        <h6 className="" style="text-align: center; font-weight:600">Examples:</h6>
        <div className="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; padding-left: 10px;">
          <div className="card-body" style="text-align: center;"><br/>
            <span>Text : ABCDEFGHIJKLMNOPQRSTUVWXYZ</span><br />
            <span>Shift : 23</span><br />
            <span>Cipher : XYZABCDEFGHIJKLMNOPQRSTUVW</span><br /><br/>
            <span>Cipher : XYZABCDEFGHIJKLMNOPQRSTUVW</span><br />
            <span>Shift: 4</span><br />
            <span>Cipher: EXXEGOEXSRGI</span><br /><br/>
          </div>
        </div>
        </p>
        <h6 class="card-title">Advantages</h6>
        <ul>
    <li>
      <span>Easy to implement and use thus, making suitable for beginners to learn about encryption.</span>
    </li>
    <li>
      <span>Can be physically implemented, such as with a set of rotating disks or a set of cards, known as a scytale, which can be useful in certain situations.</span>
    </li>
    <li>
      <span>Requires only a small set of pre-shared information.</span>
    </li>
    <li>
      <span>Can be modified easily to create a more secure variant, such as by using a multiple shift values or keywords.</span>
    </li>
        </ul>
    <h6 class="card-title">Disadvantages</h6>
    <ul>
    <li>
      <span>It is not secure against modern decryption methods.</span>
    </li>
    <li>
      <span>Vulnerable to known-plaintext attacks, where an attacker has access to both the encrypted and unencrypted versions of the same messages.</span>
    </li>
    <li>
      <span>The small number of possible keys means that an attacker can easily try all possible keys until the correct one is found, making it vulnerable to a brute force attack.</span>
    </li>
    <li>
      <span>It is not suitable for long text encryption as it would be easy to crack.</span>
    </li>
    <li>
      <span>It is not suitable for secure communication as it is easily broken.</span>
    </li>
    <li>
      <span>Does not provide confidentiality, integrity, and authenticity in a message. </span>
    </li>
        </ul>

        <h6 class="card-title">Features of caesar cipher:</h6>
      <span>1. Substitution cipher: The Caesar cipher is a type of substitution cipher, where each letter in the plaintext is replaced by a letter some fixed number of positions down the alphabet.</span><br/>
      <span>2. Fixed key: The Caesar cipher uses a fixed key, which is the number of positions by which the letters are shifted. This key is known to both the sender and the receiver.</span><br/>
      <span>3. Symmetric encryption: The Caesar cipher is a symmetric encryption technique, meaning that the same key is used for both encryption and decryption.</span><br/>
      <span>4. Limited keyspace: The Caesar cipher has a very limited keyspace of only 26 possible keys, as there are only 26 letters in the English alphabet.</span><br/>
      <span>5. Vulnerable to brute force attacks: The Caesar cipher is vulnerable to brute force attacks, as there are only 26 possible keys to try.</span><br/>
      <span>6. Easy to implement: The Caesar cipher is very easy to implement and requires only simple arithmetic operations, making it a popular choice for simple encryption tasks. </span><br/><br/>

      <h6 class="card-title">Rules for the Caesar Cipher:</h6>
      <span>1. Choose a number between 1 and 25. This will be your “shift” value.</span><br/>
      <span>2. Write down the letters of the alphabet in order, from A to Z.</span><br/>
      <span>3. Shift each letter of the alphabet by the “shift” value. For example, if the shift value is 3, A would become D, B would become E, C would become F, and so on.</span><br/>
      <span>4. Encrypt your message by replacing each letter with the corresponding shifted letter. For example, if the shift value is 3, the word “hello” would become “khoor”.</span><br/>
      <span>5. o decrypt the message, simply reverse the process by shifting each letter back by the same amount. For example, if the shift value is 3, the encrypted message “khoor” would become “hello”.</span><br/><br/>

      <h6 class="card-title"><span>Algorithm for Caesar Cipher:</span><br/> 
Input: </h6>
      <span>1. Choose a shift value between 1 and 25.</span><br/>
      <span>2.Write down the alphabet in order from A to Z.</span><br/>
      <span>3. Create a new alphabet by shifting each letter of the original alphabet by the shift value. For example, if the shift value is 3, the new alphabet would be:</span><br/>
      <span>4. A B C D E F G H I J K L M N O P Q R S T U V W X Y Z
D E F G H I J K L M N O P Q R S T U V W X Y Z A B C</span><br/>
      <span>5. Replace each letter of the message with the corresponding letter from the new alphabet. For example, if the shift value is 3, the word “hello” would become “khoor”.</span><br/>
      <span>6. To decrypt the message, shift each letter back by the same amount. For example, if the shift value is 3, the encrypted message “khoor” would become “hello”.</span><br/><br/>

      <h6 class="card-title">Procedure: </h6>
    <ul>
    <li>
      <span>Traverse the given text one character at a time .</span>
    </li>
    <li>
      <span>For each character, transform the given character as per the rule, depending on whether we’re encrypting or decrypting the text.</span>
    </li>
    <li>
      <span>Return the new string generated.</span>
    </li>
        </ul>
    <p class="card-text">A program that receives a Text (string) and Shift value( integer) and returns the encrypted text. </p><br/>
    
    <h6 class=""style="text-align: center; font-weight: 600;">Try it yourself</h6>
        <div class="card" style="width: 32rem; border: none; margin: auto;">
            <form method="POST" action="" style="text-align: center;">
                <label for="encryptPlainText">Enter text to encrypt:</label><br>
                <input type="text" id="encryptPlainText" name="encryptPlainText" value="<?php echo isset($_POST['encryptPlainText']) ? $_POST['encryptPlainText'] : ''; ?>"><br>
                <label for="encryptCaesarShift">Enter Caesar shift value:</label><br>
                <input type="number" id="encryptCaesarShift" name="encryptCaesarShift" value="<?php echo isset($_POST['encryptCaesarShift']) ? $_POST['encryptCaesarShift'] : ''; ?>"><br><br>
                <button type="submit" name="encrypt" class="btn btn-success">Encrypt</button>
                <p>Encrypted Text: <?php echo $encryptedText; ?></p>
            </form>

            <form method="POST" action="" style="text-align: center;">
                <label for="decryptEncryptedText">Enter text to decrypt:</label><br>
                <input type="text" id="decryptEncryptedText" name="decryptEncryptedText" value="<?php echo isset($_POST['decryptEncryptedText']) ? $_POST['decryptEncryptedText'] : ''; ?>"><br>
                <label for="decryptCaesarShift">Enter Caesar shift value:</label><br>
                <input type="number" id="decryptCaesarShift" name="decryptCaesarShift" value="<?php echo isset($_POST['decryptCaesarShift']) ? $_POST['decryptCaesarShift'] : ''; ?>"><br><br>
                <button type="submit" name="decrypt" class="btn btn-success" style="background-color: rgb(42, 42, 44);">Decrypt</button>
                <p>Decrypted Text: <?php echo $decryptedText; ?></p>
            </form>

            <?php if ($encryptedText !== "") ?>
                <?php if ($decryptedText !== "") { ?>
                <input type="hidden" name="encryptedText" value="<?php echo $encryptedText; ?>">
                <input type="hidden" name="caesarShift" value="<?php echo $caesarShift; ?>">
            <?php } ?>
        </div>
  </p>
</div>
<?php include 'Footer.php'; ?>
</div>

 

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
