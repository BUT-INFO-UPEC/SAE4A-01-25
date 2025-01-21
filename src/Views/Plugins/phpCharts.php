<?php

namespace App\Model\Visualisations;


use Src\Model\Repository\Requetteur_BDD;

// -----
// DONEE TEXTUELLE
// -----
function unique_value($data, $comp)
{
  $unite = Requetteur_BDD::BDD_fetch_unit($comp->get_attribut());
  // var_dump($data);
  return array_values($data[0])[0] . $unite;
}

function generate_text_representation($data)
{
  return "<p>" . htmlspecialchars($data) . "</p>";
}
