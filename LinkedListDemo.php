<?php
    namespace lr1;
    use lr1\LinkedList\LinkedList;
    require_once "LinkedList\LinkedList.php";
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkedList</title>
</head>
<body>
    <h1 style="margin: 10px auto; text-align:center;">Зв'язаний список.</h1>
    
    <h3>Створення списку на основі масиву <i>[1,2,3,4,5,6,7,8,9]</i></h3>
    <?php
        echo LinkedList::fromArray([1,2,3,4,5,6,7,8,9])->toString(fn($el)=>$el->getValue() . ($el->hasNext() ? ' -> ' : '<br/>'));
    ?>
    <h3>Додавання елементів.</h3>
    <h4>Ланцюжок Перетворень: <i>[1,2,3,4,5,6,7,8,9]</i> ->append(1)->append(2)->append(3)->prepend(4)->append(3)->prepend(3).</h4>
    <?php
        $list = LinkedList::fromArray([1,2,3,4,5,6,7,8,9]);
        echo $list->append(1)->append(2)->append(3)->prepend(4)->append(3)->prepend(3)->toString(fn($el)=>$el->getValue() . ($el->hasNext() ? ' -> ' : '<br/>'));
    ?>
    <h3>Видалення трійок.</h3>
    <?php
        $list[] = 8;
        echo "Видалений елемент: " . (string)$list->delete(3).'<br/>';
        echo $list->toString(fn($el)=>$el->getValue() . ($el->hasNext() ? ' -> ' : '<br/>'));
    ?>
    <h3>Вибір кожного елемента.</h3>
    <ul type="circle">
        <?php
            $el = $list[$i=0];
            while($el != null) {
                echo '<li>Елемент з індексом ' . $i . ' => ' . $el . '</li>';
                $el = $list[++$i];
            }
        ?>
    </ul>
    <h3>Перетворення списку в масив.</h3>
    <?php
        print_r($list->toArray());
        echo '<br/>';
    ?>
    <h3>Розвернутий список перетворений до масиву.</h3>
    <?php
        print_r($list->reverse()->toArray());
        echo '<br/>';
    ?>
    <h3>Видалення елементів з початку списку</h3>
    <?php
        $copiedList = LinkedList::copyList($list);
        echo "Вихідний список: [{$list->toString(null)}]<br/>";
        do {
            $el = $copiedList?->deleteHead();
            echo "Видалений елемент: $el - Вміст списку: [{$copiedList->toString(null)}]<br/>";
        } while(!$copiedList->isEmpty());
    ?>
    <h3>Видалення елементів з кінця списку.</h3>
    <?php
        $copiedList = LinkedList::copyList($list);
        echo "Вихідний список: [{$copiedList->toString(null)}]<br/>";
        do {
            $el = $copiedList?->deleteTail();
            echo "Вміст списку: [{$copiedList->toString(null)}]" . " - Видалений елемент: " . $el . '<br/>';
        } while(!$copiedList->isEmpty());
    ?>
    <h3>Перебирання масиву за допомогою foreach</h3>
    <?php
        echo 'Довжина списку: ' . count(new LinkedList) . '<br/>';
        foreach($list as $key => $value) {
            echo "$key => $value <br/>";
        }
    ?>
</body>
</html>