<!DOCTYPE HTML>
<html>
<head>
  <?php wp_head(); ?>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
  <meta name="viewport" content="initial-scale=1, maximum-scale=1">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <?php
    //Echo the adsense verifier code
    echo get_theme_mod('niche_adsense_verifier');
  ?>
</head>
<body>
  <?php get_header(); ?>
  <main class="container">
    <div id="main-content">
      <div>
        <?php
          //Stare the core loop
          while(have_posts()):
            the_post();
            if(is_single() || is_page()){ ?>
                <article>
                  <time datetime="<?php the_time("Y-m-d"); ?>" class="articletime"><?php the_date("F Y"); ?></time>
                  <?php the_auto_header(); ?>
                  <?php the_content(); ?>
                </article>
            <?php }
            else the_list_item();
          endwhile;
        ?>
        <!-- Print the back / forth buttons if it is a list & has second page -->
        <?php if(!(is_single() || is_page()) && nav_buttons_neccessary()): ?>
          <div id="back-forth-holder"><?php posts_nav_link(); ?></div>
        <?php endif; ?>
      </div>
    </div>
    <div class="aside-holder">
      <div>
        <aside class="who-am-i">
          <?php $name=get_the_author_meta('first_name').' '.get_the_author_meta('last_name'); ?>
          <h2>HI, Ich bin <?php echo $name; ?></h2>
          <img alt="Autor der Seite: <?php echo $name; ?>" src="<?php echo get_theme_mod('author_image') ?>"/>
          <?php echo get_the_author_meta('description'); ?>
        </aside>
        <aside class="recent-posts">
          <span id="recent-title">Letzte Artikel</span>
          <?php $posts = get_recent_posts(); //var_dump($posts);
            foreach($posts as $post): ?>
              <div class="recent-item">
                <a href="<?php echo get_permalink($post['ID']); ?>"><?php echo get_the_post_thumbnail($post['ID']); ?></a>
                <h1><a href="<?php echo get_permalink($post['ID']); ?>"><?php echo get_the_title($post['ID']); ?></a></h1>
              </div>
            <?php endforeach;
          ?>
        </aside>
        <footer>
          <a class="direct-footer-item" href="<?php the_terms_conditions_url(); ?>">Terms and Conditions</a>
          <a class="direct-footer-item" href="/wp-admin/">Admin Login</a>
          <span class="direct-footer-item" style="color:#777777; font-size:0.8em;">Powered by Marc-Andre Wessner</a>
          <?php wp_footer(); ?>
        </footer>
      </div>
    </div>
  </main>
  <div id="cookiebar">
    <p>Durch die weitere Nutzung der Webseite stimmst du der Verwendung von Cookies zu.</p>
    <div id="button" onclick="onAgreedToCookie();">Verstanden</div>
  </div>
</body>
</html>
