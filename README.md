##Environment:

XAMPP Server (PHP 8.2 + 10.9.8-MariaDB)

##App:

Yii2 (basic version) REST API (http://localhost:8080) + Angular 16/Bootstrap frontend (http://localhost:4200)

- Yii2 folder: root
- Angular app folder: /app

- Authentication method: JWT (JSON Web Token) to access books CRUD endpoints

- Pages:
1. Initial login page (http://localhost:4200/login)
![alt text](https://github.com/fernandacanazzo/book-list-app/blob/main/login_page.png?raw=true)
2. Books CRUD (http://localhost:4200)
![alt text](https://github.com/fernandacanazzo/book-list-app/blob/main/index_page.png?raw=true)
##API:

- GET /book/index: returns book list;
- POST /book/create: creates new book;
- PATCH /book/update?id={id}: updates book {id};
- DELETE /book/delete?id={id}: deletes book {id};
- GET /weather: returns weather API data according to user location
- POST /auth/create: creates new Bearer token and authenticates user

##PS:

1. Integration JWT package was installed via composer

composer require sizeg/yii2-jwt

2. The file

- vendor\sizeg\yii2-jwt\JwtValidationData.php 

was missing from installation. For this extension to work it was necessary to manually include it:
https://github.com/sizeg/yii2-jwt/blob/master/JwtValidationData.php

3. Files

- vendor\lcobucci\jwt\src\Builder.php
- vendor\lcobucci\jwt\src\Token.php

were incomplete after yii2-jwt installation. It was necessary to copy version from the following repository and update them manually for the authentication to work:
https://github.com/lcobucci/jwt/blob/3.3/src/Token.php
https://github.com/lcobucci/jwt/blob/3.3/src/Builder.php

4. File config/params.php was added to gitignore as it includes Yii2 and HG weather API keys.
It's required to add the key created on https://console.hgbrasil.com/keys and another one generated using the HS256 algorithm.

- Add the following code with the created keys on config/params.php:

'apiKey' => 'HG-KEY',

'apiSecretKey' => 'SECRET-KEY',

'jwt' => [

	'issuer' => 'http://localhost:8080',  //name of your project (for information only)
	
	'audience' => 'http://localhost:4200',  //description of the audience, eg. the website using the authentication (for info only)
	
	'id' => 'UNIQUE-JWT-IDENTIFIER',  //a unique identifier for the JWT, typically a random string
	
	'expire' => 300,  //the short-lived JWT token is here set to expire after 5 min.
	
],

5. Run migrations before using app

---------------------------------------------------------------------------
(PT-BR)

##Ambiente:

Servidor XAMPP (PHP 8.2 + 10.9.8-MariaDB)

##App:

Yii2 (basic version) REST API (http://localhost:8080) + Angular 16/Bootstrap frontend (http://localhost:4200)

- Pasta Yii2: Raiz
- Pasta App Angular: /app

- Método Autenticação: JWT (JSON Web Token) para acesso aos endpoints do CRUD livros

- Páginas:
1. Tela inicial login (http://localhost:4200/login)
![alt text](https://github.com/fernandacanazzo/book-list-app/blob/main/login_page.png?raw=true)
2. CRUD livros (http://localhost:4200)
![alt text](https://github.com/fernandacanazzo/book-list-app/blob/main/index_page.png?raw=true)
##API:

- GET /book/index: lista livros;
- POST /book/create: criar um novo livro;
- PATCH /book/update?id={id}: atualiza o livro {id};
- DELETE /book/delete?id={id}: deleta o livro {id};
- GET /weather: retorna os dados da API de clima com base na localização do usuário;
- POST /auth/create: cria um novo Bearer token e autentica usuário

##Obs:

1. Foi instalado o pacote de integração JWT para o Yii2 através do composer

composer require sizeg/yii2-jwt

2. O arquivo 

- vendor\sizeg\yii2-jwt\JwtValidationData.php 

não foi incluído com a instalação. Para que essa extensão pudesse funcionar foi necessário incluí-lo manualmente: https://github.com/sizeg/yii2-jwt/blob/master/JwtValidationData.php

3. Os arquivos 

- vendor\lcobucci\jwt\src\Builder.php
- vendor\lcobucci\jwt\src\Token.php

vieram incompletos após a instalação do yii2-jwt. Foi necessário copiar a versão do seguinte repositório e atualizá-los manualmente para a autenticação funcionar:
https://github.com/lcobucci/jwt/blob/3.3/src/Token.php
https://github.com/lcobucci/jwt/blob/3.3/src/Builder.php

4. O arquivo config/params.php foi adicionado ao gitignore por conter as chaves das APIs do Yii2 e do HG weather. 
Será necessário adicionar uma chave criada pelo site https://console.hgbrasil.com/keys e uma gerada com o algoritmo HS256.

- Adicionar o seguinte trecho em config/params.php com as chaves já criadas:

'apiKey' => 'HG-KEY',

'apiSecretKey' => 'SECRET-KEY',

'jwt' => [

	'issuer' => 'http://localhost:8080',  //name of your project (for information only)
	
	'audience' => 'http://localhost:4200',  //description of the audience, eg. the website using the authentication (for info only)
	
	'id' => 'UNIQUE-JWT-IDENTIFIER',  //a unique identifier for the JWT, typically a random string
	
	'expire' => 300,  //the short-lived JWT token is here set to expire after 5 min.
	
],


5. Rodar as migrations antes de usar o app











