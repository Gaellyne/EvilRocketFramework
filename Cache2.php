<?php

/**
 * Класс который будет кешировать
 */
class Evil_Cache2
{
    /**
     * @description Получение объекта из кеша
     * @param $hash - md5 hash объекта
     * @static
     * @return object
     */

    public static function get($hash)
    {
        $back = explode(':', $hash);
        $back = $back[0];
        
        $backend = $back::getInstance(array());

        return $backend->get($hash);
    }

    /**
     * @description Помещает объект в кеш     *
     * @param $object - объект
     * @static
     * @return md5 hash объекта
     */
    public static function put($object,$hash = null)
    {
        $hash = (null == $hash) ? self::getHash($object) : $hash;
        $backend = self::_getBackend($object);
        self::_saveToCache($hash, $object, $backend);
    }

    protected static function _getBackendClass($object)
    {
        if (gettype($object) == 'array' || gettype($object) == 'string' || gettype($object) == 'integer' || gettype($object) == 'double' || gettype($object) == 'boolean')
        {
            return 'Evil_Cache_Redis';
        }
        
        return 'Evil_Cache_Pull';
    }
    protected static function _getBackend($object)
    {
       $backendClass = self::_getBackendClass($object);
       return $backendClass::getInstance(array());
    }

    /**
     * @description Сохраняет в кеше хеш объекта как ключ, объект как значение
     * @param $hash - md5 хеш объекта
     * @param $object - объект
     * @return bool
     */
    protected function _saveToCache($hash, $object, $backend)
    {
        $backend->put($hash, $object);
        return true;
    }


    /**
     * @static
     * @param  $object
     * @return string
     */
    public static function getHash($object)
    {
        $backend = self::_getBackendClass($object);
        return $backend . ':' . md5(json_encode($object, true));
    }

}