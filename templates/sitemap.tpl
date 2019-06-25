<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {foreach $links as $link}
        <url>
            <loc>https://www.{$host}{$link}</loc>
            <priority>0.8</priority>
        </url>
    {/foreach}
</urlset>