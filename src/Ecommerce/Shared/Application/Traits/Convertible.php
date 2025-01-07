<?php

namespace Core\Ecommerce\Shared\Application\Traits;

trait Convertible
{
    /**
     * toArray
     *
     * @param  mixed $properties indices con su valor a devolver en el array
     * @return array
     */
    public function toArray(array $properties = null): array
    {
        $data = [];
        foreach (get_object_vars($this) as $key => $propertyValue) {
            $data[$key] = $this->convert($propertyValue);
        }
        $data = array_filter($data, fn($item)=> !is_null($item));
        if (!is_array($properties)) {
            return $data;
        }
        $filtered = array_filter($data, function ($item) use ($properties) {
            return in_array($item, $properties);
        }, ARRAY_FILTER_USE_KEY);

        return $filtered;
    }

    private function convert($propertyValue)
    {
        if (!is_object($propertyValue)) {
            return $propertyValue;
        }
        $traits = class_uses($propertyValue);
        $parent = in_array("toArray", get_class_methods($propertyValue));
        $isConvertible = in_array(__TRAIT__, $traits) || $parent;
        if ($isConvertible) {
            return $propertyValue->toArray();
        }
        return $propertyValue;
    }
}
