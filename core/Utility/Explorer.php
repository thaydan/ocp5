<?php


namespace Core\Utility;


use ReflectionException;
use ReflectionObject;

abstract class Explorer
{
    static public function getValue($tabOrObj, string $key, $default = null)
    {
        try {
            if (is_array($tabOrObj)) {
                if (!isset($tabOrObj[$key])) {
                    return $default;
                }
                return $tabOrObj[$key];
            }

            if (!is_object($tabOrObj)) {
                throw new \Exception('Should be an object or an array.');
            }

            $reflectionObject = new ReflectionObject($tabOrObj);

            if ($reflectionObject->hasProperty($key) && $reflectionObject->getProperty($key)->isPublic()) {
                return $tabOrObj->$key;
            }

            foreach (['', 'is', 'has', 'get'] as $startMethodName) {
                $methodName = $startMethodName . ((strlen($startMethodName) === 0) ? $key : ucfirst($key));

                if ($reflectionObject->hasMethod($methodName) && $reflectionObject->getMethod($methodName)->isPublic(
                    )) {
                    return $tabOrObj->$methodName();
                }
            }

            return $default;
        } catch (ReflectionException $e) {
            throw new \Exception('Should be an object or an array.');
        }
    }

    static public function setValue(&$tabOrObj, string $key, $value)
    {
        try {
            if (is_array($tabOrObj)) {
                $tabOrObj[$key] = $value;
                return;
            }

            if (!is_object($tabOrObj)) {
                throw new \Exception('Should be an object or an array.');
            }

            $reflectionObject = new ReflectionObject($tabOrObj);

            if ($reflectionObject->hasProperty($key) && $reflectionObject->getProperty($key)->isPublic()) {
                $tabOrObj->$key = $value;
                return;
            }

            foreach (['', 'set'] as $startMethodName) {
                $methodName = $startMethodName . ((strlen($startMethodName) === 0) ? $key : ucfirst($key));

                if ($reflectionObject->hasMethod($methodName) && $reflectionObject->getMethod($methodName)->isPublic(
                    )) {
                    $tabOrObj->$methodName($value);
                    return;
                }
            }
        } catch (ReflectionException $e) {
            throw new \Exception('Should be an object or an array.');
        }
    }

}