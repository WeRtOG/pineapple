<?php
    
    /**
     * Контроллер API
     */
	class Controller_API extends Controller
	{
        /**
         * Конструктор контроллера API
         */
        public function __construct()
        {
            global $session_client, $clientMgr, $productMgr, $auth_helper, $cart, $npAPI, $adminAuth, $citiesMgr, $translator;

            $this->SessionClient = $session_client;
            $this->ClientManager = $clientMgr;
            $this->ProductManager = $productMgr;
            $this->AuthHelper = $auth_helper;
            $this->AdminAuth = $adminAuth;
            $this->Root = Route::GetRoot();
            $this->Cart = $cart;
            $this->NPAPI = $npAPI;
            $this->CitiesManager = $citiesMgr;
            $this->Translator = $translator;
        }
        /**
         * Экшн коренной страницы
         */
		public function action_index()
		{
            $this -> action_404();
        }
        public function action_TranslateUA()
        {
            switch($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $this->action_400();
                    break;
                case 'POST':
                    $text = $_POST['text'];
                    $result = $this->Translator->TranslateBigText($text);
                    API::Answer([
                        'ok' => true,
                        'code' => 200,
                        'result' => $result
                    ]);
                    break;
            }
        }
        /**
         * Экшн загрузки аватара
         */
        public function action_UploadAvatar()
        {
            if($this->SessionClient->IsAuthorized) {
                switch($_SERVER['REQUEST_METHOD']) {
                    case 'GET':
                        $this->action_400();
                        break;
                    case 'POST':
                        if(!empty($_FILES['image'])) {
                            $result = $this->SessionClient->UploadAvatar($_FILES['image']);
                            if($result) {
                                API::Answer([
                                    'ok' => true,
                                    'code' => 200,
                                ]);
                            } else {
                                $this->action_400();
                            }
                        } else {
                            $this->action_400();
                        }
                        
                        break;
                }
            } else {
                $this->action_403();
            }
        }
        /**
         * Экшн загрузки горизонтального фото товара
         */
        public function action_UploadHorizontalPhoto()
        {
            if($this->AdminAuth->IsAuthorized) {
                switch($_SERVER['REQUEST_METHOD']) {
                    case 'GET':
                        $this->action_400();
                        break;
                    case 'POST':
                        if(!empty($_FILES['image']) && !empty($_POST['id'])) {
                            $result = $this->ProductManager->UploadHorizontalPhoto($_FILES['image'], $_POST['id']);
                            
                            if($result) {
                                API::Answer([
                                    'ok' => true,
                                    'code' => 200,
                                ]);
                            } else {
                                $this->action_400();
                            }
                        } else {
                            $this->action_400();
                        }
                        
                        break;
                }
            } else {
                $this->action_403();
            }
        }
        /**
         * Экшн удаления фото товара
         */
        public function action_DeleteProductPhoto()
        {
            if($this->AdminAuth->IsAuthorized) {
                switch($_SERVER['REQUEST_METHOD']) {
                    case 'GET':
                        $this->action_400();
                        break;
                    case 'POST':
                        if(!empty($_POST['filename']) && !empty($_POST['id'])) {
                            $result = $this->ProductManager->DeleteProductPhoto($_POST['id'], $_POST['filename']);
                            
                            if($result) {
                                API::Answer([
                                    'ok' => true,
                                    'code' => 200,
                                ]);
                            } else {
                                $this->action_400();
                            }
                        } else {
                            $this->action_400();
                        }
                        
                        break;
                }
            } else {
                $this->action_403();
            }
        }
        /**
         * Экшн загрузки фото товара
         */
        public function action_UploadProductPhoto()
        {
            if($this->AdminAuth->IsAuthorized) {
                switch($_SERVER['REQUEST_METHOD']) {
                    case 'GET':
                        $this->action_400();
                        break;
                    case 'POST':
                        if(!empty($_FILES['image']) && !empty($_POST['id'])) {
                            $filename = $this->ProductManager->UploadProductPhoto($_FILES['image'], $_POST['id']);
                            
                            if(!empty($filename)) {
                                API::Answer([
                                    'ok' => true,
                                    'code' => 200,
                                    'filename' => $filename
                                ]);
                            } else {
                                $this->action_400();
                            }
                        } else {
                            $this->action_400();
                        }
                        
                        break;
                }
            } else {
                $this->action_403();
            }
        }
        /**
         * Экшн добавления элемента в корзину
         */
        public function action_AddItemToCart()
        {
            switch($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $this->action_400();
                    break;
                case 'POST':
                    $id = $this->AuthHelper->POSTSafeField('id');
                    $sizeID = $this->AuthHelper->POSTSafeField('sizeID');
                    $colorID = $this->AuthHelper->POSTSafeField('colorID');

                    if(!empty($id)) {
                        $result = $this->Cart->AddItem($id, $sizeID, $colorID);
                        if($result) {
                            API::Answer([
                                'ok' => true,
                                'code' => 200
                            ]);
                        } else {
                            $this->action_400();
                        }
                    } else {
                        $this->action_400();
                    }
                    
                    break;
            }
        }
        /**
         * Экшн удаления элемента из корзины
         */
        public function action_RemoveItemFromCart()
        {
            switch($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $this->action_400();
                    break;
                case 'POST':
                    $id = $this->AuthHelper->POSTSafeField('id');
                    if(!empty($id)) {
                        $result = $this->Cart->RemoveItem($id);
                        if($result) {
                            API::Answer([
                                'ok' => true,
                                'code' => 200
                            ]);
                        } else {
                            $this->action_400();
                        }
                    } else {
                        $this->action_400();
                    }
                    
                    break;
            }
        }
        /**
         * Экшн получения суммы корзины
         */
        public function action_GetCartTotalPrice()
        {
            $totalPrice = $this->Cart->TotalPrice;
            API::Answer([
                'ok' => true,
                'code' => 200,
                'totalPrice' => $totalPrice,
                'totalPriceString' => number_format($totalPrice, 2, ',', ' ') . ' ₴'
            ]);
        }
        /**
         * Метод для обновления кол-ва позиций товара
         */
        public function action_UpdateAmount()
        {
            switch($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $this->action_400();
                    break;
                case 'POST':
                    $count = $this->AuthHelper->POSTSafeField('amount');
                    $id = $this->AuthHelper->POSTSafeField('id');

                    if($count < 1) $count = 1;

                    if(!empty($id) && !empty($count)) {
                        $result = $this->Cart->UpdateItemCount($count, $id);
                        if($result) {
                            API::Answer([
                                'ok' => true,
                                'code' => 200
                            ]);
                        } else {
                            $this->action_400();
                        }
                    } else {
                        $this->action_400();
                    }
                    
                    break;
            }
        }
        /**
         * Экшн получения кол-ва элементов в корзине
         */
        public function action_GetCartItemsCount()
        {
            $count = $this->Cart->GetItemsCount();
            API::Answer([
                'ok' => true,
                'code' => 200,
                'count' => $count
            ]);
        }
        /**
         * Экшн получения списка отделений Новой Почты
         */
        public function action_GetWarehouses()
        {
            $result = $this->NPAPI->GetWarehouses();
            API::Answer([
                'ok' => true,
                'code' => 200,
                'result' => $result
            ]);
        }
        
        /**
         * Экшн получения списка отделений в отдельном городе
         */
        public function action_GetCityWarehouses(string $city = '') 
        {
            $result = $this->NPAPI->GetCityWarehouses(urldecode($city));
            API::Answer([
                'ok' => true,
                'code' => 200,
                'result' => $result
            ]);
        }
        /**
         * Экшн получения списка регионов
         */
        public function action_GetRegionList()
        {
            $result = $this->CitiesManager->GetRegionList();
            API::Answer([
                'ok' => true,
                'code' => 200,
                'result' => $result
            ]);
        }
        /**
         * Экшн получения списка городов региона
         * @param string $region Регион
         */
        public function action_GetRegionCities(string $region = '')
        {
            $region = urldecode($region);
            $result = $this->CitiesManager->GetRegionCities($region);
            API::Answer([
                'ok' => true,
                'code' => 200,
                'result' => $result
            ]);
        }
        public function action_ClearUnusedCities() {
            /*set_time_limit(0);
            $cities = $this->CitiesManager->GetAllCities();
            foreach($cities as $city) {
                $result = $this->NPAPI->GetCityWarehouses($city['Name']);
                if(empty($result->data)) {
                    $this->CitiesManager->DeleteCity($city['ID']);
                    echo "Город " . $city['Name'] . " удалён<br>";
                }
            }*/
            API::Answer([
                'ok' => false,
                'code' => 200,
                'error' => 'Not allowed.'
            ]);
        }
        /**
         * Экшн 400 ошибки
         */
        public function action_400()
        {
            API::Answer([
                'ok' => false,
                'code' => 400,
                'error' => 'Bad request.'
            ]);
        }
        /**
         * Экшн 403 ошибки
         */
        public function action_403()
        {
            API::Answer([
                'ok' => false,
                'code' => 403,
                'error' => 'Unauthorized.'
            ]);
        }
        /**
         * Экшн 404 ошибки
         */
        public function action_404() 
        {
            API::Answer([
                'ok' => false,
                'code' => 404,
                'error' => 'Method is not found.'
            ]);
        }
	}
?>