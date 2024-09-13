<?php if ($alerts = session()->getFlashdata(config('Alerts.alertsKey'))): ?>
    <?= view(setting('Alerts.views')['display'], $alerts); ?>
<?php endif; ?>