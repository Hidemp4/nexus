# neXus Implementation Context

Este arquivo descreve a visao do projeto `neXus` e uma linha cronologica detalhada para construir o sistema do ponto atual ate a versao final planejada.

O objetivo deste documento e servir como contexto fixo para agentes de IA que forem trabalhar neste projeto. Antes de implementar qualquer feature relacionada ao hub, leia este arquivo e preserve a direcao conceitual, visual e arquitetural aqui descrita.

## 1. Essencia Do Projeto

O `neXus` e um hub pessoal de projetos com estetica de terminal, laboratorio e interface operacional.

Ele nao deve se comportar como um portfolio tradicional, nem como uma simples lista de links. A experiencia desejada e a de um sistema high-tech minimalista que detecta, apresenta e inicializa modulos demonstraveis do ecossistema do autor.

Conceito central:

> O neXus nao lista todos os projetos. Ele inicializa apenas modulos publicos, curados e prontos para serem vistos.

Principios do produto:

- Minimalismo acima de escalabilidade excessiva.
- Poucos projetos, mas bem apresentados.
- Experiencia visual consistente com terminal/sistema operacional/laboratorio.
- Projetos devem ser tratados como modulos operacionais ou demos inicializaveis.
- O GitHub deve ser usado como fonte dinamica, mas a curadoria local deve continuar existindo.
- O sistema deve parecer vivo, mas sem depender de complexidade desnecessaria.

## 2. Estado Atual Do Projeto

Stack atual:

- Laravel 13.
- PHP 8.3+.
- Blade.
- Tailwind CSS 4.
- Vite 8.
- Alpine.js via CDN.
- SQLite local.

Rotas atuais:

- `/`: renderiza `resources/views/home.blade.php`.
- `/access`: renderiza `resources/views/pages/system.blade.php`.

Arquivos principais:

- `resources/views/layouts/app.blade.php`: layout base, tema visual, fonte, background, animacoes e footer.
- `resources/views/components/navbar.blade.php`: navbar fixa, links desktop, burger mobile e overlay mobile.
- `resources/views/home.blade.php`: landing page conceitual do neXus.
- `resources/views/pages/system.blade.php`: tela de acesso com simulacao de boot sequence e lista de modulos.
- `resources/css/app.css`: entrada Tailwind e configuracao de fontes.
- `resources/js/app.js`: atualmente vazio.
- `routes/web.php`: rotas web simples baseadas em closures.

Estado funcional atual:

- A home comunica a identidade do projeto.
- A tela `/access` ja simula um sistema operacional carregando.
- A lista de modulos ainda e estatica e definida diretamente dentro do JavaScript inline da view.
- Os modulos atuais apontam para demos/rotas futuras.
- Ainda nao existe integracao real com GitHub.
- Ainda nao existe tela intermediaria de modulo.
- Ainda nao existe cache/sync local.

## 3. Direcao Final Desejada

A versao final planejada deve funcionar assim:

1. O usuario acessa `/`.
2. A home apresenta o universo visual do `neXus`.
3. O usuario entra em `/access`.
4. A tela executa uma sequencia de boot/scan.
5. O sistema lista modulos detectados e curados.
6. O usuario seleciona um modulo por teclado ou clique.
7. O sistema navega para uma tela intermediaria `/module/{key}`.
8. A tela intermediaria apresenta detalhes operacionais do modulo.
9. O usuario pode abrir a demo, repositorio ou documentacao.

Fluxo desejado:

```txt
/home
  -> /access
    -> scan modules
    -> select module
      -> /module/{key}
        -> open.demo
        -> open.repository
        -> return.access
```

## 4. Decisoes De Produto Ja Tomadas

### 4.1 GitHub Topics Como Entrada Dinamica

Os projetos publicos devem ser detectados via GitHub topics, nao pelo nome do repositorio.

Topic principal:

```txt
nexus-module
```

Regra:

- Todo repositorio publico do GitHub com a topic `nexus-module` pode aparecer no `neXus`.
- Repositorios sem essa topic nao devem aparecer automaticamente.
- O nome do repositorio nao precisa comecar com `neXus`.
- O GitHub e a fonte dinamica, mas nao deve remover a necessidade de curadoria local.

### 4.2 Projetos Como Demos

Os projetos exibidos no `neXus` devem ser tratados como demos ou modulos demonstraveis.

Um projeto so deve aparecer quando estiver minimamente apresentavel, com pelo menos uma destas saidas:

- URL de demo/app publicado.
- Repositorio publico relevante.
- Documentacao ou pagina explicativa.

