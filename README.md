<p align="center">
    <img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400">
    <img src="https://s2.glbimg.com/AAFtO5HUFg5jLD0fbuw4_qG1B7c=/1200x/smart/filters:cover():strip_icc()/i.s3.glbimg.com/v1/AUTH_59edd422c0c84a879bd37670ae4f538a/internal_photos/bs/2018/7/N/7PVvISR9GWMFHNR7vfmw/helpay-1-.jpg" width="180"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>


## Desafio Helpay: Somos sua solução de pagamento definitiva
Foi realizado a criação de uma API em laravel<br>
Para emular o projeto, basta seguir os requisitos básico do Laravel 7.x, que se encontra no link: https://laravel.com/docs/7.x

Após o clone do projeto, basta entrar no projeto e seguir o procedimento abaixo<br>
<ul>
    <li>executar o comando "composer install"</li>
    <li>executar o comando "git clone https://github.com/laradock/laradock.git"</li>
</ul>

A API utiliza o laradock para instanciar o docker

Para utilizar o Docker na api, entre na pasta laradock e execute o comando "sudo docker-compose up -d nginx mysql phpmyadmin".<br>
OBS: Após o git clone do laradock, deve-se configurar um arquivo .env dentro da pasta laradock, existe um arquivo .env.example para melhor entendimento.

Para configurar o drive deve ter os arquivos "credentials.json" e "token.json".<br>
O arquivo "credentials.json" informe o seu "client_id" e "client_secret" caso queira utilizar o aplicativo google que criei, ou basta substituir o arquivo com a credenciais de seu aplicativo google.

O arquivo "token.json" é gerado pela a rota "api/google/callback", após definir seu "client_id" e "client_secret" no "credentials.json", quando solicitar a rota irá disponibilizar um link do google, para confirmar o uso da aplicação google, após isso irá retornar com o callback com código para gerar o "token.json"

Importante: Se atente a rota "api/google/callback", para o meu OAuth2.0 criei essa "http://localhost:8000/api/callback" nos direcionamento, se atente de adicionar a rota "api/google/callback" em seu OAuth2.0



#### Rotas da API

```
+--------+----------+--------------------------+-----------------+------------------------------------------------+------------+
| Domain | Method   | URI                      | Name            | Action                                         | Middleware |
+--------+----------+--------------------------+-----------------+------------------------------------------------+------------+
|        | GET|HEAD | /                        |                 | Closure                                        | web        |
|        | GET|HEAD | api/google/callback      |                 | App\Http\Controllers\GoogleController@callback | api        |
|        | POST     | api/products             | products.store  | App\Http\Controllers\ProductController@store   | api        |
|        | GET|HEAD | api/products             | products.list   | App\Http\Controllers\ProductController@list    | api        |
|        | GET|HEAD | api/products/{productId} | products.show   | App\Http\Controllers\ProductController@show    | api        |
|        | DELETE   | api/products/{productId} | products.delete | App\Http\Controllers\ProductController@delete  | api        |
|        | POST     | api/purchase             | orders.store    | App\Http\Controllers\OrderController@store     | api        |
+--------+----------+--------------------------+-----------------+------------------------------------------------+------------+

```

#### Rotas 
As rotas seguiu todas as especificações solicitada no documento de teste.<br>
Foi criado uma collection no <a href="https://documenter.getpostman.com/view/6533460/T1LVA4fe?version=latest">Postman</a> para dar apoio.


<br>

#### TDD
<img src="https://i.imgur.com/ayK5oAL.png">
<br>


## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
