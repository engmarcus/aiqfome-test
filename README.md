# Aiqfome - API de Produtos Favoritos

API RESTful desenvolvida para gerenciar **clientes** e seus **produtos favoritos** dentro da plataforma Aiqfome, integrando com a API pública [Fake Store API](https://fakestoreapi.com/docs).

---

## 📦 Tecnologias Utilizadas

- Laravel 12 (PHP 8.2)
- PostgreSQL
- Docker + Docker Compose
- Composer
- API externa: [https://fakestoreapi.com](https://fakestoreapi.com)

---

## Funcionalidades

### Clientes

- Criar, listar, editar e excluir clientes
- Campos obrigatórios: `nome`, `email`
- **Validação**: e-mail único por cliente

### Favoritos

- Relacionamento 1:N entre cliente e produtos favoritos
- Integração com API externa para validação dos produtos
- Um produto não pode ser duplicado na lista de um cliente
- Produto favorito inclui: `id`, `title`, `image`, `price` e `rating`

---

## 🔐 Autenticação

A API é pública, mas requer autenticação via token.

Exemplo de header:

```
Authorization: Bearer {seu_token_aqui}
```

---

## 🧰 Pré-requisitos

- PHP 8.2+
- Composer
- Docker e Docker Compose
- Git

---

## Instalação Local

### Clonar e preparar

```bash
git clone https://github.com/engmarcus/aiqfome-test
cd aiqfome-test
cp .env.example .env
```

### 🔑 Gerar chaves e configurar ambiente

1. Gere a chave da aplicação e o segredo JWT:

```bash
php artisan key:generate
php artisan jwt:secret
```

2. Preencha os campos obrigatórios no arquivo `.env`:

```env
APP_KEY= # preenchido automaticamente com o comando acima
JWT_SECRET= # preenchido automaticamente com o comando acima
#adicione seu dados de conecxão
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=aiqfome
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 📦 Instalar dependências e migrar

```bash
composer install
php artisan migrate
```

### ▶️ Iniciar localmente

```bash
php artisan serve
```

Acesse: [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

---

## 🐳 Rodando com Docker

```bash
docker compose up --build -d
```

---

## Documentação (Swagger)

```
http://localhost:8000/api/documentation
```

---

## Possíveis Problemas

- Banco não sobe? Verifique `.env` e se o serviço `db` do Docker está rodando.
- Falha no seed/migration: confira permissões de volume/banco.
- Erro 500: reveja permissões, chaves ou variáveis ausentes no `.env`.

---

## Licença

MIT © 2025 - Desenvolvido para o desafio técnico Aiqfome
