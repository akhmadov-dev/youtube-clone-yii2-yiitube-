<?php
/** @var $channel \common\models\User */
?>

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-4"><?= $channel->username ?></h1>
        <hr class="my-4">
        <?= \yii\helpers\Html::a('Subscribe <i class="fa-solid fa-bell"></i>',
            '#',
            [
                'class' => 'btn btn-danger',
                'role' => 'button'
            ]
        ) ?> 9
    </div>
</div>

<!--   <div class="row align-items-md-stretch">
       <div class="col-md-6">
           <div class="h-100 p-5 text-bg-dark rounded-3">
               <h2>Change the background</h2>
               <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron look. Then, mix and match with additional component themes and more.</p>
               <button class="btn btn-outline-light" type="button">Example button</button>
           </div>
       </div>
       <div class="col-md-6">
           <div class="h-100 p-5 bg-light border rounded-3">
               <h2>Add borders</h2>
               <p>Or, keep it light and add a border for some added definition to the boundaries of your content. Be sure to look under the hood at the source HTML here as we've adjusted the alignment and sizing of both column's content for equal-height.</p>
               <button class="btn btn-outline-secondary" type="button">Example button</button>
           </div>
       </div>
   </div>

   <footer class="pt-3 mt-4 text-muted border-top">
       © 2022
   </footer>
-->