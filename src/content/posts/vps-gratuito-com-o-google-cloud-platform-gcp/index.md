---
title: "VPS gratuito com o Google Cloud Platform"
draft: false
date: 2021-10-17T20:00:00.000Z
tableOfContents: true
description: "Aprenda a ativar gratuitamente uma máquina virtual no ecossistema do Google Cloud Platform (GCP), para executar tarefas variadas de computação."
categories:
  - Computação em nuvem
tags:
  - Google Cloud Platform
  - GCP
  - Cloud
  - VPS
---

## Introdução

---

Um servidor virtual privado (VPS) nada mais é do que uma máquina virtual (VM) remota localizada em algum datacenter. A máquina é dita virtual pois é gerada através de um processo de [virtualização](https://pt.wikipedia.org/wiki/Virtualiza%C3%A7%C3%A3o).

Podemos comparar este servidor ao seu próprio computador. Nele, você tem total liberdade para instalar qualquer software que desejar, independentemente do seu caso de uso. Você também pode organizar seus arquivos da maneira que bem entender.

Neste post irei mostrar como você pode alugar um VPS utilizando o serviço de computação em nuvem do Google, de maneira gratuita!

## Pré-requisitos

---

Espera-se somente que você tenha alguma noção do sistema operacional Linux e conhecimento de alguns comandos básicos.

## Casos de uso

---

Você pode estar se perguntando:

> Certo... mas pra que diabos eu vou querer esse negócio aí?!

Se você veio até este post, provavelmente já sabe qual a utilidade de um VPS. Caso não saiba, eu diria que a principal função de um VPS é executar tarefas computacionais constantes ou que precisem de tempo de computação indefinido, geralmente com o propósito de servir usuários de uma determinada aplicação. Não seria nem um pouco legal você deixar seu próprio computador ligado por horas, dias ou até mesmo meses para realizar alguma computação ou prover algum serviço. Mas com um VPS você está salvo, pois o provedor garante que a máquina ficará disponível 24 horas por dia (a não ser que você não queira, o que poderia lhe beneficiar economicamente).

Uma outra utilidade de um VPS é acesso a recursos mais poderosos do que você tem disponível fisicamente. Você pode alugar máquinas **extremamente potentes** para executar tarefas pesadas (com centenas de cores e gigabytes de memória RAM, além de GPUs, mas que são **MUITO** mais caras, evidentemente).

De qualquer maneira, enumero aqui alguns casos de uso:

- Manter um site e/ou servidor web
- Manter um servidor de e-mail
- Treinar modelos de machine learning
- Renderizar vídeos e aplicações 3D
- Criar um espaço de backup
- ...

Existem provavelmente muitas outras dezenas de casos de uso, mas acho que você já entendeu a utilidade de um VPS.

## Escolhendo o provedor de computação em nuvem

---

Ok, vamos ao que interessa. Você quer um servidor para executar a sua tarefa. Primeiro, é importante saber que existem muitas empresas que oferecem este serviço, sendo as mais populares a tríade [Amazon AWS](https://aws.amazon.com/pt/), [Microsoft Azure](https://azure.microsoft.com/pt-br/) e [Google Cloud Platform (GCP)](https://cloud.google.com/). Com base em relátorios de 2021, elas compartilham uma fatia de cerca de 58% do mercado de computação em nuvem.

Todas estas três empresas possuem planos gratuitos temporários. A saber, na data deste post, os modelos de assinatura gratuita da AWS e da Azure oferecem 12 meses de acesso à uma instância de VM com 1 vCPU e 1GB RAM (que não é lá grande coisa, mas serve para atividades menos exigentes). Por outro lado, o GCP é um pouco mais maleável: ele te dá **US$ 300** válidos por 90 dias para você gastar com o que quiser, com o modelo de VM que você quiser. Por esta razão, iremos utilizar o GCP neste tutorial.

## Configurando a VM no GCP

---

O primeiro passo é logar com sua conta do Google no [console do GCP](https://console.cloud.google.com/getting-started) e clicar no botão de teste gratuito. Confirme seus dados e clique para concordar com os termos de uso.

{{< alert info >}}
O seu cartão de crédito será utilizado somente para fins de validação.
<br/>
Você não será cobrado durante o período de teste.
{{< /alert >}}

Você deverá ser redirecionado para uma tela parecida com esta:

{{< img alt="Tela inicial do GCP" src="gcp1.png" >}}

Agora, vamos criar nossa primeira VM. Para isso, acesse o item do menu **Compute Engine > Instâncias de VM** e ative o serviço. Você irá se deparar com esta tela:

{{< img alt="Tela de ativação do Compute Engine" src="gcp2.png" >}}

Clique em **Criar instância** para ser redirecionado à página de configuração da sua VM. Vamos aos principais itens:

- **Nome**: um nome personalizado para você identificar sua VM.
- **Região**: selecione `southamerica-east1 (São Paulo)`. Note que a região está diretamente ligada à latência da sua aplicação. Escolha uma região que esteja de acordo com a característica de acesso do(s) usuário(s).
- **Zona**: não há necessidade de alteração.
  Na configuração da máquina, escolha a que melhor se adapta às suas necessidades. Perceba que o GCP tem diversas instâncias diferentes e com características diferentes. [Neste link](https://cloud.google.com/compute/docs/machine-types) você pode visualizar com mais detalhes cada uma delas. Eu irei optar pela instância **e2-standard-2 (2vCPU, 8GB de memória)**.

Na seção **disco de inicialização**, você irá selecionar o sistema operacional e tamanho do disco. Eu irei optar pelo Ubuntu 20.04 LTS (Focal), com 50GB de disco permanente equilibrado.

Por fim, em **_firewall_**, permita tanto o tráfego HTTP quanto HTTPS caso sua intenção seja utilizar a VM como servidor web. Caso contrário, não há necessidade de assinalar estas opções.

Revise suas configurações e clique em **Criar**. A minha configuração ficou assim:

{{< img alt="Configuração da VM" src="gcp3.png" >}}

### Acessando sua VM com SSH

{{< alert success >}}
Sucesso! Você criou a sua primeira VM!
{{< /alert >}}

Agora que você tem uma VM novinha em folha, você precisa de um meio de acessá-la. Para tanto, utilizaremos o protocolo [SSH](https://pt.wikipedia.org/wiki/Secure_Shell), que permite fazer login em máquinas remotas a partir do seu próprio computador. O GCP te permite utilizar o próprio browser para isso, com o Google Cloud Shell:

{{< img alt="Google Cloud Shell" src="gcp4.png" >}}

Embora funcione perfeitamente bem e não exija nenhuma configuração a priori, eu não sou particulamente muito fã deste método, porque sempre que você quiser se conectar à sua VM você vai ter que abrir o seu navegador, ir até a seção de VMs, etc, etc. Além de que é possivel que o desempenho, dependendo do seu computador, possa não ser tão bom quanto o de um terminal puro.

#### Gerando par de chaves SSH

O outro método, que acredito ser o mais comum, é fazer o login SSH pelo terminal. As regras aqui consideram um sistema operacional Linux (o quê? você usa Windows?! Neste caso siga os passos descritos [aqui](https://cloud.google.com/compute/docs/instances/connecting-advanced#windows-putty)). Primeiro de tudo, você vai precisar gerar um par de chaves SSH pública e privada, que servem para autenticar que você está fazendo login de um computador confiável.

Utilize o comando:

```bash
ssh-keygen -t rsa -f ~/.ssh/<KEY_FILENAME> -C <USERNAME>
```

onde `<KEY_FILENAME>` é o nome do arquivo das chaves e ` <USERNAME>` denomina o nome de usuário que irá se conectar à VM. Note que as chaves serão armazenadas sob o diretório `.ssh`.

No meu caso, ficou:

```bash
ssh-keygen -t rsa -f ~/.ssh/minha-instancia -C diego
```

Ao executar o comando, ele irá perguntar se você deseja atribuir uma senha às chaves. Esta etapa é opcional, e serve para evitar que pessoas com acesso ao seu computador - como colegas de trabalho - copiem a sua chave.

Altere o modo de leitura/escrita das chaves, para que ninguém senão você possa ler e alterá-la:

```bash
chmod 400 ~/.ssh/<KEY_FILENAME>
```

Por último, você precisa informar ao GCP que esta chave que você acabou de gerar é de um computador confiável que tem permissão para acessar a instância. Para isso, você vai precisar copiar a chave **pública** (no meu caso, é o arquivo `~/.ssh/minha-instancia.pub`) para a [seção de metadados do GCP](https://console.cloud.google.com/compute/metadata/sshKeys). Para copiar a chave, utilize o comando `cat`:

```bash
cat ~/.ssh/<KEY_FILENAME>.pub
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDQzXjT2G298BeqLMAN4kLG9iCQaPqN3JACG9zoutqBcWGJ290V8ZVL0lr2bauq4NnEIE5GiO+K1zd5kIqR6WhclOz0Q/QLjJCc+rUSadC/NRg/geIBJWYlOgdAzOVNINz7CBuf5NicJLgTS9dLLvRI+b8ZQadqRkPPMkeZVIPzYpt2sGow+W47Brk+DXuBrPCjkrQTvviGBui5gHSJQss4CTwhJ7rzjgZQP39krD3B6BN8kSVoIKq4l/1pmDSQxyqASWulds7JrJihxA0OTIm7ZADj1z4Rh/Uu4iP69/2Ai0AByJHr0Wb8G1+3kjD/YYO+BysnrwnlGN7Uuvid5DyB diego
```

{{< alert info >}}
Lembre-se que para copiar qualquer texto dentro do terminal, você deve usar "CTRL + SHIFT + C".
{{< /alert >}}

Na seção de metadados, adicione a sua chave SSH que você acabou de copiar e clique em **Salvar**.

#### Conectando-se à VM por SSH via terminal

Ufa! Agora que você gerou suas chaves, é muito simples conectar-se à sua instância, através do comando `ssh`:

```bash
ssh -i PATH_TO_PRIVATE_KEY USERNAME@EXTERNAL_IP
```

Substitua as variáveis `PATH_TO_PRIVATE_KEY`, `USERNAME` e `EXTERNAL_IP` por: nome do arquivo da chave que você gerou na etapa anterior, seu nome de usuário e endereço de IP externo da sua VM, respectivamente.

No meu caso ficou:

```bash
ssh -i ~/.ssh/minha-instancia diego@35.199.91.25
```

O resultado esperado deve ser a tela de boas-vindas do sistema operacional escolhido, algo parecido com:

```plain
Welcome to Ubuntu 20.04.3 LTS (GNU/Linux 5.11.0-1020-gcp x86_64)

- Documentation: https://help.ubuntu.com
- Management: https://landscape.canonical.com
- Support: https://ubuntu.com/advantage

System information as of Sun Oct 17 06:31:10 UTC 2021

System load: 0.0 Processes: 104
Usage of /: 3.4% of 48.29GB Users logged in: 0
Memory usage: 2% IPv4 address for ens4: 10.158.0.2
Swap usage: 0%

1 update can be applied immediately.
To see these additional updates run: apt list --upgradable

The list of available updates is more than a week old.
To check for new updates run: sudo apt update
```

Yay! Agora você tem acesso a uma máquina Linux prontinha para executar suas tarefas. Antes de baixar qualquer software na sua VM, não se esqueça de executar o comando `sudo apt update` para atualizar todos os pacotes e obter as versões mais recentes.

## Conclusão

---

Neste post foi demonstrado como ativar uma VM utilizando os créditos gratuitos fornecidos pelo Google Cloud Platform. É um processo que é relativamente simples, mas que pode se tornar confuso caso você não entenda muito bem os conceitos por trás desta tecnologia. Lembre-se que o GCP não se limita apenas a fornecer instâncias de máquinas virtuais, ele é um serviço muito mais abrangente, e você pode explorá-lo e aprender outras funcionalidades com os seus créditos.

Aproveito para frisar que o processo de criação de VMs em outros provedores, como AWS e Azure, também é muito semelhante a este descrito aqui. Se você conseguiu criar e logar na sua VM com sucesso, então não terá muita dificuldade para replicar estes passos nestes outros ambientes (a maior diferença é na interface, sinceramente).

Em posts futuros pretendo mostrar como você pode executar uma aplicação web genérica e expô-la na internet, utilizando esta mesma VM.
