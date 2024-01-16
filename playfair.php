<?php
function prepareKey($key) {
    $key = strtoupper(str_replace('J', 'I', $key));
    $keyArray = str_split($key);
    $alphabet = str_split("ABCDEFGHIKLMNOPQRSTUVWXYZ");

    foreach ($keyArray as $char) {
        if (($keyPos = array_search($char, $alphabet)) !== false) {
            unset($alphabet[$keyPos]);
        }
    }

    return array_merge($keyArray, $alphabet);
}

function generateMatrix($key) {
    $matrix = array_chunk(prepareKey($key), 5);
    return $matrix;
}

function getCharPosition($matrix, $char) {
    foreach ($matrix as $rowIndex => $row) {
        if (($colIndex = array_search($char, $row)) !== false) {
            return array($rowIndex, $colIndex);
        }
    }
    return false;
}

function encryptPlayfair($plaintext, $key) {
    $matrix = generateMatrix($key);
    $ciphertext = '';
    $plaintext = str_replace('J', 'I', $plaintext);
    $pairs = str_split($plaintext, 2);

    foreach ($pairs as $pair) {
        list($char1, $char2) = str_split($pair);

        list($row1, $col1) = getCharPosition($matrix, $char1);
        list($row2, $col2) = getCharPosition($matrix, $char2);

        if ($row1 == $row2) {
            $ciphertext .= $matrix[$row1][($col1 + 1) % 5] . $matrix[$row2][($col2 + 1) % 5];
        } elseif ($col1 == $col2) {
            $ciphertext .= $matrix[($row1 + 1) % 5][$col1] . $matrix[($row2 + 1) % 5][$col2];
        } else {
            $ciphertext .= $matrix[$row1][$col2] . $matrix[$row2][$col1];
        }
    }

    return $ciphertext;
}

function decryptPlayfair($ciphertext, $key) {
    $matrix = generateMatrix($key);
    $plaintext = '';
    $pairs = str_split($ciphertext, 2);

    foreach ($pairs as $pair) {
        list($char1, $char2) = str_split($pair);

        list($row1, $col1) = getCharPosition($matrix, $char1);
        list($row2, $col2) = getCharPosition($matrix, $char2);

        if ($row1 == $row2) {
            $plaintext .= $matrix[$row1][($col1 - 1 + 5) % 5] . $matrix[$row2][($col2 - 1 + 5) % 5];
        } elseif ($col1 == $col2) {
            $plaintext .= $matrix[($row1 - 1 + 5) % 5][$col1] . $matrix[($row2 - 1 + 5) % 5][$col2];
        } else {
            $plaintext .= $matrix[$row1][$col2] . $matrix[$row2][$col1];
        }
    }

    return $plaintext;
}

