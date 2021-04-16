<h1>Blog</h1>

<?php foreach ($posts as $post): ?>

<div class="post-item">
  <div class="featured-image">
    <?= $post['featured_image'] ?>
  </div>
  <div class="title">
    <?= $post['title'] ?>
  </div>
  <div class="desc">
    <?= $post['desc'] ?>
  </div>
  <div class="date">
    <?= $post['date'] ?>
  </div>
</div>

<?php endforeach; ?>