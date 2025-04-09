# Informações

- Nome: Nélio Souza Alves
- E-mail: nelio13alves@gmail.com
- Cargo: Análista de tecnologia da informação
- Perfil profissional: Desenvolvedor PHP

> Observação: Para o desenvolvimento da API foi utilizado o API-Platform.

- Como testar a aplicação?
  - Requisitos: Docker
  - Passo a passo
    - Clonar o repositorio
    - Executar o comando: `docker compose up --wait`
    - Acessar o localshot: `https://localhost`
    - Acessar a página de admin caso queira utilzar o admin para realizar os cadastros.
    - Acessar a api caso queiram cadastrar os dados via API.

# Requisitos gerais da prova

- A. Implementar mecanismo de autorização e autenticação, bem como não permitir acesso ao endpoint a partir de domínios diversos do qual estará hospedado o serviço;
- B. A solução de autenticação deverá expirar a cada 5 minutos e oferecer a possibilidade de renovação do período;
- C. ~~Implementar pelo menos os verbos post, put, get;~~
- D. ~~Conter recursos de paginação em todas as consultas;~~
- E. ~~Os dados produzidos deverão ser armazenados no servidor de banco de dados previamente criado em container;~~
- F. ~~Orquestrar a solução final utilizando Docker Compose de modo que inclua todos os contêineres utilizados.~~

# Requisitos Específicos

- ~~Implementar uma API Rest para o diagrama de banco de dados acima tomando por base as seguintes orientações:~~
- ~~Criar um CRUD para Servidor Efetivo, Servidor Temporário, Unidade e Lotação. Deverá ser contemplado a inclusão e edição dos dados das tabelas relacionadas;~~
- ~~Criar um endpoint que permita consultar os servidores efetivos lotados em determinada unidade parametrizando a consulta pelo atributo unid_id;~~
   - ~~Retornar os seguintes campos: Nome, idade, unidade de lotação e fotografia;~~
- ~~Criar um endpoint que permita consultar o endereço funcional (da unidade onde o servidor é lotado) a partir de uma parte do nome do servidor efetivo.~~
- Realizar o upload de uma ou mais fotografias enviando-as para o Min.IO;
- A recuperação das imagens deverá ser através de links temporários gerados pela biblioteca do Min.IO com tempo de expiração de 5 minutos.

# Instruções:

- A. O projeto deverá estar disponível no Github
- Crie um arquivo README.md contendo seus dados de inscrição bem como orientações de como executar e testar a solução apresentada.
- Decorrido o prazo de entrega, nenhum outro commit deverá ser enviado ao repositório do projeto.
- Adicione as dependências que considerar necessárias;
-  Deverá estar disponível no repositório de versionamento todos os arquivos e scripts utilizados para a solução.

<h1 align="center"><a href="https://api-platform.com"><img src="https://api-platform.com/images/logos/Logo_Circle%20webby%20text%20blue.png" alt="API Platform" width="250" height="250"></a></h1>

API Platform is a next-generation web framework designed to easily create API-first projects without compromising extensibility
and flexibility:

* Design your own data model as plain old PHP classes or [**import an existing ontology**](https://api-platform.com/docs/schema-generator).
* **Expose in minutes a hypermedia REST or a GraphQL API** with pagination, data validation, access control, relation embedding,
  filters, and error handling...
* Benefit from Content Negotiation: [GraphQL](https://api-platform.com/docs/core/graphql/), [JSON-LD](https://json-ld.org), [Hydra](https://hydra-cg.com),
  [HAL](https://github.com/mikekelly/hal_specification/blob/master/hal_specification.md), [JSON:API](https://jsonapi.org/), [YAML](https://yaml.org/), [JSON](https://www.json.org/), [XML](https://www.w3.org/XML/) and [CSV](https://www.ietf.org/rfc/rfc4180.txt) are supported out of the box.
* Enjoy the **beautiful automatically generated API documentation** ([OpenAPI](https://api-platform.com/docs/core/openapi/)).
* Add [**a convenient Material Design administration interface**](https://api-platform.com/docs/admin) built with [React](https://reactjs.org/)
  without writing a line of code.
* **Scaffold fully functional Progressive-Web-Apps and mobile apps** built with [Next.js](https://api-platform.com/docs/client-generator/nextjs/) (React),
[Nuxt.js](https://api-platform.com/docs/client-generator/nuxtjs/) (Vue.js) or [React Native](https://api-platform.com/docs/client-generator/react-native/)
thanks to [the client generator](https://api-platform.com/docs/client-generator/) (a Vue.js generator is also available).
* Install a development environment and deploy your project in production using **[Docker](https://api-platform.com/docs/distribution)**
and [Kubernetes](https://api-platform.com/docs/deployment/kubernetes).
* Easily add **[OAuth](https://oauth.net/) authentication**.
* Create specs and tests with **[a developer friendly API testing tool](https://api-platform.com/docs/distribution/testing/)**.

The official project documentation is available **[on the API Platform website](https://api-platform.com)**.

API Platform embraces open web standards and the
[Linked Data](https://www.w3.org/standards/semanticweb/data) movement. Your API will automatically expose structured data.
It means that your API Platform application is usable **out of the box** with technologies of
the semantic web.

It also means that **your SEO will be improved** because **[Google leverages these formats](https://developers.google.com/search/docs/guides/intro-structured-data)**.

Last but not least, the server component of API Platform is built on top of the [Symfony](https://symfony.com) framework,
while client components leverage [React](https://reactjs.org/) ([Vue.js](https://vuejs.org/) flavors are also available).
It means that you can:

* Use **thousands of Symfony bundles and React components** with API Platform.
* Integrate API Platform in **any existing Symfony, React, or Vue application**.
* Reuse **all your Symfony and JavaScript skills**, and benefit from the incredible amount of documentation available.
* Enjoy the popular [Doctrine ORM](https://www.doctrine-project.org/projects/orm.html) (used by default, but fully optional:
  you can use the data provider you want, including but not limited to MongoDB and Elasticsearch)

## Install

[Read the official "Getting Started" guide](https://api-platform.com/docs/distribution/).

## Credits

Created by [Kévin Dunglas](https://dunglas.fr). Commercial support is available at [Les-Tilleuls.coop](https://les-tilleuls.coop).
