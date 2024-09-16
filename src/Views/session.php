<?php if ($alerts = session()->getFlashdata(config('Alerts.key'))): ?>
    <?= view(setting('Alerts.views')['display'], $alerts); ?>
<?php endif; ?>
