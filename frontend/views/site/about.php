<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'О сайте';
?>
<section class="blog-post">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="blog-post-content">
                <h2 class="blog-post-title"><?= Html::encode($this->title) ?></h2>

                <p>Клон твиттера на Yii2</p>
                <p>Этот и другие проекты: </p><a href="https://github.com/Phrlog/Geeker"><code>https://github.com/Phrlog/Geeker</code></a>
                <p><a href="mailto:phrlog@gmail.com">phrlog@gmail.com</a></p>
            </div>
        </div>
    </div>
</section>
