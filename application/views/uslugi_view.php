<?php
foreach ($uslugi as $k => $u)
{
    list ( $name, $min_cost, $about) = $u;
    echo '<div class="w-100">
    <p class="text-primary h5">'.$name.'  от '.$min_cost.' руб.</p>
    <p>
    '.$about.'
</p>
</div><hr/>';
}
?>