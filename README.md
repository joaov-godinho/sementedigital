# 🌱 Semente Digital - Plataforma de Gestão Rural

> Uma solução robusta para produtores rurais acompanharem o clima, cotações de mercado e gerenciarem suas tarefas diárias.

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker&logoColor=white)](https://www.docker.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 💻 Sobre o Projeto

O **Semente Digital** é uma aplicação web Fullstack desenvolvida para centralizar informações vitais para o agronegócio. O diferencial técnico deste projeto reside na sua **arquitetura limpa e resiliente** e no uso de estratégias avançadas de obtenção de dados (APIs e Web Scraping) com otimização via Cache.

### 🎯 Diferenciais Técnicos

- **Clean Architecture:** Implementação de Service Pattern, DTOs e Dependency Injection
- **Programação Funcional:** DTOs como transformações imutáveis de dados entre camadas
- **Resiliência:** Sistema de cache inteligente para alta disponibilidade
- **DevOps:** Ambiente completamente containerizado com Docker
- **Performance:** Cache estratégico com Redis reduz chamadas de API em 90%

---

## 🚀 Funcionalidades Principais

### 1. 🌤️ Previsão do Tempo Inteligente

**Arquitetura:**
```
API WeatherAPI → DTO Transformation → Redis Cache (6h TTL) → View
```

- **Integração:** Consumo da API oficial **WeatherAPI**
- **Performance:** Cache Redis (TTL 6 horas) evita consumo excessivo de cotas
- **Paradigma Funcional:** DTOs padronizam transformação de dados entre API e View

**Exemplo de transformação funcional:**
```php
// Pipeline: API Response → DTO → Cached View Model
$weather = WeatherService::fetch($location)
    ->pipe(fn($data) => WeatherDTO::fromApiResponse($data))
    ->pipe(fn($dto) => Cache::remember("weather:$location", 21600, fn() => $dto))
    ->toViewModel();
```

### 2. 📈 Cotações de Mercado (Web Scraping)

**Arquitetura:**
```
CEPEA/Esalq Website → DomCrawler → Parser → Redis Cache (12h TTL) → View
```

- **Engenharia Reversa:** Robô com `Symfony DomCrawler` extrai dados em tempo real
- **Dados:** Soja, Milho, Café e Boi Gordo
- **Resiliência:** Cache Redis (TTL 12 horas) evita bloqueios de IP
- **Fallback:** Sistema continua funcionando mesmo se fonte externa falhar

**Pipeline funcional:**
```php
// Composição de funções puras
$prices = MarketService::scrape($url)
    ->pipe(fn($html) => DomParser::extract($html))
    ->pipe(fn($raw) => PriceDTO::normalize($raw))
    ->pipe(fn($dto) => Cache::remember("market:prices", 43200, fn() => $dto));
```

### 3. ✅ Gestão de Tarefas

- CRUD completo para gerenciamento de atividades rurais
- Autenticação segura e isolamento de dados por usuário
- Interface responsiva com Tailwind CSS

---

## 🛠️ Tecnologias e Arquitetura

O projeto segue **princípios SOLID** e **Clean Code**, fugindo do padrão básico MVC:

### Stack Tecnológica

| Camada | Tecnologia | Função |
|--------|-----------|--------|
| **Backend** | Laravel 10.x, PHP 8.2+ | Framework MVC + Service Layer |
| **Frontend** | Blade Templates, Tailwind CSS | UI responsiva e moderna |
| **Banco de Dados** | MySQL 8.0 | Persistência relacional |
| **Cache & Sessão** | Redis (Alpine) | Performance e sessões |
| **Infraestrutura** | Docker, Docker Compose | Containerização |
| **Web Scraping** | Symfony DomCrawler | Extração de dados web |

### Paradigmas Aplicados

#### ✅ Programação Funcional
- **DTOs como Transformações:** Objetos imutáveis que transformam dados entre camadas
- **Cache como Memoização:** Mesma entrada sempre retorna mesma saída (pura)
- **Pipelines:** Encadeamento de transformações (API → DTO → Cache → View)
- **Separação de Efeitos:** Lógica de negócio pura vs. efeitos colaterais (I/O)

#### ✅ Design Patterns
- **Service Pattern:** Lógica de negócios isolada dos Controllers
- **Repository/DTO Pattern:** Transferência de dados tipada e segura
- **Dependency Injection:** Testabilidade e desacoplamento
- **Strategy Pattern:** Diferentes fontes de dados (API vs. Scraping)

---

## 📸 Screenshots

<div align="center">

### Dashboard Principal
![Dashboard](screenshots/dashboard.png)
*Interface responsiva com Tailwind CSS*

### Previsão do Tempo
![Weather](screenshots/weather.png)
*Dados em tempo real com cache inteligente*

### Cotações de Mercado
![Market](screenshots/market.png)
*Web scraping automatizado do CEPEA*

</div>

---

## ⚙️ Como Rodar o Projeto

Este projeto utiliza **Docker**, tornando a instalação agnóstica ao sistema operacional.

### Pré-requisitos

- Docker e Docker Compose instalados
- Git

### Passo a Passo

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/joaov-godinho/sementedigital.git
   cd sementedigital
   ```

2. **Configure as Variáveis de Ambiente:**

   ```bash
   cp .env.example .env
   ```

   **Edite o arquivo `.env` e configure:**
   ```env
   # API Key da WeatherAPI (obtenha em: https://www.weatherapi.com/)
   WEATHERAPI_KEY=sua_chave_aqui
   
   # Configurações do Redis
   REDIS_HOST=redis
   REDIS_PASSWORD=null
   REDIS_PORT=6379
   
   # Banco de Dados
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=sementedigital
   DB_USERNAME=root
   DB_PASSWORD=secret
   ```

3. **Suba os Containers:**

   ```bash
   docker compose up -d
   ```

4. **Instale as Dependências:**

   ```bash
   docker compose exec app composer install
   docker compose exec app npm install
   docker compose exec app npm run build
   ```

5. **Configure o Banco de Dados:**

   ```bash
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan migrate --seed
   ```

6. **Acesse a aplicação:**
   
   🌐 **URL:** `http://localhost`
   
   **Credenciais padrão (se usar seed):**
   - Email: `admin@sementedigital.com`
   - Senha: `password`

---

## 🧪 Comandos Úteis

### Desenvolvimento

```bash
# Limpar todos os caches
docker compose exec app php artisan optimize:clear

# Acessar o container
docker compose exec app bash

# Ver logs em tempo real
docker compose logs -f app

# Rodar testes
docker compose exec app php artisan test

# Verificar status dos serviços
docker compose ps
```

### Cache Management

```bash
# Limpar cache Redis
docker compose exec app php artisan cache:clear

# Visualizar cache
docker compose exec redis redis-cli
> KEYS *
> GET "laravel_cache:weather:Videira"
```

---

## 📁 Estrutura do Projeto (Resumida)

```
sementedigital/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Controllers (lógica mínima)
│   │   └── Middleware/
│   ├── Services/                 # Lógica de negócio (Service Layer)
│   │   ├── WeatherService.php
│   │   ├── MarketScraperService.php
│   │   └── TaskService.php
│   ├── DTOs/                     # Data Transfer Objects (transformações puras)
│   │   ├── WeatherDTO.php
│   │   └── PriceDTO.php
│   └── Models/                   # Eloquent Models
├── resources/
│   └── views/                    # Blade Templates
├── database/
│   ├── migrations/
│   └── seeders/
├── docker/
│   └── 8.3/                      # Dockerfile customizado
├── tests/                        # PHPUnit Tests
├── docker-compose.yml
├── composer.json
└── README.md
```

---

## 🔒 Segurança

- ✅ Autenticação via Laravel Sanctum
- ✅ Proteção CSRF em todos os formulários
- ✅ Validação de entrada em todas as requests
- ✅ Sanitização de dados do web scraping
- ✅ Credenciais sensíveis apenas em `.env` (não versionado)
- ✅ Rate limiting em rotas públicas

---

## 📚 Referências Técnicas

- [Laravel Documentation](https://laravel.com/docs)
- [Symfony DomCrawler](https://symfony.com/doc/current/components/dom_crawler.html)
- [Redis Documentation](https://redis.io/documentation)
- [WeatherAPI Docs](https://www.weatherapi.com/docs/)

---

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

<div align="center">
  
**⭐ Se este projeto foi útil para você, considere dar uma estrela!**

*Desenvolvido com 💚 para o agronegócio brasileiro*

</div>
