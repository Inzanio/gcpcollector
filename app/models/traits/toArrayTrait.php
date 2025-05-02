<?php

namespace App\Models\Traits;

/**
 * Trait ToArrayTrait
 * 
 * Ce trait permet de convertir un objet en tableau en utilisant les getters de la classe.
 * 
 * Attention : les classes qui utilisent ce trait doivent avoir des getters bien définis pour que cela fonctionne correctement.
 * Les getters doivent être nommés de la manière suivante : getNomDeLaPropriété (par exemple, getNom pour la propriété $nom).
 */
trait ToArrayTrait
{
    /**
     * Convertit l'objet en tableau
     * 
     * @return array
     */
    public function toArray()
    {
        // Initialise le tableau qui contiendra les valeurs des propriétés
        $array = [];

        // Obtient toutes les méthodes de l'objet
        $methods = get_class_methods($this);

        // Itère sur les méthodes et appelle celles qui sont des getters
        foreach ($methods as $method) {
            // Vérifie si la méthode est un getter (commence par 'get' et a plus de 3 caractères)
            if (strpos($method, 'get') === 0 && strlen($method) > 3) {
                // Extrait le nom de la propriété à partir du nom de la méthode getter
                $propertyName = lcfirst(substr($method, 3));

                // Exclut les propriétés dateCreation et dateModification
                if ($propertyName !== 'dateCreation' && $propertyName !== 'dateModification' && $propertyName !== 'docId') {
                    // Appelle le getter et ajoute la valeur au tableau
                    $array[$propertyName] = $this->$method();
                }
            }
        }

        // Retourne le tableau
        return $array;
    }
}
