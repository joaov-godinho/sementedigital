# Semente Digital

## Visão Geral

- A agropecuária familiar desempenha um papel crucial na economia e na
segurança alimentar de muitas regiões, sendo responsável por grande parte da
produção agrícola e pecuária. No entanto, pequenos produtores enfrentam
desafios significativos, como a falta de acesso a tecnologias e informações que
poderiam otimizar suas atividades e melhorar a produtividade.

- Nesse contexto, a aplicação que estamos desenvolvendo surge como
uma ferramenta para apoiar esses produtores. Trata-se de uma página web
intuitiva e acessível, que funciona como uma agenda digital. Com ela, os
produtores poderão organizar suas tarefas diárias, agendar atividades
essenciais, e consultar a previsão do tempo para planejar suas operações
agrícolas de forma mais eficaz. Além disso, a aplicação oferece informações
atualizadas sobre os preços de mercado de produtos agrícolas, permitindo que
os produtores façam escolhas informadas na hora de comprar insumos e vender
sua produção.

- Outro diferencial da aplicação é a disponibilização de dicas de cultivo para
diversas culturas, fornecendo orientação técnica que pode fazer a diferença na
produtividade e na sustentabilidade das operações agropecuárias. Com essa
ferramenta, pequenos produtores terão um suporte robusto para gerenciar suas
atividades, melhorar a eficiência e, consequentemente, aumentar sua
competitividade no mercado

## Funcionalidades
- **Cadastro de Usuários:** O sistema permite o cadastro de usuários
- **Login e Registro:** O sistema permite que os usuários façam login utilizando suas credenciais
- **Cadastro de Tarefas:** Os usuários podem adicionar, visualizar e gerenciar suas tarefas futuras.
- **Previsão do Tempo:** A aplicação exibe a previsão do tempo para os próximos dias, baseada no código postal do usuário. O sistema utiliza a [WeatherAPI](https://www.weatherapi.com/) para buscar as informações climáticas.
- **Consultas de Mercado:** Acompanhe o preço de produtos agrícolas em tempo real. -> **Ainda é necessário implementar**

## Tecnologias Utilizadas

- **Backend:** PHP 8.3 com o framework Laravel
- **Frontend:** Laravel Breeze, HTML, CSS (Tailwind), FullCalendar.js
- **Banco de Dados:** MySQL (em desenvolvimento com SQLite como alternativa local)
- **API Externa:** [WeatherAPI](https://www.weatherapi.com/) para consulta de condições climáticas
- **Docker:** Ambiente de desenvolvimento Dockerizado
- **Servidor Web:** Apache com PHP
- **Outros:** Composer, Node.js, Supervisor