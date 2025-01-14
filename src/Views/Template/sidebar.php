<?php
echo '<nav>';
  foreach ($_COOKIE["CurrentContoller"]::getActionsList() as $key => $value){
    echo "<a href=". CONTROLLER_URL ."?$value> $key </a>";
  }
echo '</nav>';