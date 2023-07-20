<?php
declare(strict_types=1);

use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Lcobucci\JWT\UnencryptedToken;

require 'vendor/autoload.php';

$parser = new Parser(new JoseEncoder());

try {
    $token = $parser->parse($_POST["credential"]);
} catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
    echo 'Oh no, an error: ' . $e->getMessage();
}
assert($token instanceof UnencryptedToken);
setcookie("google-signin", $_POST["credential"], time() + 3600, "/",".quizza.org");
echo "Signed in ".$token->claims()->all()["name"]." with email ".$token->claims()->all()["email"]." and picture ".$token->claims()->all()["picture"];
?>
