<div id="<?= config('Alerts')->htmlWrapperId; ?>" class="position-fixed z-index-50 bottom-0 end-0 p-3">
    <?= view(setting('Alerts.views')['session']); ?>
</div>
