Par défaut, le protocole HTTP est un protocole sans état. Cela signifie que lorsque nous effectuons une requête auprès du serveur, le protocole HTTP ne stocke pas d'informations en mémoire.

Ceci n'est pas très pratique dans certaines situations, comme dans le cas où un utilisateur naviguerait d'une page sécurisée à une autre... il faudrait alors lui demander de se reconnecter à chaque fois pour vérifier son identité.

Il est possible de stocker des informations sur le serveur via une **session**. Cela va nous permettre de conserver en mémoire des informations.

🔗 [Voir la documentation Symfony](https://symfony.com/doc/current/session.html#basic-usage)

## Mise en place

Nous allons utiliser le service `RequestStack` mis à disposition par Symfony pour manipuler notre session.

*💡 Pour information, la `SessionInterface` et le service `session` sont dépréciés depuis Symfony 5.3. Désormais, il faut privilégier l'utilisation de `RequestStack`.*

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class MyController extends AbstractController
{
    // 1/ Nous initialisons une propriété privée dont la valeur sera définie
    // dans notre constructeur
    private $requestStack;
    
    // 2/ Nous définissons notre constructeur
    // En argument de celui-ci, nous réalisons une injection de dépendance
    // afin de définir la variable $requestStack comme étant un objet de la classe RequestStack
    // `RequestStack $requestStack` est à peu près équivalent à `$requestStack = new RequestStack()`
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function myFunction()
    {
        // 3/ Nous démarrons la session grâce à la méthode `getSession()`
        // de l'objet `requestStack`
        $session = $this->requestStack->getSession();
        
        // 4/ Une fois que la session est démarrée, nous allons
        // pouvoir la manipuler afin d'y stocker des informations,
        // en modifier, ou encore en supprimer
        
        // 4.1/ Stocker un attribut dans la session
        //      grâce à la méthode `set`
        //      set('attribute-name', 'attribute-value')
        $myFirstname = 'charles';
        $session->set('firstname', $myFirstname);

        // 4.2/ Récupérer la valeur d'un attribut stocké en session
        //      grâce à la méthode `get`
        //      get('attribute-name')
        $myFirstname = $session->get('firstname');

        // 4.3/ Modifier la valeur d'un attribut stocké en session
        //      grâce à la méthode `set`
        $myFirstname = 'pierre';
        $session->set('firstname', $myFirstname);

        // 4.4/ Supprimer un attribut stocké en session
        //      grâce à la méthode `remove`
        $session->remove('firstname');

        // return new Response('Hello ' . $myFirstname);
        return new response('');
    }
}
```

## La liste des méthodes

### `set()`

Pour stocker un attribut en session ⇒ `$session->set('attribute-name', 'attribute-value');`

Ou pour modifier la valeur d'un attribut déjà existant

### `get()`

Pour récupérer la valeur d'un attribut stocké en session ⇒ `$session->get('attribute-name');`

Dans le cas où nous essayons de récupérer la valeur d'un attribut qui n'existe pas en session, alors la méthode `get` renverra `null`. Mais il est possible de changer le type de donnée retournée en le précisant en second argument ⇒ `$session->get('attribute-name', []);` retournera un tableau vide et non plus la valeur `null`.

### `remove()`

Pour supprimer un attribut stocké en session ⇒ `$session->remove('attribute-name');`

### `all()`

Pour récupérer l'ensemble des attributs stockés en session avec leurs valeurs associées sous la forme d'un tableau ⇒ `$session->all();`

### `has()`

Retourne `true` si un attribut du nom demandé existe en session, sinon retourne `false` ⇒ `$session->has('attribute-name');`

### `replace()`

Permet de créer plusieurs attributs à la fois avec leurs valeurs associées. Si l'attribut existe déjà alors il sera remplacé, sinon il sera créé ⇒ 

`$session->replace([
    'attribute-name' => 'attribute-value',
    'attribute-name' => 'attribute-value'
]);`

### `clear()`

Supprime tous les attributs ⇒ `$session->clear();`