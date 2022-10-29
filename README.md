# Desafio Audax
### Um desafio de CRUD e relacionamento de tabelas usando Laravel, possuindo features solicitadas:

- [x] Validações nos campos,
- [x] Tratamento de erros,
- [x] uuid na versão 4,
- [x] Hash de senha,
- [x] Horario salvo em ISO8601,
- [x] Segurança de duplicidade de dados

## Documentação

## Primeiros passos:

- Crie um arquivo **.env** usando com base o **.env.exemple**, configure de acordo com seu banco
- Rode no terminal o comando:
 ```ruby
 php artisan migrate
 ```
 - Rode o comando:
 ```ruby
 php artisan db:seed
 ```
 para popular o banco(é opcional);
 **OBS: por isso esses campos não foram considerados unicos no banco e apenas por validação dos controllers, mas caso não use as seeds pode ser alterado nas migrations os campos que deseja que o banco considere unicos e rodar novamente a migrate**

- Rode o comando:
```ruby
php artisan serve
```
E o servidor estrá no ar na porta 8000
## Rotas

### Usuários

**OBS: Todas as rotas tem um prefixo de /api**

#### Tipo get, resgata todos os usuários paginados(10 por página).
#### para acessar as demais página adiciona ?page=Número da página.

```ruby
/api/users
```
Retorna um array de usuários:

```ruby
{
    "id": 1,
    "uuid": "cdd4a06c-55b6-11ed-a834-988389d531f9",
    "user_name": "dolorum",
    "created_at": "2022-10-28T01:01:23.000000Z",
    "updated_at": "2022-10-28T01:01:23.000000Z",
    "registered_at": "2022-10-28 19:44:10"
},
{
    "id": 2,
    "uuid": "ce42a95b-55b6-11ed-a834-988389d531f9",
    "user_name": "testess dadadefsfsnmdxsvfffsefsfs",
    "created_at": "2022-10-28T01:01:24.000000Z",
    "updated_at": "2022-10-28T22:26:29.000000Z",
    "registered_at": "2022-10-28 19:44:10"
},
```

#### Tipo get, Um usuário específico

```ruby
/api/users/:uuid
```

Retorna um usuário com base no uuid passada na url:

```ruby
{
    "id": 1,
    "uuid": "cdd4a06c-55b6-11ed-a834-988389d531f9",
    "user_name": "dolorum",
    "created_at": "2022-10-28T01:01:23.000000Z",
    "updated_at": "2022-10-28T01:01:23.000000Z",
    "registered_at": "2022-10-28 19:44:10"
},
```

#### Tipo post, Cria um usuário:
```ruby
/api/users
```

#### Deve ser passado no body os seguintes valores e chaves:

```ruby
{
"user_name": "Nome de mínimo 3 caracteres",
"password": "Senha De no mínimo 8 caracteres"
}
```
**OBS: As rotas de criação são as unicas que não retorna o uuid do usuário**

Retorna seu usuário criado:

```ruby
{
"user_name": "Seu user",
"updated_at": "2022-10-28T22:57:18.000000Z",
"created_at": "2022-10-28T22:57:18.000000Z",
"registered_at": "2022-10-28 19:44:10",
"id": 41
}
```
#### Tipo put, atualiza o usuário:

```ruby
/api/users/:uuid
```

#### Deve ser passado no body os seguintes valores e chaves:

```ruby
{
"user_name": "Nome de mínimo 3 caracteres",
"password": "Senha De no mínimo 8 caracteres"
}
```
Retorna seu usuário atualizado:

```ruby
{
	"id": 2,
	"uuid": "ce42a95b-55b6-11ed-a834-988389d531f9",
	"user_name": "testess dadadefsfsnmdxsvfffdsfssefsfs",
	"created_at": "2022-10-28T01:01:24.000000Z",
	"updated_at": "2022-10-28T22:57:32.000000Z",
	"registered_at": "2022-10-28 19:44:10"
}
```

#### Tipo delete, deleta o usuário:

```ruby
/api/user/:uuid
```
Retorna um status 204

### Articles

#### Tipo get, Resgata todos os article:

```ruby
/api/article
```
Retorna um array com todos os artigos e seus usuários

