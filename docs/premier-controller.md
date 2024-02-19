En Symfony, l'objectif d'un contrôleur est de récupérer les informations d'une requête HTTP et de renvoyer une réponse appropriée.

Imaginons par exemple un utilisateur se rendant sur la page d'accueil de notre site, et que nous souhaitions à cette occasion le saluer, parce que nous sommes bien élevés et polis.

Pour ce faire, nous aurions besoin de mettre en place un contrôleur, qui serait configuré de telle sorte à ce qu'il soit sollicité lorsque l'utilisateur arrive sur la page d'accueil, et qui saurait quoi faire, à savoir dire bonjour.

💬 **Par où commençons-nous ?**

Nous allons commencer par créer un fichier PHP contenant une classe qui sera une classe de contrôleur, qui elle-même contiendra une méthode qui sera une méthode de contrôleur.

💬 **Où créons-nous ce fichier PHP ?**

Nous allons le créer dans le dossier `src/Controller` de notre projet Symfony.

💬 **Comment le nomme-t-on ?**

Étant donné que son rôle est d'afficher une page d'accueil, nous allons l'appeler `HomeController.php`.

💬 **Que met-on dans ce fichier `HomeController.php` ?**

Étant donné que nous allons privilégier la programmation orientée-objet, ce contrôleur sera une classe.

📝 Par convention, le nom d'un fichier contenant une classe commencera toujours par une majuscule et respectera le *CamelCase*.

```php
<?php

// Le dossier virtuel "App" fait référence au dossier physique "src"
// Merci à l'autoloader de Composer
namespace App\Controller;

class HomeController
{
}
```

💬 **Et maintenant ?**

Nous allons mettre en place la méthode du contrôleur.

```php
<?php

// Le dossier virtuel "App" fait référence au dossier physique "src"
// Merci à l'autoloader de Composer
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index(): Response
    {
	// Symfony attend toujours un return de type Response
        // C'est pourquoi un echo('Bonjour'); produirait une erreur
        return new Response('Bonjour');
    }
}
```

⚠️ Une méthode de contrôleur doit **TOUJOURS** retourner un objet de type `Response`.

Lorsque la méthode `index()` sera appelée, celle-ci retournera une réponse contenant la chaîne de caractères `Bonjour`.

💬 **Comment Symfony sait que c'est la méthode `index` de notre classe `HomeController` qui doit être appelée lorsque l'utilisateur se rend sur la page d'accueil ?**

Bien vu 👀, pour l'instant il ne peut pas le savoir. Il va falloir rajouter l'annotation `@Route` pour qu'il le sache (voir la fiche notre première route).

```php
<?php

// Le dossier virtuel "App" fait référence au dossier physique "src"
// Merci à l'autoloader de Composer
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
// Doc Symfo : https://symfony.com/doc/current/routing.html#creating-routes
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
	// Symfony attend toujours un return de type Response
        // C'est pourquoi un echo('Bonjour'); produirait une erreur
        return new Response('Bonjour');
    }
}
```

Et voilà, si nous lançons notre application avec `php -S localhost:8080 -t public`, et que dans notre navigateur nous nous rendons sur la page `http://localhost:8080/`, notre application nous dira Bonjour 👋

## Afficher un template

Jusqu'ici, nous nous sommes contentés d'afficher `Bonjour` dans notre navigateur, sans code HTML, ni une quelconque mise en forme. Ce n'est clairement pas propre ni optimal.

Pour générer un template, nous allons, dans le cadre d'un projet Symfony, privilégier l'utilisation du moteur de template Twig. Pourquoi ? Parce que c'est celui qui est recommandé par Symfony et qu'il est quand même bien pratique.

💬 **Comment ça marche ?**

La méthode de notre contrôleur ne va plus retourner une simple réponse mais va devoir **rendre** un template. C'est la méthode `render()` d'une classe bien particulière qu'est l'`AbstractController` qui va nous permettre de faire ça.

💬 **D'où il sort l'`AbstractController` ?**

C'est un contrôleur de base fourni par le framework Symfony qui dispose de tout un tas de méthodes bien pratiques dont cette fameuse méthode `render()`.


💬 **Comment on s'en sert ?**

La seule chose que nous ayons à faire, c'est de faire hériter à notre contrôleur actuel toutes les méthodes de l'`AbstractController` et pour ça nous avons le mot clé `extends`.

```php
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
}
```

Et voilà 🎉 notre `HomeController` a désormais accès à toutes les méthodes définies dans l'`AbstractController`, dont cette fameuse méthode `render()`. Il ne nous reste plus qu'à l'utiliser pour afficher notre template.

```php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     *
     * @return Response
     */
    public function index(): Response
    {
        // Si nous allons voir le code de la méthode render(),
        // nous verrons qu'elle renvoie bien un objet de type Response
	return $this->render('home/index.html.twig');
    }
}
```

💬 **C'est quoi ce `home/index.html.twig` ?**

Comme évoqué un petit peu plus tôt, nous nous servons du moteur de template Twig pour gérer nos templates. Ici, nous demandons à la méthode de notre contrôleur de renvoyer le template dont le nom est `index.html.twig` qui est stocké dans le dossier `templates/home`.