A narrativa correta nao e:

```txt
Aqui estao todos os meus projetos.
```

A narrativa correta e:

```txt
Aqui estao os modulos inicializaveis do meu ecossistema.
```

### 4.3 Sem Featured Modules

Nao implementar uma camada de `featured modules` neste momento.

Motivo:

- O autor nao possui muitos projetos.
- O sistema deve ser minimalista.
- Uma lista pequena e curada ja resolve a hierarquia de importancia.

### 4.4 Sem Categorizacao Pesada

Evitar categorias amplas demais como `interfaces`, `automation`, `commerce`, `learning`, `ai`, `infra`, etc. por enquanto.

Motivo:

- O volume de projetos sera baixo.
- Escalabilidade nao e o problema principal.
- Minimalismo e clareza importam mais.

Se uma categorizacao for necessaria no futuro, usar campos simples como `type` ou `runtime`, mas sem criar uma arquitetura complexa cedo demais.

### 4.5 Tela Intermediaria E A Feature Principal

A tela intermediaria de modulo e a feature mais importante do projeto depois da listagem dinamica.

Ela deve unir as ideias de:

- Manifesto do modulo.
- Status operacional.
- Descricao tecnica curta.
- Acoes disponiveis.
- Links para demo, repo e docs.

Essa tela deve manter a estetica de terminal/interface operacional.

### 4.6 Evitar `nexus.json` Inicialmente

A ideia de um arquivo `nexus.json` dentro de cada repositorio foi descartada como primeira opcao porque a estetica do projeto pede algo com mais cara de terminal/sistema.

Se no futuro existir um manifesto dentro dos repositorios, preferir um formato mais textual, por exemplo:

```txt
NEXUS_MODULE
key: nihon.journey
signal: stable
entry: demo
runtime: web
stack: react, typescript, vercel
demo: https://example.com
repo: public
notes: structured japanese learning interface
END
```

Nome sugerido para esse manifesto futuro:

```txt
.nexus
```

Importante:

- Nao implementar leitura de `.nexus` na primeira fase.
- Comecar com configuracao local e overrides.
- Adicionar manifesto remoto apenas se ele realmente trouxer valor depois.

## 5. Modelo De Dados Conceitual

Cada modulo deve ser normalizado para uma estrutura parecida com esta:

```php
[
    'key' => 'nihon.journey',
    'repo' => 'hidenihon-journey',
    'name' => 'Hidenihon Journey',
    'description' => 'Structured Japanese learning interface.',
    'signal' => 'stable',
    'runtime' => 'web',
    'entry' => 'demo',
    'stack' => ['React', 'TypeScript', 'Vercel'],
    'demo_url' => 'https://hidenihon-journey.vercel.app',
    'repo_url' => 'https://github.com/USER/hidenihon-journey',
    'docs_url' => null,
    'homepage_url' => 'https://hidenihon-journey.vercel.app',
    'language' => 'TypeScript',
    'updated_at' => '2026-05-29T00:00:00Z',
]
```

Campos importantes:

- `key`: identificador visual/operacional usado na interface e na URL.
- `repo`: nome real do repositorio no GitHub.
- `name`: nome humano do modulo.
- `description`: descricao curta.
- `signal`: status minimalista do modulo.
- `runtime`: ambiente/plataforma principal.
- `entry`: acao principal esperada.
- `stack`: tecnologias principais.
- `demo_url`: URL da demo/app.
- `repo_url`: URL do repositorio.
- `docs_url`: URL de documentacao, se existir.
- `homepage_url`: homepage vinda do GitHub, usada como fallback para demo.
- `language`: linguagem principal vinda do GitHub.
- `updated_at`: data de atualizacao do repo.

## 6. Signals Permitidos

Manter poucos status para preservar minimalismo.

Signals recomendados:

```txt
stable
testing
dormant
```

Significado:

- `stable`: modulo pronto para ser visto como demo principal.
- `testing`: modulo experimental, navegavel, mas ainda em evolucao.
- `dormant`: modulo antigo, pausado ou arquivado, mas ainda relevante.

Evitar criar muitos status como `online`, `offline`, `building`, `archived`, `lab`, `ready`, etc. a menos que exista uma necessidade real.

Na interface, usar o termo `signal`, nao `status`, porque combina melhor com a linguagem do projeto.

Exemplo visual:

```txt
nihon.journey        signal: stable      runtime: web
pdv.local            signal: testing     runtime: local
legacy.output        signal: dormant     runtime: archive
```

## 7. Arquitetura Recomendada

Implementar de forma incremental e simples.

