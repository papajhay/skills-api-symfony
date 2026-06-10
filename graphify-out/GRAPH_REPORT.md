# Graph Report - .  (2026-06-09)

## Corpus Check
- Corpus is ~20,931 words - fits in a single context window. You may not need a graph.

## Summary
- 187 nodes · 235 edges · 17 communities (15 shown, 2 thin omitted)
- Extraction: 100% EXTRACTED · 0% INFERRED · 0% AMBIGUOUS
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- [[_COMMUNITY_Community 0|Community 0]]
- [[_COMMUNITY_Community 1|Community 1]]
- [[_COMMUNITY_Community 2|Community 2]]
- [[_COMMUNITY_Community 3|Community 3]]
- [[_COMMUNITY_Community 4|Community 4]]
- [[_COMMUNITY_Community 5|Community 5]]
- [[_COMMUNITY_Community 6|Community 6]]
- [[_COMMUNITY_Community 7|Community 7]]
- [[_COMMUNITY_Community 8|Community 8]]
- [[_COMMUNITY_Community 9|Community 9]]
- [[_COMMUNITY_Community 10|Community 10]]
- [[_COMMUNITY_Community 11|Community 11]]
- [[_COMMUNITY_Community 12|Community 12]]

## God Nodes (most connected - your core abstractions)
1. `require` - 24 edges
2. `User` - 24 edges
3. `Product` - 23 edges
4. `Category` - 16 edges
5. `self` - 9 edges
6. `self` - 8 edges
7. `self` - 6 edges
8. `Version20260603000000` - 5 edges
9. `Version20260605081127` - 5 edges
10. `ProductFixture` - 5 edges

## Surprising Connections (you probably didn't know these)
- None detected - all connections are within the same source files.

## Import Cycles
- None detected.

## Communities (17 total, 2 thin omitted)

### Community 0 - "Community 0"
Cohesion: 0.12
Nodes (5): User, PasswordAuthenticatedUserInterface, DateTimeImmutable, self, UserInterface

### Community 1 - "Community 1"
Cohesion: 0.13
Nodes (4): Category, Product, DateTimeImmutable, self

### Community 2 - "Community 2"
Cohesion: 0.08
Nodes (23): assets:install %PUBLIC_DIR%, cache:clear, autoload, autoload-dev, psr-4, psr-4, extra, symfony (+15 more)

### Community 3 - "Community 3"
Cohesion: 0.08
Nodes (24): require, api-platform/core, doctrine/doctrine-bundle, doctrine/doctrine-migrations-bundle, doctrine/orm, ext-ctype, ext-iconv, fakerphp/faker (+16 more)

### Community 4 - "Community 4"
Cohesion: 0.16
Nodes (5): Collection, Category, Product, DateTimeImmutable, self

### Community 5 - "Community 5"
Cohesion: 0.20
Nodes (8): AppFixtures, CategoryFixture, ProductFixture, DependentFixtureInterface, Fixture, ObjectManager, ObjectManager, ObjectManager

### Community 6 - "Community 6"
Cohesion: 0.23
Nodes (5): AbstractMigration, Schema, Version20260603000000, Schema, Version20260605081127

### Community 7 - "Community 7"
Cohesion: 0.23
Nodes (7): CategoryRepository, ProductRepository, UserRepository, ServiceEntityRepository, ManagerRegistry, ManagerRegistry, ManagerRegistry

### Community 8 - "Community 8"
Cohesion: 0.29
Nodes (7): symfony/flex, symfony/runtime, block-insecure, config, allow-plugins, audit, sort-packages

### Community 9 - "Community 9"
Cohesion: 0.60
Nodes (3): AbstractController, HomeController, Response

### Community 11 - "Community 11"
Cohesion: 0.67
Nodes (3): BaseKernel, MicroKernelTrait, Kernel

## Knowledge Gaps
- **41 isolated node(s):** `type`, `license`, `minimum-stability`, `prefer-stable`, `php` (+36 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **2 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Category` connect `Community 1` to `Community 5`, `Community 7`?**
  _High betweenness centrality (0.071) - this node is a cross-community bridge._
- **Why does `Product` connect `Community 4` to `Community 5`, `Community 7`?**
  _High betweenness centrality (0.062) - this node is a cross-community bridge._
- **What connects `type`, `license`, `minimum-stability` to the rest of the system?**
  _41 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Community 0` be split into smaller, more focused modules?**
  _Cohesion score 0.11692307692307692 - nodes in this community are weakly interconnected._
- **Should `Community 1` be split into smaller, more focused modules?**
  _Cohesion score 0.12666666666666668 - nodes in this community are weakly interconnected._
- **Should `Community 2` be split into smaller, more focused modules?**
  _Cohesion score 0.08333333333333333 - nodes in this community are weakly interconnected._
- **Should `Community 3` be split into smaller, more focused modules?**
  _Cohesion score 0.08333333333333333 - nodes in this community are weakly interconnected._