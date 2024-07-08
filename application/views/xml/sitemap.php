<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?=BASE_URL?></loc>
    </url>
    <?php foreach (getMenu() as $menu){?>
        <url>
            <loc><?=BASE_URL.$menu['url']?></loc>
        </url>
        
            <?php if (isset($menu['parent'])) { ?>
                    <?php foreach ($menu['parent'] as $m){?>
                <url>
                    <loc><?=BASE_URL.$m['url']?></loc>
                </url>
                    
                    
                    <?php }?>
            <?php }?>
    

            <?php
       
        foreach ($products as $p){ ;?>
            <?php if ($p->id != PREPITNE) { // PREPITNE PRE BALICA ?>
                <url>
                    <loc><?=BASE_URL.getUrlCategoryById($p->category).$p->url?></loc>
                </url>
        
        
            <?php }?>
            <?php }?>

       
    <?php }?>

</urlset>

