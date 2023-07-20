<?php
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Lcobucci\JWT\UnencryptedToken;

require '/var/www/html/docs/lib/login-endpoint/vendor/autoload.php';
$loggedIn = false;

$parser = new Parser(new JoseEncoder());
$gsi_auth = "";

if (isset($_COOKIE["google-signin"])){
  $gsi_auth = $_COOKIE["google-signin"];
}

if (isset($_POST["auth"])){
  $gsi_auth = $_POST["auth"];
}

if($gsi_auth !== ""){
  try {
      $token = $parser->parse($gsi_auth);
  } catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
      echo 'Oh no, an error: ' . $e->getMessage();
  }
  assert($token instanceof UnencryptedToken);
  $name = $token->claims()->all()["name"];
  $email = $token->claims()->all()["email"];
  $pic = $token->claims()->all()["picture"];
  $client = new Google_Client(['client_id' => '117895756240-ujiuojlsbtruthgqnghnu215d2hn7flp.apps.googleusercontent.com']);
  $payload = $client->verifyIdToken($gsi_auth);
  if ($payload) {
    $loggedIn = true;
  }
}
?>