Estrutura recomendada inicial:

```txt
config/nexus.php
app/Services/Nexus/GitHubModules.php
app/Services/Nexus/ModuleRegistry.php
routes/web.php
resources/views/pages/system.blade.php
resources/views/pages/module.blade.php
```

Responsabilidades:

- `config/nexus.php`: define usuario GitHub, topic, overrides e modulos manuais temporarios.
- `GitHubModules`: busca repositorios publicos do GitHub com a topic configurada.
- `ModuleRegistry`: normaliza, aplica overrides, ordena e entrega os modulos para as views.
- `routes/web.php`: define `/access` e `/module/{key}`.
- `system.blade.php`: renderiza a tela de acesso e lista modulos vindos do backend.
- `module.blade.php`: renderiza a tela intermediaria do modulo.

Evitar banco de dados na primeira versao.

Motivos:

- O volume de modulos sera baixo.
- Cache do Laravel e configuracao local resolvem bem.
- Banco adicionaria complexidade prematura.

## 8. Configuracao Local Recomendada

Criar `config/nexus.php` com estrutura parecida com:

```php
<?php

return [
    'github' => [
        'username' => env('NEXUS_GITHUB_USERNAME', 'your-github-user'),
        'topic' => env('NEXUS_GITHUB_TOPIC', 'nexus-module'),
        'token' => env('GITHUB_TOKEN'),
        'cache_ttl' => env('NEXUS_GITHUB_CACHE_TTL', 3600),
    ],

    'overrides' => [
        'hidenihon-journey' => [
            'key' => 'nihon.journey',
            'signal' => 'stable',
            'runtime' => 'web',
            'entry' => 'demo',
            'stack' => ['React', 'TypeScript', 'Vercel'],
            'demo_url' => 'https://hidenihon-journey.vercel.app',
            'notes' => 'Structured Japanese learning interface.',
        ],
    ],

    'manual' => [
        // Usar temporariamente antes da integracao com GitHub.
    ],
];
```

Regras dos overrides:

- A chave do override deve ser o nome real do repositorio.
- O override deve complementar ou substituir dados vindos do GitHub.
- Se o GitHub nao tiver homepage, `demo_url` pode vir do override.
- `key` deve ser obrigatorio para modulos exibidos na interface.

## 9. Linha Cronologica De Implementacao

### Fase 0: Preservar Base Visual Existente

Objetivo:

Garantir que qualquer alteracao futura preserve a identidade visual ja existente.

Tarefas:

1. Manter a fonte mono e a estetica de terminal.
2. Manter a home como tela conceitual, nao transformar em dashboard generico.
3. Manter `/access` como entrada operacional.
4. Evitar componentes muito comuns de portfolio, como cards coloridos, badges chamativos ou grids comerciais.
5. Manter animacoes sutis, como boot sequence, fade-up, cursor e scan.

Resultado esperado:

- O projeto continua parecendo uma interface operacional, nao um template de portfolio.

### Fase 1: Criar Configuracao Local De Modulos

Objetivo:

Remover a lista estatica hardcoded dentro de `system.blade.php` e mover os modulos para uma fonte backend simples.

Tarefas:

1. Criar `config/nexus.php`.
2. Adicionar uma lista `manual` com os modulos atuais.
3. Criar uma rota `/access` que passa os modulos para a view.
4. Alterar `system.blade.php` para receber os modulos via Blade.
5. Injetar os modulos no Alpine usando `@js($modules)`.
6. Garantir que a navegacao por teclado continue funcionando.

Exemplo de modulo manual:

```php
[
    'key' => 'nihon.journey',
    'desc' => 'Learn Japanese',
    'signal' => 'stable',
    'runtime' => 'web',
    'demo_url' => 'https://hidenihon-journey.vercel.app/',
    'repo_url' => null,
]
```

Resultado esperado:

- A lista de modulos nao fica mais presa no JavaScript da view.
- O sistema ja fica preparado para receber dados dinamicos depois.

### Fase 2: Criar Tela Intermediaria De Modulo

Objetivo:

Criar a principal experiencia nova do projeto: uma tela operacional para cada modulo.

Tarefas:

1. Criar rota `/module/{key}`.
2. Criar view `resources/views/pages/module.blade.php`.
3. Criar logica para localizar um modulo pelo `key`.
4. Alterar `/access` para navegar para `/module/{key}` em vez de abrir a demo diretamente.
5. Renderizar dados do modulo em formato de terminal.
6. Adicionar acoes como `open.demo`, `open.repository` e `return.access`.
7. Exibir apenas acoes que realmente tenham URL disponivel.

