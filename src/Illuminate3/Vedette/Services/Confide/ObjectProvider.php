<?php namespace Illuminate3\Vedette\Services\Confide;

class ObjectProvider{

    /**
     * For testing purposes this method will
     * return an instance of the given class
     *
     * @param  string  $class
     * @return  mixed  Instance of class
     */
    public function getObject( $class )
    {
        return new $class;
    }

}
