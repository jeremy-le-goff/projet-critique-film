Twig est un moteur de template pour PHP. Il s'agit d'un projet Symfony, ce qui en fait par conséquent un outil particulièrement adapté pour la gestion de nos templates dans le cadre d'un projet en Symfony.

Il permet notamment, au travers d'une syntaxe particulière, de mettre en place un système d'héritage entre nos différents templates et de rendre nos contenus dynamiques. Mais trêve de galéjade, voyons comment cela fonctionne.

## Installation

Si nous avons installé la version `website-skeleton` d'un projet Symfony, alors le composant **Twig** est déjà prêt à être utilisé.

En revanche, si nous avons installé uniquement la version `skeleton`, alors nous devrons installer le composant **Twig** en faisant `composer require twig` avant de nous lancer.

Maintenant que c'est fait, voyons à quoi ça ressemble.

## Architecture

À l'installation, nous pouvons trouver à la racine de notre projet Symfony un dossier `templates`. 

> 💡 C'est ici que nous viendrons stocker l'ensemble de nos templates.

Pour l'instant, il ne contient qu'un fichier `base.html.twig`.

> 💡 Tous nos fichiers de template se termineront par l'extension `html.twig` (par convention et pour que Symfony sache que c'est du Twig).

👀 Allons voir ce qui se cache à l'intérieur

```html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{% block title %}Welcome!{% endblock %}</title>
        
	{% block stylesheets %}{% endblock %}

        {% block javascripts %}{% endblock %}
    </head>
    <body>
        {% block body %}{% endblock %}
    </body>
</html>
```

Il s'agit en réalité d'un modèle de base pour les futures pages de notre application. Nous pouvons distinguer à l'heure actuelle 4 blocs : `title`, `stylesheets`, `javascripts`, et `body`. Libre à vous de modifier leurs noms, mais si ils ont été choisis c'est pour une bonne raison :

- le bloc `title` va contenir le texte affiché dans l'onglet de notre navigateur web
- le bloc `stylesheets` va contenir nos liens vers nos différentes ressources comme nos fichiers `css` par exemple
- le bloc `javascripts` va contenir nos liens vers nos scripts `js`
- le bloc `body` va contenir le code HTML de notre page

### 💬 Mais à quoi sert ce gabarit de base ?

Comme évoqué en introduction, Twig s'appuie énormément sur le concept d'**héritage**. Quand nous allons créer un nouveau template, par exemple `home.html.twig`, **nous souhaitons que ce template enfant utilise le même modèle que celui de base** (header, footer, etc.).

Pour ce faire, nous allons utiliser le tag `extends`. Il permet de spécifier à Twig, que ce template hérite, étend, d'un autre template.

```html
{% extends "base.html.twig"}
```

Ici, nous précisons que le template `home.html.twig` étend le template `base.html.twig`, et hérite de tout son contenu.

### 💬 Comment utiliser les blocs ?

