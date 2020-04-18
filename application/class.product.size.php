<?php
    namespace ProductManager;
    
    /**
     * Класс объекта размера
     */
    class Size {
        public int $ID;
        public string $Size;

        /**
         * Конструктор объекта размера
         * @param array $data Массив
         */
        public function __construct(array $data) {
            if(empty($data)) return;
            foreach($data as $key => $value) $this->{$key} = $value;
        }
    }
?>