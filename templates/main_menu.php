<ul class="<?=$classUl?>">

<?php foreach ($array as $itemMenu): 
    if ($itemMenu['title']): ?>
        <li>
            <a 
                <?php
                if (!isCurrentUrl($itemMenu['path'])): ?>
                    href="<?=$itemMenu["path"]?>"
                <?php endif; ?>           
                
                class="<?=isCurrentUrl($itemMenu['path']) ? 'main-menu__item active' : 'main-menu__item'?>"
            >
                <?=$itemMenu['title']?>
            </a>
        </li>
    <?php endif; 
endforeach; ?>

</ul>
