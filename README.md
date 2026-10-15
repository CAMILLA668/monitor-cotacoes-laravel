# 📈 Monitoramento de Cotações

Sistema educacional desenvolvido em **Laravel** com o objetivo de praticar, de forma integrada, conceitos de desenvolvimento de sistemas utilizando PHP, Laravel, banco de dados, consumo de API, autenticação, comandos Artisan, Scheduler, envio de e-mails e testes automatizados.

O projeto foi desenvolvido durante as aulas pelos alunos, permitindo que os alunos realizassem a construção das principais funcionalidades de uma aplicação web.

Esta versão representa o gabarito do projeto finalizado pelo professor, podendo estar divergente a versão desenvolvida por cada aluno.

---

## 🎯 Objetivo do projeto

O sistema permite acompanhar cotações de ativos financeiros, consultar seu histórico de preços e criar alertas personalizados para determinadas condições de preço.

O projeto utiliza a **AwesomeAPI** para obter as cotações dos ativos cadastrados.

### Funcionalidades principais

* 🔐 Autenticação de usuários
* 📊 Visualização das cotações
* 🔄 Atualização das cotações através de API
* 📈 Histórico de preços
* 🔔 Criação de alertas
* ✏️ Edição de alertas
* 🗑️ Exclusão de alertas
* 📧 Notificação por e-mail quando um alerta é atingido
* ⏱️ Atualização automática através do Scheduler
* 🧪 Testes automatizados das principais funcionalidades

---

# 🛠️ Tecnologias utilizadas

* **PHP**
* **Laravel**
* **SQLite**
* **Blade**
* **Vite**
* **Tailwind CSS**
* **AwesomeAPI**
* **PHPUnit / Laravel Testing**

---

# 📌 Principais funcionalidades

## 🔐 Autenticação

O usuário precisa estar autenticado para acessar as funcionalidades principais do sistema.

O projeto utiliza os recursos de autenticação do próprio Laravel.

### 📷 Screenshot — Login

![Login](docs/images/login.png)

---

## 📊 Monitoramento de cotações

A tela principal apresenta os ativos cadastrados e suas respectivas cotações.

As informações são obtidas através da AwesomeAPI e armazenadas no banco de dados.

### 📷 Screenshot — Tela principal

![Dashboard](docs/images/dashboard.png)

---

## 🔄 Atualização das cotações

As cotações podem ser atualizadas através do processo desenvolvido no projeto.

O comando responsável é:

```bash
php artisan quotes:update
```

Esse processo:

1. Consulta a API;
2. Atualiza os ativos;
3. Registra o histórico;
4. Verifica os alertas cadastrados.

---

## 📈 Histórico de preços

Cada atualização válida de uma cotação pode gerar um registro no histórico do respectivo ativo.

### 📷 Screenshot — Histórico

![Histórico](docs/images/historico.png)

---

## 🔔 Alertas de preço

O usuário pode criar alertas informando:

* ativo;
* preço desejado;
* condição.

As condições disponíveis são:

* **Acima de**
* **Abaixo de**

Quando a condição é atingida, o sistema realiza o disparo do alerta.

### 📷 Screenshot — Lista de alertas

![Lista de Alertas](docs/images/alertas.png)

### 📷 Screenshot — Criando um alerta

![Criar Alerta](docs/images/criar-alerta.png)

---

## 📧 Notificação por e-mail

Quando um alerta é atingido, o sistema envia uma notificação por e-mail ao usuário.

Durante o desenvolvimento, o envio pode ser configurado para o `log` do Laravel, permitindo verificar o conteúdo da mensagem sem utilizar um serviço de e-mail real.



# ⏱️ Atualização automática

O Laravel Scheduler é utilizado para executar periodicamente o comando de atualização das cotações.

A programação utilizada no projeto executa:

```text
quotes:update
```

periodicamente.

Para verificar as tarefas configuradas:

```bash
php artisan schedule:list
```

Para executar o Scheduler durante o desenvolvimento:

```bash
php artisan schedule:work
```

---

# 🗃️ Estrutura principal

Os principais componentes desenvolvidos no projeto incluem:

```text
app/
├── Console/
│   └── Commands/
│       └── UpdateQuotesCommand.php
│
├── Http/
│   ├── Controllers/
│   └── Requests/
│
├── Mail/
│   └── PriceAlertTriggered.php
│
├── Models/
│   ├── User.php
│   ├── Asset.php
│   ├── PriceHistory.php
│   └── PriceAlert.php
│
└── Services/
    ├── QuoteService.php
    └── AlertService.php
```

### Responsabilidades principais

**QuoteService**

Responsável pela comunicação com a API e atualização das cotações.

**UpdateQuotesCommand**

Executa o processo de atualização das cotações através do Artisan.

**AlertService**

Verifica as condições dos alertas e realiza o processamento quando uma condição é atingida.

**PriceHistory**

Armazena o histórico das cotações.

**PriceAlert**

Representa os alertas cadastrados pelos usuários.

**PriceAlertTriggered**

Responsável pela estrutura do e-mail enviado quando um alerta é atingido.

---

# 🔄 Fluxo básico do sistema

```text
Usuário
   │
   ▼
Login
   │
   ▼
Visualização das cotações
   │
   ▼
Atualização das cotações
   │
   ▼
AwesomeAPI
   │
   ▼
Atualização dos ativos
   │
   ├──────────────► Histórico
   │
   ▼
Verificação dos alertas
   │
   ▼
Condição atingida?
   │
   ├── Não ──► Continua monitorando
   │
   └── Sim
         │
         ▼
     Envio do e-mail
         │
         ▼
     Alerta disparado
```

---

# ⚙️ Configuração

Após configurar o projeto Laravel, ajuste o arquivo `.env` com as informações necessárias.

Exemplo:

```env
APP_NAME="Monitoramento de Cotações"

DB_CONNECTION=sqlite

QUOTE_API_URL=https://economia.awesomeapi.com.br/json/last/USD-BRL,EUR-BRL,GBP-BRL,BTC-BRL,ETH-BRL

MAIL_MAILER=log
MAIL_FROM_ADDRESS=marketwatch@example.com
MAIL_FROM_NAME="Monitoramento de Cotações"
```

Depois, execute:

```bash
php artisan migrate
```

Para executar os seeders:

```bash
php artisan db:seed
```

---

# ▶️ Executando o projeto

Instale as dependências:

```bash
composer install
npm install
```

Execute o Vite:

```bash
npm run dev
```

Em outro terminal, execute o Laravel:

```bash
php artisan serve
```

A aplicação estará disponível em:

```text
http://localhost:8000
```

---

# 🧪 Testes

Os testes podem ser executados através do comando:

```bash
php artisan test
```

Também é possível verificar as rotas:

```bash
php artisan route:list
```

E limpar os caches da aplicação:

```bash
php artisan optimize:clear
```

---

# 🎓 Objetivo educacional

Este projeto foi desenvolvido principalmente como **material prático de aprendizagem**.

Durante sua construção são trabalhados conceitos como:

* estrutura MVC;
* rotas;
* Controllers;
* Models e Eloquent;
* migrations;
* relacionamentos;
* validação;
* autenticação;
* consumo de APIs;
* Services;
* comandos Artisan;
* Scheduler;
* envio de e-mails;
* banco de dados;
* testes automatizados;
* organização de um projeto Laravel.

O objetivo principal não é disponibilizar uma aplicação comercial, mas proporcionar aos alunos uma experiência próxima do desenvolvimento de um sistema real, integrando diferentes funcionalidades em um único projeto.

---

# 👨‍🏫 Projeto desenvolvido em aula

Projeto desenvolvido com finalidade educacional, acompanhando a evolução das funcionalidades durante as aulas de desenvolvimento de sistemas.

**Tecnologia principal:** Laravel + PHP

**Banco de dados:** SQLite

**API de cotações:** AwesomeAPI