Layout conceitual da tela:

```txt
module: nihon.journey
signal: stable
runtime: web
entry: demo
source: github.public

description:
structured japanese learning interface

stack:
react / typescript / vercel

actions:
[01] open.demo
[02] open.repository
[03] return.access
```

Resultado esperado:

- O clique em um modulo nao joga o usuario imediatamente para fora do `neXus`.
- Cada projeto passa a ter uma camada de apresentacao propria.
- A experiencia fica mais memoravel e mais alinhada com o conceito de sistema.

### Fase 3: Criar Service `ModuleRegistry`

Objetivo:

Centralizar a montagem dos modulos fora das rotas e views.

Tarefas:

1. Criar namespace `App\Services\Nexus`.
2. Criar classe `ModuleRegistry`.
3. Implementar metodo `all()` para retornar modulos normalizados.
4. Implementar metodo `findByKey(string $key)`.
5. Aplicar ordenacao simples por ordem definida no config ou por `key`.
6. Garantir que todo modulo tenha campos minimos.

Campos minimos:

```php
key
name
signal
runtime
entry
repo_url
docs_url
stack
```

Resultado esperado:

- Rotas ficam limpas.
- Views recebem dados prontos.
- A futura integracao com GitHub encaixa sem reescrever a interface.

### Fase 4: Adicionar Integracao Com GitHub Topics

Objetivo:

Buscar repositorios publicos do GitHub marcados com a topic `nexus-module`.

Tarefas:

1. Criar classe `GitHubModules`.
2. Ler `username`, `topic`, `token` e `cache_ttl` de `config/nexus.php`.
3. Usar a API publica do GitHub para buscar repositorios do usuario.
4. Filtrar repositorios que tenham a topic configurada.
5. Usar token opcional via `GITHUB_TOKEN` para reduzir risco de rate limit.
6. Normalizar os dados brutos do GitHub.
7. Retornar dados para o `ModuleRegistry`.

Dados relevantes da API:

- `name`.
- `full_name`.
- `description`.
- `html_url`.
- `homepage`.
- `language`.
- `topics`.
- `updated_at`.
- `archived`.

Resultado esperado:

- Repositorios com topic `nexus-module` podem aparecer automaticamente.
- A interface nao depende mais apenas de modulos manuais.

### Fase 5: Aplicar Cache Local

Objetivo:

Evitar chamadas ao GitHub em todo request.

Tarefas:

1. Usar `Cache::remember()` dentro de `GitHubModules` ou `ModuleRegistry`.
2. Definir TTL via `NEXUS_GITHUB_CACHE_TTL`.
3. Usar uma chave de cache clara, por exemplo `nexus.github.modules`.
4. Criar fallback para modulos manuais se GitHub falhar.
5. Nao quebrar a pagina caso a API esteja indisponivel.

Comportamento esperado:

- Se GitHub responder, usar dados atualizados.
- Se GitHub falhar e houver cache, usar cache.
- Se GitHub falhar e nao houver cache, usar `manual` do config.

Resultado esperado:

- Sistema mais rapido.
- Menos dependente de rede.
- Menos risco de rate limit.

### Fase 6: Implementar Overrides Locais

Objetivo:

Permitir curadoria manual dos dados vindos do GitHub.

Tarefas:

1. Ler `overrides` de `config/nexus.php`.
2. Aplicar override usando o nome do repositorio como chave.
3. Permitir sobrescrever `key`, `name`, `description`, `signal`, `runtime`, `entry`, `stack`, `demo_url`, `docs_url` e `notes`.
4. Manter dados do GitHub como fallback.
5. Garantir que modulos sem `key` valida nao sejam exibidos.

Exemplo:

```php
'hidenihon-journey' => [
    'key' => 'nihon.journey',
    'signal' => 'stable',
    'runtime' => 'web',
    'entry' => 'demo',
    'demo_url' => 'https://hidenihon-journey.vercel.app',
]
```

Resultado esperado:

- O GitHub fornece a base dinamica.
- O `neXus` controla a apresentacao final.

### Fase 7: Refinar `/access` Como Scan Realista

Objetivo:

Melhorar a sensacao de sistema carregando os modulos.

Tarefas:

1. Atualizar boot lines para mencionar registry/scan.
2. Exibir quantidade de modulos detectados.
3. Exibir source como `github.registry` ou `local.registry`.
4. Manter a sequencia curta para nao cansar o usuario.
5. Preservar navegacao por teclado.

Exemplo de boot lines:

