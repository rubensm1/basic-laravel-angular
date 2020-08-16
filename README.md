# Instalação

## Código e dependências 

Para a instalação, é necessário: 

1. Instalar Wamp, Xampp ou Lampp

2. Instalar [Composer](https://getcomposer.org/download/)

3. Instalar Git

4. Clonar repositório no diretório de páginas do Apache

5. Entrar no diretório via terminal

6. Executar o comando:

`composer update`

7. Instalar [NodeJS](https://nodejs.org/)

8. Entrar no diretório `resources/assets/front`

9. Executar os comandos:
```
npm install -g @angular/cli

ng update --all
```


------
## Configuração do Apache

no diretório da instalação do apache, acesse o arquivo Acesse o arquivo `conf/extra/httpd-vhosts.conf`
Adicione ao final do arquivo, substituindo `<caminho>` pelo diretório do site, configurado no apache
```
<VirtualHost *:80>
  ServerName inscricao
  DocumentRoot "<caminho>/processo-seletivo/public"
</VirtualHost>
```

## Configuração de nome Local

acesse o arquivo de dns local (no windows: "C:\Windows\System32\drivers\etc\hosts", no linux: "/etc/hosts")

Adicione: 

`127.0.0.1   localhost inscricao`

## Configuração do Banco de Dados

1. Acesse o servidor de banco de dados (pelo [phpmyadmin](http://localhost/phpmyadmin/), por exemplo)

2. Crie um banco de dados/esquema de nome `processo_seletivo` (ou o nome que desejar)

3. Conectado a este banco, execute o script localizado em `database/script.sql`

4. crie uma cópia do arquivo `.env.example` (na raiz do projeto) e o renomeie para `.env`

5. Edite o arquivo `.env` com as configurações necessárias (configurações de acesso ao banco de dados, por exemplo)


## Acessando

Acesse pelo navegador através do link [http://inscricao](http://inscricao/)


## Pendências
Redução de volume da dados para requisições de inscrições