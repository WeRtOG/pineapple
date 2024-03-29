<?php
    namespace ClientCart;

    use ProductManager\Product as Product;

    /**
     * Класс элемента корзины
     */
    class CartItem {
        public Product $Product;
        public string $Amount;
        public ?string $Size;
        public ?string $ColorName;
        /**
         * Конструктор элемента корзины
         * @param array Массив данных
         */
        public function __construct(array $data) {
            if(empty($data)) return;
            foreach($data as $key => $value) $this->{$key} = $value;
        }
    }
?>