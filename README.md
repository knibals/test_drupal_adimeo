# Test Drupal

## Durée
### Pas de contrainte de durée
**MAIS le temps passé est à transmettre.**

C'est selon votre disponibilité, vous pouvez y passer 2h ou beaucoup plus si vous souhaitez. L'appréciation finale du travail rendu tiendra forcément compte de l'adéquation du temps passé par rapport à la qualité/quantité de travail.

Un travail rendu en 2h parfaitement fonctionnel, efficace, pourra être autant apprécié qu'un travail plus long et plus peaufiné avec **par exemple** :

* **et/ou** + de code spécifique ;
* **et/ou** une stratégie de mise en cache, de motif d'url, breadcrumb etc. ;
* **et/ou** un travail plus avancé sur le front (intégration ; workflow, utilisation de twig, js) ;
* **et/ou** un travail sur l'UX du backoffice (display form etc) ;
* **et/ou** tout ce que vous auriez envie de montrer !



## Description de l'existant
Le site est déjà installé (profile standard), la db est à la racine du projet.
Un **type de contenu** `Événement` a été créé et des contenus générés avec Devel. Il y a également une **taxonomie** `Type d'événement` avec des termes.

Les files sont versionnées sous forme d'une archive compréssée. Vous êtes invité à créer un fichier `settings.local.php` pour renseigner vos accès à la DB. Le fichier `settings.php` est lui versionné.

Un thème vide est installé avec comme base `classy`. Voir le README du thème pour plus de détails.

## Consignes

### Globales

**Vous devez cloner ce repo** et nous envoyer soit un lien vers votre propre repo, soit un package si vous n'avez pas de compte GitHub.

**Vous pouvez utiliser composer pour installer ce que vous voulez.**

**Les descriptions fonctionnelles ci-dessous** sont volontairement simples pour vous permettre de moduler le temps du test.
*Par exemple*, la page agenda peut être une page très basique avec uniquement la liste paginée, ou alors comporter des filtres, être une vue ou pas, avoir une intégration ou pas etc...


### 1. Faire une page Agenda
* affichant la liste des événements **à venir ou en cours** ;
* avec pour chaque, le visuel et le titre en tant que lien vers la page de détail et le résumé non cliquable ;
* par ordre de date début ;
* avec une pagination ajax ;
* faire de cet agenda la page d'accueil du site ;
* (optionnel JS) Sur chaque événement de la liste, rajouter un bouton qui au clic change la couleur du fond du container html de l'événement.

### 2. Faire un bloc custom (plugin annoté)
* s'affichant sur la page de détail d'un événement
* et affichant un autre événement du même type (taxonomie) que l'événement courant.
* (optionnel JS) cacher le bloc, ajouter un bouton en bas du détail de l'événement et au clic afficher le bloc en popin (au dessus du reste de la page avec un overlay).

### 3. Faire une tache cron
* qui **dépublie** les événements dont la date de fin est dépassée ;
* à l'aide d'un **QueueWorker**.

## Rendu attendu
**Vous devez cloner ce repo** et nous envoyer soit un lien vers votre propre repo, soit un package avec :

* votre configuration exportée ;
* **et/ou** un dump de base de données ;
* **et pourquoi pas** des readme, des commentaires etc. :)

Le temps que vous avez passé : par mail ou dans un readme par exemple, ou même un rapport de TimeTracker.
