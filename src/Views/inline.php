<div hx-swap-oob="beforeend:#<?= setting('Alerts.htmlWrapperId'); ?>">
    <?= view(setting('Alerts.views')['display'], $alerts); ?>
</div>
