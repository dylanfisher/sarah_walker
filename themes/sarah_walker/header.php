<!DOCTYPE html>
<html class="no-js">
  <head>
<!--
                          _
                        .' `'.__
                       /      \ `'"-,
      .-''''--...__..-/ .     |      \
    .'               ; :'     '.  a   |
   /                 | :.       \     =\
  ;                   \':.      /  ,-.__;.-;`
 /|     .              '--._   /-.7`._..-;`
; |       '                |`-'      \  =|
|/\        .   -' /     /  ;         |  =/
(( ;.       ,_  .:|     | /     /\   | =|
 ) / `\     | `""`;     / |    | /   / =/
   | ::|    |      \    \ \    \ `--' =/
  /  '/\    /       )    |/     `-...-`
 /    | |  `\    /-'    /;
 \  ,,/ |    \   D    .'  \
  `""`   \  nnh  D_.-'L__nnh
          `"""`

Website developed by Dylan Fisher
-->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php wp_title( '-', true, 'right' ); echo esc_html( get_bloginfo('name'), 1 ) ?></title>
  <meta name="description" content="<?php echo get_bloginfo('description') ?>">
  <meta name="keywords" content="">
  <meta name="viewport" content="width=device-width">
  <link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.png">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,300' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('stylesheet_url'); ?>" />
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-64526760-1', 'auto');
    ga('send', 'pageview');
  </script>
  <?php wp_head() // For plugins ?>
</head>
<body>
  <!--[if lte IE 9]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
  <![endif]-->
  <div <?php body_class('wrapper') ?>>
    <header>
      <div class="sidebar">
        <h1 class="site-title">
          <a href="<?php bloginfo('url') ?>/" title="<?php echo esc_html( bloginfo('name'), 1 ) ?>" rel="home"><?php bloginfo('name') ?></a>
        </h1>
        <nav><?php wp_nav_menu(); ?></nav>
        <?php
          if(is_single()):
            get_template_part('partials/single_work_nav');
          endif;
        ?>
      </div>
    </header>
