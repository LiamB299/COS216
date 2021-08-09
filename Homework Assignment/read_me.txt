NOTE: Please view the seperate API document on how to use the API. test.js has a JSON string with different
parameters set and commented out ready for use and evaluation. The output is displayed in the console window
of the browser in JSON and printed as a string in test.html which has a button to send a request to the api.

task 2:
Password:
It is important for a password to contain special characters, digits and uppercase/lowercase 
combinations due to when a malicious user attempts to brute force the password of a user with 
a script the amount of processing time to do so exponentially increases with the use of the 
additional characters, as the hacker may attempt to use common password lists, and word lists 
which will break a text only password in a single case. Thus making it much much more difficult
to crack the password.

Hashing algorithm:
The Argon2I standard is recommeneded as a modern and safe standard specifically designed for
password hashing and protection. SHA and many commonly known standards are not secured with 
modern computers and exploits being known. It has won the pasword hashing competition in
2015. 

Salt: 
The salt is adding the first half of the password to itself.

API Key:
An API key by spec definition is a alphanumeric string. The key has multiple versions for 
security in the program.

Experimental high level:
The users surname is hashed using sha256 and a substr is used as the secret phrase.
A key is then generated holding the ID and privilege level of the user (only requests 
currently).
The string is padded to 20 chars if too short.
The key is now the private key.
The key is encrypted with the secret using AES128 to make the public key, used as the
API key for this project.

Simple:
MDA5 hash returns alphanumeric hashes. The email is hashed and used as the key...

Some designers specify the API key to be representative of something about the owner
the key and thus should be reversible. Here the key is linked to a user through the
database, to identify them. 