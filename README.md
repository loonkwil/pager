# Pager

[![Build Status](https://travis-ci.org/loonkwil/pager.png)](https://travis-ci.org/loonkwil/pager)

## Install

composer.json:
```json
"repositories": [
    ...
    {
        "type": "vcs",
        "url": "https://github.com/loonkwil/pager.git"
    },
    ...
],
"require": {
    ...
    "spe/pager": "dev-master",
    ...
}
```

```bash
php composer.phar update
```

# Usage

```php
<?php

// ...

use SPE\Pager\Pager;

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

```twig
{% if pages.prev %}
  <a href="{{ path('list_news', { page: pages.prev }) }}">prev</a>
{% endif %}
```
