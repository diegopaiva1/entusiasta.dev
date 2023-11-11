---
title: "Round 6: Quais as chances de cada jogador no desafio da ponte de cristal?"
draft: false
date: 2021-10-26T20:00:00.000Z
tableOfContents: true
description: "Utilizando estatística e programação é possível criar um modelo capaz de predizer as chances de sobrevivência de cada jogador no desafio da ponte de cristal, da série sul-coreana Round 6."
categories:
  - Estatística
tags:
  - Probabilidade
  - Python
  - Round 6
  - Visualização de dados
---

## Introdução

---

Você provavelmente já assistiu **Round 6** (_Squid Game_ - em inglês), afinal de contas, [ela se tornou a série mais vista da história da Netflix](https://www.omelete.com.br/netflix/round-6-mais-vista).

Dentre os desafios impostos, um deles consiste em realizar a travessia de uma ponte constituida por 18 pares de vidros, dispostos sequencialmente e separados por uma distância de 1 metro. Cada par conta com um vidro temperado, que suporta o peso de até dois jogadores, e um vidro normal, que quebra quando pisado sobre. Os 16 jogadores nesta etapa formam uma fila indiana e, a cada passo, o primeiro jogador da fila escolhe um dos dois vidros a partir da posição em que estiver. Se a escolha for incorreta, _game over_. Caso contrário, ele continua tomando as decisões até que seja eliminado ou conclua a travessia. Quando um jogador cai, o próximo sempre avança com segurança até a posição em que o jogador anterior foi eliminado e, portanto, tem mais chances de sobreviver.

{{< img
    src="squid-game-glass-bridge.png"
    alt="Round 6 - Ponte de Cristal"
    caption="O desafio da ponte de cristal. Fonte: Netflix."
    caption-position="center" >}}

Intuitivamente, é fácil perceber que este é um jogo injusto, pois quanto mais próximo do fim da fila, menos riscos o jogador terá que assumir. Mas quanto exatamente é a chance de cada jogador? Utilizando estatística e programação, vamos calcular a probabilidade de cada um dos 16 jogadores sobreviver!

{{< alert info >}}
Para acessar as probabilidades de cada jogador diretamente, <a href="#grafico">clique aqui</a>.
{{< /alert >}}

</div>

## Considerações

---

Como eu assisti a série um pouquinho depois do _boom_, imaginei que alguém já tivesse publicado algo similar na internet.
Acabei encontrando três ótimos links, todos em inglês:

- [Succeed at the Squid Game glass bridge using statistics](https://blog.evlabs.io/2021/10/16/succeed-at-the-squid-game-glass-bridge-using-statistics/)
- [The Squid Game glass bridge game explained with probability](https://medium.com/@lakshayakula/the-squid-game-glass-bridge-game-explained-with-probability-138371d77b52)
- [🦑 Squid Game — What are the chances to survive the Glass Bridge?](https://medium.com/@alex.martinez.vargas/squid-game-what-are-the-chances-to-survive-the-glass-bridge-71c87c392d6d)

Pelo fato de não ter encontrado nada em português, decidi fazer a minha própria versão.

## Modelagem do desafio com estatística

---

Em cada passo, a probabilidade de adivinhar qual dos dois vidros é o correto é sempre igual a $\frac{1}{2}$. Isto posto, a chance de sobrevivência do primeiro jogador é relativamente simples de calcular. Ele precisará necessariamente adivinhar **todos** os 18 vidros, o que equivale a uma probabilidade de:

$$
\left(\frac{1}{2}\right)^{18} = \frac{1}{262144} = 0,0000038
$$

Ou seja, o jogo é praticamente uma sentença de morte para o pobre do cidadão!

Contudo, para os jogadores seguintes, não é tão trivial assim calcular as probabilidades, pois elas dependem do desempenho do jogador anterior. Para nossa sorte, o jogo pode ser pensado como $n = 18$ experimentos independentes em que cada experimento possui uma probabilidade de falha $p = \frac{1}{2}$ e de acerto $q = 1 - p = \frac{1}{2}$. Um total de zero falhas significa que todos os jogadores conseguem cruzar a ponte com sucesso, com uma falha todos os jogadores menos um, e assim por diante. Portanto, o evento de interesse será a **falha**, pois com ela será possível calcular as probabilidades de sobrevivência. Isso nos permite modelar a probabilidade discreta do número de **falhas** como uma variável aleatória $X$ que segue uma [distribuição binomial](https://pt.wikipedia.org/wiki/Distribui%C3%A7%C3%A3o_binomial). Em termos estatísticos:

$$
X \sim B(n, p)
$$

Uma das primeiras informações que conseguimos obter a partir desta modelagem é o [valor esperado](https://pt.wikipedia.org/wiki/Valor_esperado) de quantos jogadores irão ser eliminados. Na distribuição binomial, o valor esperado (ou esperança) é calculado como:

$$
E[X] = np = 18 \cdot \frac{1}{2} = 9
$$

O valor esperado é de 9 jogadores, ou seja, do total de 16 jogadores, a expectativa é de que apenas 7 consigam atravessar a ponte (na série foram apenas 3).

Para calcular a probabilidade de $X$ assumir $k$ falhas $(k \in \mathbb{N})$, utilizamos a **função de probabilidade** (f.d.p) da distribuição binominal:

$$
P(X = k) = \binom{n}{k}p^kq^{n-k}
$$

Lembrando que $\binom{n}{k} = \frac{n!}{k!(n - k)!}$ representa a combinação de $n$ valores tomados $k$ a $k$.

Entretanto, não estamos exatamente interessados em saber a probabilidade de um número individual de jogadores eliminados, mas sim a probabilidade **acumulada**. O que eu quero dizer é que não importa saber qual a chance de, por exemplo, os 9 primeiros jogadores fracassarem, mas sim a probabilidade de que **até** 9 jogadores fracassem (pode ser 0, 1, 2, etc). Posteriormente, isso ajudará a calcular a chance de sobrevivência de cada jogador. A probabilidade acumulada pode ser calculada somando-se todas as funções de probabilidade até o limite superior $k$:

$$
P(X \leqslant k) = \sum_{i = 0}^k P(X = i)
$$

Com essa função em mãos, podemos determinar a chance de sobrevivência $S(x)$ do $x$-ésimo jogador $(x > 0$):

$$
S(x) = P(X \leqslant x - 1)
$$

Talvez tenha ficado abstrato demais. Para exemplificar, considere os cenários em que o 4º jogador sobrevive:

- 0 falhas: todos os jogadores sobrevivem
- 1 falha: todos os jogadores sobrevivem, exceto o 1º
- 2 falhas: todos os jogadores sobrevivem, exceto o 1º e o 2º
- 3 falhas: todos os jogadores sobrevivem exceto o 1º, 2º e o 3º

Logo, podemos calcular a probabilidade de sobrevivência do 4º jogador como:

<div style="overflow-x: auto">
$$
\begin{split}
S(4) = P(X \leqslant 3) = \sum_{i = 0}^3 P(X = i) &= P(X = 0) + P(X = 1) + P(X = 2) + P(X = 3) \\
                                             &= 0,000004 + 0,000069 + 0,000584 + 0,003113 \\
                                             &= 0,003769
\end{split}
$$
</div>

Ou seja, as chances do 4º jogador sobreviver são de aproximadamente 0,3769%. É evidente que não iremos fazer todos estes cálculos a mão, por isso na próxima seção iremos programar um _script_ em Python para calcular e plotar estas probabilidades.

## Implementação em Python

---

Para calcular e plotar as probabilidades de sobrevivência, utilizaremos as bibliotecas `scipy` e `matplotlib`.

```python
from scipy.stats import binom
import matplotlib.pyplot as plt

plt.style.use('seaborn')

n = 18
p = 0.5

X = binom(n, p)

# São 16 jogadores, a função range exclui o limite superior.
players = range(1, 17)

# Calculando a taxa de sobrevivência pra cada jogador.
# A função `cdf` do scipy fornece a função de probabilidade acumulada.
survival = [X.cdf(x - 1) for x in players]

plt.figure(figsize = (12, 8))

plt.title(
    r'Probabilidade de sobrevivência do $x$º jogador',
    fontsize = 16, fontweight = 'bold'
)

plt.xticks(players)
plt.xlabel('Jogador')
plt.ylabel('Probabilidade')

plt.plot(
    players,
    survival,
    marker = 'o',
    label = r'$S(x) = P(X\ \leqslant\ x - 1)$'
)

# Anotar os valores nas coordenadas (x, y).
for x, y in zip(players, survival):
    plt.annotate(
        "{:.2f}".format(y),
        (x, y),
        textcoords = "offset points",
        xytext = (0, 10),
        ha = 'center'
    )

plt.legend()
plt.show()
```

## Resultado

---

Este é o gráfico resultante da execução do _script_:

{{< img
    alt="Probabilidade de sobrevivência do xº jogador"
    src="surv.png" >}}

É impressionante observar como é somente a partir do 10º jogador que as chances de sobreviver são maiores do que as chances de ser eliminado. Antes disso, você corre sério risco de se espatifar no chão. Mas eu, particularmente, só ficaria aliviado estando pelo menos no 13º lugar, onde haveria pelo menos 95% de chance de sair vivo!

### Aperfeiçoando o gráfico para o contexto da série {#grafico}

Para finalizar, deixo aqui este gráfico mais bacana, que representa visualmente as chances de cada jogador, com destaque para os personagens que tem alguma relevância na trama.

{{< img
    alt="Representação gráfica das chances de sobrevivência de cada jogador na série Round 6"
    src="probabilidade_sobrevivencia.png" >}}

Por este gráfico, conseguimos perceber que era bastante improvável que as três personagens principais (Sang-woo, Sae-byeok e Gi-hun) não conseguissem realizar a travessia, uma vez que o trio ocupava as últimas posições. Todos eles começaram o desafio com pelo menos 98% de chances de sobreviver!

O código utilizado para gerar este gráfico está disponível [no meu Github](https://github.com/diegopaiva1/squid-game-bridge-probability).

{{< alert info >}}
Abra as imagens em uma nova guia ou amplie-as para melhor visualização.
{{< /alert >}}

## Conclusão

---

Neste post mostrei como a matemática e a estatística podem ser aplicadas para predizer quais jogadores irão sobreviver ao desafio da ponte de cristal, da série sul-coreana Round 6. Interessante, não?

Evidentemente, o nosso modelo estatístico, baseado na **distribuição binomial**, não levou em conta fatores externos como o tempo, o jogador se esquecer do vidro correto ou até mesmo a possibilidade de um jogador sabotar o outro (ou até a si mesmo), como foi o caso da Mi-nyeo. Na verdade, isso até explica porque sobreviveram menos jogadores do que o valor esperado que foi calculado. Um exemplo disso é o 13º jogador (o vidraceiro), que teria 95,19% de chances de sobreviver, mas que possivelmente teve sua probabilidade real reduzida devido aos eventos adversos ocorridos durante a travessia.

Portanto, é um modelo bastante plausível, que considera apenas a natureza aleatória do desafio.
