# DokuWiki Random Page

My goal is to have the same function as MediaWiki's Random Page.

I use the search functions to have an array of files and output a random page of this array.

工作原理：从dokuwiki\data\index\page.idx文件中读取页面，然后随机显示。有个不好的地方，页面删除后，此文件中的页面名称列表似乎不会立即发生变化。

## Usage

You can paste this line of code into the sidebar page to use.

```html
<randompage_syntax>Random Page</randompage_syntax>
```



```
?do=randompage
```

```
?do=nsrandompage
```

For example：`http://localhost:8800/doku.php?do=randompage`




## Afterword
> I wanted to use the Random Page plugin for DokuWiki：http://www.dokuwiki.org/plugin:random_page
>
> But it didn't work. So I poked at it a bit... and now it works.
>
>  (I even fixed the URLs it returns.)
>
> Jean Marc Massou did all the original code, I just cleaned it up so it would work. 
>I did email him about it, but I figured I should also publish the code in case someone else wanted to use it. I also changed it from being named 'random_page' to 'randompage' 
> 
> (Hooray for open source.)
> 
> This code is released under the GPL. 



Pete Prodoehl
pete@rasterweb.net
http://rasterweb.net/raster/
Twitter: @raster



