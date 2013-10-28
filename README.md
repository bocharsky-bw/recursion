Recursion
=========

High spead realization of ```recursion``` for create a multi-dimensional arrays

Multi-array generation in controller
------------------------------------
``` php
public function menuAction($id) {
    // ...
    // your code for get items in common php array from DB

    $recursion = new \BW\MenuBundle\Service\Recursion();
    $data->items = $recursion->levelParentEntityRecursion($items);

    return $this->render('BWMenuBundle:Menu:list-menu.html.twig', array('items' => $items));
}
```

Twig recursion
--------------
Notice: the items in ```{{ _self.menuRecursion(items) }}``` must be an multi-array with levels and parents division.

``` twig
{% macro menuRecursion(items) %}
    <ul>
        {% for item in items %}
            <li>
                <a href="">{{ item.current.name }}</a>
                {% if item.children is defined %}
                    {{ _self.menuRecursion(item.children) }}
                {% endif %}
            </li>
        {% endfor %}
    </ul>
{% endmacro %}

<div>
    <h3>Main menu</h3>
    {{ _self.menuRecursion(items) }}
</div>
```
