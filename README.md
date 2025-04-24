# Controle de Animes

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

## 📋 Sobre o Projeto

Sistema de controle e gerenciamento de animes desenvolvido com Laravel 9. Este projeto permite que os usuários organizem e acompanhem seus animes favoritos, mantendo um registro detalhado do progresso de assistência.

## 🚀 Funcionalidades

### Sistema de Autenticação
- Registro de usuários
- Login/Logout
- Perfil de usuário personalizado
- Proteção de rotas

### Gerenciamento de Animes
- Cadastro de animes com integração à API Kitsu
- Busca automática de informações e imagens dos animes
- Lista personalizada de animes por usuário
- Edição e remoção de animes
- Visualização em cards com imagens dos animes

### Controle de Temporadas e Episódios
- Organização por temporadas
- Listagem de episódios por temporada
- Interface intuitiva com sistema de acordeão
- Visualização do número total de episódios por temporada

### Sistema de Progresso
- Marcação de episódios como:
  - Assistido
  - Em andamento
  - Não assistido
- Marcação rápida de temporada inteira
- Feedback visual do status de cada episódio
- Progresso individual por usuário

### Interface e UX
- Design responsivo com Bootstrap
- Tema claro/escuro
- Notificações toast para feedback de ações
- Ícones intuitivos
- Interface moderna e amigável

### Recursos Técnicos
- Integração com API externa (Kitsu)
- Sistema de cache para otimização
- Validações de formulários
- Proteção CSRF
- Migrations para versionamento do banco de dados

## 🛠️ Tecnologias Utilizadas

- PHP 8.0.2+
- Laravel 9
- MySQL
- Bootstrap 5
- JavaScript
- API Kitsu
- Biblioteca de ícones Bootstrap

## 📦 Requisitos

- PHP >= 8.0.2
- Composer
- MySQL
- Node.js e NPM

## 🔧 Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/controle-animes.git
```

2. Instale as dependências do PHP:
```bash
composer install
```

3. Instale as dependências do Node.js:
```bash
npm install
```

4. Copie o arquivo de ambiente:
```bash
cp .env.example .env
```

5. Gere a chave da aplicação:
```bash
php artisan key:generate
```

6. Configure o banco de dados no arquivo `.env`

7. Execute as migrações:
```bash
php artisan migrate
```

8. Inicie o servidor:
```bash
php artisan serve
```

## 🔄 Atualizações Recentes

### v1.1.0
- Implementação do sistema de progresso de episódios
- Adição do tema claro/escuro
- Melhorias na interface do usuário
- Correção de bugs na autenticação

### v1.0.0
- Lançamento inicial
- Sistema básico de gerenciamento de animes
- Autenticação de usuários
- Integração com API Kitsu

## 🤝 Contribuindo

Contribuições são sempre bem-vindas! Sinta-se à vontade para abrir issues ou enviar pull requests.

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 📧 Contato

Rafael da Rosa Ferreira - [LinkedIn](https://www.linkedin.com/in/rafael-da-rosa-ferreira-3767181b6/)

Link do Projeto: [https://github.com/Rafinha-rf/controle-animes](https://github.com/Rafinha-rf/controle-animes)
