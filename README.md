
# Dotme 


Dotme é um projeto full-stack desenvolvido como Projeto Integrado (PI), trabalho de conclusão do curso Técnico em Informática do Senac.

A proposta é criar uma plataforma gratuita que ajude uma empresa ou a comunidade geral.

# Objetivo

Oferecer uma ferramenta acessível para tutores e amantes de pets realizarem doações, encontrarem novos lares para seus animais, ou localizarem pets desaparecidos.

## Funcionalidades principais

- Cadastro e configuração de perfil de usuário;
- Feed de animais disponíveis para adoção;
- Feed de animais desaparecidos;
- Postagem de pets (doação ou desaparecidos);
- Postagem de depoimentos;
- Envio de feedbacks sobre a plataforma;

## Tecnologias utilizadas

- PHP/Laravel
- JavaScript
- HTML/CSS
- Bootstrap
- Swiper.js (Biblioteca de carrossel)

## Rodando o projeto localmente

### Pré-requisitos

- PHP >= 8.1
- Composer
- MySQL
- npm
- Git

### Passo a passo

#### 1. Clone e acesse o repositório

git clone https://github.com/VictorPreviato/projetointegrador-laravel-.git
cd projetointegrador-laravel-

#### 2. Instale as dependências PHP com o Composer
composer install

#### 3. Instale as dependências front-end com o npm
npm install
npm run dev

#### 4. Configuração do .env
Para este projeto, o arquivo .env **não está incluído no .gitignore**, por tratar-se de um projeto educacional não utilizamos senhas sensíveis no banco de dados

#### 5. Rode as migrations para criar as tabelas no banco
php artisan migrate

#### 6. Inicie o servidor de desenvolvimento
php artisan serve

A aplicação estará disponível em: http://localhost:8000


<p align="center">
<img src="/public/IMG/LOGOS/DotPetLogT.png" alt="Logo Dotme" width="300"/>
</p>
