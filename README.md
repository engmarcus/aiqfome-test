# Aiqfome - API de Produtos Favoritos

API RESTful desenvolvida como parte de um desafio técnico para o Aiqfome, com o objetivo de gerenciar **clientes** e seus **produtos favoritos**, integrando com a API pública [Fake Store API](https://fakestoreapi.com/docs).

---

## Contexto

O Aiqfome está expandindo seus canais de integração e precisa de uma API robusta para gerenciar os "produtos favoritos" de usuários. Esta funcionalidade será utilizada por aplicativos e interfaces web, exigindo alta performance, escalabilidade e integração com APIs externas confiáveis.

---

##  Requisitos Atendidos

- [x] Criar, visualizar, editar e remover clientes
- [x] Garantir unicidade do e-mail
- [x] Associar produtos favoritos aos clientes
- [x] Validar produtos com a API externa (`fakestoreapi.com`)
- [x] Evitar duplicação de produtos favoritos
- [x] Exibir `id`, `title`, `image`, `price` e `rating` do produto
- [x] Autenticação via token JWT
- [x] Arquitetura modular e separada por camadas
- [x] Documentação Swagger
- [x] Docker + PostgreSQL prontos para produção
- [x] Cache implementado para performance

---

## Arquitetura e Decisões Técnicas

- A aplicação foi escrita em **Laravel 12 (PHP 8.2)** por ser o ambiente mais estável no momento da entrega.
- A arquitetura é modular e baseada em **camadas separadas**: DTOs, Mappers, Clients HTTP, Controllers e Middleware.
- A API conta com **sistema de cache** para reduzir chamadas repetidas à API externa.
- Foram escritos **testes automatizados** como demonstração de qualidade e estrutura, embora o ambiente `.env.testing` precise ser configurado.
- A intenção era criar uma versão paralela em **Node.js**, mas optei por focar em uma entrega sólida e bem testada dentro do prazo.

---

---
## Próximos Passos e Melhorias Sugeridas

A aplicação foi pensada com escalabilidade e boas práticas em mente. A seguir estão algumas sugestões para evolução da arquitetura:

-  **Orquestração com Kubernetes**
  Containerizar a aplicação com suporte ao Kubernetes e práticas de CI/CD, permitirá escalar horizontalmente conforme a demanda.
-  **Vault para gerenciamento de segredos**
  A utilização do [HashiCorp Vault](https://www.vaultproject.io/) permitirá injetar credenciais, secrets e tokens sensíveis de forma segura e auditável.
- **Redis como sistema de cache distribuído**
  A troca do cache local por uma instância do Redis permitirá maior eficiência e compatibilidade em ambientes com múltiplas réplicas, além de habilitar features como TTL por item, filas assíncronas e pub/sub para eventos.
- **Autoescalabilidade**
  A configuração de métricas de uso (CPU/RAM) via Horizontal Pod Autoscaler (HPA) no Kubernetes permitirá escalar os pods da API automaticamente de acordo com a carga de trabalho.

- **Monitoramento e observabilidade**
  Ferramentas como Prometheus + Grafana ou Elastic Stack (ELK) podem ser utilizadas para monitorar desempenho, rastrear erros e analisar métricas em tempo real.

- **Mais testes e CI/CD completo**
  Expandir a cobertura de testes (unitários e integração) e configurar pipelines CI/CD com validação automatizada antes do deploy.

- **Rate limiting e proteção contra abuso**
  Implementar controle de requisições por IP ou token com Laravel RateLimiter + Redis, para proteger a API de uso indevido.

```
Essas melhorias visam preparar a aplicação para ambientes de produção de alta escala e uso intensivo.

```
---

## Tecnologias Utilizadas

- Laravel 12
- PHP 8.2
- PostgreSQL
- Docker + Docker Compose
- JWT Auth
- API externa: [https://fakestoreapi.com](https://fakestoreapi.com)

---

##  Autenticação

A API é pública, mas requer autenticação via token JWT.

Exemplo de header:

```
Authorization: Bearer {seu_token_aqui}
```



## Instalação Local

### 1. Clonar e preparar

```bash
git clone https://github.com/engmarcus/aiqfome-test
cd aiqfome-test
cp .env.example .env
```

### 2. Instalar dependências, gerar chave e segredo JWT

```bash
composer install
```
```bash
php artisan key:generate
```
```bash
php artisan jwt:secret
```


### 3. Ajustar o `.env`
Conforme seu ambiente

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=aiqfome
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Preparar o banco de dados

Foi criado um comando personalizado que automatiza a criação do banco, execução das migrações e demais preparações iniciais.

```bash
php artisan app:setup
```

### 5. Iniciar servidor

```bash
php artisan serve
```

Acesse: [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

---

##  Rodando com Docker

### Clonar e preparar

```bash
git clone https://github.com/engmarcus/aiqfome-test
cd aiqfome-test
cp .env.docker .env
```

### Build e subida dos containers

```bash
docker compose up --build -d
```

### Acesso à aplicação

Após o build e inicialização dos containers, a aplicação exibirá uma **tela de loading** até que todas as dependências estejam prontas.

[http://localhost:8000](http://localhost:8000)

#### Tela de loading

![Tela de loading](docs/assets/loading-screen.png)


---

## Documentação (Swagger)

Disponível em:

```
http://localhost:8000/api/documentation
```
#### Tela de Documentação

![Tela de Documentação](docs/assets/doc.png)

---

##  Testes (rodando localmente - windows)

Testes foram implementados para validar comportamento da aplicação, porém é necessário configurar variáveis no `.env.testing`.

Rodar os testes:

```bash
php artisan test
```
#### Tela de Testes

![Tela de teste](docs/assets/tests.png)

---

##   API - Instruções de Uso

##  Autenticação via Swagger

Para utilizar os endpoints protegidos da API, siga os passos abaixo:

### 1. Cadastrar um novo cliente
Acesse o Swagger e vá até a seção **Clients**.

- Use a rota: `POST /api/v1/clients/register`
- Preencha os dados obrigatórios como `name`, `email` e `password`
- Exemplo de payload:
```json
{
  "name": "Ai Q Fome",
  "email": "user@aiqfome.com",
  "password": "senha123",
  "passwordConfirmation": "senha123"
}
```

### 2. Realizar login
Ainda no Swagger, acesse a rota: `POST /api/v1/auth/login`.

- Informe o `email` e `password` cadastrados.
- Você receberá uma resposta como esta:
```json
{
  "success": true,
  "message": "ok",
  "data": {
    "token": "eyJ0eXAiOiJK....",
    "tokenType": "Bearer",
    "expiresIn": 3600
  }
}
```

### 3. Autorizar no Swagger

Para que os endpoints autenticados funcionem:

- Clique no botão **Authorize** no canto superior direito da interface Swagger.
- No campo de autorização, cole o token no seguinte formato:

```
Bearer eyJ0eXAiOiJK...
```

- Clique em **Authorize** e depois em **Close**.

Pronto! Agora você pode testar as rotas autenticadas diretamente pela interface do Swagger.

---

## Notas
- O token de acesso expira em 1 hora.
- Sempre utilize o prefixo `Bearer ` antes do token ao autorizar.
- Caso o token expire, repita o processo de login para obter um novo.

---

## Possíveis Problemas

- Banco não sobe? Verifique `.env` e se o serviço `db` do Docker está ativo.
- Erro 500? Revise permissões, APP_KEY, JWT_SECRET ou variáveis ausentes.
- Problemas com seed/migration? Confirme permissões de volume ou banco.
- Pós Build com docker-compose error:
```bash
Building app
[+] Building 90.8s (16/16) FINISHED                                                                                                                                                               docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                        0.1s
 => => transferring dockerfile: 609B                                                                                                                                                                        0.1s
 => [internal] load metadata for docker.io/library/php:8.2-fpm                                                                                                                                              0.0s
 => [internal] load metadata for docker.io/library/composer:latest                                                                                                                                          0.0s
 => [internal] load .dockerignore                                                                                                                                                                           0.1s
 => => transferring context: 2B                                                                                                                                                                             0.0s
 => [stage-0 1/9] FROM docker.io/library/php:8.2-fpm                                                                                                                                                        0.0s
 => [internal] load build context                                                                                                                                                                          75.2s
 => => transferring context: 940.98kB                                                                                                                                                                      75.2s
 => FROM docker.io/library/composer:latest                                                                                                                                                                  0.0s
 => CACHED [stage-0 2/9] RUN apt-get update && apt-get install -y     git     curl     zip     unzip     libpq-dev     libonig-dev     libxml2-dev     libzip-dev     && docker-php-ext-install         pd  0.0s
 => CACHED [stage-0 3/9] COPY --from=composer:latest /usr/bin/composer /usr/bin/composer                                                                                                                    0.0s
 => CACHED [stage-0 4/9] WORKDIR /var/www                                                                                                                                                                   0.0s
 => [stage-0 5/9] COPY . /var/www                                                                                                                                                                           2.4s
 => [stage-0 6/9] COPY .docker/entrypoint.sh /usr/local/bin/entrypoint.sh                                                                                                                                   0.0s
 => [stage-0 7/9] COPY .docker/php.ini /usr/local/etc/php/conf.d/custom.ini                                                                                                                                 0.0s
 => [stage-0 8/9] RUN chmod +x /usr/local/bin/entrypoint.sh                                                                                                                                                 0.3s
 => [stage-0 9/9] RUN chown -R www-data:www-data /var/www                                                                                                                                                  12.0s
 => exporting to image                                                                                                                                                                                      0.6s
 => => exporting layers                                                                                                                                                                                     0.6s
 => => writing image sha256:d81e9f1f5d3e2354b573d8a8870ff9613089e0d2c8b056e81636daaa48f0333a                                                                                                                0.0s
 => => naming to docker.io/library/aiqfome-test_app                                                                                                                                                         0.0s
Starting laravel-db ... done
Recreating laravel-app ...

ERROR: for laravel-app  'ContainerConfig'

ERROR: for app  'ContainerConfig'
Traceback (most recent call last):
  File "/usr/bin/docker-compose", line 33, in <module>
    sys.exit(load_entry_point('docker-compose==1.29.2', 'console_scripts', 'docker-compose')())
             ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/cli/main.py", line 81, in main
    command_func()
  File "/usr/lib/python3/dist-packages/compose/cli/main.py", line 203, in perform_command
    handler(command, command_options)
  File "/usr/lib/python3/dist-packages/compose/metrics/decorator.py", line 18, in wrapper
    result = fn(*args, **kwargs)
             ^^^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/cli/main.py", line 1186, in up
    to_attach = up(False)
                ^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/cli/main.py", line 1166, in up
    return self.project.up(
           ^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/project.py", line 697, in up
    results, errors = parallel.parallel_execute(
                      ^^^^^^^^^^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/parallel.py", line 108, in parallel_execute
    raise error_to_reraise
  File "/usr/lib/python3/dist-packages/compose/parallel.py", line 206, in producer
    result = func(obj)
             ^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/project.py", line 679, in do
    return service.execute_convergence_plan(
           ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/service.py", line 579, in execute_convergence_plan
    return self._execute_convergence_recreate(
           ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/service.py", line 499, in _execute_convergence_recreate
    containers, errors = parallel_execute(
                         ^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/parallel.py", line 108, in parallel_execute
    raise error_to_reraise
  File "/usr/lib/python3/dist-packages/compose/parallel.py", line 206, in producer
    result = func(obj)
             ^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/service.py", line 494, in recreate
    return self.recreate_container(
           ^^^^^^^^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/service.py", line 612, in recreate_container
    new_container = self.create_container(
                    ^^^^^^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/service.py", line 330, in create_container
    container_options = self._get_container_create_options(
                        ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/service.py", line 921, in _get_container_create_options
    container_options, override_options = self._build_container_volume_options(
                                          ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/service.py", line 960, in _build_container_volume_options
    binds, affinity = merge_volume_bindings(
                      ^^^^^^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/service.py", line 1548, in merge_volume_bindings
    old_volumes, old_mounts = get_container_data_volumes(
                              ^^^^^^^^^^^^^^^^^^^^^^^^^^^
  File "/usr/lib/python3/dist-packages/compose/service.py", line 1579, in get_container_data_volumes
    container.image_config['ContainerConfig'].get('Volumes') or {}
    ~~~~~~~~~~~~~~~~~~~~~~^^^^^^^^^^^^^^^^^^^
KeyError: 'ContainerConfig'
```
Rode o comando pra limpar configurações e imagens antigas:

```bash
docker-compose down --volumes --remove-orphans && docker-compose build --no-cache && docker-compose up -d
```

---

## Licença

MIT © 2025 — Desenvolvido para o desafio técnico do Aiqfome por [Marcus Vinicius](https://www.linkedin.com/in/engenheiromarcus)
