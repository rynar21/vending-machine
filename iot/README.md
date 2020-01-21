#### 1. Generate your own Merchant RSA Key Pair
Skip this step if key pair has already been provided

#### 2. Update the Key Pair for integration
Please replace the content under **/keys** folder to your own key pairs
```
keys/merchant_private_key.key
keys/merchant_public_key.key
keys/sarawakpay_public_key.pem
```

#### 3. In the case where RSA Key filename changes is required

Please update the following configuration under **/plugins/SarawakPay.php** into your RSA filename
```
const SP_PUBLIC_KEY          = "keys/sarawakpay_public_key.pem";
const MERCHANT_PUBLIC_KEY    = "keys/merchant_public_key.key";
const MERCHANT_PRIVATE_KEY   = "keys/merchant_private_key.key";
```


#### 4. Update Merchant RSA Public Key to Sarawak Pay System

Login with the credential provided by Sarawak Pay technical team to the following URL
```
https://spfintech.sains.com.my/ecs/
```

Change the content under API Integration Menu into the content of your RSA public key content, e.g.
```
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAxl4xIsPmyIC+LVoBtAAUps/8hogegrMY/a6esQvPIg6Fc5LlG07Ckh2sNTV1ZRFlUh30/1LJMdyTcsdB5+CrCiwTuTFV6mfGXUk3V8ZpB4vKEQYlp5REHWG8QBcFZ43Ky58l2yrFOXr87BAMdvICj+An8T9iNqKJkxJVjHa3FwqxoQi+8zVAycn6a5WEUS47+uvr2Y106ZvcNe2wwjVIr7pyK4iSHT7X/2xyHtvQQfJv6X1RIW/RKPs7Dp6rwm777c1c31zFIif4n2ZBZPh6cQHouVuZZ/psWh+eDUpsItnQH08pTEDQgmC8EA1t8h4ZGoTm/oq+wahAjX0dllA93To8cq2lo62JZmt/zyCmAVMPrVW126sVFxrVfeGagipe7J8xhY7yQJRDvsfjY3K+X/plaOPea7rPIMpYZDCBjIycSZrIOyasDmHeU6qhOnOuUroJGaSYcq7OWIEw0NaDfuXMrrTFJ1BrFbKN5EEsOFs8VPSIi1WiFwb2qlcJFTU4Y27zXD1RIWhAf22GxdA8uqhNWuNlpM+SfPspsYrWLMOS3de7TWPML4yKDu8dMQDKCS4UvP4Nzyy6pce1fY7jmRRz9HCI+g/BDhgcfrjJ3rGQ7E/E8O5BJlU7rsWkIGl3BW1uPu/nv9/1letElbGrm+zVdVOQyfyRAItXdsb4XCUCAwEAAQ==
```

#### 5. Update the Integration Merchant ID

Please update the following configuration under **index.php**
```
'merchantId' => 'M100001040', // To be replace by integration merchant ID
```


#### 6. Execute the script index.php
```
{"sign":"Jge+PvwbiK39g89acUF69JSD0NsiAqe7Uc/CwkmG4Uo/YXNEn8f9d0YE1++oI3IPOY7/6Xz8bpdEW6U5PUNvSA==","ResCode":"TPB017","ResStatus":1,"ResMsg":"BAR code has been used, please refresh"}
```