```txt
// boot sequence start
nexus v0.3
environment loaded
$ scanning module registry...
$ source: github.topics
$ modules detected: 03
```

Resultado esperado:

- A integracao dinamica passa a fazer parte da narrativa visual.
- O usuario entende que os modulos foram detectados pelo sistema.

### Fase 8: Refinar Tela De Modulo

Objetivo:

Fazer a tela intermediaria parecer uma ficha operacional, nao uma pagina de detalhe comum.

Tarefas:

1. Adicionar bloco de metadata.
2. Adicionar bloco de descricao.
3. Adicionar bloco de stack.
4. Adicionar bloco de acoes.
5. Adicionar link de retorno para `/access`.
6. Opcionalmente adicionar uma pequena animacao de inicializacao.
7. Garantir boa responsividade mobile.

Regras visuais:

- Fonte mono.
- Baixo contraste colorido.
- Linhas, bordas e separadores sutis.
- Nada de cards comerciais chamativos.
- Nada de layouts de SaaS genericos.

Resultado esperado:

- Cada modulo parece um item real do sistema.
- A experiencia de abrir uma demo fica intencional.

### Fase 9: Melhorar Resiliencia E Estados Vazios

Objetivo:

Garantir que o sistema funcione mesmo com poucos ou nenhum projeto.

Tarefas:

1. Criar estado vazio para `/access`.
2. Mostrar mensagem operacional se nenhum modulo for encontrado.
3. Evitar erro se GitHub falhar.
4. Evitar erro se uma URL estiver ausente.
5. Retornar 404 estilizado ou redirect controlado se `/module/{key}` nao existir.

Exemplo de estado vazio:

```txt
$ scanning module registry...
$ modules detected: 00
$ no public modules initialized
```

Resultado esperado:

- O sistema fica robusto mesmo antes de haver varios projetos.

### Fase 10: Opcional Futuro - Manifesto `.nexus`

Objetivo:

Permitir que alguns repositorios descrevam seu proprio modulo em um formato textual com cara de terminal.

Nao implementar esta fase cedo.

Quando implementar:

1. Buscar arquivo `.nexus` na raiz do repositorio.
2. Parsear formato chave/valor simples.
3. Mesclar dados na ordem: GitHub -> `.nexus` -> override local.
4. Manter override local como maior prioridade.

Exemplo:

```txt
NEXUS_MODULE
key: nihon.journey
signal: stable
entry: demo
runtime: web
stack: react, typescript, vercel
demo: https://hidenihon-journey.vercel.app
notes: structured japanese learning interface
END
```

Prioridade de dados:

```txt
override local > .nexus remoto > GitHub API
```

Resultado esperado:

- Repositorios podem carregar uma identidade propria.
- O hub continua tendo controle final via override.

## 10. Regras Para Futuras IAs

Ao trabalhar neste projeto:

1. Nao transformar o `neXus` em portfolio generico.
2. Nao adicionar dashboard complexo sem necessidade.
3. Nao criar banco de dados para modulos antes de esgotar config/cache.
4. Nao adicionar categorias pesadas enquanto houver poucos projetos.
5. Nao implementar `featured modules` sem nova decisao explicita.
6. Nao substituir a estetica terminal por componentes comerciais padrao.
7. Preservar a navegacao por teclado em `/access`.
8. Preservar responsividade mobile.
9. Preferir alteracoes pequenas e incrementais.
10. Quando houver duvida entre escalabilidade e curadoria, preferir curadoria.

## 11. Comandos De Verificacao

Depois de alterar codigo, executar quando aplicavel:

```bash
npm run build
```

```bash
composer test
```

Se alterar PHP com estilo significativo, considerar:

```bash
./vendor/bin/pint
```

## 12. Definicao De Pronto

O sistema pode ser considerado alinhado com a visao final quando:

- `/access` lista modulos vindos de uma fonte backend.
- Modulos podem vir do GitHub por topic `nexus-module`.
- Overrides locais controlam a apresentacao.
- Cada modulo tem uma tela intermediaria `/module/{key}`.
- A tela intermediaria mostra signal, runtime, descricao, stack e acoes.
- A experiencia continua minimalista, tecnica e operacional.
- O sistema funciona bem mesmo com poucos projetos.
- Falhas do GitHub nao quebram a interface.

## 13. Frase Norteadora

Use esta frase para validar qualquer decisao de produto:

> Isto faz o neXus parecer mais como um terminal de acesso a modulos demonstraveis, ou apenas como uma lista comum de links?

Se a resposta for “lista comum de links”, reavaliar a implementacao.
