<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$page_title?> | Pineapple Shoes Admin</title>
        <?php
			$this -> LoadCSS($this->Root . '/css/admin-login.css');
		?>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900" rel="stylesheet">
		<script>var http_root = '<?=$this->Root?>'</script>
    </head>
    <body>
        <?php include 'application/views/'.$content_view; ?>
        <div class="loading-screen<?=$_COOKIE['lang'] != 'ua' ? ' hidden collapsed' : ''?>">
			Завантаження...
		</div>
        <script src="/cdn/jquery.js"></script>
		<script src="/cdn/transit.js"></script>
        <script src="/cdn/anix.js?v=6"></script>
        <?php
			$this -> LoadJS($this->Root . '/js/api.js');
			$this -> LoadJS($this->Root . '/js/translate.js');
        ?>
        <script>
            api = new API();
        </script>
        
    </body>
</html>