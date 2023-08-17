<?php
declare(strict_types=1);

use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Lcobucci\JWT\UnencryptedToken;

require '/var/www/html/docs/lib/login-endpoint/vendor/autoload.php';

$parser = new Parser(new JoseEncoder());

try {
    $token = $parser->parse($_POST["credential"]);
} catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
    echo 'Oh no, an error: ' . $e->getMessage();
}
assert($token instanceof UnencryptedToken);

$name = $token->claims()->all()["name"];
$email = $token->claims()->all()["email"];
$pic = $token->claims()->all()["picture"];

$client = new Google_Client(['client_id' => '117895756240-ujiuojlsbtruthgqnghnu215d2hn7flp.apps.googleusercontent.com']);
$payload = $client->verifyIdToken($gsi_auth);

if($payload){
    echo "Signed in ".$token->claims()->all()["name"]." with email ".$token->claims()->all()["email"]." and picture ".$token->claims()->all()["picture"];

    if (session_status() === PHP_SESSION_NONE) { session_start(); }

    $_SESSION["loggedIn"] = true;
    $_SESSION["name"] = $name;
    $_SESSION["email"] = $email;
    $_SESSION["pic"] = $pic;
    $_SESSION["age"] = time();
}
?>