Imaginons que nous voulions ajouter du contenu à notre template `home.html.twig` (ce qui est tout de même l'objectif final 😃).

Dans ce cas, il suffit de définir du contenu dans le bloc `body` de notre template en y ajoutant le code HTML souhaité.

```html
{% extends "base.html.twig"}

{% block body %}
    <h1>Hello World!</h1>
{% endblock %}
```

Désormais, notre page `home.html.twig` affiche un titre de niveau 1 disant bonjour au monde, avec tout le layout présent dans `base.html.twig` 🎉

De même, si nous renseignons par exemple un lien vers un fichier CSS dans un bloc `stylesheets` du template `home.html.twig`, celui-ci sera également ajouté au template `base.html.twig` (ce qui nous permettra d'avoir une feuille de style spécifique à la page d'accueil).

### Pour résumer

☠️ Le template `base.html.twig` est en quelque sorte un squelette HTML, un modèle de base, dans lequel nous allons spécifier différents blocs comme ceux proposés par défaut, mais auxquels nous pouvons en ajouter de nouveaux (e.g. un bloc de navigation, un header, un footer, etc.).

👶 Ensuite, nous allons créer des templates enfants qui hériteront de ces éléments. Chaque enfant pourra redéfinir tout ou partie des blocs parents pour y ajouter ce qu'il veut, tout en conservant la structure de base du parent 🎉

## Conventions de nommage

L'ensemble de nos templates seront stockés dans notre dossier `templates` mais pas n'importe comment... pour chaque contrôleur, nous allons créer un dossier du même nom.

Si nous avons un contrôleur nommé `PromoController`, alors nous créerons un dossier `promo` dans notre dossier `templates`. C'est à l'intérieur de ce dernier que nous stockerons tous nos templates relatifs aux méthodes de notre contrôleur `PromoController`.

Il est également recommandé d'utiliser le `snake_case` pour le nommage de nos templates.

Dans notre exemple, nous pourrions avoir dans le dossier `templates/promo`, des fichiers comme `browse.html.twig`, `read.html.twig`, `add.html.twig`, etc.

## Un peu de syntaxe

`{% ... %}` est utilisé pour exécuter des instructions.

| Version PHP | Version Twig |
| --- | --- |
| `<?php if ($myTest) : ?> ... <?php endif; ?>` | `{% if myTest %} ... {% endif %}` |
| `<?php foreach ($items as $item) : ?> ... <?php endforeach; ?>` | `{% for item in items %} ... {% endfor %}` |

`{{ ... }}` est utilisé pour afficher du contenu.

| Version PHP | Version Twig |
| --- | --- |
| `<?php echo $myVariable; ?>` | `{{ myVariable }}` |
| `<?= $myVariable ?>` | `{{ myVariable }}` |

`{# ... #}` est utilisé pour ajouter des commentaires.

`~` permet de concaténer une chaîne de caractères.

### La boucle for

```html
// Boucle PHP foreach (value)
{% for item in items %}
    // les instructions
{% endblock %}

// Boucle PHP foreach (key, value)
{% for key, item in items %}
    // key correspond à la clé du tableau => 0, 1, 2, ...
    // les instructions
{% endblock %}
```

## Les fragments (de template)

Pour illustrer le concept des *fragments* (connus par ailleurs sous le nom de *partials)*, l'exemple le plus parlant est probablement celui de la navigation. Celle-ci doit être partagée par tous les templates, qu'il s'agisse de la page d'accueil, d'une page listant des objets, d'une page affichant les informations d'un seul objet, d'une page de contact, etc. Nous nous disons que le plus logique est de la définir dans le template `base.html.twig`, étant donné que nos templates enfants vont hériter de cette base, et nous aurions raison. Ce qui donnerait quelque chose comme ceci :

```html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{% block title %}Un super site{% endblock %}</title>

        {% block stylesheets %}{% endblock %}

        {% block javascripts %}{% endblock %}
    </head>
    <body>
        <nav class="navbar">
            <ul class="navbar__list">
	        <li class="navbar__list__item">
		    <a class="navbar__list__item__link" href="/">Accueil</a>
		</li>
		<li class="navbar__list__item">
		    <a class="navbar__list__item__link" href="/promo">Promotions</a>
		</li>
		<li class="navbar__list__item">
		    <a class="navbar__list__item__link" href="/teacher">Formateurs</a>
		</li>
	    </ul>
	</nav>
        
        {% block body %}{% endblock %}
    </body>
</html>
```

Ce serait fonctionnel, mais si nous avons des liens à rajouter ou d'autres sections de code, nous pourrions perdre en visibilité en ce qui concerne les différents blocs présents.

Une optimisation consiste à déplacer la partie navigation dans un *fragment*, c'est-à-dire dans un autre fichier que nous nommerions `_navbar.html.twig`.

> 💡 Par convention, le nom des *fragments* commencent par un `_` afin de facilement les distinguer des autres templates.

```html
{# fichier _navbar.html.twig #}
<nav class="navbar">
    <ul class="navbar__list">
        <li class="navbar__list__item">
            <a class="navbar__list__item__link" href="/">Accueil</a>
        </li>
        <li class="navbar__list__item">
            <a class="navbar__list__item__link" href="/promo">Promotions</a>
        </li>
        <li class="navbar__list__item">
            <a class="navbar__list__item__link" href="/teacher">Formateurs</a>
        </li>
    </ul>
</nav>
```

Dans notre template `base.html.twig`, il ne nous reste plus qu'à **inclure** notre *fragment* grâce à la fonction Twig `include`.

```html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{% block title %}Un super site{% endblock %}</title>

        {% block stylesheets %}{% endblock %}

        {% block javascripts %}{% endblock %}
    </head>
    <body>
        <!-- Navbar -->
        {{ include('_navbar.html.twig') }}
				        
        {% block body %}{% endblock %}
    </body>
</html>
```

## Les fonctions indispensables sous Symfony

### `asset()`

Cette fonction permet d'indiquer plus facilement où aller chercher nos ressources, comme nos fichiers CSS, JS, ou nos images. Cette fonction créera un lien HTTP vers le dossier `public` de notre application, là ou se trouvent nos *assets*.

> 💡 Afin de pouvoir utiliser cette fonction, il faut disposer du composant du même nom. Celui-ci est installé de base avec la version `website-skeleton` de Symfony, sinon il faut taper la commande `composer require symfony/asset`.

```html
{# l'image est stockée ici "public/images/logo.png" #}
<img src="{{ asset('images/logo.png') }}" alt="Symfony!"/>

{# le fichier css est stocké ici "public/css/style.css" #}
<link href="{{ asset('css/style.css') }}" rel="stylesheet"/>

{# le fichier js est stocké ici "public/js/app.js" #}
<script src="{{ asset('js/app.js') }}"></script>
```

### `path()`

Plutôt que d'écrire nous-mêmes les liens de redirection dans nos templates Twig, nous allons nous servir de la fonction `path()` pour les générer dynamiquement à notre place, en lien avec le routeur de Symfony.

Cette fonction attend en premier argument le **nom** de notre route ⇒ la valeur de l'attribut `name` de l'annotation `@Route` de la méthode du contrôleur qui nous intéresse.

```php
<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
// Doc Symfo : https://symfony.com/doc/current/routing.html#creating-routes
use Symfony\Component\Routing\Annotation\Route;

class PromoController
{
    /**
     * Page affichant l'ensemble des promotions de l'école O'clock.
     * 
     * @Route("/promo", name="promo_browse", methods={"GET"})
     *
     * @return Reponse
     */
    public function browse(): Response
    {
        // Traitement permettant de récupérer l'ensemble des promotions
       
	// return
    }
}
```

```html
<a href="{{ path('promo_browse') }}">Liste des promotions</a>
```

Dans le cas où il s'agit d'une route avec un paramètre dynamique, nous devrons en préciser la valeur en second argument de la fonction `path()`.

```php
<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
// Doc Symfo : https://symfony.com/doc/current/routing.html#creating-routes
use Symfony\Component\Routing\Annotation\Route;

class PromoController
{
    /**
     * Page affichant les informations d'une promotion.
     * 
     * @Route("/promo/{id}", name="promo_read", methods={"GET"}, requirements={"id"="\d+"})
     *
     * @return Reponse
     */
    public function read(int $id): Response
    {
        // Traitement permettant de récupérer la promotion concernée
       
	// return
    }
}
```

```html
{% for promo in promos %}
    <a href="{{ path('promo_read', {id: promo.id}) }}">Promo {{ promo.name }}</a>
{% endfor %}
```