```ruby
{
    "id": 1,
    "uuid": "cddf34e9-55b6-11ed-a834-988389d531f9",
    "title": "fuga",
    "resume": "debitis",
    "text": "Natus tempora eum dolores dolorum inventore.",
    "slug": "dicta",
    "created_at": "2022-10-28T01:01:23.000000Z",
    "updated_at": "2022-10-28T01:01:23.000000Z",
    "user_id": 1,
    "registered_at": "2022-10-28 19:41:29",
    "user": {
        "id": 1,
        "uuid": "cdd4a06c-55b6-11ed-a834-988389d531f9",
        "user_name": "dolorum",
        "created_at": "2022-10-28T01:01:23.000000Z",
        "updated_at": "2022-10-28T01:01:23.000000Z",
        "registered_at": "2022-10-28 19:44:10"
    }
},
{
    "id": 3,
    "uuid": "cdf33e84-55b6-11ed-a834-988389d531f9",
    "title": "velit",
    "resume": "cum",
    "text": "Minus ut sed atque nihil est.",
    "slug": "optio",
    "created_at": "2022-10-28T01:01:23.000000Z",
    "updated_at": "2022-10-28T01:01:23.000000Z",
    "user_id": 1,
    "registered_at": "2022-10-28 19:41:29",
    "user": {
        "id": 1,
        "uuid": "cdd4a06c-55b6-11ed-a834-988389d531f9",
        "user_name": "dolorum",
        "created_at": "2022-10-28T01:01:23.000000Z",
        "updated_at": "2022-10-28T01:01:23.000000Z",
        "registered_at": "2022-10-28 19:44:10"
    }
},
```

#### Tipo get, Resgata um article passado no parâmetro:

```ruby
`/api/article/:uuid
```

Retorna um article e seu usuário

```ruby
{
    "id": 3,
    "uuid": "cdf33e84-55b6-11ed-a834-988389d531f9",
    "title": "velit",
    "resume": "cum",
    "text": "Minus ut sed atque nihil est.",
    "slug": "optio",
    "created_at": "2022-10-28T01:01:23.000000Z",
    "updated_at": "2022-10-28T01:01:23.000000Z",
    "user_id": 1,
    "registered_at": "2022-10-28 19:41:29",
    "user": {
        "id": 1,
        "uuid": "cdd4a06c-55b6-11ed-a834-988389d531f9",
        "user_name": "dolorum",
        "created_at": "2022-10-28T01:01:23.000000Z",
        "updated_at": "2022-10-28T01:01:23.000000Z",
        "registered_at": "2022-10-28 19:44:10"
    }
}
```

#### Tipo post, Cria um article:

```ruby
/api/article
```

#### Deve ser passado os seguintes valores:

```ruby
{
	"title": "Um titulo de minímo de 30 carateres e no máximo 70 caracteres",
	"resume": "Um resumo de mínimo 50 caracteres e no máximo 100 caracteres",
	"text": "Um texto de mínimo de 200 caracteres",
	"user_id": "Uuid do usuário que você quer adicionar ao artigo"
}
```

Retorna a article criada

```ruby
{
     "id": 3,
    "uuid": "cdf33e84-55b6-11ed-a834-988389d531f9",
    "title": "Lain, gurren laggan e kill la kill melhores animes da terra , sim ou claro?",
    "resume": "Melhores animes e não tem oque pensar além disso",
    "text": "Miojinho bom",
    "slug": "lain-gurren-laggan-e-kill-la-kill-melhores-animes-da-terra-sim-ou-claro?",
    "created_at": "2022-10-28T01:01:23.000000Z",
    "updated_at": "2022-10-28T01:01:23.000000Z",
    "user_id": 1,
    "registered_at": "2022-10-28 19:41:29",
}
```

#### Tipo put, resgata o article passado de parâmentro:

```ruby
/api/article/:uuid
```

```ruby
{
	"title": "Um titulo de minímo de 30 carateres e no máximo 70 caracteres",
	"resume": "Um resumo de mínimo 50 caracteres e no máximo 100 caracteres",
	"text": "Um texto de mínimo de 200 caracteres",
	"user_id": "Uuid do usuário que você quer adicionar ao artigo"
}
```

Retorna a article atualizada

```ruby
{
     "id": 3,
    "uuid": "cdf33e84-55b6-11ed-a834-988389d531f9",
    "title": "Glory To Mankind",
    "resume": "It's a curse?",
    "text": "Nier Automata melhor jogo do mundo",
    "slug": "glory-to-mankind",
    "created_at": "2022-10-28T01:01:23.000000Z",
    "updated_at": "2022-10-28T01:01:23.000000Z",
    "user_id": 1,
    "registered_at": "2022-10-28 19:41:29",
}
```

#### Tipo delete, deleta o article de acordo com o uuid:

```ruby
/api/article/:uuid
```

Retorna um status 204

# Qualquer duvida entre em contato:

<a href="https://www.linkedin.com/in/matheus-victor-henrique-270640236/" target="_blank"><img src="https://img.shields.io/badge/-LinkedIn-%230077B5?style=for-the-badge&logo=linkedin&logoColor=white" target="_blank"></a> 

```ruby
{
   "author":"Matheus",
   "Framework": "Laravel",
   "Project": "Desafio Audax"
}
```
