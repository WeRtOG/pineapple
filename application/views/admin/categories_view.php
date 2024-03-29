<section class="cards">
    <?php if(!$data['IsRoot']) { ?>
    <a href="<?=$this->Root?>/admin/categories">
        <button class="back-button">
            <span class="material-icons">keyboard_arrow_left</span>
            <span data-translate="content">Назад</span>
        </button>
    </a>
    <?php } ?>
    <?php foreach($data['Categories'] as $category) { ?>
    <section class="card">
        <?=$data['IsRoot'] ? '<a href="' . $this->Root . '/admin/categories/' . $category->ID . '">' : ''?><h1 class="name"><?=$category->Name?></h1><?=$data['IsRoot'] ? '</a>' : ''?>
        <div class="actions">
            <form action="<?=$this->Root?>/admin/editcategory" method="POST">
                <input type="hidden" name="parentID" value="<?=$data['ParentID']?>"/>
                <input type="hidden" name="id" value="<?=$category->ID?>"/>
                <input type="hidden" name="name" value="<?=$category->Name?>"/>
                <input data-translate="title" title="Редактировать" type="submit" class="edit" value="edit"/>
            </form>
            <form action="<?=$this->Root?>/admin/deletecategory" data-translate="confirm" data-confirm="Вы уверены, что хотите удалить эту категорию? Удаление категории может затронуть некоторые товары и затронет все вложенные подкатегории" method="POST">
                <input type="hidden" name="parentID" value="<?=$data['ParentID']?>"/>
                <input type="hidden" name="id" value="<?=$category->ID?>"/>
                <input data-translate="title" title="Удалить" type="submit" value="delete_forever"/>
            </form>
        </div>
    </section>
    <?php } ?>
    <form action="<?=$this->Root?>/admin/addcategory" method="POST" class="card add">
        <input type="hidden" name="parentID" value="<?=$data['ParentID']?>"/>
        <input data-translate="placeholder" type="category" name="category" placeholder="Название категории (на русском)" />
        <input data-translate="value" type="submit" value="Добавить" />
    </form>
</section>