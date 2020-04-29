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
      <img src="./styles/images/logga.png" alt="" class="logo_header_start"/>

      <div class="navigation-links">
        <form class="search-form" action="search.php" method="GET">
          <input class="search-input" type="text" name="q"/>
          <button class="search-submit-btn" type="submit">Sök</button>
        </form>
        <div class="header_categories">
          <a class="navigation-link" href="http://localhost/Webbshoppen/lastChance.php">Sista chansen</a>
          <a class="navigation-link" href="http://localhost/Webbshoppen/contact.php">Kontakt</a>
                  <a class="navigation-link" href="http://localhost/Webbshoppen/cart.php"><img src="./styles/images/cart.svg" alt="" class="cart-img" height="25px" width="25px"> </a>
        </div>

      </div>
    </nav>

    <header></header>

    <!--<div class="header-category-links">
      <a class="header-category-link" href="http://localhost/Webbshoppen/category.php?category=light&kategori=Lampor">Lampor</a>
      <a class="header-category-link" href="http://localhost/Webbshoppen/category.php?category=table&kategori=Bord">Bord</a>
      <a class="header-category-link" href="http://localhost/Webbshoppen/category.php?category=armchair&kategori=Fåtöljer">Fåtöljer</a>
      <a class="header-category-link" href="http://localhost/Webbshoppen/category.php?category=pillow&kategori=Kuddar">Kuddar</a>
      <a class="header-category-link" href="http://localhost/Webbshoppen/category.php?category=sofa&kategori=Soffor">Soffor</a>
    </div>-->


<?php

require_once "db.php";

  $category_list = "<div class='header-category-links'>";
  $sql = "SELECT * FROM category";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $category = $row['category'];
    $ucCategory = ucfirst($category);
    $category_list .= "<a class='header-category-link' href='http://localhost/Webbshoppen/category.php?category=$category'>$ucCategory</a>";
  }
  $category_list .= "</div>";
  echo $category_list;
  ?>


