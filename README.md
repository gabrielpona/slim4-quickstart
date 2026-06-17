# Slim4-Quickstart (WIP)

Template base para desenvolvimento rápido de aplicações PHP utilizando o Slim Framework 4.

O objetivo deste projeto é fornecer uma estrutura simples, organizada e reutilizável para criação de sistemas administrativos, formulários, votações, inscrições e APIs de pequeno porte.

---

## Requisitos

* PHP 8.2 ou superior
* Composer
* Apache ou Nginx (opcional)
* MySQL/MariaDB (quando necessário)

---

## Dependências

| Pacote              | Finalidade               |
| ------------------- | ------------------------ |
| php-di/php-di       | Injeção de Dependência   |
| php-di/slim-bridge  | Integração Slim + PHP-DI |
| vlucas/phpdotenv    | Variáveis de Ambiente    |
| monolog/monolog     | Logging                  |
| doctrine/orm        | Doctrine ORM             |
| doctrine/dbal       | Doctrine DBAL            |
| symfony/cache       | ORM Cache                |
| slim/twig-view      | Templates Twig           |
| firebase/php-jwt    | Autenticação JWT         |

---

## Estrutura do Projeto

```text
.
├── public/
│   ├── .htaccess
│   ├── bootstrap.php
│   └── index.php
│
├── app/
│   ├── Controllers/
│   ├── Services/
│   ├── Repositories/
│   ├── Middleware/
│   ├── Models/
│   └── Routes/
│
├── config/
├── logs/
├── storage/
├── vendor/
│
├── .env
├── composer.json
└── README.md
```

---

## Instalação

Clone o repositório:

```bash
git clone https://github.com/seu-usuario/slim-base.git
cd slim-base
```

Instale as dependências:

```bash
composer install
```

---

## Executando Localmente

Utilizando o servidor embutido do PHP:

```bash
php -S localhost:8080 -t public
```

Acesse:

```text
http://localhost:8080
```

---

## Executando no Apache

Configure o `DocumentRoot` apontando para a pasta `public`.

Exemplo:

```apache
DocumentRoot "/caminho/do/projeto/public"

<Directory "/caminho/do/projeto/public">
    AllowOverride All
    Require all granted
</Directory>
```

---

## Executando em Subdiretórios

Caso a aplicação seja acessada através de uma URL como:

```text
http://localhost/slim-base
```

configure o Base Path:

```php
$app->setBasePath('/slim-base');
```

---

## Exemplo de Rota

```php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', function (
    Request $request,
    Response $response
) {
    $response->getBody()->write('Hello World');

    return $response;
});
```

---

## Ambiente de Desenvolvimento

Recomenda-se habilitar o Error Middleware durante o desenvolvimento:

```php
$app->addErrorMiddleware(
    true,
    true,
    true
);
```

---



## Licença

MIT License
