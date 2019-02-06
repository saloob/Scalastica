<?php

/**
 *
 * <p>Title: Enum class</p>
 *
 * <p>Description: </p>
 *
 * <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights Reserved.</p>
 *
 * <p>Company: Steema Software SL</p>
 *
 *   public abstract*/

  class Enum /*implements Serializable*/ {

    public /*transient String*/ $name='';
    public /*transient int*/ $value;

    protected function _Enum(/*int*/ $value) {
        $this();
        $this->value = $value;
    }

    function Enum() {
//        parent
    }


/*        public function serialize(){
            return serialize($this);
        }
        public function unserialize($serialized){
            return unserialize($serialized);
        }
  */
  /*throws NoSuchFieldException,
            IllegalAccessException*/

    protected function readResolve()  {
        return getClass()->getField(name)->get(null);
    }

    public function getValue() {
        return $value;
    }

    /*throws IOException,
            ClassNotFoundException */
    private function readObject($in)  {
        $this->name = (string) $in->readObject();
    }

    /*throws IOException*/
    private function writeObject($out)  {
        $out->writeObject(getName());
    }

    private function  getName() {
/*        Class c = getClass();
        Field[] f = c.getDeclaredFields();

        for (int i = 0; i < f.length; i++) {
            int mod = f[i].getModifiers();

            if (Modifier.isStatic(mod) && Modifier.isFinal(mod)
                && Modifier.isPublic(mod)) {

                try {
                    if (this == f[i].get(null)) {
                        return f[i].getName();
                    }
                } catch (IllegalAccessException ex) {
                    return "";
                } catch (IllegalArgumentException ex) {
                    return "";
                }
            }
        }
  */
        return "";
    }

}

?>