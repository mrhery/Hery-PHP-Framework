# Encrypter Class (available in HPFv3 Only)
This `Encrypter` class has 3 small methods to *Generate Initial Vector*, *Encrypt String* and *Decrypt String*. The encryption rely on AES-CBC encryption via **PHPSecLib**. **PHPSecLib** one of best encryption library which is has a complex mechanism to encrypt anything!

## Methods Directory
- `Encrypter::CreateIv()`
- `Encrypter::AESEncrypt()`
- `Encrypter::AESDecrypt()`

### Encrypter::CreateIv() :static method
This method will return random byte.<br />
This random byte will be use as *Initial Vector (IV)* to encrypt or decrypt string.
```
$block = Encrypter::CreateIv();
```

### Encrpter::AESEncrypt(@param1, @param2, @param3) :static method
@param1:string  -> String to encrypt<br />
@param2:string  -> String key, 16 or 32 character.<br />
@param3:byte    -> Byte of initial value, can use `Encrypter::CreateIv()`<br />
This method will return encrypted string as **byte**.<br />

### Encrypter::AESDecrypt(@param1, @param2, @param3)  :static method
@param1:byte    -> Byte of encrypted string. Can use value from `Encrypter::AESEncrypt()`<br />
@param2:string  -> String of key, 16 or 32 character. Must use the same key while encrypting string.<br />
@param3:byte    -> Byte of initial value. Must use the same block byte while encrypting string.<br />
This method will return decrypted byte as **string**.
