## Objetivo: 
Criar uma aplicação web em PHP com acesso restrito, que exiba uma listagem de livros com as opções de ver os detalhes, editar, deletar e criar um livro, e também exiba o clima atual da sua região.

O prazo para realização do teste é de 3 dias. 
Após o término da prova, colocar o código em algum repositório público (github, gitlab, bitbucket.. ) e então informar nas respostas o caminho onde está a prova para avaliação respondendo o email.

## Funcionalidades:

1) Tela de Login
    • A tela inicial deve ser a de login;
    • Não deve ser possível acessar outras telas sem realizar o login;

2) CRUD de Livros
    • Listagem de livros com paginação e filtragem;
    • Adição e Edição de Livros;
        ◦ Dados do Livro
            ▪ Título;
            ▪ Descrição;
            ▪ Autor;
            ▪ Número de Páginas;
            ▪ Data de Cadastro;
    • Exclusão de um livro.

3) Clima da região
    • Integração com API externa para exibir o clima de uma determinada região;
    • Mostrar apenas o Clima atual.
        ◦ API https://hgbrasil.com/status/weather. Consultar documentação https://console.hgbrasil.com/documentation/weather.

### Instalação

- **cd desafio-book**
- **./vendor/bin/sail up**
- **./vendor/bin/sail php artisan migrate:fresh --seed**
- **./vendor/bin/sail npm install**
