# Installálás

composer.json fájlba:
```
"repositories": [
    ...
    {
        "type": "vcs",
        "url": "https://github.com/loonkwil/pager-utilities.git"
    },
    ...
],
"require": {
    ...
    "spe/pager-utilities": "dev-master",
    ...
}
```

```
php composer.phar update
```

# Használata

controller rétegben:

```
<?php

// ...

use SPE\PagerUtilitiesBundle\PagerUtilities;

class DefaultController extends Controller
{
    public function listAction(Request $request)
    {
        $page  = (int)$request->get('page', 1);
        $limit = $this->container->getParameter('max_item_on_news_page', 10);

        $query = $this->getDoctrine()
            ->getRepository('AcmeNewsBundle:News')
            ->findAll()
            ->getLatestNewsQuery($page, $limit, $request->getLocale())
            ;
        $news = new Paginator($query);

        return $this->render(
            'AcmeNewsBundle:Default:list.html.twig',
            array(
                'news'  => $news,
                'pages' => new PagerUtilities(count($news), $limit, $page),
            )
        );
    }
}
```

view rétegben:

```
{% if pages.prev %}
  <a href="{{ path('list_news', { page: pages.prev }) }}">prev</a>
{% endif %}
```