$textToEncrypt = isset($_POST['textToEncrypt']) ? strtoupper($_POST['textToEncrypt']) : '';
$textToDecrypt = isset($_POST['textToDecrypt']) ? strtoupper($_POST['textToDecrypt']) : '';
$encryptedText = '';
$decryptedText = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['encrypt'])) {
        $key = 'monarchy';  // Replace with your actual key
        $encryptedText = encryptPlayfair($textToEncrypt, $key);
    } elseif (isset($_POST['decrypt'])) {
        $key = 'monarchy';  // Replace with your actual key
        $decryptedText = decryptPlayfair($textToDecrypt, $key);
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
  <title>Playfair Cipher</title>
</head>
<body>
  <?php include 'NavBar.php'; ?>
  <?php include 'sidebar.php'; ?>
  <div class="card" style="margin-left: 225px; margin-right: 200px; border: none; margin-top: 80px;">
  <h2 class="card-header" style="font-weight: 800; background-color: white;">PLAYFAIR CIPHER</h2>
      <div class="card-body">
        <h5 class="card-title">Playfair Cipher</h5>
        <p class="card-text">
          The Playfair cipher was the first practical digraph substitution cipher. The scheme was invented in 1854 by Charles Wheatstone but was named after Lord Playfair who promoted the use of the cipher. In playfair cipher unlike traditional cipher we encrypt a pair of alphabets(digraphs) instead of a single alphabet. <br/> 
          The ‘key’ for the Affine cipher consists of 2 numbers, we’ll call them a and b. The following discussion assumes the use of a 26 character alphabet (m = 26). a should be chosen to be relatively prime to m (i.e. a should have no factors in common with m).It was used for tactical purposes by British forces in the Second Boer War and in World War I and for the same purpose by the Australians during World War II. This was because Playfair is reasonably fast to use and requires no special equipment. <br/>        </p>
        <h6 class="" style="text-align: center;">Image here</h6>
        <h6 class="" style="text-align: center; font-weight: 600;">Encryption</h6>
        <p class="card-text">
          For the encryption process let us consider the following example:<br />
        </p>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span style="font-weight: 600;">key: monarchy</span><br />
            <span>Plaintext: instruments</span><br />
            <p class="card-text">•The key square is a 5×5 grid of alphabets that acts as the key for encrypting the plaintext. Each of the 25 alphabets must be unique and one letter of the alphabet (usually J) is omitted from the table (as the table can hold only 25 alphabets). If the plaintext contains J, then it is replaced by I.<br/>        </p>
            <span>•The initial alphabets in the key square are the unique alphabets of the key in the order in which they appear followed by the remaining letters of the alphabet in order.</span><br  />
			<span>The plaintext is split into pairs of two letters (digraphs). If there is an odd number of letters, a Z is added to the last letter. <br  />
            For example: </span><br  />
            <span style="font-weight: 600;">PlainText: "instruments" <br  />
            After Split: 'in' 'st' 'ru' 'me' 'nt' 'sz' </span> <br/><br/>
          </div>
        </div>
        <br/>
		<p class="card-text">
          1. Pair cannot be made with same letter. Break the letter in single and add a bogus letter to the previous letter.

            Plain Text: “hello”<br/><br/>

            <span style="font-weight: 600;">After Split: ‘he’ ‘lx’ ‘lo’</span><br/>

            <span style="font-weight: 600;">Here ‘x’ is the bogus letter.</span><br/><br/>

            2. If the letter is standing alone in the process of pairing, then add an extra bogus letter with the alone letter<br />

            <span style="font-weight: 600;">Plain Text: “helloe”</span><br />

            <span style="font-weight: 600;">AfterSplit: ‘he’ ‘lx’ ‘lo’ ‘ez’</span><br /><br />
        <h6 class="" style="text-align: center; font-weight: 600;">Decryption</h6>
        <p class="card-text">
          Decrypting the Playfair cipher is as simple as doing the same process in reverse. The receiver has the same key and can create the same key table, and then decrypt any messages made using that key. <br />
        </p>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span style="font-weight: 600;">key: monarchy</span><br />
            <span>ciphertext:gatlmzclrqtx</span><br />
          </div>
        </div>
        <p class="card-text">
          <span>Algorithm to decrypt the ciphertext: The ciphertext is split into pairs of two letters (digraphs).</span><br/> 
          <span>
          Note: The ciphertext always have even number of characters.<br/><br/>  
             For example: <br/>  
 
             CipherText: "gatlmzclrqtx" <br/>  
             After Split: 'ga' 'tl' 'mz' 'cl' 'rq' 'tx'<br  />
             Rules for Decryption: <br/> <br/> 
             If both the letters are in the same column: Take the letter above each one (going back to the bottom if at the top).<br/>
             For example: <br />
 
             Diagraph: "cl" <br  />
             Decrypted Text: me<br/>  
             Decryption: <br />
             c -> m<br />
             l -> e	<br/>  	
<html>
<head>
<style>
 table, th, tr {
  border: 1px solid black;
  border-collapse: collapse;
}
table.center {
  margin-left: auto; 
  margin-right: auto;
</style>
</head>
<body>			 
<table style="width: 50%;">

<table class="center">


  <tr>
    <th><p style="color:red;">m</p></th>
    <th><p style="color:red;">o</p></th>
    <th><p style="color:red;">n</p></th>
    <th><p style="color:red;">a</p></th>
    <th><p style="color:red;">r</p></th>
  </tr>
  <tr>
   <th><p style="color:red;">c</p></th>
    <th><p style="color:red;">h</p></th>
	<th><p style="color:red;">y</p></th>
    <th>b</th>
    <th>d</th>
  </tr>
  <tr>
    <th>e</th>
   <th>f</th>
    <th>g</th>
    <th>i/j</th>>
    <th>k</th>
  </tr>
  <tr>
   <th>l</th>
   <th>p</th>
   <th>q</th>
   <th>s</th>
   <th>t</th>
  </tr>
   <tr>
    <th>u</th>
    <th>v</th>
    <th>w</th>
    <th>x</th>
    <th>z</th>
  </tr>
</table>

</body>
</html>

             If both the letters are in the SAME ROW: Take the letter to the left of each one (going back to the rightmost if at the leftmost position).	<br/>  
             For example: <br/>  
 
             Diagraph: "tl" <br/>  
             Decrypted Text: st <br/>  
             Decryption: <br/>  
             t -> s <br/>  
             l -> t <br />
			 
			<html>
<head>
<style>
 table, th, tr {
  border: 1px solid black;
  border-collapse: collapse;
}
table.center {
  margin-left: auto; 
  margin-right: auto;
</style>
</head>
<body>			 
<table style="width: 50%;">

<table class="center">
  <tr>
    <th><p style="color:red;">m</p></th>
    <th><p style="color:red;">o</p></th>
    <th><p style="color:red;">n</p></th>
    <th><p style="color:red;">a</p></th>
    <th><p style="color:red;">r</p></th>
  </tr>
  <tr>
   <th><p style="color:red;">c</p></th>
    <th><p style="color:red;">h</p></th>
	<th><p style="color:red;">y</p></th>
    <th>b</th>
    <th>d</th>
  </tr>
  <tr>
    <th>e</th>
   <th>f</th>
    <th>g</th>
    <th>i/j</th>>
    <th>k</th>
  </tr>
  <tr>
   <th>l</th>
   <th>p</th>
   <th>q</th>
   <th>s</th>
   <th>t</th>
  </tr>
   <tr>
    <th>u</th>
    <th>v</th>
    <th>w</th>
    <th>x</th>
    <th>z</th>
  </tr>
</table>

</body>
</html> 
			 If neither of the above rules is true: Form a rectangle with the two letters and take the letters on the horizontal opposite corner of the rectangle.
             For example: 
 
             Diagraph: "rq" 
             Decrypted Text: nt 
             Decryption: 
			 r - > n
			 q - > t
<html>
<head>
<style>
 table, th, tr {
  border: 1px solid black;
  border-collapse: collapse;
}
table.center {
  margin-left: auto; 
  margin-right: auto;
</style>
</head>
<body>			 
<table style="width: 50%;">

<table class="center">

  <tr>
    <th><p style="color:red;">m</p></th>
    <th><p style="color:red;">o</p></th>
    <th><p style="color:red;">n</p></th>
    <th><p style="color:red;">a</p></th>
    <th><p style="color:red;">r</p></th>
  </tr>
  <tr>
   <th><p style="color:red;">c</p></th>
    <th><p style="color:red;">h</p></th>
	<th><p style="color:red;">y</p></th>
    <th>b</th>
    <th>d</th>
  </tr>
  <tr>
    <th>e</th>
   <th>f</th>
    <th>g</th>
    <th>i/j</th>>
    <th>k</th>
  </tr>
  <tr>
   <th>l</th>
   <th>p</th>
   <th>q</th>
   <th>s</th>
   <th>t</th>
  </tr>
   <tr>
    <th>u</th>
    <th>v</th>
    <th>w</th>
    <th>x</th>
    <th>z</th>
  </tr>
</table>

</body>
</html>
          </span>
		  <span>Plain Text: "gatlmzclrqtx"<br/>
           Decrypted Text: instrumentsz<br/>
           Decryption: <br/>
            (red)-> (green)<br/>
              ga -> in<br/>
              tl -> st<br/>
              mz -> ru<br/>
              cl -> me<br/>
              rq -> nt<br/>
              tx -> sz </span>
        </p>
        <div class="card" style="width: 32rem; background-color: rgb(200,200,200); border: none; margin: auto; text-align: center;">
          <div class="card-body">
            <span style="font-weight: 600;"><span>Plain Text: "instrumentsz"<br />
            Encrypted Text: gatlmzclrqtx<br />
            Encryption: <br />
            i -> g<br />
            n -> a<br />
            s -> t<br />
            t -> l<br />
            r -> m<br />
            u -> z<br />
            m -> c<br />
            e -> l<br />
            n -> r<br />
            t -> q<br />
            s -> t<br />
            z -> x </span></span><br />
        
          </div>
        </div>
       
        <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Playfair Cipher</title>
</head>
<body>
  <div class="container">
    <h2 class="mt-5">Playfair Cipher</h2>
    
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4">
      <div class="form-group">
        <label for="textToEncrypt">Text to Encrypt:</label>
        <textarea class="form-control" name="textToEncrypt"><?php echo $textToEncrypt; ?></textarea>
      </div>
      <button type="submit" class="btn btn-success" name="encrypt">Encrypt</button>
      <p class="mt-2">Encrypted Text: <?php echo $encryptedText; ?></p>
    </form>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4">
      <div class="form-group">
        <label for="textToDecrypt">Text to Decrypt:</label>
        <textarea class="form-control" name="textToDecrypt"><?php echo $textToDecrypt; ?></textarea>
      </div>
      <button type="submit" class="btn btn-danger" name="decrypt">Decrypt</button>
      <p class="mt-2">Decrypted Text: <?php echo $decryptedText; ?></p>
    </form>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <?php include 'Footer.php'; ?>
</body>
</html>


 
      