<?php

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
        // Crée une instance de ReflectionClass pour obtenir les propriétés de la classe
        $reflectionClass = new ReflectionClass($this);
        
        // Obtient les propriétés privées de la classe
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PRIVATE);

        // Initialise le tableau qui contiendra les valeurs des propriétés
        $array = [];
        
        // Itère sur les propriétés et appelle les getters correspondants
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $getterName = 'get' . ucfirst($propertyName);
            
            // Vérifie si le getter existe pour la propriété
            if (method_exists($this, $getterName)) {
                // Appelle le getter et ajoute la valeur au tableau
                $array[$propertyName] = $this->$getterName();
            }
        }

        // Retourne le tableau
        return $array;
    }
}

?>