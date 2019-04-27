<?php
$iv = Encrypter::CreateIv();

echo "IV: " . $iv . "<br />";
$encrypted = Encrypter::AESEncrypt("My Name is Hery", "1234567890123451", $iv);
echo "Encrypt: " . $encrypted . " <br />";
echo "Decrypt: " . Encrypter::AESDecrypt($encrypted, "1234567890123451", $iv);

?>