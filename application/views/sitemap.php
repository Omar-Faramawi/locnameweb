<?php header('Content-type: text/xml'); ?>
<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    <url>
        <loc>http://www.locname.com/</loc>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>http://www.locname.com/auth/register</loc>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>http://www.locname.com/auth/forgot_password</loc>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>http://www.locname.com/index/terms</loc>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>http://www.locname.com/index/privacy</loc>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>http://www.locname.com/page/about</loc>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>http://www.locname.com/index/partner</loc>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>http://www.locname.com/index/api</loc>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>http://www.locname.com/index/contact</loc>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>http://www.locname.com/auth/login</loc>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>http://www.locname.com/registerlocation</loc>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>http://www.locname.com/index/about</loc>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>http://www.locname.com/index/apidemo</loc>
        <priority>0.80</priority>
    </url>

    <?php foreach ($urls as $url) { ?>
        <url>
            <loc><?= base_url() . $url['title'] ?></loc>
            <priority>0.50</priority>
        </url>
    <?php } ?>

</urlset>
