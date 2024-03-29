<?php
    namespace ProductManager;

    require_once 'class.product.manager.php';
    require_once 'class.product.color.php';
    require_once 'class.product.category.php';
    require_once 'class.product.size.php';
    require_once 'class.product.season.php';
    require_once 'class.product.brand.php';
    require_once 'class.product.images.php';

    /**
     * Класс объекта товара
     */
    class Product {
        public int $ID;
        public Category $Category;
        public Brand $Brand;
        public Season $Season;
        public array $Colors;
        public array $Sizes;
        public int $Year;
        public string $Name;
        public string $Title;
        public string $Description;
        public float $Price;
        public int $CountSale;
        public ProductImages $Images;
        public bool $InCart = false;

        /**
         * Конструктор объекта товара
         * @param array $data Массив
         */
        public function __construct(array $data) {
            if(empty($data)) return;
            foreach($data as $key => $value) $this->{$key} = $value;

            $this->Images = new ProductImages($this->ID);
            $this->Title = mb_strtoupper($this->Brand->Name . ' ' . $this->Name, 'utf8');
        }
        /**
         * Метод для получения размера товара по умолчанию
         * @return Size Размер по-умолчанию
         */
        public function GetDefaultSize() : ?Size {
            if(count($this->Sizes) >= 1) {
                return $this->Sizes[0];
            } else {
                return null;
            }
        }
        /**
         * Метод для получения размера цвета по умолчанию
         * @return Color Цвет по-умолчанию
         */
        public function GetDefaultColor() : ?Color {
            if(count($this->Colors) >= 1) {
                return $this->Colors[0];
            } else {
                return null;
            }
        }
    }
?>