<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="./styles/style.css"/>
    <title>Webshop</title>
  </head>
  <body>
    <nav class="navigation">
      <img src="./styles/images/loggoplaceholder.jpg" alt=""/>

      <div class="navigation-links">
        <form class="search-form" action="search.php" method="GET">
          <input class="search-input" type="text" name="q"/>
          <button class="search-submit-btn" type="submit">Sök</button>
        </form>
        <div class="header_categories">
          <a class="navigation-link" href="http://localhost/Webbshoppen/">Start</a>
          <a class="navigation-link" href="">Kontakt</a>
          <a class="navigation-link" href="">Admin</a>
        </div>
      </div>
    </nav>

    <header></header>

    <div class="header-category-links">
      <a class="header-category-link" href="http://localhost/Webbshoppen/category.php?category=light&kategori=Lampor">Lampor</a>
      <a class="header-category-link" href="http://localhost/Webbshoppen/category.php?category=table&kategori=Bord">Bord</a>
      <a class="header-category-link" href="http://localhost/Webbshoppen/category.php?category=armchair&kategori=Fotöljer">Fotölj</a>
      <a class="header-category-link" href="http://localhost/Webbshoppen/category.php?category=pillow&kategori=Kuddar">Kudde</a>
      <a class="header-category-link" href="http://localhost/Webbshoppen/category.php?category=sofa&kategori=Soffor">Soffor</a>
    </div>