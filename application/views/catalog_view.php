<section class="catalog-wrapper">
    <section class="catalog">
        <?php if($data['Page'] == 1 && !$data['Filtered']) {
        ?>
        <h1 data-translate="content" class="anix" data-hold="0" data-continue="true" data-fx="move" data-direction="down">Топ продаж</h1>
        <div class="carousel anix" data-fx="move" data-direction="down" data-continue="true">
            <?php foreach($data['CarouselItems'] as $item) { ?>
            <div class="card" data-id="<?=$item->ID?>" style="background-image: url(<?=$item->Images->HorizontalImage->Path?>)"><a href="<?=$this->Root?>/catalog/product/<?=$item->ID?>"><h3><?=$item->Title?></h3></a></div>
            <?php } ?>
        </div>
        <h1 data-translate="content" class="anix" data-fx="move" data-direction="down" data-continue="true" data-hold="100">Сезонное предложение</h1>
        <div class="seasonal-offer anix" data-fx="move" data-direction="down" data-continue="true" data-hold="100">
            <?php foreach($data['SeasonalOfferItems'] as $item) { ?>
            <a href="<?=$this->Root?>/catalog/product/<?=$item->ID?>" class="skip-anix">
                <article class="item-card">
                    <div class="image" style="background-image: url(<?=$item->Images->ImagesList[0]->Path?>)"></div>
                    <h2><?=$item->Title?></h2>
                    <h4 data-translate="content"><?=$item->Category->Name?></h4>
                    <h3><?=number_format($item->Price, 0, ',', ' ')?> ₴</h3>
                    <button>
                        <p>
                            <span class="icon material-icons">
                                double_arrow
                            </span>
                            <span data-translate="content" class="text">Подробнее</span>
                        </p>
                    </button>
                </article>
            </a>
            <?php } ?>
        </div>
        <h1 data-translate="content" class="anix" data-fx="move" data-direction="down" data-continue="true" data-hold="100">Все товары</h1>
        <?php
        } else {
        ?>
        <?php
        }
        ?>
        <section class="all-items anix">
            <div class="all-items-sidebar">
                <div class="filters">
                    <h2>
                        <span data-translate="content" class="text">Фильтр</span>
                        <img src="<?=$this->Root?>/images/filter.svg"/>
                    </h2>
                    <div class="filters-list">
                        <ul class="collapsible<?=$data['Filter'] != 'brand' ? ' hidden' : ''?>">
                            <li data-translate="content" class="header">
                                По брендам
                            </li>
                            <ul class="content">
                                <?php foreach($data['Brands'] as $brand) { ?>
                                <a href="<?=$this->Root?>/catalog/page/1/?filter=brand&id=<?=$brand->ID?>">
                                    <li><?=$brand->Name?></li>
                                </a>
                                <?php } ?>
                            </ul>
                        </ul>
                        <ul class="collapsible<?=$data['Filter'] != 'category' ? ' hidden' : ''?>">
                            <li data-translate="content" class="header">
                                По категориям
                            </li>
                            <ul class="content">
                                <?php foreach($data['Categories'] as $category) { ?>
                                <?php if(count($category->SubCategories) == 0) { ?>
                                <a href="<?=$this->Root?>/catalog/page/1/?filter=category&id=<?=$category->ID?>">
                                    <li data-translate="content"><?=$category->Name?></li>
                                </a>
                                <?php } else { ?>
                                <?php
                                    $hide = true;
                                    foreach($category->SubCategories as $subcategory)
                                        if($subcategory->ID == $data['FilterID'])
                                            $hide = false;
                                ?>
                                <li class="sub<?=$hide ? ' hidden' : ''?>">
                                    <div class="header" data-translate="content"><?=$category->Name?></div>
                                    <ul class="content">
                                        <a href="<?=$this->Root?>/catalog/page/1/?filter=category&id=<?=$category->ID?>">
                                            <li data-translate="content">Все</li>
                                        </a>
                                        <?php foreach($category->SubCategories as $subcategory) { ?>
                                        <a href="<?=$this->Root?>/catalog/page/1/?filter=category&id=<?=$subcategory->ID?>">
                                            <li data-translate="content"><?=$subcategory->Name?></li>
                                        </a>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } ?>
                                <?php } ?>
                            </ul>
                        </ul>
                        <ul class="collapsible<?=$data['Filter'] != 'size' ? ' hidden' : ''?>">
                            <li data-translate="content" class="header">
                                По размерам
                            </li>
                            <ul class="content">
                                <?php foreach($data['Sizes'] as $size) { ?>
                                <a href="<?=$this->Root?>/catalog/page/1/?filter=size&id=<?=$size->ID?>">
                                    <li><?=$size->Size?></a></li>
                                <?php } ?>
                            </ul>
                        </ul>
                    </div>
                    <a href="<?=$this->Root?>/catalog">
                        <button data-translate="content">Сбросить фильтры</button>
                    </a>
                </div>
            </div>
            <div class="all-items-content<?=count($data['AllItems']) == 0 ? ' no-data' : ''?>">
                <?php foreach($data['AllItems'] as $item) { ?>
                <a href="<?=$this->Root?>/catalog/product/<?=$item->ID?>">
                    <article class="item-card">
                        <div class="image" style="background-image: url(<?=$item->Images->ImagesList[0]->Path?>)"></div>
                        <h2><?=$item->Title?></h2>
                        <h4 data-translate="content"><?=$item->Category->Name?></h4>
                        <h3><?=number_format($item->Price, 0, ',', ' ')?> ₴</h3>
                        <button>
                            <p>
                                <span class="icon material-icons">
                                    double_arrow
                                </span>
                                <span class="text" data-translate="content">Подробнее</span>
                            </p>
                        </button>
                    </article>
                </a>
                <?php } ?>
            </div>
        </section>
        <?php if($data['PageCount'] > 1) { ?>
        <section class="page-select anix">
            <?
                // Получаем текующую страницу и кол-во страниц
                $page = $data['Page'];
                $all_pages = $data['PageCount'];

                // Рассчитываем кнопки
                $start = $page - 2;
                if($all_pages < 4)
                    $buttons = $all_pages;
                else
                    $buttons = 4;
                if($start < 1) {
                    $start = 1;
                }
                if($buttons < 4 && $all_pages > 4)
                    $buttons = $buttons + 2;
                $end = $buttons + $start;
                if($end > $all_pages) $end = $all_pages;

                $q_string = '';
                if(count($_GET) > 0) $q_string = '?' . http_build_query($_GET);

                // Выводим кнопки
                if($start != 1) {
                    echo '<a href="' . $this->Root . '/catalog/page/1/' . $q_string . '"><button class="page sw">&laquo;</button></a>';
                }
                for($i = $start; $i <= $end; $i++) {
                ?>
                <a href="<?=$this->Root?>/catalog/page/<?=$i?>/<?=$q_string?>"><button class="page<?=$page == $i ? ' current' : ''?>"><?=$i?></button></a>
                <?php
                }
                if($all_pages > $end) {
                    echo '<a href="' . $this->Root . '/catalog/page/' . $all_pages . '/' . $q_string . '"><button class="page sw">&raquo;</button></a>';
                }
            ?>
        </section>
        <?php } ?>
    </section>
</section>