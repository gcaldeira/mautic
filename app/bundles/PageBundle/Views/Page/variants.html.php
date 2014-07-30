<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic, NP. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
?>

<?php
$parent = $page->getVariantParent();
$children = ($parent) ? $parent->getVariantChildren() : $page->getVariantChildren();
?>
<?php if (count($children)): ?>
    <span class="bundle-main-item-secondary margin-sm-top">
        <span class="has-click-event"  onclick="Mautic.toggleRelatedPages('variants');">
            <i class="fa fa-sitemap"></i>
            <span class="margin-sm-left">
                <em><?php echo $view['translator']->trans('mautic.page.page.variants'); ?>
                    <i class="fa fa-chevron-circle-down related-variants-toggle"></i>
                </em>
            </span>
        </span>
        <ul class="no-bullet related-variants" style="display: none;">
            <?php if ($parent): ?>
                <li>
                    <?php echo $view->render('MauticCoreBundle:Helper:publishstatus.html.php',array(
                        'item'       => $parent,
                        'dateFormat' => (!empty($dateFormat)) ? $dateFormat : 'F j, Y g:i a',
                        'model'      => 'page.page'
                    )); ?>
                    <a href="<?php echo $view['router']->generate('mautic_page_action', array(
                        'objectAction' => 'view', 'objectId' => $parent->getId())); ?>"
                       data-toggle="ajax">
                        <span><?php echo $parent->getTitle() . " (" . $parent->getAlias() . ")"; ?></span>
                        <span><strong> [<?php echo $view['translator']->trans('mautic.page.page.parent'); ?>]</strong></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php foreach ($children as $c): ?>
                <?php if ($c->getId() == $page->getId()) continue; ?>
                <li>
                    <?php echo $view->render('MauticCoreBundle:Helper:publishstatus.html.php',array(
                        'item'       => $c,
                        'dateFormat' => (!empty($dateFormat)) ? $dateFormat : 'F j, Y g:i a',
                        'model'      => 'page.page'
                    )); ?>
                    <a href="<?php echo $view['router']->generate('mautic_page_action', array(
                        'objectAction' => 'view', 'objectId' => $c->getId())); ?>"
                       data-toggle="ajax">
                        <span><?php echo $c->getTitle() . " (" . $c->getAlias() . ")"; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </span>
<?php endif; ?>
