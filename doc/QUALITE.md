# Rapport de Qualité - Projet Covoiturage (Marie Lory)

## Résumé
Ce document récapitule la conformité du projet aux règles de qualité demandées : DocBlocks, PHPStan, PHPUnit, et conventions PSR.

---

## Conformité PSR / Qualité de code

| Contrôle | Statut attendu | Observations / Commande |
|---|---:|---|
| Indentation (PSR-12) | OK | Respecter 4 espaces, pas de tabulations. |
| Déclarations strictes | OK | `declare(strict_types=1);` ajouté dans les classes principales. |
| Namespaces PSR-4 | OK | Autoload configuré: `App\` -> `src/App/`. |
| DocBlocks (PHPDoc) | OK | Méthodes publiques et modèles commentés. |
| Typage des retours | OK | Types scalaires et `array` utilisés pour les méthodes publiques. |
| Gestion des erreurs PDO | OK | PDO::ERRMODE_EXCEPTION utilisé. |
| Tests unitaires | OK | Tests pour Trip (create/update/delete) avec transaction rollback. |
| Analyse statique (PHPStan) | Niveau recommandé: 8 | Configuré via `phpstan.neon.dist`. |
| Couverture PHPUnit | Objectif: >50% sur code métier | Config via `phpunit.xml.dist` pour générer HTML. |

---

## Comment exécuter les vérifications

1. Installer les dépendances :
```bash
composer install --dev
```

2. Lancer PHPStan :
```bash
composer analyse
# ou
vendor/bin/phpstan analyse --configuration=phpstan.neon.dist
```

3. Lancer les tests PHPUnit :
```bash
composer test
# ou
vendor/bin/phpunit --configuration=phpunit.xml.dist
```

4. Générer le rapport de couverture (avec Xdebug ou phpdbg) :
```bash
composer coverage
# ou
vendor/bin/phpunit --coverage-html build/coverage --configuration=phpunit.xml.dist
```

---

## Remarques et points d'amélioration
- Certains contrôleurs utilisent `header()` + `exit` pour la redirection — pratique acceptable pour une petite application, mais difficile à tester sans adapter (injection d'un Response).  
- Pour production, migrer l'authentification simulée (`test123`) vers `password_hash` / `password_verify`.  
- Ajouter davantage de tests unitaires (User model, AdminController logic, Agencies CRUD) pour monter la couverture.  
- Ajouter CI (GitHub Actions) pour lancer PHPStan et PHPUnit automatiquement à chaque push.

---

## Fichiers clés fournis
- `phpstan.neon.dist` - configuration PHPStan (niveau 8)  
- `phpunit.xml.dist` - configuration PHPUnit + coverage  
- `composer.json` - scripts `analyse`, `test`, `coverage`  
- `tests/TripTest.php` - test principal pour opérations d'écriture  
- `doc/MCD.png` - modèle conceptuel de données

---
